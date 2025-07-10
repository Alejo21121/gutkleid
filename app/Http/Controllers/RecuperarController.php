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
        'nueva-password' => 'required|min:6|same:nueva-password_confirmation',
    ]);

        $email = session('correo_recuperacion');

        $record = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $request->codigo)
            ->first();

        if (!$record) {
            return back()->with('error', 'Código inválido o expirado.');
        }

        // Cambiar contraseña
        Usuario::where('correo', $email)->update([
            'contraseña' => Hash::make($request->input('nueva-password'))
        ]);

        // Eliminar código
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect()->route('recuperar_cuenta')->with('success', 'Contraseña actualizada');
    }
}
