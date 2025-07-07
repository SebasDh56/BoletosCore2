<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperativa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cantidad_pasajeros',
        'porcentaje_comision',
    ];
}