<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Withdrawal;

class WithdrawalCompletedNotification extends Notification
{
    use Queueable;
    protected $withdrawal;

    /**
     * Create a new notification instance.
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Anda bisa tambahkan 'database' jika ingin notifikasi in-app
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Penarikan Saldo Berhasil!')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Penarikan saldo Anda sebesar Rp ' . number_format($this->withdrawal->amount, 0, ',', '.') . ' telah berhasil diproses dan ditransfer ke rekening Anda.')
            ->line('Status: ' . ucfirst($this->withdrawal->status))
            ->line('No. Rekening: ' . $this->withdrawal->bank_account_number)
            ->action('Lihat Riwayat Penarikan', url('/traveler/withdrawals'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'withdrawal_id' => $this->withdrawal->id,
            'amount' => $this->withdrawal->amount,
            'status' => $this->withdrawal->status,
            'message' => 'Penarikan saldo Anda sebesar Rp ' . number_format($this->withdrawal->amount, 0, ',', '.') . ' telah selesai diproses.',
        ];
    }
}
