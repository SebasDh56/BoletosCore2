
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoletosCore - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0288d1 0%, #4fc3f7 50%, #80deea 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #01579b !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-brand img {
            height: 30px;
        }
        .nav-link {
            color: #e1f5fe !important;
            font-weight: 500;
            padding: 10px 15px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .nav-link:hover {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .nav-icon {
            margin-right: 6px;
        }
        .container-main {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
            max-width: 1200px;
            flex: 1;
        }
        .alert {
            border-radius: 8px;
            animation: slideIn 0.5s ease-in-out;
            position: relative;
            margin-bottom: 20px;
        }
        .alert-dismissible .btn-close {
            padding: 0.75rem 1rem;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            color: #01579b;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 25px;
            text-align: center;
        }
        .btn-primary {
            background-color: #0288d1;
            border-color: #0288d1;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0277bd;
            border-color: #0277bd;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background-color: #546e7a;
            border-color: #546e7a;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-secondary:hover {
            background-color: #455a64;
            border-color: #455a64;
            transform: translateY(-2px);
        }
        footer {
            background-color: #01579b;
            color: #e1f5fe;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }
        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2000;
        }
        @media (max-width: 576px) {
            .container-main {
                padding: 15px;
                margin: 20px 10px;
            }
            .navbar-brand {
                font-size: 1.3rem;
            }
            .nav-link {
                padding: 8px 10px;
            }
            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="https://via.placeholder.com/30?text=BC" alt="">
                BoletosCore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('personas.index') }}"><i class="bi bi-people-fill nav-icon"></i>Personas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cooperativas.index') }}"><i class="bi bi-building-fill nav-icon"></i>Cooperativas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ventas.index') }}"><i class="bi bi-ticket-fill nav-icon"></i>Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ventas.resumen') }}"><i class="bi bi-bar-chart-fill nav-icon"></i>Resumen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-main">
       
       

        @yield('content')
    </div>

    <footer>
        <p>© {{ date('Y') }} BoletosCore. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script para mostrar spinner durante transiciones -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('a:not(.alert .btn-close)');
            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    if (!this.classList.contains('no-spinner')) {
                        const spinner = document.createElement('div');
                        spinner.className = 'loading-spinner';
                        spinner.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>';
                        document.body.appendChild(spinner);
                        spinner.style.display = 'block';
                    }
                });
            });
        });
    </script>
</body>
</html>
