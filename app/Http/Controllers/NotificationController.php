<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = auth()->user()->notifications()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        // Marquer comme lue
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        // Rediriger vers l’URL stockée dans la notification
        return view('notifications.show', compact('notification'));
    }

}
