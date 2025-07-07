@extends('layouts.app')

@section('title', 'Crear Venta')

@section('content')
    <h1>Crear Venta</h1>
    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="persona_id" class="form-label">Persona</label>
            <select name="persona_id" id="persona_id" class="form-control" required>
                <option value="">Seleccione una persona</option>
                @foreach ($personas as $persona)
                    <option value="{{ $persona->id }}" {{ old('persona_id') == $persona->id ? 'selected' : '' }}>{{ $persona->nombre }} {{ $persona->apellido }}</option>
                @endforeach
            </select>
            @error('persona_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cantidad_boletos" class="form-label">Cantidad de Boletos</label>
            <input type="number" name="cantidad_boletos" id="cantidad_boletos" class="form-control" value="{{ old('cantidad_boletos', 1) }}" min="1" required>
            @error('cantidad_boletos')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="precio_base" class="form-label">Precio Base por Boleto</label>
            <input type="number" step="0.01" name="precio_base" id="precio_base" class="form-control" value="{{ old('precio_base') }}" required>
            @error('precio_base')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <p class="text-info">La cooperativa se asignará automáticamente según disponibilidad.</p>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill nav-icon"></i> Guardar</button>
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
    </form>
@endsection
