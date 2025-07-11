
@extends('layouts.app')

@section('title', 'Resumen de Ventas')

@section('content')
    <h1>Resumen de Ventas</h1>
    <div class="row">
        @if ($primera_cooperativa)
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ventas Totales ({{ $primera_cooperativa->nombre }})</h5>
                        <p class="card-text fs-4 text-primary">{{ number_format($ventas_totales_primera, 2) }} USD</p>
                    </div>
                </div>
            </div>
        @endif
    
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total de Comisiones Generadas</h5>
                    <p class="card-text fs-4 text-primary">{{ number_format($total_comision_general, 2) }} USD</p>
                </div>
            </div>
        </div>
       
    </div>

    @if ($cooperativas->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle-fill me-2"></i> No hay cooperativas registradas.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Cooperativa</th>
                        <th>Boletos Disponibles</th>
                        <th>Boletos Vendidos</th>
                        <th>Capacidad Total</th>
                        <th>Comisión Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cooperativas as $cooperativa)
                        <tr>
                            <td>{{ $cooperativa->nombre }}</td>
                            <td>{{ $cooperativa->cantidad_pasajeros - ($cooperativa->boletos_vendidos ?? 0) }}</td>
                            <td>{{ $cooperativa->boletos_vendidos ?? 0 }}</td>
                            <td>{{ $cooperativa->cantidad_pasajeros }}</td>
                            <td>{{ number_format($cooperativa->total_comision ?? 0, 2) }} USD</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('ventas.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left nav-icon"></i> Volver a Ventas</a>
@endsection
