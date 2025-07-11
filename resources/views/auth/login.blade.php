@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5" style="border-color: #007bff;">
                    <div class="card-header bg-primary text-white text-center">
                        <h3><i class="bi bi-shield-lock"></i> Iniciar Sesión</h3>
                    </div>
                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label text-dark fw-semibold">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope-fill"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label text-dark fw-semibold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-dark" for="remember">Recordarme</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2" style="font-size: 1.1rem;">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                            </button>

                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 py-2" style="font-size: 1.1rem;">
                                <i class="bi bi-person-plus-fill"></i> Registrar
                            </a>
                            <p class="mt-2 text-muted">¿Olvidaste tu contraseña? <a href="#" class="text-primary fw-medium">Recupérala aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection