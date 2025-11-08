<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- 1. Estilos y Scripts de Vite/Tailwind (instalados por Breeze) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 2. Integración de Bootstrap (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- 3. Estilos personalizados para la barra lateral --}}
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding-top: 56px; /* Para que inicie debajo del navbar */
        }
        .main-content {
            margin-left: 250px; /* Ajusta el contenido principal para que no se superponga */
            padding-top: 66px; /* Espacio para el encabezado */
        }
        .navbar {
            z-index: 1010; /* Asegura que la barra de navegación esté por encima de todo */
        }
    </style>
</head>
<body>
    {{-- 4. ENCABEZADO (Navbar Fijo) --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            {{-- Logo y Título del Proyecto --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                {{--  Reemplaza con tu logo --}}
                <img src="/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                {{-- Título: TECNICATURA UNIVERSITARIA EN TECNOLOGÍAS DE LA INFORMACIÓN [cite: 2] --}}
                **TUTI** - Gestión de Clientes
            </a>
            
            {{-- Dropdown de Usuario (Logout) --}}
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    {{-- 5. BARRA DE NAVEGACIÓN LATERAL (Se carga como componente) --}}
    @include('layouts.navigation_sidebar')

    {{-- 6. CONTENIDO PRINCIPAL DINÁMICO --}}
    <main class="main-content">
        <div class="container-fluid">
            @yield('content') {{-- Aquí se inyectará el contenido de cada vista (ej: users.index) --}}
        </div>
    </main>

    {{-- 7. Scripts de Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>