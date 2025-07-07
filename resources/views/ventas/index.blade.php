@extends('layouts.app')

@section('title', 'Lista de Ventas')

@section('content')
    <h1>Lista de Ventas</h1>
    <a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3"><i class="bi bi-plus-circle-fill nav-icon"></i> Crear Venta</a>
    @if ($ventas->isEmpty())
        <p>No hay ventas registradas.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Persona</th>
                    <th>Cooperativa</th>
                    <th>Cantidad de Boletos</th>
                    <th>Precio Base</th>
                    <th>Comisión</th>
                    <th>Fecha de Venta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->persona->nombre }} {{ $venta->persona->apellido }}</td>
                        <td>{{ $venta->cooperativa->nombre }}</td>
                        <td>{{ $venta->cantidad_boletos }}</td>
                        <td>{{ number_format($venta->precio_base, 2) }}</td>
                        <td>{{ number_format($venta->comision, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Editar</a>
                            <form action="{{ route('ventas.destroy', $venta) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta venta?')"><i class="bi bi-trash-fill"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
