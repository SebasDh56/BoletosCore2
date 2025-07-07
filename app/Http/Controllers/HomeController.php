<?php
namespace App\Http\Controllers;

use App\Models\Cooperativa;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Muestra la página principal con el resumen de ventas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cooperativas = Cooperativa::select(
            'cooperativas.id',
            'cooperativas.nombre',
            'cooperativas.cantidad_pasajeros',
            'cooperativas.porcentaje_comision'
        )
            ->leftJoin('ventas', 'cooperativas.id', '=', 'ventas.cooperativa_id')
            ->groupBy(
                'cooperativas.id',
                'cooperativas.nombre',
                'cooperativas.cantidad_pasajeros',
                'cooperativas.porcentaje_comision'
            )
            ->selectRaw('SUM(ventas.cantidad_boletos) as boletos_vendidos')
            ->selectRaw('SUM(ventas.comision) as total_comision')
            ->get();

        $total_comision_general = $cooperativas->sum('total_comision');

        // Calcular ventas totales de la primera cooperativa
        $primera_cooperativa = Cooperativa::orderBy('id')->first();
        $ventas_totales_primera = 0;
        if ($primera_cooperativa) {
            $ventas_totales_primera = Venta::where('cooperativa_id', $primera_cooperativa->id)
                ->sum(DB::raw('precio_base * cantidad_boletos'));
        }

        return view('home', compact('cooperativas', 'total_comision_general', 'ventas_totales_primera', 'primera_cooperativa'));
    }
}
