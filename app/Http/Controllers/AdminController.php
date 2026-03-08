<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function latestNotifications()
    {
        $notifications = Notification::where('read', 0)
            ->latest()
            ->take(5)
            ->get();

        $count = Notification::where('read', false)->count();

        // return response()->json($notifications);
        return response()->json([
            'count' => $count,
            'data' => $notifications
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read = 1;
        $notification->save();

        return response()->json(['success' => true]);
    }

    public function dashboard(Request $request)
    {
        $filter = $request->get('filter', 'month'); 

        $user_count = User::count();

        return view('admin.dashboard', compact('user_count'));
    }

}
