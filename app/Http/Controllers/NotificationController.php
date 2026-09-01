<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())->update(['is_read' => true]);

        return back();
    }
}