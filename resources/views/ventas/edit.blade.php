@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
    <h1>Editar Venta</h1>
    <form action="{{ route('ventas.update', $venta) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="persona_id" class="form-label">Persona</label>
            <select name="persona_id" id="persona_id" class="form-control" required>
                <option value="">Seleccione una persona</option>
                @foreach ($personas as $persona)
                    <option value="{{ $persona->id }}" {{ old('persona_id', $venta->persona_id) == $persona->id ? 'selected' : '' }}>{{ $persona->nombre }} {{ $persona->apellido }}</option>
                @endforeach
            </select>
            @error('persona_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cooperativa_id" class="form-label">Cooperativa</label>
            <select name="cooperativa_id" id="cooperativa_id" class="form-control" required>
                <option value="">Seleccione una cooperativa</option>
                @foreach ($cooperativas as $cooperativa)
                    <option value="{{ $cooperativa->id }}" {{ old('cooperativa_id', $venta->cooperativa_id) == $cooperativa->id ? 'selected' : '' }}>{{ $cooperativa->nombre }}</option>
                @endforeach
            </select>
            @error('cooperativa_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cantidad_boletos" class="form-label">Cantidad de Boletos</label>
            <input type="number" name="cantidad_boletos" id="cantidad_boletos" class="form-control" value="{{ old('cantidad_boletos', $venta->cantidad_boletos) }}" min="1" required>
            @error('cantidad_boletos')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="precio_base" class="form-label">Precio Base por Boleto</label>
            <input type="number" step="0.01" name="precio_base" id="precio_base" class="form-control" value="{{ old('precio_base', $venta->precio_base) }}" required>
            @error('precio_base')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill nav-icon"></i> Actualizar</button>
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
    </form>
@endsection
