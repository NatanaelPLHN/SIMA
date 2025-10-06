<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Departement;

class DepartementPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin']);
    }

    public function view(User $user, Departement $departement)
    {
        if ($user->role === 'admin') {
            return $user->employee &&
                $user->employee->department &&
                $user->employee->department->instansi_id === $departement->instansi_id;
        }
        return false;
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Departement $departement)
    {
        return $this->view($user, $departement);
    }

    public function delete(User $user, Departement $departement)
    {
        return $this->update($user, $departement);
    }
}

