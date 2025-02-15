<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationsComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $notifications = $user ? $user->unreadNotifications : collect();

        // Compartir las notificaciones con la vista
        $view->with('notifications', $notifications);
    }
}
