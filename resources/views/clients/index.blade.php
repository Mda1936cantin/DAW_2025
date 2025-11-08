@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Gestión de Clientes</h1>

    {{-- Mensajes de Éxito/Error --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">
        Registrar Nuevo Cliente
    </a>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Fecha de Alta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->fecha_de_alta ? \Carbon\Carbon::parse($client->fecha_de_alta)->format('d/m/Y') : 'N/A' }}</td>
                                <td>
                                    {{-- Botón para Ver Ventas (Fase 3) --}}
                                    <a href="{{ route('clients.ventas', $client) }}" class="btn btn-sm btn-info me-1">
                                        Ver ventas
                                    </a>
                                    
                                    {{-- Botones CRUD --}}
                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                                    
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este cliente?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay clientes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- {{ $clients->links() }} --}} {{-- Si usas paginación --}}
            </div>
        </div>
    </div>
@endsection