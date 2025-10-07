<?php
namespace App\Observers;

use App\Models\Employee;
use App\Models\Institution;
use App\Models\User;

class InstitutionObserver
{
    /**
     * Handle the Institution "updated" event.
     */
    public function updated(Institution $institution): void
    {
        // Cek apakah kepala instansi berubah
        if ($institution->wasChanged('kepala_instansi_id')) {

            // Dapatkan ID kepala instansi yang LAMA
            $oldKepalaId = $institution->getOriginal('kepala_instansi_id');

            // Dapatkan ID kepala instansi yang BARU
            $newKepalaId = $institution->kepala_instansi_id;

            // 1. Proses Kepala Instansi LAMA (jika ada)
            if ($oldKepalaId) {
                $oldKepalaUser = User::where('karyawan_id', $oldKepalaId)->first();
                // Jika user lama ada dan rolenya admin, ubah kembali menjadi 'user'
                if ($oldKepalaUser && $oldKepalaUser->role === 'admin') {
                    $oldKepalaUser->role = 'user';
                    $oldKepalaUser->save();
                }
            }

            // 2. Proses Kepala Instansi BARU (jika ada)
            if ($newKepalaId) {
                // 1. Hapus department_id dari employee yang baru diangkat
                $newKepalaEmployee = Employee::find($newKepalaId);
                if ($newKepalaEmployee) {
                    $newKepalaEmployee->department_id = null; // Hapus departemen
                    $newKepalaEmployee->save();
                }

                // 2. Update role user menjadi 'admin'
                $newKepalaUser = User::where('karyawan_id', $newKepalaId)->first();
                // Jika user baru ada, promosikan rolenya menjadi 'admin'
                if ($newKepalaUser) {
                    $newKepalaUser->role = 'admin';
                    $newKepalaUser->save();
                }
            }
        }
    }
}