@extends('layouts.app')

@section('title', 'Crear Cooperativa')

@section('content')
    <h1>Crear Cooperativa</h1>
    <form action="{{ route('cooperativas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cantidad_pasajeros" class="form-label">Cantidad de Pasajeros</label>
            <input type="number" name="cantidad_pasajeros" id="cantidad_pasajeros" class="form-control" value="{{ old('cantidad_pasajeros') }}" min="0" required>
            @error('cantidad_pasajeros')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="porcentaje_comision" class="form-label">Porcentaje de Comisión (%)</label>
            <input type="number" step="0.01" name="porcentaje_comision" id="porcentaje_comision" class="form-control" value="{{ old('porcentaje_comision') }}" min="0" max="100" required>
            @error('porcentaje_comision')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('cooperativas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection