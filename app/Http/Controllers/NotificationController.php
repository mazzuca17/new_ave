<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Obtener las notificaciones del usuario autenticado
        $notifications = auth()->user()->unreadNotifications;

        return view('notifications.index', compact('notifications'));
    }
}
