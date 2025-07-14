@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="bi bi-people"></i> Gestión de Usuarios - Cambiar Roles</h4>
                </div>
                <div class="card-body">
                    <p class="lead">Aquí podrás gestionar los usuarios y cambiar sus roles.</p>
                    <!-- Tabla de usuarios -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role ?? 'Cliente' }}</td>
                                        <td>
                                            <!-- Espacio para acciones (a implementar más adelante) -->
                                            -
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay usuarios para mostrar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection