{{-- resources/views/layouts/navigation_sidebar.blade.php --}}

<div class="sidebar bg-light border-end p-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door-fill me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                <span>Módulos Principales</span>
            </h6>
        </li>

        {{-- Enlace a Gestión de Clientes --}}
        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('clients.index') }}">
                <i class="bi bi-people-fill me-2"></i> Gestión de Clientes
            </a>
        </li>

        {{-- Enlace a Gestión de Usuarios (Solo visible para Administradores) --}}
        {{-- Usamos la directiva @can para aplicar la Policy: Solo si el usuario puede ver la lista de usuarios --}}
        @can('viewAny', App\Models\User::class) 
            <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('users.index') }}">
                    <i class="bi bi-person-lines-fill me-2"></i> Gestión de Usuarios
                </a>
            </li>
        @endcan
    </ul>
</div>