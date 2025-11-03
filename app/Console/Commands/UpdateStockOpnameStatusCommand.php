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

        // Gunakan Carbon::now() untuk membandingkan waktu lengkap
        $currentTime = Carbon::now();

        // Ambil sesi yang statusnya masih berjalan dan sudah melewati deadline (waktu lengkap)
        $overdueSessions = StockOpnameSession::whereIn('status', ['dijadwalkan', 'proses'])
            ->where('tanggal_deadline', '<', $currentTime) // Bandingkan dengan waktu lengkap saat ini
            ->get();

        if ($overdueSessions->isEmpty()) {
            $this->info('No overdue sessions found.');
            return;
        }

        $this->info("Found {$overdueSessions->count()} overdue session(s). Processing...");

        foreach ($overdueSessions as $session) {
            $this->info("Processing session #{$session->id} for department ID: {$session->department_id}...");
            try {
                DB::transaction(function () use ($session) {
                    // Langkah 1: Tandai sesi sebagai selesai
                    $session->status = 'selesai';
                    $session->tanggal_selesai = now();
                    $session->catatan = trim(($session->catatan ?? '') . ' Sesi ditutup otomatis karena melewati batas waktu.');
                    $session->save();

                    // Langkah 2: Proses Aset BERGERAK & TIDAK BERGERAK yang belum dicek (status_fisik null)
                    $unprocessedMovable = $session->details()
                        ->whereNull('status_fisik')
                        ->whereHas('asset', fn($q) => $q->whereIn('jenis_aset', ['bergerak', 'tidak_bergerak']))
                        ->with('asset')
                        ->get();

                    foreach ($unprocessedMovable as $detail) {
                        $statusLama = $detail->status_lama;
                        $jumlahSistem = $detail->jumlah_sistem;

                        $detail->status_fisik = $statusLama;
                        $detail->jumlah_fisik = $jumlahSistem;
                        $detail->save();

                        $asset = $detail->asset;
                        if ($asset) {
                            $asset->status = $statusLama;
                            $asset->jumlah = $jumlahSistem;
                            $asset->save();
                        }
                    }
                    $this->info("- Processed {$unprocessedMovable->count()} movable/immovable assets (status/jumlah preserved).");

                    // Langkah 3: Proses Aset HABIS PAKAI yang belum dihitung (jumlah_fisik null)
                    $unprocessedConsumable = $session->details()
                        ->whereNull('jumlah_fisik')
                        ->whereHas('asset', fn($q) => $q->where('jenis_aset', 'habis_pakai'))
                        ->with('asset')
                        ->get();

                    foreach ($unprocessedConsumable as $detail) {
                        $jumlahSistem = $detail->jumlah_sistem;
                        $statusLama = $detail->status_lama;

                        $detail->jumlah_fisik = $jumlahSistem;
                        $detail->status_fisik = $statusLama;
                        $detail->save();

                        $asset = $detail->asset;
                        if ($asset) {
                            $asset->jumlah = $jumlahSistem;
                            $asset->status = $statusLama;
                            $asset->save();
                        }
                    }
                    $this->info("- Processed {$unprocessedConsumable->count()} consumable assets (jumlah/status preserved).");
                });
                $this->info("Session #{$session->id} ('{$session->nama}') has been successfully marked as 'selesai'.");
            } catch (\Exception $e) {
                $this->error("Failed to update session #{$session->id}: " . $e->getMessage());
            }
        }

        $this->info('All overdue sessions have been processed.');
    }
}
