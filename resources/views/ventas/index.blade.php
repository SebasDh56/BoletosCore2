@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Ventas</h1>
        <a href="{{ route('ventas.create') }}" class="btn btn-success mb-3">Crear Venta</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($ventas->isEmpty())
            <p class="alert alert-warning">No hay ventas registradas.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Persona</th>
                        <th>Cooperativa</th>
                        <th>Cantidad de Boletos</th>
                        <th>Comisión</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ $venta->persona->nombre ?? 'Sin persona' }}</td>
                            <td>{{ $venta->cooperativa->nombre ?? 'Sin cooperativa' }}</td>
                            <td>{{ $venta->cantidad_boletos ?? 0 }}</td>
                            <td>{{ number_format($venta->comision ?? 0, 2) }}</td>
                            <td>{{ $venta->fecha_venta->format('d/m/Y H:i') ?? 'Sin fecha' }}</td>
                            <td>
                                <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta venta?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection