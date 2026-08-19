<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusCutiNotification extends Notification
{
    use Queueable;

    protected $pengajuan;
    protected $pesan;

    /**
     * Create a new notification instance.
     */
    public function __construct($pengajuan, $pesan)
    {
        $this->pengajuan = $pengajuan;
        $this->pesan = $pesan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Ubah menjadi 'database' agar muncul di lonceng website
        return ['database']; 
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Data ini yang akan disimpan dan ditampilkan di menu dropdown notifikasi
        return [
            'pengajuan_id' => $this->pengajuan->id,
            'jenis_cuti' => $this->pengajuan->jenisCuti->nama ?? 'Cuti',
            'status' => $this->pengajuan->status,
            'pesan' => $this->pesan,
        ];
    }
}