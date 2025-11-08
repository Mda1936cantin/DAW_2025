<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // <-- Asegúrate de importar tu clase base
use Illuminate\Validation\Rule; // <-- ¡Añade esta línea!

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo si el usuario puede ver la lista (viewAny en la Policy)
    $this->authorize('viewAny', User::class); 
    
    $users = User::paginate(10);
    return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Proteger la ruta con la Policy (create)
        $this->authorize('create', User::class); 
        
        // Crea la vista users/create.blade.php
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        
        // Validaciones (debes crear un FormRequest aquí para la separación de responsabilidades)
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username', // Campo de usuario
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:50',
            'profile' => ['required', Rule::in(['Administrador', 'Gestion', 'Consultas'])],
            'password' => 'required|string|min:8|confirmed', // password_confirmation es requerido
        ]);
        
        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile' => $request->profile,
            // Requerimiento: Utilizar contraseñas encriptadas mediante bcrypt
            'password' => Hash::make($request->password), 
        ]);
        
        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // La vista de un usuario individual no es crítica, se puede permitir o restringir con 'view'
        // $this->authorize('view', $user); 
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update', $user); // Proteger con Policy (update)
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $user); // Proteger con Policy (update)
        
        // Validaciones de actualización...
        // ...
        
        $user->update([ /* datos validados */ ]);
        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $this->authorize('delete', $user); // Proteger con Policy (delete)
        
        // Usa delete() para la baja lógica gracias al trait SoftDeletes
        $user->delete(); 
        
        return redirect()->route('users.index')->with('success', 'Usuario dado de baja con éxito.');
    }
}
