@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Crear Nuevo Usuario</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            {{-- Muestra errores de validación si existen --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                
                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                
                {{-- Apellido --}}
                <div class="mb-3">
                    <label for="last_name" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                </div>
                
                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                {{-- Nombre de Usuario (Asumiendo que lo agregaste a la migración) --}}
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                </div>
                
                {{-- Teléfono --}}
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                </div>

                {{-- Perfil (Administrador, Gestión, Consultas) --}}
                <div class="mb-3">
                    <label for="profile" class="form-label">Perfil</label>
                    <select class="form-select" id="profile" name="profile" required>
                        <option value="">Seleccione un Perfil</option>
                        <option value="Administrador" {{ old('profile') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Gestion" {{ old('profile') == 'Gestion' ? 'selected' : '' }}>Gestión</option>
                        <option value="Consultas" {{ old('profile') == 'Consultas' ? 'selected' : '' }}>Consultas</option>
                    </select>
                </div>
                
                {{-- Contraseña --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                {{-- Confirmar Contraseña --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-success">Guardar Usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection