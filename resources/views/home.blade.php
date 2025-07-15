@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="bi bi-speedometer2"></i> Bienvenido a BoletosCore</h4>
                </div>
                <div class="card-body">
                    <p class="lead text-success fw-bold mb-4" style="background-color: #e9f7ef; padding: 10px; border-radius: 5px;">
                        <i class="bi bi-info-circle-fill"></i> En total en ventas de la Cooperativa 1 y además la totalidad de comisiones y boletos restantes
                    </p>

                    <!-- Sección de Resumen -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5><i class="bi bi-bar-chart-fill"></i> Resumen de Ventas</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cooperativa</th>
                                            <th>Total Boletos</th>
                                            <th>Total Comisiones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cooperativas as $cooperativa)
                                            <tr>
                                                <td>{{ $cooperativa->nombre }}</td>
                                                <td>{{ $cooperativa->total_boletos ?? 0 }}</td>
                                                <td>${{ number_format($cooperativa->total_comision ?? 0, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No hay datos de ventas disponibles.</td>
                                            </tr>
                                        @endforelse
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