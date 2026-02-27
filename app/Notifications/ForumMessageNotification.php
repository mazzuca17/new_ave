<?php

namespace App\Notifications;

use App\Models\Forum;
use App\Models\ForumMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ForumMessageNotification extends Notification
{
    use Queueable;

    protected $forum;
    protected $message;

    public function __construct(Forum $forum, ForumMessage $message)
    {
        $this->forum = $forum;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nuevo mensaje en foro',
            'subject' => $this->forum->title,
            'message' => mb_strimwidth(strip_tags($this->message->body), 0, 120, '...'),
            'forum_id' => $this->forum->id,
            'url' => route('forums.show', $this->forum->id),
            'icon' => 'fa-comments',
        ];
    }
}
