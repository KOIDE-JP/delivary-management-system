<?php

namespace App\Http\Controllers;

use App\Models\TruckType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TruckTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $truckTypes = TruckType::query();

            return DataTables::of($truckTypes)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked  = $row->status ? 'checked' : '';
                    $disabled = auth()->user()->hasPermission('truck-types.edit') ? '' : 'disabled';
                    return '
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" ' . $checked . ' ' . $disabled . '
                                onchange="toggleStatus(' . $row->id . ', this, \'truck-types\')">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full
                                peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px]
                                after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full
                                after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl   = route('truck-types.edit', $row->id);
                    $deleteUrl = route('truck-types.destroy', $row->id);
                    $actions   = '<div class="text-center space-x-2">';

                    if (auth()->user()->hasPermission('truck-types.edit')) {
                        $actions .= '
                            <a title="' . __('layouts.edit') . '" href="' . $editUrl . '"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium
                                rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2
                                focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fa-solid fa-pencil w-3 h-3"></i>
                            </a>';
                    }

                    if (auth()->user()->hasPermission('truck-types.destroy')) {
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

        return view('truck-types.index');
    }

    public function create()
    {
        return view('truck-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $validated['status']     = 1;
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        TruckType::create($validated);

        return redirect()->route('truck-types.index')
            ->with('success', __('layouts.created_successfully'));
    }

    public function edit(TruckType $truckType)
    {
        return view('truck-types.edit', compact('truckType'));
    }

    public function update(Request $request, TruckType $truckType)
    {
        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:0,1'],
        ]);

        $validated['updated_by'] = auth()->id();
        $truckType->update($validated);

        return redirect()->route('truck-types.index')
            ->with('success', __('layouts.updated_successfully'));
    }

    public function destroy(TruckType $truckType)
    {
        if ($truckType->freightRates()->exists()) {
            return redirect()->route('truck-types.index')
                ->with('error', __('layouts.cannot_delete_linked'));
        }

        $truckType->delete();

        return redirect()->route('truck-types.index')
            ->with('success', __('layouts.deleted_successfully'));
    }

    public function toggle(TruckType $truckType)
    {
        $truckType->update([
            'status'     => ! $truckType->status,
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'status' => $truckType->status]);
    }
}
