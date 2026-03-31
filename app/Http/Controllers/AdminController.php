<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Destination;
use App\Models\FreightRate;
use App\Models\Notification;
use App\Models\Order;
use App\Models\TruckType;
use App\Models\User;
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

    // public function dashboard(Request $request)
    // {
    //     $filter = $request->get('filter', 'month'); 

    //     $user_count = User::count();

    //     return view('admin.dashboard', compact('user_count'));
    // }

    public function dashboard(Request $request)
    {
        $user_count         = User::count();
        $destination_count  = Destination::count();
        $carrier_count      = Carrier::count();
        $truck_type_count   = TruckType::count();
        $freight_rate_count = FreightRate::count();
        $order_count        = Order::count();

        return view('admin.dashboard', compact(
            'user_count',
            'destination_count',
            'carrier_count',
            'truck_type_count',
            'freight_rate_count',
            'order_count'
        ));
    }

}
