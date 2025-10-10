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

$overdueSessions = StockOpnameSession::whereIn('status', ['dijadwalkan', 'proses'])
->where('tanggal_deadline', '<', $today)
         ->get();

         if ($overdueSessions->isEmpty()) {
             $this->info('No overdue sessions found.');
             return;
         }

         foreach ($overdueSessions as $session) {
             try {
                 DB::transaction(function () use ($session) {
                     $session->status = 'selesai';
                     $session->tanggal_selesai = Carbon::now();
                     $session->catatan = ($session->catatan ? $session->catatan . ' ' : '') . 'Sesi ditutup otomatis karena melewati batas waktu.';
                     $session->save();

                     // Iterasi melalui detail yang belum diproses
                     // Asumsi 'belum diproses' adalah jika jumlah fisik masih 0 dan status fisik belum diubah dari status lama
                     $unprocessedDetails = $session->details()->whereColumn('status_lama', 'status_fisik')->get();

                     foreach ($unprocessedDetails as $detail) {
                         $asset = $detail->asset;
                         if (!$asset) continue;