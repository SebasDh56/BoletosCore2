
@extends('layouts.app')

@section('title', 'Lista de Cooperativas')

@section('content')
    <h1>Lista de Cooperativas</h1>
    <a href="{{ route('cooperativas.create') }}" class="btn btn-primary mb-3">Crear Cooperativa</a>
    @if ($cooperativas->isEmpty())
        <p>No hay cooperativas registradas.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad de Pasajeros</th>
                    <th>Porcentaje de Comisión</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cooperativas as $cooperativa)
                    <tr>
                        <td>{{ $cooperativa->id }}</td>
                        <td>{{ $cooperativa->nombre }}</td>
                        <td>{{ $cooperativa->cantidad_pasajeros }}</td>
                        <td>{{ number_format($cooperativa->porcentaje_comision, 2) }}%</td>
                        <td>
                            <a href="{{ route('cooperativas.edit', $cooperativa) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('cooperativas.destroy', $cooperativa) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta cooperativa?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
