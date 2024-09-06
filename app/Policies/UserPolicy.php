<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'Admin';
    }

    public function view(User $user, User $model)
    {
        return $user->role === 'Admin' || $user->id === $model->id;
    }

    public function delete(User $user)
    {
        return $user->role === 'Admin';
    }
}
