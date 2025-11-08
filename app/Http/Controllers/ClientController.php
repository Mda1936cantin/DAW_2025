<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Opcional, pero bueno para transacciones/debugging

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
        // Este método se desarrollará en la Fase 3 para consumir el endpoint externo protegido con JWT[cite: 45, 46].
        // Por ahora, lo dejamos vacío.
        return view('clients.ventas', compact('client'));
    }



}
