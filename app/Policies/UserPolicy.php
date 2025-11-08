<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any users (Listar usuarios).
     * Solo administradores pueden ver el listado completo de usuarios.
     */
    public function viewAny(User $user): bool
    {
        return $user->profile === 'Administrador';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create users (Crear usuario).
     */
    public function create(User $user): bool
    {
        return $user->profile === 'Administrador';
    }

    /**
     * Determine whether the user can update the user (Editar usuario).
     */
    public function update(User $user, User $model): bool
    {
        // El administrador puede editar cualquier usuario, excepto a sí mismo (opcional, pero buena práctica)
        // Opcional: return $user->profile === 'Administrador' && $user->id !== $model->id; 
        return $user->profile === 'Administrador';
    }

    /**
     * Determine whether the user can delete the user (Eliminar usuario).
     */
    public function delete(User $user, User $model): bool
    {
        // El administrador puede eliminar usuarios, excepto a sí mismo.
        return $user->profile === 'Administrador' && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
