<?php
// namespace App\Console\Commands;
// 4
// 5 use Illuminate\Console\Command;
// 6 use App\Models\StockOpnameSession;
// 7 use Carbon\Carbon;
// 8 use Illuminate\Support\Facades\DB;
// 9
// 10 class UpdateStockOpnameStatusCommand extends Command
// 11 {
// 12     /**
// 13      * The name and signature of the console command.
// 14      *
// 15      * @var string
// 16      */
// 17     protected $signature = 'app:update-stock-opname-status';
// 18
// 19     /**
// 20      * The console command description.
// 21      *
// 22      * @var string
// 23      */
// 24     protected $description = 'Update status of stock opname sessions that have passed their deadline';
// 25
// 26     /**
// 27      * Execute the console command.
// 28      */
// 29     public function handle()
// 30     {
// 31         $this->info('Checking for overdue stock opname sessions...');
// 32
// 33         $today = Carbon::today();
// 34
// 35         // Ambil sesi yang statusnya masih berjalan (dijadwalkan/proses) dan sudah melewati deadline
// 36         $overdueSessions = StockOpnameSession::whereIn('status', ['dijadwalkan', 'proses'])
// 37             ->where('tanggal_deadline', '<', $today)
// 38             ->get();
// 39
// 40         if ($overdueSessions->isEmpty()) {
// 41             $this->info('No overdue sessions found.');
// 42             return;
// 43         }
// 44
// 45         $this->info("Found {$overdueSessions->count()} overdue session(s). Processing...");
// 46
// 47         foreach ($overdueSessions as $session) {
// 48             try {
// 49                 DB::transaction(function () use ($session) {
// 50                     // 1. Ubah status sesi utama
// 51                     $session->status = 'selesai';
// 52                     $session->tanggal_selesai = Carbon::now();
// 53                     $session->catatan = trim(($session->catatan ?? '') . ' Sesi ditutup otomatis karena melewati batas waktu.');
// 54                     $session->save();
// 55
// 56                     // 2. Proses detail yang belum diverifikasi
// 57                     // Asumsi 'belum diproses' adalah jika status fisik belum diubah dari status awal
// 58                     $unprocessedDetails = $session->details()->whereColumn('status_lama', 'status_fisik')->get();
// 59
// 60                     foreach ($unprocessedDetails as $detail) {
// 61                         $asset = $detail->asset;
// 62                         if (!$asset) continue;
// 63
// 64                         // Logika default saat deadline terlewat
// 65                         if (in_array($asset->jenis_aset, ['bergerak', 'tidak_bergerak'])) {
// 66                             // Jika status masih 'tersedia', anggap 'hilang'
// 67                             if ($detail->status_fisik === 'tersedia') {
// 68                                 $detail->status_fisik = 'hilang';
// 69                                 $detail->jumlah_fisik = 0;
// 70                             }
// 71                         } elseif ($asset->jenis_aset === 'habis_pakai') {
// 72                             // Jika habis pakai, anggap jumlahnya 0 dan statusnya 'habis'
// 73                             $detail->jumlah_fisik = 0;
// 74                             $detail->status_fisik = 'habis';
// 75                         }
// 76
// 77                         $detail->save();
// 78                     }
// 79                 });
// 80                 $this->info("Session #{$session->id} ('{$session->nama}') has been marked as 'selesai'.");
// 81             } catch (\Exception $e) {
// 82                 $this->error("Failed to update session #{$session->id}: " . $e->getMessage());
// 83             }
// 84         }
// 85
// 86         $this->info('All overdue sessions have been processed.');
// 87     }
// 88 }