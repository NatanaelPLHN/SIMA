<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Departement;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Perluas daftar nama depan (total 80 nama realistis Indonesia)
        $namaDepan = [
            // Asli dari Anda (50)
            'Budi', 'Andi', 'Fajar', 'Agus', 'Rizky', 'Ahmad', 'Eko', 'Yusuf', 'Rian', 'Hendra',
            'Imam', 'Bayu', 'Adi', 'Doni', 'Irfan', 'Rizal', 'Taufik', 'Galih', 'Ferry', 'Rudi',
            'Joko', 'Arif', 'Teguh', 'Nanda', 'Bagus',
            'Siti', 'Dina', 'Rina', 'Putri', 'Nina', 'Mega', 'Tasya', 'Lina', 'Dewi', 'Fitri',
            'Ayu', 'Wulan', 'Rani', 'Yuni', 'Maya', 'Silvi', 'Laila', 'Intan', 'Dwi', 'Citra',
            'Desi', 'Ratna', 'Nadya', 'Tiara', 'Elsa',

            // Tambahan 30 nama umum (laki & perempuan)
            'Reza', 'Dedi', 'Hadi', 'Wawan', 'Asep', 'Dani', 'Raka', 'Gilang', 'Raka', 'Wildan',
            'Siska', 'Lia', 'Anita', 'Rika', 'Novi', 'Yanti', 'Rina', 'Sari', 'Lusi', 'Indah',
            'Hari', 'Deni', 'Wahyu', 'Ilham', 'Raka', 'Bima', 'Kevin', 'Michelle', 'Stevani', 'Alif'
        ];

        $namaBelakang = [
            'Santoso', 'Pratama', 'Supriyadi', 'Nugroho', 'Setiawan', 'Hidayat', 'Fauzi', 'Saputra',
            'Maulana', 'Firmansyah', 'Gunawan', 'Kurniawan', 'Sutanto', 'Wibowo', 'Nugraha',
            'Permana', 'Suryadi', 'Wijaya', 'Kusuma', 'Lesmana', 'Susanto', 'Saputro', 'Syahputra',
            'Ramadhan', 'Prayoga', 'Hermawan', 'Purnama', 'Wardana', 'Utama', 'Mahendra',
            'Raharja', 'Surya', 'Adinata', 'Wirawan', 'Darmawan', 'Prasetyo', 'Hakim', 'Rahman',
            'Irawan', 'Suryono'
        ];

        $jalan = [
            'Jl. Melati', 'Jl. Mawar', 'Jl. Kenanga', 'Jl. Anggrek', 'Jl. Dahlia',
            'Jl. Cempaka', 'Jl. Flamboyan', 'Jl. Teratai', 'Jl. Kamboja', 'Jl. Bougenville',
            'Jl. Seroja', 'Jl. Sedap Malam', 'Jl. Mawar Putih', 'Jl. Tulip', 'Jl. Lavender',
            'Jl. Kenari', 'Jl. Pahlawan', 'Jl. Sudirman', 'Jl. Diponegoro', 'Jl. Gatot Subroto'
        ];

        // === Generate semua kombinasi unik ===
        $allNames = [];
        foreach ($namaDepan as $depan) {
            foreach ($namaBelakang as $belakang) {
                $allNames[] = $depan . ' ' . $belakang;
            }
        }

        $allNames = array_unique($allNames);
        shuffle($allNames);

        if (count($allNames) < 2000) {
            throw new \Exception("Jumlah kombinasi nama (" . count($allNames) . ") masih kurang dari 2000.");
        }

        // Ambil 2000 nama pertama
        $selectedNames = array_slice($allNames, 0, 2000);

        // Hitung jumlah departemen agar distribusi merata
        $departements = Departement::all();
        if ($departements->isEmpty()) {
            throw new \Exception("Tidak ada departemen. Jalankan DepartementSeeder terlebih dahulu.");
        }

        $totalEmployees = 2000;
        $perDepartment = intval(ceil($totalEmployees / count($departements)));
        $counter = 0;
        $nameIndex = 0;

        foreach ($departements as $departement) {
            for ($i = 1; $i <= $perDepartment; $i++) {
                if ($nameIndex >= 2000) break;

                $nama = $selectedNames[$nameIndex];
                $nameIndex++;

                $employee = Employee::create([
                    'nip' => '1979' . str_pad($departement->id, 3, '0', STR_PAD_LEFT) . str_pad(($i % 1000), 3, '0', STR_PAD_LEFT),
                    'nama' => $nama,
                    'alamat' => $jalan[array_rand($jalan)] . ' No.' . rand(1, 150),
                    'telepon' => '08' . rand(1000000000, 9999999999),
                    'department_id' => $departement->id,
                    'institution_id' => $departement->instansi_id,
                ]);

                // Pegawai pertama di tiap departemen jadi kepala bidang
                if ($i === 1) {
                    $departement->update(['kepala_bidang_id' => $employee->id]);
                }

                $counter++;
                if ($counter >= 2000) break;
            }
            if ($counter >= 2000) break;
        }

        echo "Seeder selesai membuat {$counter} pegawai dengan nama **unik**.\n";
    }
}