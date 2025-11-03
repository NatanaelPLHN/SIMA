<?php

namespace App\Services;

use App\Mail\OpnameScheduledNotificationMail;
use App\Models\StockOpnameSession;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendOpnameScheduledNotification(StockOpnameSession $opnameSession)
    {
        $subAdmins = User::where('role', 'subadmin')
            ->whereHas('employee', function ($query) use ($opnameSession) {
                $query->where('department_id', $opnameSession->department_id);
            })
            ->get();

        Log::info("Mengirim notifikasi ke " . $subAdmins->count() . " subadmin untuk opname sesi ID: " . $opnameSession->id);

        foreach ($subAdmins as $subAdmin) {
            if ($subAdmin->email) {
                Log::info("Mengirim email ke: " . $subAdmin->email);
                Mail::to($subAdmin->email)->send(new OpnameScheduledNotificationMail($opnameSession));
            } else {
                Log::warning("Subadmin ID {$subAdmin->id} tidak memiliki email.");
            }
        }
    }
}
