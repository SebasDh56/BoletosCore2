@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Ventas</h1>
        <a href="{{ route('ventas.create') }}" class="btn btn-success mb-3">Crear Venta</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($ventas->isEmpty())
            <p class="alert alert-warning">No hay ventas registradas.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Persona</th>
                        <th>E-mail</th>
                        <th>Cooperativa</th>
                        <th>Cantidad de Boletos</th>
                        <th>Precio Base</th>
                        <th>Ocupación (%)</th>
                        <th>Comisión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->persona->nombre ?? 'Sin persona' }}</td>
                            <td>{{ $venta->persona->email ?? 'Sin e-mail' }}</td>
                            <td>{{ $venta->cooperativa->nombre ?? 'Sin cooperativa' }}</td>
                            <td>{{ $venta->cantidad_boletos ?? 0 }}</td>
                            <td>{{ number_format($venta->precio_base ?? 0, 2) }}</td>
                            <td>
                                @if ($venta->cooperativa && $venta->cooperativa->cantidad_pasajeros > 0)
                                    {{ number_format((($venta->cooperativa->ventas->sum('cantidad_boletos') ?? 0) / $venta->cooperativa->cantidad_pasajeros) * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($venta->comision ?? 0, 2) }}</td>
                            <td>
                                <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection