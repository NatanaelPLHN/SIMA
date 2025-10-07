<?php

namespace App\Observers;

  use App\Models\Departement;
  use App\Models\Employee;
  use App\Models\User;

  class DepartementObserver
  {
      /**
       * Handle the Departement "updated" event.
       */
      public function updated(Departement $departement): void
      {
          // Cek apakah kepala bidang berubah
          if ($departement->wasChanged('kepala_bidang_id')) {

              // Dapatkan ID kepala bidang yang LAMA
              $oldKepalaId = $departement->getOriginal('kepala_bidang_id');

              // Dapatkan ID kepala bidang yang BARU
              $newKepalaId = $departement->kepala_bidang_id;

              // 1. Proses Kepala Bidang LAMA (jika ada)
              if ($oldKepalaId) {
                  $oldKepalaUser = User::where('karyawan_id', $oldKepalaId)->first();
                  // Jika user lama ada, ubah rolenya kembali menjadi 'user'
                  if ($oldKepalaUser) {
                      $oldKepalaUser->role = 'user';
                      $oldKepalaUser->save();
                  }
              }

              // 2. Proses Kepala Bidang BARU (jika ada)
              if ($newKepalaId) {
                  $newKepalaUser = User::where('karyawan_id', $newKepalaId)->first();
                  // Jika user baru ada, ubah rolenya menjadi 'subadmin'
                  if ($newKepalaUser) {
                      $newKepalaUser->role = 'subadmin';
                      $newKepalaUser->save();
                  }
              }
          }
      }
  }