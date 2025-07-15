@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-speedometer2"></i> ¡Bienvenido a BoletosCore!</h4>
                </div>
                <div class="card-body">
                    @php
                        // Identificar la cooperativa principal (prioridad en ventas, id = 1)
                        $principal = $cooperativas->firstWhere('id', 1);
                        $otrasCooperativas = $cooperativas->where('id', '!=', 1);

                        // Cálculos para la cooperativa principal
                        $boletosVendidosPrincipal = $principal ? $principal->total_boletos ?? 0 : 0;
                        $boletosDisponiblesPrincipal = $principal ? max(0, $principal->cantidad_pasajeros - $boletosVendidosPrincipal) : 0;
                        $totalVentasPrincipal = $principal ? $principal->total_ventas ?? 0 : 0;
                        $totalComisionPrincipal = $principal ? $principal->total_comision ?? 0 : 0;

                        // Cálculos totales para las demás cooperativas (para referencia)
                        $boletosVendidosOtras = $otrasCooperativas->sum('total_boletos') ?? 0;
                        $boletosDisponiblesOtras = $otrasCooperativas->sum('cantidad_pasajeros') - $boletosVendidosOtras ?? 0;
                        $totalVentasOtras = $otrasCooperativas->sum('total_ventas') ?? 0;
                        $totalComisionOtras = $otrasCooperativas->sum('total_comision') ?? 0;

                        // Total General (ventas de la principal + comisiones de todas)
                        $totalGeneral = $totalVentasPrincipal + $totalComisionOtras;
                    @endphp

                   <p class="lead text-center"> <strong>Total General: ${{ number_format($totalGeneral, 2) }} </strong></p>
                    <!-- Tabla para la Cooperativa Principal -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-gradient bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-star-fill"></i> Cooperativa Principal</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Boletos Vendidos</th>
                                            <th class="text-center">Boletos Disponibles</th>
                                            <th class="text-center">Total de Ventas</th>
                                            <th class="text-center">Total de Comisión</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($principal)
                                            <tr>
                                                <td>{{ $principal->nombre }}</td>
                                                <td class="text-center">{{ number_format($boletosVendidosPrincipal, 0) }}</td>
                                                <td class="text-center">{{ number_format($boletosDisponiblesPrincipal, 0) }}</td>
                                                <td class="text-center">${{ number_format($totalVentasPrincipal, 2) }}</td>
                                                <td class="text-center">${{ number_format($totalComisionPrincipal, 2) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-warning">No se encontró la cooperativa principal.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla para las Otras Cooperativas -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-gradient bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-people-fill"></i> Otras Cooperativas</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Boletos Vendidos</th>
                                            <th class="text-center">Boletos Disponibles</th>
                                            <th class="text-center">Total de Ventas</th>
                                            <th class="text-center">Total de Comisión</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($otrasCooperativas as $otraCooperativa)
                                            <tr>
                                                <td>{{ $otraCooperativa->nombre }}</td>
                                                <td class="text-center">{{ number_format($otraCooperativa->total_boletos ?? 0, 0) }}</td>
                                                <td class="text-center">{{ number_format(max(0, $otraCooperativa->cantidad_pasajeros - ($otraCooperativa->total_boletos ?? 0)), 0) }}</td>
                                                <td class="text-center">${{ number_format($otraCooperativa->total_ventas ?? 0, 2) }}</td>
                                                <td class="text-center">${{ number_format($otraCooperativa->total_comision ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach

                                        @if ($otrasCooperativas->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center text-warning">No hay otras cooperativas con datos.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection