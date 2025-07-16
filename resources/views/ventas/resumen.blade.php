@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resumen de Cooperativas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Boletos Vendidos</th>
                    <th>Capacidad Total</th>
                    <th>% Ocupación</th>
                    <th>Total Comisión</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cooperativas as $coop)
                    <tr>
                        <td>{{ $coop->nombre }}</td>
                        <td>{{ $coop->boletos_vendidos ?? 0 }}</td>
                        <td>{{ $coop->cantidad_pasajeros }}</td>
                        <td>{{ number_format(($coop->boletos_vendidos / $coop->cantidad_pasajeros) * 100, 2) }}%</td>
                        <td>{{ number_format($coop->total_comision ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"><strong>Total Comisión General</strong></td>
                    <td><strong>{{ number_format($total_comision_general, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
        <p>Ventas Totales de {{ $primera_cooperativa->nombre ?? 'N/A' }}: {{ number_format($ventas_totales_primera, 2) }}</p>
    </div>
@endsection