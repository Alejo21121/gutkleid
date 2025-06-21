<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rols';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    protected $fillable = ['nombre'];
}