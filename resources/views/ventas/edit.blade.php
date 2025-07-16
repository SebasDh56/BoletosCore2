@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Venta</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="persona_id" class="form-label">Persona</label>
                <select name="persona_id" id="persona_id" class="form-control" required>
                    @foreach ($personas as $persona)
                        <option value="{{ $persona->id }}" {{ $venta->persona_id == $persona->id ? 'selected' : '' }}>{{ $persona->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="cooperativa_id" class="form-label">Cooperativa</label>
                <select name="cooperativa_id" id="cooperativa_id" class="form-control" required>
                    @foreach ($cooperativas as $cooperativa)
                        <option value="{{ $cooperativa->id }}" {{ $venta->cooperativa_id == $cooperativa->id ? 'selected' : '' }}>{{ $cooperativa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="precio_base" class="form-label">Precio Base</label>
                <input type="number" name="precio_base" id="precio_base" class="form-control" step="0.01" value="{{ $venta->precio_base }}" required>
            </div>
            <div class="mb-3">
                <label for="cantidad_boletos" class="form-label">Cantidad de Boletos</label>
                <input type="number" name="cantidad_boletos" id="cantidad_boletos" class="form-control" min="1" value="{{ $venta->cantidad_boletos }}" required>
            </div>
            <p>Cooperativa: {{ $venta->cooperativa->nombre ?? 'Sin cooperativa' }}<br>
               Ocupación: {{ number_format((($venta->cooperativa->ventas->sum('cantidad_boletos') ?? 0) / ($venta->cooperativa->cantidad_pasajeros ?? 1)) * 100, 2) }}%<br>
               Comisión aplicada: {{ number_format($venta->comision ?? 0, 2) }}%</p>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection