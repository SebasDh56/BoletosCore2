@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Habilitar Autenticación de Dos Factores</h2>

    <p>Escanea este código QR con Google Authenticator o Authy:</p>

    {{-- Mostramos el QR generado en SVG --}}
    <img src="data:image/svg+xml;base64,{{ $qr }}" alt="QR" width="200">

    <p>Clave secreta manual:</p>
    <strong>{{ $secret }}</strong>

    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <label for="code">Código de 6 dígitos:</label>
        <input type="text" name="code" class="form-control" required>

        <button class="btn btn-primary mt-3">Verificar y Activar</button>
    </form>
</div>
@endsection
