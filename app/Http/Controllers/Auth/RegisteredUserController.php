<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule; // <-- ¡Añade o corrige esta línea!
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'], // <-- NUEVO
        'username' => ['required', 'string', 'max:255', 'unique:users'], // <-- NUEVO y ÚNICO
        'phone' => ['nullable', 'string', 'max:50'], // <-- NUEVO
        'profile' => ['required', Rule::in(['Administrador', 'Gestion', 'Consultas'])], // <-- NUEVO
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name, 
            
            // ¡ESTA LÍNEA ES LA QUE FALTABA O ESTABA MAL UBICADA!
            'username' => $request->username, // <-- AÑADIR O CORREGIR
            
            'phone' => $request->phone, 
            'profile' => $request->profile, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
