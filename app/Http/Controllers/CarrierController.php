<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CarrierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $carriers = Carrier::query();

            return DataTables::of($carriers)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked  = $row->status ? 'checked' : '';
                    $disabled = auth()->user()->hasPermission('carriers.edit') ? '' : 'disabled';
                    return '
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" ' . $checked . ' ' . $disabled . '
                                onchange="toggleStatus(' . $row->id . ', this, \'carriers\')">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full
                                peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px]
                                after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full
                                after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl   = route('carriers.edit', $row->id);
                    $deleteUrl = route('carriers.destroy', $row->id);
                    $actions   = '<div class="text-center space-x-2">';

                    if (auth()->user()->hasPermission('carriers.edit')) {
                        $actions .= '
                            <a title="' . __('layouts.edit') . '" href="' . $editUrl . '"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium
                                rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2
                                focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fa-solid fa-pencil w-3 h-3"></i>
                            </a>';
                    }

                    if (auth()->user()->hasPermission('carriers.destroy')) {
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

        return view('carriers.index');
    }

    public function create()
    {
        return view('carriers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $validated['status']     = 1;
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        Carrier::create($validated);

        return redirect()->route('carriers.index')
            ->with('success', __('layouts.created_successfully'));
    }

    public function edit(Carrier $carrier)
    {
        return view('carriers.edit', compact('carrier'));
    }

    public function update(Request $request, Carrier $carrier)
    {
        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:0,1'],
        ]);

        $validated['updated_by'] = auth()->id();
        $carrier->update($validated);

        return redirect()->route('carriers.index')
            ->with('success', __('layouts.updated_successfully'));
    }

    public function destroy(Carrier $carrier)
    {
        if ($carrier->freightRates()->exists()) {
            return redirect()->route('carriers.index')
                ->with('error', __('layouts.cannot_delete_linked'));
        }

        $carrier->delete();

        return redirect()->route('carriers.index')
            ->with('success', __('layouts.deleted_successfully'));
    }

    public function toggle(Carrier $carrier)
    {
        $carrier->update([
            'status'     => ! $carrier->status,
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'status' => $carrier->status]);
    }
}
