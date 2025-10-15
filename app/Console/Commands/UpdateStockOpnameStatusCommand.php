<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StockOpnameSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateStockOpnameStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stock-opname-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of stock opname sessions that have passed their deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for overdue stock opname sessions...');

        $today = Carbon::today();

        // Ambil sesi yang statusnya masih berjalan (dijadwalkan/proses) dan sudah melewati deadline
        $overdueSessions = StockOpnameSession::whereIn('status', ['dijadwalkan', 'proses'])
            ->where('tanggal_deadline', '<', $today)
            ->get();

        if ($overdueSessions->isEmpty()) {
            $this->info('No overdue sessions found.');
            return;
        }

        $this->info("Found {$overdueSessions->count()} overdue session(s). Processing...");

        foreach ($overdueSessions as $session) {
            try {
                DB::transaction(function () use ($session) {
                    // 1. Ubah status sesi utama
                    $session->status = 'selesai';
                    $session->tanggal_selesai = Carbon::now();
                    $session->catatan = trim(($session->catatan ?? '') . ' Sesi ditutup otomatis karena melewati batas waktu.');
                    $session->save();

                    // 2. Proses detail yang belum diverifikasi
                    // Asumsi 'belum diproses' adalah jika status fisik belum diubah dari status awal

                    // --------------------------------
                    // PERLU DIPERHATIKAN YG BAWAH INI , KARENA BISA JADI SEMUA SUDAH SESUAI KARENA STATUS LAMA DAN FISIK SUDAH SESUAI
                    // -------------------------------
                    // $unprocessedDetails = $session->details()->whereColumn('status_lama', 'status_fisik')->get();

                    // foreach ($unprocessedDetails as $detail) {
                    //     $asset = $detail->asset;
                    //     if (!$asset) continue;

                    //     // Logika default saat deadline terlewat
                    //     if (in_array($asset->jenis_aset, ['bergerak', 'tidak_bergerak'])) {
                    //         // Jika status masih 'tersedia', anggap 'hilang'
                    //         if ($detail->status_fisik === 'tersedia') {
                    //             $detail->status_fisik = 'hilang';
                    //             $detail->jumlah_fisik = 0;
                    //         }
                    //     } elseif ($asset->jenis_aset === 'habis_pakai') {
                    //         // Jika habis pakai, anggap jumlahnya 0 dan statusnya 'habis'
                    //         $detail->jumlah_fisik = 0;
                    //         $detail->status_fisik = 'habis';
                    //     }

                    //     $detail->save();
                    // }
                });
                $this->info("Session #{$session->id} ('{$session->nama}') has been marked as 'selesai'.");
            } catch (\Exception $e) {
                $this->error("Failed to update session #{$session->id}: " . $e->getMessage());
            }
        }

        $this->info('All overdue sessions have been processed.');
    }
}
