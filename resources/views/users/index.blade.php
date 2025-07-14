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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
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
                                            <form action="{{ route('users.updateRole', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <select name="role" class="form-control d-inline-block w-auto">
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="cliente" {{ $user->role == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Cambiar Rol</button>
                                            </form>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
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