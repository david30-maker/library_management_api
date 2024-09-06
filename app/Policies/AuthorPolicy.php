<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'Admin' || $user->role === 'Librarian';
    }

    public function update(User $user)
    {
        return $user->role === 'Admin' || $user->role === 'Librarian';
    }

    public function delete(User $user)
    {
        return $user->role === 'Admin';
    }
}
