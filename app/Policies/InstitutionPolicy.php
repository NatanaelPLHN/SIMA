<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Institution;

class InstitutionPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'superadmin';
    }

    public function view(User $user, Institution $institution)
    {
        return $user->role === 'superadmin';
    }

    public function create(User $user)
    {
        return $user->role === 'superadmin';
    }

    public function update(User $user, Institution $institution)
    {
        return $user->role === 'superadmin';
    }

    public function delete(User $user, Institution $institution)
    {
        return $user->role === 'superadmin';
    }
}

