<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;

class AssetPolicy
{
    public function viewAny(User $user)
    {
        // smua role bisa lihat asset
        return in_array($user->role, ['pegawai','admin','superadmin']);
    }

    public function view(User $user, Asset $asset)
    {
        // semua role bisa lihat detail
        return in_array($user->role, ['pegawai','admin','superadmin']);
    }

    public function create(User $user)
    {
        // hanya admin & superadmin
        return in_array($user->role, ['admin','superadmin']);
    }

    public function update(User $user, Asset $asset)
    {
        // hanya admin & superadmin
        return in_array($user->role, ['admin','superadmin']);
    }

    public function delete(User $user, Asset $asset)
    {
        // hanya superadmin
        return $user->role === 'superadmin';
    }
}
