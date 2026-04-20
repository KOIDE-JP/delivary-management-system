<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Destination;
use App\Models\FreightRate;
use App\Models\Order;
use App\Models\TruckType;
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

            return DataTables::of($query)
                ->addColumn('order_details', function ($row) {
                    $date = $row->registered_date ? $row->registered_date : 'N/A';
                    return '
                    <div class="font-bold text-gray-900">' . htmlspecialchars($row->order_number) . '</div>
                    <div class="text-xs text-gray-600 mt-0.5 mb-1.5 font-medium">' . htmlspecialchars($row->order_name) . '</div>
                    <div class="text-[11px] text-gray-400 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                         ' . __('layouts.reg') . ': ' . $date . '
                    </div>
                ';
                })
                ->addColumn('timeline', function ($row) {
                    $daysTxt = $row->due_date ? $row->due_date :  __('layouts.pending');
                    return '
                    <div class="flex flex-col gap-1.5 items-start">
                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold text-orange-700 bg-orange-100 rounded-md">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            ' . __('layouts.due') . ': ' . htmlspecialchars($daysTxt) . '
                        </span>
                    </div>
                ';
                })
                ->addColumn('delivery_info', function ($row) {
                    $carrier = $row->carrier ? $row?->Carrier?->name : __('layouts.pending_carrier');
                    $date = $row->shipping_date ? $row->shipping_date : __('layouts.tbd');
                    return '
                    <div class="text-sm font-medium text-gray-900">' . htmlspecialchars($carrier) . '</div>
                    <div class="mt-1 text-xs text-gray-500">Est: ' . htmlspecialchars($date) . '</div>
                ';
                })
                ->addColumn('status', function ($row) {
                    $priorityHtml = $row->priority === 'yes'
                        ? '<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-red-700 bg-red-100 rounded-md mb-1"> ' . __('layouts.priority') . '</span>'
                        : '<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-gray-600 bg-gray-100 rounded-md mb-1">' . __('layouts.normal') . '</span>';

                    // $statusText = $row->shipping_status ? strtoupper($row->shipping_status) : '.' . __('layouts.pending') . '.';
                    $statusText = $row->shipping_status ? __('layouts.' . $row->shipping_status) : __('layouts.pending');
                    $statusColor = $row->shipping_status === 'arranged' ? 'text-blue-700 bg-blue-100' : 'text-yellow-800 bg-yellow-100';

                    return '
                    <div class="flex flex-col items-start">
                        ' . $priorityHtml . '
                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium ' . $statusColor . ' rounded-full">
                            ' . htmlspecialchars($statusText) . '
                        </span>
                    </div>
                ';
                })
                ->addColumn('action', function ($row) {
                    // Here you can securely use route() and check permissions!
                    $viewUrl   = route('order.view', $row->id); // Update with your actual route names
                    $editUrl   = route('order.edit', $row->id);

                    $actions = '<div class="flex items-center justify-end gap-2">';

                    // Example of permission wrapping
                    // if (auth()->user()->hasPermission('order.view')) {
                    $actions .= '
                        <a href="' . $viewUrl . '" title="' . __('layouts.view') . '" class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                            <i class="fa-solid fa-eye"></i>
                        </a>';
                    // }

                    // if (auth()->user()->hasPermission('order.edit')) {
                    $actions .= '
                        <a href="' . $editUrl . '" title="' . __('layouts.edit') . '" class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                            <i class="fa-solid fa-pencil"></i>
                        </a>';
                    // }

                    // if (auth()->user()->hasPermission('order.delete')) {
                    $actions .= '
                        <a href="#" title="' . __('layouts.delete') . '" class="p-2 text-red-500 transition-colors bg-red-50 border border-red-100 rounded-lg hover:text-red-700 hover:bg-red-100 hover:border-red-200">
                            <i class="fa-solid fa-trash"></i>
                        </a>';
                    // }

                    $actions .= '</div>';

                    return $actions;
                })
                // CRITICAL: Tell DataTables to render these columns as raw HTML
                ->rawColumns(['order_details', 'timeline', 'delivery_info', 'status', 'action'])
                ->make(true);
        }

        return view('orders.index');
    }

    public function create(Request $request)
    {
        $destinations = Destination::select('name', 'id', 'prefix')->get();
        $carriers = Carrier::select('name', 'id')->get();
        $truckTypes = TruckType::select('name', 'id')->get();
        $freightRates = FreightRate::all();
        // dump($destinations, $carriers, $truckTypes, $freightRates);
        // dd('Debugging: Check if data is loaded correctly');
        return view('orders.create', compact('destinations', 'carriers', 'truckTypes', 'freightRates'));
    }

    public function view($id)
    {
        $order = Order::findOrFail($id);
        // dd($order->Destination->name);
        $activityLogs = $order->activityLogs()->latest()->paginate(5);
        return view('orders.view', compact('order', 'activityLogs'));
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
            'freight_master_price'   => 'nullable|numeric|min:0',
            'freight_note'           => 'nullable|string|max:255',
            
            // Internal Dates
            'pickup_transfer_date'   => 'nullable|date',
            'sales_transfer_date'    => 'nullable|date',
            'shipping_transfer_date' => 'nullable|date',
        ]);

        if (!is_null($validatedData['freight_price']) && !is_null($validatedData['freight_master_price'])) {
            if ((float)$validatedData['freight_price'] !== (float)$validatedData['freight_master_price']) {
                $validatedData['freight_is_manual'] = true;
            }
        }

        // 2. Create the order using Mass Assignment
        // Note: Make sure these fields are added to your Order model's $fillable array!
        $order = Order::create($validatedData);

        logActivity(
            $order,
            'action_created',
            'order_created',
            'status_success'
        );

        // 3. Redirect back with success message
        return redirect()->route('order.index')->with('success', 'Order created successfully!');
    }

    public function edit($id)
    {
        $destinations = Destination::select('name', 'id', 'prefix')->get();
        $carriers = Carrier::select('name', 'id')->get();
        $truckTypes = TruckType::select('name', 'id')->get();
        $freightRates = FreightRate::all();
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order', 'destinations', 'carriers', 'truckTypes', 'freightRates'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // 1. Validate the request data
        $validatedData = $request->validate([
            // Ignore the current order's ID for the unique check
            'order_number'           => 'required|string|max:255|unique:orders,order_number,' . $order->id,
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
            'freight_master_price'   => 'nullable|numeric|min:0',
            'freight_note'           => 'nullable|string|max:255',

            // Internal Dates
            'pickup_transfer_date'   => 'nullable|date',
            'sales_transfer_date'    => 'nullable|date',
            'shipping_transfer_date' => 'nullable|date',
        ]);

        // 2. Update the order
        $order->update($validatedData);

        logActivity(
            $order,
            'action_updated',
            'order_updated',
            'status_success'
        );

        // 3. Redirect back with success message
        return redirect()->route('order.index')->with('success', 'Order updated successfully!');
    }
}
