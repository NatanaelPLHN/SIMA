<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        // Hanya superadmin, admin, dan subadmin yang bisa melihat daftar user.
        return in_array($user->role, ['superadmin', 'admin', 'subadmin']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function view(User $user, User $targetUser): bool
    {
        // User tidak bisa melihat dirinya sendiri di daftar (jika diperlukan)
        if ($user->id === $targetUser->id) {
            return true; // Atau false, tergantung kebutuhan UI
        }

        switch ($user->role) {
            case 'superadmin':
                // Superadmin bisa melihat semua role di bawahnya
                return in_array($targetUser->role, ['admin', 'subadmin', 'user']);

            case 'admin':
                // Admin bisa melihat subadmin dan user di instansinya
                return in_array($targetUser->role, ['subadmin', 'user']) &&
                    $user->employee->institution_id === $targetUser
                    ->employee->institution_id;

            case 'subadmin':
                // Subadmin bisa melihat user di departemennya
                return $targetUser->role === 'user' &&
                    $user->employee->department_id === $targetUser->employee->department_id;

            default:
                return false;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        // Hanya superadmin, admin, dan subadmin yang bisa membuat user baru.
        return in_array($user->role, ['superadmin', 'admin', 'subadmin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $targetUser): bool
    {
        // Logikanya sama dengan 'view', siapa yang bisa melihat, dia juga bisa update.
        return $this->view($user, $targetUser);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function delete(User $user, User $targetUser): bool
    {
        // Pengguna tidak bisa menghapus dirinya sendiri.
        if ($user->id === $targetUser->id) {
            return false;
        }

        // Logika sama persis dengan 'view'
        return $this->view($user, $targetUser);
    }
}
