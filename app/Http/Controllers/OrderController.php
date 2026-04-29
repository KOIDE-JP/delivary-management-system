<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Destination;
use App\Models\FreightRate;
use App\Models\Order;
use App\Models\TruckType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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

            // 4. Apply Remaining Days Filter
            if ($request->filled('remaining_days')) {
                $today = now()->startOfDay();
                if ($request->remaining_days == 'overdue') {
                    $query->where('due_date', '<', $today);
                } elseif ($request->remaining_days == '0_3') {
                    $query->whereBetween('due_date', [$today, $today->copy()->addDays(3)]);
                }
                // Add other conditions for 4_7, 8_15, etc...
            }

            return DataTables::of($query)
                // APPLY HIGHLIGHT RULES: due_date - today <= 0 AND priority == 'yes'
                ->setRowClass(function ($row) {
                    $highlight = false;

                    if ($row->due_date && $row->priority === 'yes') {
                        $today = now()->startOfDay();
                        $dueDate = Carbon::parse($row->due_date)->startOfDay();

                        if ($dueDate->lte($today)) {
                            $highlight = true;
                        }
                    }

                    return $highlight
                        ? 'bg-red-100 hover:bg-red-200 transition-colors divide-y divide-red-200 text-sm'
                        : 'bg-white hover:bg-blue-50/50 transition-colors divide-y divide-gray-100 text-sm';
                })
                ->addColumn('remaining_days', function ($row) {
                    if (!$row->due_date) {
                        return '<span class="text-xs text-gray-500">' . __('layouts.pending') . '</span>';
                    }

                    $today = now()->startOfDay();
                    $dueDate = Carbon::parse($row->due_date)->startOfDay();
                    $diff = $today->diffInDays($dueDate, false);

                    if ($diff < 0) {
                        $text = abs($diff) . ' ' . __('layouts.days_overdue');
                        $badge = 'text-red-700 bg-red-100';
                    } elseif ($diff == 0) {
                        $text = __('layouts.today');
                        $badge = 'text-orange-700 bg-orange-100';
                    } else {
                        $text = $diff . ' ' . __('layouts.days_left');
                        $badge = 'text-green-700 bg-green-100';
                    }

                    return '<span class="inline-flex items-center px-2 py-0.5 text-xs font-bold rounded-md ' . $badge . '">' . $text . '</span>';
                })
                ->addColumn('order_details', function ($row) {
                    $date = $row->registered_date ? $row->registered_date : 'N/A';
                    return '
                    <div class="font-bold text-gray-900"># ' . htmlspecialchars($row->order_number) . '</div>
                    <div class="text-xs text-gray-600 mt-0.5 mb-1.5 font-medium">' . htmlspecialchars($row->order_name) . '</div>
                    <div class="text-[11px] text-gray-400 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                         ' . __('layouts.reg') . ': ' . $date . '
                    </div>
                ';
                })
                ->addColumn('delivery_info', function ($row) {
                    $carrier = $row->carrier ? $row?->Carrier?->name : __('layouts.pending_carrier');
                    $date = $row->shipping_date ? $row->shipping_date : __('layouts.tbd');
                    return '
                    <div class="text-sm font-medium text-gray-900">' . htmlspecialchars($carrier) . '</div>
                    <div class="mt-1 text-xs text-gray-500">' . __('layouts.shipping_date') . ': ' . htmlspecialchars($date) . '</div>
                ';
                })
                ->addColumn('status', function ($row) {
                    $priorityHtml = $row->priority === 'yes'
                        ? '<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-red-700 bg-red-100 rounded-md mb-1"> ' . __('layouts.priority') . '</span>'
                        : '<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-gray-600 bg-gray-100 rounded-md mb-1">' . __('layouts.normal') . '</span>';

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
                    $viewUrl   = route('order.view', $row->id);
                    $editUrl   = route('order.edit', $row->id);
                    $deleteUrl   = route('order.destroy', $row->id);

                    $actions = '<div class="flex items-center justify-end gap-2">';
                    if (auth()->user()->hasPermission('order.view')) {
                        $actions .= '
                        <a href="' . $viewUrl . '" title="' . __('layouts.view') . '" class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                            <i class="fa-solid fa-eye"></i>
                        </a>';
                    }
                    if (auth()->user()->hasPermission('order.edit')) {
                        $actions .= '
                        <a href="' . $editUrl . '" title="' . __('layouts.edit') . '" class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                            <i class="fa-solid fa-pencil"></i>
                        </a>';
                    }
                    if (auth()->user()->hasPermission('order.destroy')) {
                        $actions .= '
                            <form action="' . $deleteUrl . '" method="POST" class="inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button title="' . __('layouts.delete') . '" type="button" onclick="confirmOrderDelete(this)"
                                    class="p-2 text-red-500 transition-colors bg-red-50 border border-red-100 rounded-lg hover:text-red-700 hover:bg-red-100 hover:border-red-200 cursor-pointer">
                                    <i class="fa-solid fa-trash w-3 h-3"></i>
                                </button>
                            </form>';
                    }
                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['remaining_days', 'order_details', 'delivery_info', 'status', 'action'])
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
        // dd($destinations->toArray(), $carriers, $truckTypes, $freightRates);
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
            'dw_status'              => 'nullable|in:not_shipped,shipped,no_shipping_required',
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
        return redirect()->route('order.index')->with('success', __('layouts.order_text') . ' ' . __('layouts.created_successfully'));
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
            'dw_status'              => 'nullable|in:not_shipped,shipped,no_shipping_required',
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

        // Get the fields that were actually changed during the update
        $changes = $order->getChanges();

        // Remove 'updated_at' as we don't need to explicitly tell the user the timestamp changed
        unset($changes['updated_at']);

        if (count($changes) > 0) {
            // Format the changed keys nicely (e.g. 'due_date' becomes 'due date')
            $changedFields = implode(', ', array_map(function ($field) {
                return str_replace('_', ' ', $field);
            }, array_keys($changes)));

            // Pass it as a JSON string so your Blade file can decode it
            $logMessage = json_encode([
                'custom_message' => __('layouts.order_updated') . '. ' . __('layouts.updated_fields') . ": " . ucwords($changedFields)
            ]);
        } else {
            // Fallback to the original lang key if they hit 'update' without changing anything
            $logMessage = 'order_updated';
        }

        logActivity(
            $order,
            'action_updated',
            $logMessage,
            'status_success'
        );

        // 3. Redirect back with success message
        return redirect()->route('order.view', ['id' => $order->id])->with('success', __('layouts.order_text') . ' ' . __('layouts.updated_successfully'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        logActivity(
            $order,
            'action_deleted',
            'moved_to_trash_success',
            'status_success'
        );

        return redirect()->route('order.index')->with('success', __('layouts.moved_to_trash_success'));
    }

    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            // Get only trashed orders
            $query = Order::onlyTrashed();

            // 1. Apply Custom Search Filter
            if ($request->filled('custom_search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('order_number', 'like', '%' . $request->custom_search . '%')
                        ->orWhere('order_name', 'like', '%' . $request->custom_search . '%');
                });
            }

            return DataTables::of($query)
                ->addColumn('order_details', function ($row) {
                    $date = $row->registered_date ? $row->registered_date : 'N/A';
                    return '
                <div class="font-bold text-gray-900"># ' . htmlspecialchars($row->order_number) . '</div>
                <div class="text-xs text-gray-600 mt-0.5 mb-1.5 font-medium">' . htmlspecialchars($row->order_name) . '</div>
                <div class="text-[11px] text-gray-400 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                     ' . __('layouts.reg') . ': ' . $date . '
                </div>';
                })
                ->addColumn('deleted_at', function ($row) {
                    $formattedDate = $row->deleted_at ? $row->deleted_at->format('Y-m-d H:i') : 'N/A';
                    return '<span class="inline-flex items-center px-2 py-0.5 text-xs font-bold rounded-md text-red-700 bg-red-100">' . htmlspecialchars($formattedDate) . '</span>';
                })
                ->addColumn('delivery_info', function ($row) {
                    $carrier = $row->carrier ? $row?->Carrier?->name : __('layouts.pending_carrier');
                    $date = $row->shipping_date ? $row->shipping_date : __('layouts.tbd');
                    return '
                <div class="text-sm font-medium text-gray-900">' . htmlspecialchars($carrier) . '</div>
                <div class="mt-1 text-xs text-gray-500">' . __('layouts.shipping_date') . ': ' . htmlspecialchars($date) . '</div>';
                })
                ->addColumn('status', function ($row) {
                    $priorityHtml = $row->priority === 'yes'
                        ? '<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-red-700 bg-red-100 rounded-md mb-1"> ' . __('layouts.priority') . '</span>'
                        : '<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-gray-600 bg-gray-100 rounded-md mb-1">' . __('layouts.normal') . '</span>';

                    $statusText = $row->shipping_status ? __('layouts.' . $row->shipping_status) : __('layouts.pending');
                    $statusColor = $row->shipping_status === 'arranged' ? 'text-blue-700 bg-blue-100' : 'text-yellow-800 bg-yellow-100';

                    return '
                <div class="flex flex-col items-start">
                    ' . $priorityHtml . '
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium ' . $statusColor . ' rounded-full">
                        ' . htmlspecialchars($statusText) . '
                    </span>
                </div>';
                })
                ->addColumn('action', function ($row) {
                    $restoreUrl     = route('order.restore', $row->id);
                    $forceDeleteUrl = route('order.forceDelete', $row->id);

                    $actions = '<div class="flex items-center justify-end gap-2">';

                    // Restore Button
                    $actions .= '
                    <form action="' . $restoreUrl . '" method="POST" class="inline">
                        ' . csrf_field() . '
                        <button title="' . __('layouts.restore') . '" type="submit" 
                            class="p-2 text-green-600 transition-colors bg-green-50 border border-green-200 rounded-lg hover:text-green-800 hover:bg-green-100 hover:border-green-300 cursor-pointer">
                            <i class="fa-solid fa-rotate-left w-3 h-3"></i>
                        </button>
                    </form>';

                    // Force Delete Button (Wrap in permission check if needed)
                    $actions .= '
                    <form action="' . $forceDeleteUrl . '" method="POST" class="inline">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button title="' . __('layouts.force_delete') . '" type="button" onclick="confirmDelete(this)"
                            class="p-2 text-red-600 transition-colors bg-red-50 border border-red-200 rounded-lg hover:text-red-800 hover:bg-red-100 hover:border-red-300 cursor-pointer">
                            <i class="fa-solid fa-trash-can w-3 h-3"></i>
                        </button>
                    </form>';

                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['order_details', 'deleted_at', 'delivery_info', 'status', 'action'])
                ->make(true);
        }

        return view('orders.trashed');
    }

    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();

        return back()->with('success', __('layouts.order_restore_success'));
    }

    public function forceDelete($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->forceDelete();

        return back()->with('success', __('layouts.order_deleted_permanently'));
    }

    public function importOrders()
    {
        return view('orders.import');
    }

    public function uploadImportFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        try {
            // Parse Excel file into an array using Maatwebsite\Excel
            $data = Excel::toArray(new class implements \Maatwebsite\Excel\Concerns\ToArray {
                public function array(array $array) { return $array; }
            }, $request->file('file'));

            $rows = $data[0] ?? [];

            // Data starts at row 4
            $rows = array_slice($rows, 3); 
            
            // Filter out completely empty rows
            $rows = array_filter($rows, function($row) {
                return !empty(array_filter($row)); 
            });

            // Save to a temporary JSON file for chunk processing
            $fileId = uniqid('import_');
            Storage::put("temp/{$fileId}.json", json_encode(array_values($rows)));

            return response()->json([
                'success' => true,
                'file_id' => $fileId,
                'total_rows' => count($rows)
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function processImportChunk(Request $request)
    {
        $fileId = $request->input('file_id');
        $offset = (int) $request->input('offset', 0);
        $limit = 50; // Process 50 rows per request

        $path = "temp/{$fileId}.json";
        if (!Storage::exists($path)) {
            return response()->json(['success' => false, 'message' => 'Import file expired or lost.'], 404);
        }

        $rows = json_decode(Storage::get($path), true);
        $chunk = array_slice($rows, $offset, $limit);

        foreach ($chunk as $row) {
            // Skip if no Order Number
            if (empty($row[2])) continue; 

            $shippingDate = $this->parseDate($row[11] ?? null);

            Order::updateOrCreate(
                ['order_number' => trim($row[2])],
                [
                    'registered_date'        => $this->parseDate($row[1] ?? null),
                    'order_name'             => trim($row[3] ?? ''),
                    'due_date'               => $this->parseDate($row[4] ?? null),
                    
                    'dw_status'              => $this->mapStatus($row[5] ?? null, 'dw'),
                    'quotation_status'       => $this->mapStatus($row[6] ?? null, 'quotation'),
                    'order_status'           => $this->mapStatus($row[7] ?? null, 'order'),
                    
                    'material_pickup_date'   => $this->parseDate($row[8] ?? null),
                    'parts_pickup_date'      => $this->parseDate($row[9] ?? null),
                    
                    'shipping_date'          => $shippingDate,
                    // Schema doesn't have 'confirmed', mapping to 'arranged' when date exists
                    'shipping_status'        => $shippingDate ? 'arranged' : 'unconfirmed',
                    
                    'invoice_status'         => $this->mapStatus($row[12] ?? null, 'invoice'),
                    'inspection_due_date'    => $this->parseDate($row[13] ?? null),
                    'inspection_slip_status' => $this->mapStatus($row[14] ?? null, 'inspection'),
                    
                    'order_amount'           => $this->parseAmount($row[15] ?? null),
                    
                    'destination'            => trim($row[17] ?? null),
                    'carrier'                => trim($row[18] ?? null),
                    'truck_type'             => trim($row[19] ?? null),
                    'freight_price'          => $this->parseAmount($row[20] ?? null),
                    
                    'pickup_transfer_date'   => $this->parseDate($row[21] ?? null),
                    'sales_transfer_date'    => $this->parseDate($row[22] ?? null),
                    'shipping_transfer_date' => $this->parseDate($row[23] ?? null),
                ]
            );
        }

        $newOffset = $offset + count($chunk);
        $isDone = $newOffset >= count($rows);

        if ($isDone) {
            Storage::delete($path); // Cleanup
        }

        return response()->json([
            'success' => true,
            'processed' => $newOffset,
            'is_done' => $isDone
        ]);
    }

    // --- Helper Methods ---

    private function parseDate($value)
    {
        if (empty($value)) return null;
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseAmount($value)
    {
        if (empty($value)) return null;
        // Remove ¥, commas, and spaces
        $clean = preg_replace('/[¥, \s]/u', '', $value);
        return is_numeric($clean) ? (float) $clean : null;
    }

    private function mapStatus($value, $type)
    {
        $val = trim((string)$value);
        $isO = ($val === 'O' || $val === '〇' || $val === '0');
        $isX = ($val === 'X' || $val === '×');

        switch($type) {
            case 'dw':
                if ($isO) return 'shipped';
                if ($isX) return 'no_shipping_required';
                return 'not_shipped';
            case 'quotation':
                if ($isO) return 'submitted';
                if ($isX) return 'not_required';
                return 'not_submitted';
            case 'order':
                if ($isO) return 'received';
                if ($isX) return 'not_required';
                return 'not_received';
            case 'invoice':
                if ($isO) return 'sent';
                return 'not_sent';
            case 'inspection':
                if ($isO) return 'received';
                if ($isX) return 'not_required';
                return 'not_received';
        }
        return null;
    }
}
