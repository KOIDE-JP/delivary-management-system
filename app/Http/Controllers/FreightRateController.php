<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Destination;
use App\Models\FreightRate;
use App\Models\TruckType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class FreightRateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $freightRates = FreightRate::with(['destination', 'carrier', 'truckType'])->latest();

            return DataTables::of($freightRates)
                ->addIndexColumn()
                ->addColumn('destination_name', fn($row) => $row->destination?->name ?? '-')
                ->addColumn('carrier_name',     fn($row) => $row->carrier?->name ?? '-')
                ->addColumn('truck_type_name',  fn($row) => $row->truckType?->name ?? '-')
                ->addColumn('status', function ($row) {
                    $checked  = $row->status ? 'checked' : '';
                    $disabled = auth()->user()->hasPermission('freight-rates.edit') ? '' : 'disabled';
                    return '
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" ' . $checked . ' ' . $disabled . '
                                onchange="toggleStatus(' . $row->id . ', this, \'freight-rates\')">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full
                                peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px]
                                after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full
                                after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $viewUrl   = route('freight-rates.show', $row->id);
                    $editUrl   = route('freight-rates.edit', $row->id);
                    $deleteUrl = route('freight-rates.destroy', $row->id);
                    $actions   = '<div class="text-center space-x-2">';

                    // if (auth()->user()->hasPermission('freight-rates.view')) {
                        $actions .= '
                            <a title="' . __('layouts.view') . '" href="' . $viewUrl . '"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium
                                rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2
                                focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fa-solid fa-eye w-3 h-3"></i>
                            </a>';
                    // }

                    if (auth()->user()->hasPermission('freight-rates.edit')) {
                        $actions .= '
                            <a title="' . __('layouts.edit') . '" href="' . $editUrl . '"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium
                                rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2
                                focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fa-solid fa-pencil w-3 h-3"></i>
                            </a>';
                    }

                    if (auth()->user()->hasPermission('freight-rates.destroy')) {
                        $actions .= '
                            <form action="' . $deleteUrl . '" method="POST" class="inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button title="' . __('layouts.delete') . '" type="button" onclick="confirmDelete(this)"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium
                                    rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2
                                    focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                                    <i class="fa-solid fa-trash w-3 h-3"></i>
                                </button>
                            </form>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('freight-rates.index');
    }

    public function create()
    {
        $destinations = Destination::where('status', 1)->orderBy('name')->get();
        $carriers     = Carrier::where('status', 1)->orderBy('name')->get();
        $truckTypes   = TruckType::where('status', 1)->orderBy('name')->get();

        return view('freight-rates.create', compact('destinations', 'carriers', 'truckTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => ['required', 'exists:destinations,id'],
            'carrier_id'     => ['required', 'exists:carriers,id'],
            'truck_type_id'  => ['required', 'exists:truck_types,id'],
            'price'          => ['required', 'numeric', 'min:0'],
            'destination_id' => [
                Rule::unique('freight_rates')->where(fn($q) =>
                    $q->where('destination_id', $request->destination_id)
                    ->where('carrier_id', $request->carrier_id)
                    ->where('truck_type_id', $request->truck_type_id)
                ),
            ],
        ], [
            'destination_id.unique' => __('layouts.already_exists_freight_rates'),
        ]);

        $freightRate = FreightRate::create([
            'destination_id' => $request->destination_id,
            'carrier_id'     => $request->carrier_id,
            'truck_type_id'  => $request->truck_type_id,
            'price'          => $request->price,
            'status'         => 1,
            'created_by'     => auth()->id(),
            'updated_by'     => auth()->id(),
        ]);

        logActivity(
            $freightRate,
            __('layouts.action_created'),
            __('layouts.freight_rate_created'),
            __('layouts.status_success')
        );

        return redirect()->route('freight-rates.index')
            ->with('success', __('layouts.created_successfully'));
    }

    public function edit(FreightRate $freightRate)
    {
        $destinations = Destination::orderBy('name')->get();
        $carriers     = Carrier::orderBy('name')->get();
        $truckTypes   = TruckType::orderBy('name')->get();

        return view('freight-rates.edit', compact('freightRate', 'destinations', 'carriers', 'truckTypes'));
    }

    public function update(Request $request, FreightRate $freightRate)
    {
        $request->validate([
            'destination_id' => ['required', 'exists:destinations,id'],
            'carrier_id'     => ['required', 'exists:carriers,id'],
            'truck_type_id'  => ['required', 'exists:truck_types,id'],
            'price'          => ['required', 'numeric', 'min:0'],
            'status'         => ['required', 'in:0,1'],
            'destination_id' => [
                Rule::unique('freight_rates')->where(fn($q) =>
                    $q->where('destination_id', $request->destination_id)
                    ->where('carrier_id', $request->carrier_id)
                    ->where('truck_type_id', $request->truck_type_id)
                )->ignore($freightRate->id),
            ],
        ], [
            'destination_id.unique' => __('layouts.already_exists_freight_rates'),
        ]);

        $freightRate->update([
            'destination_id' => $request->destination_id,
            'carrier_id'     => $request->carrier_id,
            'truck_type_id'  => $request->truck_type_id,
            'price'          => $request->price,
            'status'         => $request->status,
            'updated_by'     => auth()->id(),
        ]);

        logActivity(
            $freightRate,
            __('layouts.action_updated'),
            __('layouts.freight_rate_updated'),
            __('layouts.status_success')
        );

        return redirect()->route('freight-rates.index')
            ->with('success', __('layouts.updated_successfully'));
    }

    public function show(FreightRate $freightRate)
    {
        $activityLogs = $freightRate->activityLogs()->latest()->get();
        return view('freight-rates.show', compact('freightRate', 'activityLogs'));
    }

    public function destroy(FreightRate $freightRate)
    {
        if ($freightRate->orders()->exists()) {
            return redirect()->route('freight-rates.index')
                ->with('error', __('layouts.cannot_delete_freight_rate_linked'));
        }
        $freightRate->delete();

        logActivity(
            $freightRate,
            __('layouts.action_deleted'),
            __('layouts.freight_rate_deleted', ['id' => $freightRate->id]),
            __('layouts.status_success')
        );

        return redirect()->route('freight-rates.index')
            ->with('success', __('layouts.deleted_successfully'));
    }

    public function toggle(FreightRate $freightRate)
    {
        $freightRate->update([
            'status'     => ! $freightRate->status,
            'updated_by' => auth()->id(),
        ]);

        logActivity(
            $freightRate,
            __('layouts.action_status_updated'),
            __('layouts.freight_rate_status_updated', [
                'from' => $freightRate->status ? __('layouts.inactive') : __('layouts.active'),
                'to'   => $freightRate->status ? __('layouts.active') : __('layouts.inactive'),
            ]),
            __('layouts.status_success')
        );

        return response()->json(['success' => true, 'status' => $freightRate->status]);
    }
}
