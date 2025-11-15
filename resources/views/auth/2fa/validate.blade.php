@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h4 class="text-center mb-4">Verificación en dos pasos</h4>

            <p class="text-center">
                Introduce el código de 6 dígitos generado por Microsoft Authenticator.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger text-center">
                    {{ $errors->first('code') }}
                </div>
            @endif

            <form method="POST" action="{{ route('2fa.validate.post') }}">
                @csrf

                <div class="mb-3">
                    <label for="code" class="form-label">Código 2FA</label>
                    <input type="text" name="code" id="code" class="form-control"
                           placeholder="123456" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Verificar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
