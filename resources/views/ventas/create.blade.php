@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Venta</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="persona_id" class="form-label">Persona (nombre – e-mail)</label>
            <select name="persona_id" id="persona_id" class="form-control" required>
                @foreach ($personas as $persona)
                    <option value="{{ $persona->id }}">
                        {{ $persona->nombre }} — {{ $persona->email ?? 'sin@email' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="precio_base" class="form-label">Precio Base</label>
            <input type="number" name="precio_base" id="precio_base" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="cantidad_boletos" class="form-label">Cantidad de Boletos</label>
            <input type="number" name="cantidad_boletos" id="cantidad_boletos" class="form-control" min="1" max="50" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}<br>
            Cooperativa asignada: {{ session('cooperativa_nombre') }}
            (Ocupación: {{ session('porcentaje_ocupacion') }}%, Comisión: {{ session('comision') }}%)
        </div>
    @endif
</div>
@endsection