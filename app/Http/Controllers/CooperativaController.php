<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use Illuminate\Http\Request;

class CooperativaController extends Controller
{
    public function index()
    {
        $cooperativas = Cooperativa::all();
        return view('cooperativas.index', compact('cooperativas'));
    }

    public function create()
    {
        return view('cooperativas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad_pasajeros' => 'required|integer|min:0',
            'porcentaje_comision' => 'required|numeric|between:0,100',
        ]);

        Cooperativa::create($validated);
        return redirect()->route('cooperativas.index')->with('success', 'Cooperativa creada con éxito.');
    }

    public function show(Cooperativa $cooperativa)
    {
        return view('cooperativas.show', compact('cooperativa'));
    }

    public function edit(Cooperativa $cooperativa)
    {
        return view('cooperativas.edit', compact('cooperativa'));
    }

    public function update(Request $request, Cooperativa $cooperativa)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad_pasajeros' => 'required|integer|min:0',
            'porcentaje_comision' => 'required|numeric|between:0,100',
        ]);

        $cooperativa->update($validated);
        return redirect()->route('cooperativas.index')->with('success', 'Cooperativa actualizada con éxito.');
    }

    public function destroy(Cooperativa $cooperativa)
    {
        $cooperativa->delete();
        return redirect()->route('cooperativas.index')->with('success', 'Cooperativa eliminada con éxito.');
    }
}