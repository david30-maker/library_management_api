<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
        use HandlesAuthorization;

        public function create(User $user)
        {
            return $user->role === 'Admin' || $user->role === 'Librarian';
        }

        public function update(User $user, Book $book)
        {
            return $user->role === 'Admin' || $user->role === 'Librarian';
        }

        public function delete(User $user, Book $book)
        {
            return $user->role === 'Admin';
        }
}
