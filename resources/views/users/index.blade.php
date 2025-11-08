@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Gestión de Usuarios</h1>

    {{-- Mensajes de Éxito/Error (Requisito: 1.3) --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Botón para Crear Nuevo Usuario (Protegido por Policy) --}}
    @can('create', App\Models\User::class)
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
            Crear Nuevo Usuario
        </a>
    @endcan

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-secondary">{{ $user->profile }}</span></td>
                                <td>
                                    {{-- Muestra si el usuario tiene baja lógica (SoftDeletes) --}}
                                    @if ($user->trashed())
                                        <span class="badge bg-danger">BAJA</span>
                                    @else
                                        <span class="badge bg-success">ACTIVO</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Botón para Ver (show) --}}
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">Ver</a>
                                    
                                    {{-- Botón para Editar (Protegido por Policy) --}}
                                    @can('update', $user)
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Editar</a>
                                    @endcan

                                    {{-- Formulario para Eliminar (Baja Lógica) (Protegido por Policy) --}}
                                    @can('delete', $user)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de dar de baja a este usuario?')">Baja</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }} {{-- Paginación --}}
            </div>
        </div>
    </div>
@endsection