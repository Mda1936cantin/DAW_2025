@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar Usuario: {{ $user->name }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT') {{-- Requerido para el método UPDATE --}}
                
                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                
                {{-- Apellido --}}
                <div class="mb-3">
                    <label for="last_name" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                </div>
                
                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                
                {{-- Teléfono --}}
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>

                {{-- Perfil --}}
                <div class="mb-3">
                    <label for="profile" class="form-label">Perfil</label>
                    <select class="form-select" id="profile" name="profile" required>
                        <option value="Administrador" {{ old('profile', $user->profile) == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Gestion" {{ old('profile', $user->profile) == 'Gestion' ? 'selected' : '' }}>Gestión</option>
                        <option value="Consultas" {{ old('profile', $user->profile) == 'Consultas' ? 'selected' : '' }}>Consultas</option>
                    </select>
                </div>
                
                {{-- Cambio de Contraseña (Opcional) --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña (Dejar vacío para no cambiar)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                
                <button type="submit" class="btn btn-success">Actualizar Usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection