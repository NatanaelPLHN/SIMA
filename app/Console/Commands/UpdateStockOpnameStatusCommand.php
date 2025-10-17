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

        // Ambil sesi yang statusnya masih berjalan dan sudah melewati deadline
        $overdueSessions = StockOpnameSession::whereIn('status', ['dijadwalkan', 'proses'])
            ->where('tanggal_deadline', '<', $today)
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

                    // Langkah 2: Proses Aset Bergerak & Tidak Bergerak yang belum dicek
                    $unprocessedMovable = $session->details()
                        ->whereNull('status_fisik')
                        ->whereHas('asset', fn($q) => $q->whereIn('jenis_aset', ['bergerak', 'tidak_bergerak']))
                        ->with('asset')
                        ->get();

                    foreach ($unprocessedMovable as $detail) {
                        $asset = $detail->asset;
                        $detail->status_fisik = 'hilang';
                        $detail->jumlah_fisik = 0;
                        $detail->save();

                        if ($asset) {
                            $asset->status = 'hilang';
                            $asset->jumlah = 0;
                            $asset->save();
                        }
                    }
                    $this->info("- Processed {$unprocessedMovable->count()} movable/immovable assets.");

                    // Langkah 3: Proses Aset Habis Pakai yang belum dihitung
                    $unprocessedConsumable = $session->details()
                        ->whereNull('jumlah_fisik')
                        ->whereHas('asset', fn($q) => $q->where('jenis_aset', 'habis_pakai'))
                        ->with('asset')
                        ->get();

                    foreach ($unprocessedConsumable as $detail) {
                        $asset = $detail->asset;
                        $detail->jumlah_fisik = 0;
                        $detail->status_fisik = 'habis';
                        $detail->save();

                        if ($asset) {
                            $asset->jumlah = 0;
                            $asset->status = 'habis';
                            $asset->save();
                        }
                    }
                    $this->info("- Processed {$unprocessedConsumable->count()} consumable assets.");
                });
                $this->info("Session #{$session->id} ('{$session->nama}') has been successfully marked as 'selesai'.");
            } catch (\Exception $e) {
                $this->error("Failed to update session #{$session->id}: " . $e->getMessage());
            }
        }

        $this->info('All overdue sessions have been processed.');
    }
}
