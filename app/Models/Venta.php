<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_id',
        'cooperativa_id',
        'cantidad_boletos',
        'precio_base',
        'comision',
        'fecha_venta',
    ];

    protected $casts = [
        'fecha_venta' => 'datetime',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class);
    }
}