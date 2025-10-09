<?php

use Illuminate\Support\Facades\Auth;
use App\Models\StockOpnameSession;

if (!function_exists('isAsetLocked')) {
    /**
     * Cek apakah ada sesi stock opname yang sedang 'proses' untuk departemen dan jenis aset tertentu.
     *
     * @param int $department_id
     * @param string $jenis_aset
     * @return bool
     */
    function isAsetLocked($department_id, $jenis_aset)
    {
        return StockOpnameSession::where('departement_id', $department_id)
            ->whereHas('details.asset', function ($query) use ($jenis_aset) {
                $query->where('jenis_aset', $jenis_aset);
            })
            ->whereIn('status', ['proses', 'dijadwalkan'])
            ->exists();
    }
}

if (! function_exists('routeForRole')) {
    function routeForRole(string $base, string $suffix, mixed $params = []): string
    {
        $role = Auth::user()?->role ?? 'user';
        $routeName = "$role.$base.$suffix";

        return route($routeName, $params);
    }
}
