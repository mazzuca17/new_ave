<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Emails;

class AnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $announcement;

    public function __construct(Emails $announcement)
    {
        $this->announcement = $announcement;
    }

    // 📌 Métodos de entrega: base de datos y correo
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    // 📌 Notificación por correo
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📢 Nuevo anuncio: ' . $this->announcement->subject)
            ->greeting('Hola ' . $notifiable->name . ' 👋')
            ->line($this->announcement->content)
            ->action('Ver anuncio', url('/mensajes/' . $this->announcement->id))
            ->line('Gracias por tu atención.');
    }

    // 📌 Notificación en la base de datos
    public function toDatabase($notifiable)
    {
        return [
            'announcement_id' => $this->announcement->id,
            'subject'         => $this->announcement->subject,
            'content'         => $this->announcement->content,
            'sender'          => $this->announcement->sender_user_id
        ];
    }
}
