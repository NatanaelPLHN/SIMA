<?php // app/Observers/StockOpnameSessionObserver.php

namespace App\Observers;

use App\Models\StockOpnameSession;
use App\Services\NotificationService; // Import Service
use Illuminate\Support\Facades\Log; // Import Log jika belum

class StockOpnameSessionObserver
{
    protected $notificationService;

    // Constructor untuk inject NotificationService
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function created(StockOpnameSession $stockOpnameSession)
    {
        // Jika statusnya langsung 'dijadwalkan' saat dibuat
        if ($stockOpnameSession->status === 'dijadwalkan') {
             $this->notificationService->sendOpnameScheduledNotification($stockOpnameSession);
             Log::info("Observer: Notifikasi dikirim karena sesi opname baru dibuat dengan status 'dijadwalkan'. ID: {$stockOpnameSession->id}");
        }
    }

    public function updated(StockOpnameSession $stockOpnameSession)
    {
        // Cek apakah kolom 'status' berubah dan menjadi 'dijadwalkan'
        if ($stockOpnameSession->isDirty('status') && $stockOpnameSession->status === 'dijadwalkan') {
            $this->notificationService->sendOpnameScheduledNotification($stockOpnameSession);
            Log::info("Observer: Notifikasi dikirim karena status sesi opname diubah menjadi 'dijadwalkan'. ID: {$stockOpnameSession->id}");
        }
    }
}