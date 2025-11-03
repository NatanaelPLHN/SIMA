<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\StockOpnameSession;
use App\Models\Departement;
use App\Models\User; // Tambahkan model User

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
        // serta merupakan subadmin dari department tertentu
        if ($user && $user->role === 'subadmin' && $user->employee && $user->employee->department) {

            // Ambil department_id dari data employee user yang login
            $departmentId = $user->employee->department->id;

            // Pastikan department ini memiliki subadmin aktif (yaitu user yang login)
            // Ini sebenarnya sudah dipastikan oleh kondisi di atas, jadi query tambahan seperti
            // $hasSubadmin mungkin tidak diperlukan di sini kecuali ada logika tambahan.
            // Kita asumsikan bahwa jika user adalah subadmin dan terikat ke departemen, maka dia adalah subadmin dari departemen tersebut.

            // Ambil sesi opname yang dijadwalkan untuk departemen tersebut
            $notifications = StockOpnameSession::where('department_id', $departmentId)
                // ->where('status', 'dijadwalkan') // Sesuaikan dengan nama kolom status yang benar, misalnya 'scheduled'
                ->whereIn('status', ['proses', 'dijadwalkan'])

                ->latest('tanggal_dijadwalkan') // Sesuaikan dengan nama kolom tanggal yang benar
                ->get();
        }

        // Kirim variabel $notifications ke view yang memanggil composer ini
        $view->with('notifications', $notifications);
    }
}