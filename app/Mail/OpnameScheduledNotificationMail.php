<?php

namespace App\Mail;

use App\Models\StockOpnameSession; // Import model yang relevan
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpnameScheduledNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $opnameSession; // Properti publik agar bisa diakses di template

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(StockOpnameSession $opnameSession)
    {
        $this->opnameSession = $opnameSession;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pemberitahuan: Sesi Opname Baru Dijadwalkan')
                    ->markdown('mail.opname-scheduled');
                    // ->from(config('mail.from.address'), config('mail.from.name')); // Opsional: jika ingin override default
    }
}