<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::all();
        return view('personas.index', compact('personas'));
    }

    public function create()
    {
        return view('personas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|unique:personas|max:20',
            'edad' => 'required|integer|min:0|max:150',
        ],
    
        [
            'nombre.required' => 'El nombre es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'La cédula ya está registrada.',
            'edad.required' => 'La edad es obligatoria.',
            'edad.integer' => 'La edad debe ser un número entero.',
            'edad.min' => 'La edad no puede ser negativa.',
            'edad.max' => 'La edad no puede ser mayor a 150 años.',
        ]);

        Persona::create($request->all());
        return redirect()->route('personas.index')->with('success', 'Persona creada con éxito');
    }

    public function edit($id)
    {
        $persona = Persona::findOrFail($id);
        return view('personas.edit', compact('persona'));
    }

    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|unique:personas,cedula,' . $id . '|max:20',
            'edad' => 'required|integer|min:0|max:150',
        ]);

        $persona->update($request->all());
        return redirect()->route('personas.index')->with('success', 'Persona actualizada con éxito');
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();
        return redirect()->route('personas.index')->with('success', 'Persona eliminada con éxito');
    }
}