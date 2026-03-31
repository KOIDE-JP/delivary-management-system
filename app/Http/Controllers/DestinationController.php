<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $destinations = Destination::query()->orderBy('created_at', 'desc');

            return DataTables::of($destinations)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked  = $row->status ? 'checked' : '';
                    $disabled = auth()->user()->hasPermission('destinations.edit') ? '' : 'disabled';
                    return '
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" ' . $checked . ' ' . $disabled . '
                                onchange="toggleStatus(' . $row->id . ', this, \'destinations\')">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full
                                peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px]
                                after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full
                                after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $viewUrl   = route('destinations.show', $row->id);
                    $editUrl   = route('destinations.edit', $row->id);
                    $deleteUrl = route('destinations.destroy', $row->id);
                    $actions   = '<div class="text-center space-x-2">';

                    // if (auth()->user()->hasPermission('destinations.show')) {
                        $actions .= '
                            <a title="' . __('layouts.view') . '" href="' . $viewUrl . '"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium
                                rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2
                                focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fa-solid fa-eye w-3 h-3"></i>
                            </a>';
                    // }

                    if (auth()->user()->hasPermission('destinations.edit')) {
                        $actions .= '
                            <a title="' . __('layouts.edit') . '" href="' . $editUrl . '"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium
                                rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2
                                focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fa-solid fa-pencil w-3 h-3"></i>
                            </a>';
                    }

                    if (auth()->user()->hasPermission('destinations.destroy')) {
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

        return view('destinations.index');
    }

    public function create()
    {
        return view('destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prefix' => ['nullable', 'string', 'max:2'],
            'name'   => ['required', 'string', 'max:255'],
        ]);

        $validated['status']     = 1;
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $destination = Destination::create($validated);

        logActivity(
            $destination,
            __('layouts.action_created'),
            __('layouts.destination_created'),
            __('layouts.status_success')
        );

        return redirect()->route('destinations.index')
            ->with('success', __('layouts.created_successfully'));
    }

    public function edit(Destination $destination)
    {
        return view('destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'prefix' => ['nullable', 'string', 'max:2'],
            'name'   => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:0,1'],
        ]);

        $validated['updated_by'] = auth()->id();
        $destination->update($validated);

        logActivity(
            $destination,
            __('layouts.action_updated'),
            __('layouts.destination_updated'),
            __('layouts.status_success')
        );

        return redirect()->route('destinations.index')
            ->with('success', __('layouts.updated_successfully'));
    }

    public function show(Destination $destination)
    {
        $activityLogs = $destination->activityLogs()->latest()->get();
        return view('destinations.show', compact('destination', 'activityLogs'));
    }

    public function destroy(Destination $destination)
    {
        if ($destination->freightRates()->exists()) {
            return redirect()->route('destinations.index')
                ->with('error', __('layouts.cannot_delete_linked'));
        }

        $destination->delete();

        logActivity(
            $destination,
            __('layouts.action_deleted'),
            __('layouts.destination_deleted', ['id' => $destination->id]),
            __('layouts.status_success')
        );

        return redirect()->route('destinations.index')
            ->with('success', __('layouts.deleted_successfully'));
    }

    public function toggle(Destination $destination)
    {
        $destination->update([
            'status'     => ! $destination->status,
            'updated_by' => auth()->id(),
        ]);

        logActivity(
            $destination,
            __('layouts.action_status_updated'),
            __('layouts.destination_status_updated', [
                'from' => $destination->status ? __('layouts.inactive') : __('layouts.active'),
                'to'   => $destination->status ? __('layouts.active') : __('layouts.inactive'),
            ]),
            __('layouts.status_success')
        );

        return response()->json(['success' => true, 'status' => $destination->status]);
    }
}
