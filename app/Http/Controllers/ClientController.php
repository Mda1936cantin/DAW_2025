<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Opcional, pero bueno para transacciones/debugging
use Illuminate\Support\Facades\Http;

// ¡Asegúrate de que esta línea esté presente y correcta!
use App\Http\Requests\StoreClientRequest; // <-- Debería ser 'App\Http\Requests'
use App\Http\Requests\UpdateClientRequest; // Y la de UpdateRequest también

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Requisito: Obtener todos los clientes (listado)[cite: 40].
        $clients = Client::orderBy('name')->paginate(10); // Ejemplo de paginación
        
        // Requisito: La vista debe ser Blade y organizada (resources/views/clients/index.blade.php)[cite: 54, 78].
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)// Las validaciones se ejecutan automáticamente.
    {
      // Requisito: Incluir validaciones de datos obligatorias[cite: 42, 74].  
      // Operación CRUD usando Eloquent ORM.     
        Client::create($request->validated());
        
        // Requisito: Mostrar mensaje de éxito[cite: 43].
        return redirect()->route('clients.index')
                         ->with('success', 'Cliente dado de alta con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        // Requisito: Validaciones de datos[cite: 42, 74].            
        // Operación CRUD usando Eloquent ORM.
        $client->update($request->validated());
        // Requisito: Mostrar mensaje de éxito[cite: 43].
        return redirect()->route('clients.index')
                         ->with('success', 'Cliente editado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Operación CRUD de eliminación usando Eloquent ORM.
        $client->delete();
        
        // Requisito: Mostrar mensaje de éxito[cite: 43].
        return redirect()->route('clients.index')
                         ->with('success', 'Cliente eliminado con éxito.');
    }
// --- Método para la Fase 3: Consumo de Servicio Externo (Ventas) ---
    public function showVentas(Client $client)
    {
        try {
            $apiConfig = config('api.ventas');
            $baseUrl = rtrim($apiConfig['base_url'], '/');
            
            // 1. Obtener token JWT
            $loginResponse = Http::post(
                $baseUrl . $apiConfig['endpoints']['login'],
                $apiConfig['credentials']
            );
            
            if (!$loginResponse->successful()) {
                return redirect()->back()
                    ->with('error', 'No se pudo autenticar con el servicio de ventas: ' . $loginResponse->body());
            }

            $token = $loginResponse->json('token');
            
            if (empty($token)) {
                return redirect()->back()
                    ->with('error', 'No se recibió un token válido del servicio de autenticación');
            }
            
            // 2. Obtener ventas del cliente usando el token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($baseUrl . $apiConfig['endpoints']['ventas'], [
                'cliente_id' => $client->id
            ]);

            $ventas = [];
            
            if ($response->successful()) {
                $ventas = $response->json();
            }

            return view('clients.ventas', [
                'client' => $client,
                'ventas' => $ventas
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al conectar con el servicio de ventas: ' . $e->getMessage());
        }
    }



}
