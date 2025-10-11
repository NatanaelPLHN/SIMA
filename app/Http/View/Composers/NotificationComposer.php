<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\StockOpnameSession;
use App\Models\Departement;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = Auth::user();
        $notifications = collect(); // Defaultnya, notifikasi kosong

        // Pastikan ada user yang login dan rolenya adalah 'subadmin'
        if ($user && $user->role === 'subadmin' && $user->employee) {

            // Cari departemen yang dikepalai oleh user ini
            $department = Departement::where('kepala_bidang_id', $user->employee->id)->first();

            if ($department) {
                // Ambil sesi opname yang dijadwalkan untuk departemen tersebut
                $notifications = StockOpnameSession::where('department_id', $department
                    ->id)
                    ->where('status', 'dijadwalkan')
                    ->latest('tanggal_dijadwalkan')
                    ->get();
            }
        }

        // Kirim variabel $notifications ke view yang memanggil composer ini
        $view->with('notifications', $notifications);
    }
}
