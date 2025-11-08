@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar Cliente: {{ $client->name }}</h1>

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

            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT') {{-- Requerido para el método UPDATE --}}
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre *</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $client->name) }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $client->email) }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $client->phone) }}">
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección *</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $client->address) }}" required>
                </div>

                <button type="submit" class="btn btn-success">Actualizar Cliente</button>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection