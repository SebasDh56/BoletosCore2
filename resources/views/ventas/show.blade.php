@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles de la Venta</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información de la Venta</h5>
                <p><strong>ID:</strong> {{ $venta->id }}</p>
                <p><strong>Persona:</strong> {{ $venta->persona->nombre ?? 'Sin persona' }}</p>
                <p><strong>Cooperativa:</strong> {{ $venta->cooperativa->nombre ?? 'Sin cooperativa' }}</p>
                <p><strong>Cantidad de Boletos:</strong> {{ $venta->cantidad_boletos ?? 0 }}</p>
                <p><strong>Precio Base:</strong> {{ number_format($venta->precio_base ?? 0, 2) }}</p>
                <p><strong>Comisión:</strong> {{ number_format($venta->comision ?? 0, 2) }}</p>
                <p><strong>Fecha de Venta:</strong> {{ $venta->fecha_venta ? $venta->fecha_venta->format('d/m/Y H:i') : 'Sin fecha' }}</p>
                <p><strong>Ocupación:</strong>
                    @if ($venta->cooperativa && $venta->cooperativa->cantidad_pasajeros > 0)
                        {{ number_format((($venta->cooperativa->ventas->sum('cantidad_boletos') ?? 0) / $venta->cooperativa->cantidad_pasajeros) * 100, 2) }}%
                    @else
                        0%
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver a la Lista</a>
            <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
            </form>
        </div>
    </div>
@endsection