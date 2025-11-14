@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Verificación en dos pasos</h3>
    <p>Introduce el código generado en tu app (Microsoft Authenticator).</p>

    <form method="POST" action="{{ route('2fa.validate.post') }}">
        @csrf
        <input type="text" name="code" class="form-control" placeholder="Código 2FA">
        <br>
        <button class="btn btn-primary">Validar</button>
    </form>
</div>
@endsection
