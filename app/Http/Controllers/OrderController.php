<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::query();

            // 1. Apply Custom Search Filter
            if ($request->filled('custom_search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('order_number', 'like', '%' . $request->custom_search . '%')
                        ->orWhere('order_name', 'like', '%' . $request->custom_search . '%');
                });
            }

            // 2. Apply Date Filter
            if ($request->filled('registered_date')) {
                $query->whereDate('registered_date', $request->registered_date);
            }

            // 3. Apply Status Filter
            if ($request->filled('status')) {
                $query->where('shipping_status', $request->status);
            }

            // 4. Apply Remaining Days Filter (Example Logic)
            if ($request->filled('remaining_days')) {
                $today = now();
                if ($request->remaining_days == 'overdue') {
                    $query->where('due_date', '<', $today);
                } elseif ($request->remaining_days == '0_3') {
                    $query->whereBetween('due_date', [$today, $today->copy()->addDays(3)]);
                }
                // Add other conditions for 4_7, 8_15, etc...
            }

            return DataTables::of($query)->make(true);
        }

        return view('orders.index');
    }

    public function create(Request $request)
    {
        return view('orders.create');
    }

    public function view($id)
    {
        return view('orders.view');
    }

    public function store(Request $request)
    {
        // 1. Validate the request data
        $validatedData = $request->validate([
            // Basic Info (Required)
            'order_number'           => 'required|string|max:255|unique:orders,order_number',
            'order_name'             => 'required|string|max:255',
            'registered_date'        => 'required|date',

            // Delivery & Shipping
            'due_date'               => 'nullable|date',
            'due_confidence'         => 'nullable|in:confirmed,unconfirmed',
            'inspection_date'        => 'nullable|date',
            'priority'               => 'nullable|in:no,yes',
            'shipping_date'          => 'nullable|date',
            'shipping_status'        => 'nullable|in:unconfirmed,unarranged,arranged,direct_delivery,courier',

            // Documents & Billing
            'dw_status'              => 'nullable|in:undelivered,delivered,not_required',
            'quotation_status'       => 'nullable|in:submitted,not_submitted,not_required',
            'order_status'           => 'nullable|in:received,not_received,not_required',

            // Client Schedule
            'material_pickup_date'   => 'nullable|date',
            'inspection_due_date'    => 'nullable|date',
            'parts_pickup_date'      => 'nullable|date',

            // Billing
            'inspection_slip_status' => 'nullable|in:received,not_received,not_required',
            'invoice_status'         => 'nullable|in:sent,not_sent,not_required',
            'order_amount'           => 'nullable|numeric|min:0',

            // Freight Info
            'destination'            => 'nullable|string|max:255',
            'carrier'                => 'nullable|string|max:255',
            'truck_type'             => 'nullable|string|max:255',
            'freight_price'          => 'nullable|numeric|min:0',

            // Internal Dates
            'pickup_transfer_date'   => 'nullable|date',
            'sales_transfer_date'    => 'nullable|date',
            'shipping_transfer_date' => 'nullable|date',
        ]);

        // 2. Create the order using Mass Assignment
        // Note: Make sure these fields are added to your Order model's $fillable array!
        $order = Order::create($validatedData);

        // 3. Redirect back with success message
        return redirect()->route('order.index')->with('success', 'Order created successfully!');
    }
}
