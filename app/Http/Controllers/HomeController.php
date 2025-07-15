<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cooperativa;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protege la ruta para usuarios autenticados
    }

    public function index()
    {
        $cooperativas = Cooperativa::leftJoin('ventas', 'cooperativas.id', '=', 'ventas.cooperativa_id')
            ->select(
                'cooperativas.id',
                'cooperativas.nombre',
                'cooperativas.cantidad_pasajeros',
                'cooperativas.porcentaje_comision',
                DB::raw('COALESCE(SUM(ventas.cantidad_boletos), 0) as total_boletos'),
                DB::raw('COALESCE(SUM(ventas.comision), 0) as total_comision'),
                DB::raw('COALESCE(SUM(ventas.precio_base * ventas.cantidad_boletos), 0) as total_ventas')
            )
            ->groupBy(
                'cooperativas.id',
                'cooperativas.nombre',
                'cooperativas.cantidad_pasajeros',
                'cooperativas.porcentaje_comision'
            )
            ->get();

        return view('home', compact('cooperativas'));
    }
}