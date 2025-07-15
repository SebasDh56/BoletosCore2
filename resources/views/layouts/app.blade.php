<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BoletosCore') - Sistema de Boletos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e6f0fa 0%, #ffffff 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background: linear-gradient(90deg, #007bff, #0056b3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }
        .navbar-brand {
            color: #ffffff;
            font-weight: 600;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover {
            transform: scale(1.05);
            color: #e9ecef;
        }
        .nav-link {
            color: #ffffff !important;
            font-weight: 400;
            margin-left: 1rem;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .nav-link:hover {
            color: #e9ecef !important;
            transform: translateY(-2px);
        }
        .container {
            flex: 1;
            margin-top: 30px;
        }
        .alert {
            border-radius: 10px;
            padding: 15px;
            animation: fadeIn 0.5s ease-in;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .table-responsive {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            background-color: #ffffff;
        }
        th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #007bff;
            color: #ffffff;
            font-weight: 600;
            text-align: center;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        footer {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">BoletosCore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        @if (Auth::user()->role === 'cliente')
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('personas.index') }}"><i class="bi bi-people-fill"></i> Personas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('ventas.index') }}"><i class="bi bi-receipt-cutoff"></i> Ventas</a>
                            </li>
                        @elseif (Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('personas.index') }}"><i class="bi bi-people-fill"></i> Personas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('cooperativas.index') }}"><i class="bi bi-building-fill"></i> Cooperativas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('ventas.index') }}"><i class="bi bi-receipt-cutoff"></i> Ventas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('users.index') }}"><i class="bi bi-gear"></i> Gestionar Usuarios</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <span class="nav-link text-white">Hola, {{ Auth::user()->name }} ({{ Auth::user()->role ?? 'Cliente' }})</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <p>© 2025 BoletosCore. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>