<?php

namespace App\Policies;

use App\Models\AssetUsage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetUsagePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        // Superadmin mendapatkan akses penuh untuk semua ability
        if ($user->role === 'superadmin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Subadmin dan User boleh melihat halaman index
        return in_array($user->role, ['subadmin', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssetUsage  $assetUsage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AssetUsage $assetUsage)
    {
        // dd(
        //     'Role Pengguna:',
        //     $user->role,
        //     'Departemen ID Pengguna:',
        //     $user->employee?->department_id,
        //     'Departemen ID Asset Usage:',
        //     $assetUsage->department_id,
        //     'Employee ID Pengguna:',
        //     $user->employee?->id,
        //     'Asset Usage Digunakan Oleh (used_by):',
        //     $assetUsage->used_by
        // );
        if ($user->role === 'subadmin') {
            // Subadmin hanya bisa melihat usage di departemennya
            return $user->employee?->department_id === $assetUsage->department_id;
        }

        if ($user->role === 'user') {
            // User hanya bisa melihat usage miliknya sendiri
            return $user->employee?->id === $assetUsage->used_by;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Hanya subadmin yang bisa membuat usage baru
        return $user->role === 'subadmin';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssetUsage  $assetUsage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AssetUsage $assetUsage)
    {
        // Hanya subadmin yang bisa mengupdate usage di departemennya
        return $user->role === 'subadmin' && $user->employee?->department_id === $assetUsage->department_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssetUsage  $assetUsage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AssetUsage $assetUsage)
    {
        // Hanya subadmin yang bisa menghapus usage di departemennya
        return $user->role === 'subadmin' && $user->employee?->department_id === $assetUsage->department_id;
    }
    /**
     * Determine whether the user can return the asset.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AssetUsage  $assetUsage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function return(User $user, AssetUsage $assetUsage)
    {
        // Hanya subadmin yang bisa mengembalikan aset di departemennya
        return $user->role === 'subadmin' && $user->employee?->department_id === $assetUsage->department_id;
    }
}
