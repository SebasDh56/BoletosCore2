<?php
namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Persona;
use App\Models\Cooperativa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Muestra la lista de todas las ventas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $ventas = Venta::with(['persona', 'cooperativa'])->get();
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Muestra el formulario para crear una nueva venta.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $personas = Persona::all();
        $cooperativas = Cooperativa::all();
        return view('ventas.create', compact('personas', 'cooperativas'));
    }

    /**
     * Almacena una nueva venta en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'precio_base' => 'required|numeric|min:0',
            'cantidad_boletos' => 'required|integer|min:1|max:50',
        ], [
            'persona_id.required' => 'Debe seleccionar una persona.',
            'persona_id.exists' => 'La persona seleccionada no existe.',
            'precio_base.required' => 'El precio base es obligatorio.',
            'precio_base.numeric' => 'El precio base debe ser un número.',
            'precio_base.min' => 'El precio base no puede ser negativo.',
            'cantidad_boletos.required' => 'La cantidad de boletos es obligatoria.',
            'cantidad_boletos.integer' => 'La cantidad de boletos debe ser un número entero.',
            'cantidad_boletos.min' => 'Debe vender al menos un boleto.',
        ]);

        $cooperativa = $this->getAvailableCooperativa($validated['cantidad_boletos']);
        if (!$cooperativa) {
            return redirect()->route('ventas.create')->with('error', 'No hay cooperativas con suficientes boletos disponibles.');
        }

        $comision = $validated['precio_base'] * ($cooperativa->porcentaje_comision / 100) * $validated['cantidad_boletos'];
        $venta = Venta::create([
            'persona_id' => $validated['persona_id'],
            'cooperativa_id' => $cooperativa->id,
            'cantidad_boletos' => $validated['cantidad_boletos'],
            'precio_base' => $validated['precio_base'],
            'comision' => $comision,
            'fecha_venta' => now(),
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito.');
    }

    /**
     * Muestra los detalles de una venta específica.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\View\View
     */
    public function show(Venta $venta)
    {
        $venta->load(['persona', 'cooperativa']);
        return view('ventas.show', compact('venta'));
    }

    /**
     * Muestra el formulario para editar una venta existente.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\View\View
     */
    public function edit(Venta $venta)
    {
        $personas = Persona::all();
        $cooperativas = Cooperativa::all();
        return view('ventas.edit', compact('venta', 'personas', 'cooperativas'));
    }

    /**
     * Actualiza una venta existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Venta $venta)
    {
        $validated = $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'cooperativa_id' => 'required|exists:cooperativas,id',
            'cantidad_boletos' => 'required|integer|min:1',
            'precio_base' => 'required|numeric|min:0',
        ], [
            'persona_id.required' => 'Debe seleccionar una persona.',
            'persona_id.exists' => 'La persona seleccionada no existe.',
            'cooperativa_id.required' => 'Debe seleccionar una cooperativa.',
            'cooperativa_id.exists' => 'La cooperativa seleccionada no existe.',
            'cantidad_boletos.required' => 'La cantidad de boletos es obligatoria.',
            'cantidad_boletos.integer' => 'La cantidad de boletos debe ser un número entero.',
            'cantidad_boletos.min' => 'Debe vender al menos un boleto.',
            'precio_base.required' => 'El precio base es obligatorio.',
            'precio_base.numeric' => 'El precio base debe ser un número.',
            'precio_base.min' => 'El precio base no puede ser negativo.',
        ]);

        $cooperativa = Cooperativa::findOrFail($validated['cooperativa_id']);
        $comision = $validated['precio_base'] * ($cooperativa->porcentaje_comision / 100) * $validated['cantidad_boletos'];

        $venta->update([
            'persona_id' => $validated['persona_id'],
            'cooperativa_id' => $validated['cooperativa_id'],
            'cantidad_boletos' => $validated['cantidad_boletos'],
            'precio_base' => $validated['precio_base'],
            'comision' => $comision,
            'fecha_venta' => $venta->fecha_venta,
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada con éxito.');
    }

    /**
     * Elimina una venta de la base de datos.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada con éxito.');
    }

    /**
     * Muestra un resumen de comisiones y boletos disponibles por cooperativa.
     *
     * @return \Illuminate\View\View
     */
    public function resumen()
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

        return view('ventas.resumen', compact('cooperativas', 'total_comision_general', 'ventas_totales_primera', 'primera_cooperativa'));
    }

    /**
     * Obtiene la primera cooperativa disponible con suficientes boletos.
     *
     * @param  int  $cantidad_boletos
     * @return \App\Models\Cooperativa|null
     */
    protected function getAvailableCooperativa($cantidad_boletos)
    {
        $cooperativas = Cooperativa::orderBy('id')->get();
        foreach ($cooperativas as $cooperativa) {
            $ventas_totales = Venta::where('cooperativa_id', $cooperativa->id)->sum('cantidad_boletos');
            if ($ventas_totales + $cantidad_boletos <= $cooperativa->cantidad_pasajeros) {
                return $cooperativa;
            }
        }
        return null;
    }
}
