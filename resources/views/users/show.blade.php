@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Detalles del Usuario: {{ $user->name }} {{ $user->last_name }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información General</h6>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Apellido:</strong> {{ $user->last_name }}</p>
            <p><strong>Nombre de Usuario:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Teléfono:</strong> {{ $user->phone ?? 'N/A' }}</p>
            <p><strong>Perfil:</strong> <span class="badge bg-secondary">{{ $user->profile }}</span></p>
            <p><strong>Fecha de Creación:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver al Listado</a>
    @can('update', $user)
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Editar Usuario</a>
    @endcan
@endsection