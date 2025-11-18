@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Ventas del Cliente: {{ $client->name }}</h4>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                            Volver al listado
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $client->email }}</p>
                                <p><strong>Teléfono:</strong> {{ $client->phone ?? 'No especificado' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Dirección:</strong> {{ $client->address ?? 'No especificada' }}</p>
                                <p><strong>Fecha de Alta:</strong> {{ $client->fecha_de_alta ? \Carbon\Carbon::parse($client->fecha_de_alta)->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Historial de Ventas</h5>
                        
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Venta</th>
                                        <th>Fecha</th>
                                        <th>CUIT</th>
                                        <th>Monto</th>
                                        <th>Registrado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($ventas['data']) && count($ventas['data']) > 0)
                                        @foreach($ventas['data'] as $venta)
                                            <tr>
                                                <td>#{{ $venta['id_venta'] ?? 'N/A' }}</td>
                                                <td>{{ isset($venta['fecha']) ? \Carbon\Carbon::parse($venta['fecha'])->format('d/m/Y') : 'N/A' }}</td>
                                                <td>{{ $venta['cuit'] ?? 'N/A' }}</td>
                                                <td>${{ number_format((float)($venta['monto'] ?? 0), 2, ',', '.') }}</td>
                                                <td>{{ isset($venta['created_at']) ? \Carbon\Carbon::parse($venta['created_at'])->format('d/m/Y H:i') : 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                No hay registros de ventas para este cliente.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
