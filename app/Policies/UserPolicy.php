<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['superadmin','admin']);
    }

    public function view(User $user, User $target)
    {
        if ($user->role === 'superadmin') {
            return $target->role === 'admin'; // only manages admins
        }

        if ($user->role === 'admin') {
            return $target->role === 'user' &&
                $user->employee &&
                $target->employee &&
                $user->employee->department->instansi_id === $target->employee->department->instansi_id;
        }

        if ($user->role === 'user') {
            return $user->id === $target->id;
        }

        return false;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['superadmin','admin']);
    }

    public function update(User $user, User $target)
    {
        return $this->view($user, $target);
    }

    public function delete(User $user, User $target)
    {
        if ($user->id === $target->id) return false; // can't delete self
        return $this->update($user, $target);
    }
}

