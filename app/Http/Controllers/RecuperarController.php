<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Mail\CodigoRecuperacion;

class RecuperarController extends Controller
{
    public function enviarCodigo(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = Usuario::where('correo', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Correo no encontrado.');
        }

        $token = Str::random(6); // código de 6 caracteres

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );


        Mail::to($request->email)->send(new CodigoRecuperacion($token));
        session(['correo_recuperacion' => $request->email]);

        return redirect()->route('codigo')->with('codigo', $token);
    }

    public function vistaCodigo()
    {
        return view('contraseña');
    }

    public function validarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nueva-password' => [
                'required',
                'string',
                'min:8',
                'same:nueva-password_confirmation',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
            ],
        ], [
            'nueva-password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'nueva-password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un signo.',
            'nueva-password.same' => 'Las contraseñas no coinciden.'
        ]);

        $email = session('correo_recuperacion');

        $record = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $request->codigo)
            ->first();

        if (!$record) {
            return back()->with('error', 'Código inválido');
        }

        // Cambiar contraseña
        Usuario::where('correo', $email)->update([
            'contraseña' => Hash::make($request->input('nueva-password'))
        ]);

        // Eliminar código usado
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect()->route('login')->with('success', 'Contraseña actualizada correctamente.');
    }
}
