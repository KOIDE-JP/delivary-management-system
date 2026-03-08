<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::query()->orderBy('id', 'desc');

            return DataTables::of($roles)
                ->addIndexColumn() // DT_RowIndex

                ->addColumn('name', function ($row) {
                    return $row->name;
                })

                ->addColumn('action', function ($row) {
                    $actions = '';
                            $editUrl = route('role.edit', $row->id);
                            $actions .= '
                                <a href="'.$editUrl.'" title="'.__('layouts.edit').'" 
                                    class="inline-flex text-center items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition">
                                    <i class="fa-solid fa-pencil w-3 h-3"></i>
                                </a>
                            ';
                        
                            // $deleteUrl = route('role.delete', $row->id);
                            // $actions .= '
                            //     <a href="'.$deleteUrl.'" title="'.__('layouts.delete').'" 
                            //         class="inline-flex text-center items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 transition ml-2" onclick="return confirm(\'Are you sure?\')">
                            //         <i class="fa-solid fa-trash w-3 h-3"></i>
                            //     </a>
                            // ';
                        
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('role.index');
    }

    public function create()
    {
        $modules = Module::with('permissions')->get();
        return view('role.create',compact('modules'));
    }

    public function store(Request  $request)
    {
         $request->validate([
                'name' => 'required|unique:roles,name'
            ]);

        try {

            $role =  Role::create([
                'name'=>$request->name,
                'slug'=> Str::slug($request->name),
            ]);

            $role->permissions()->sync($request->permission_ids);
            
            return redirect()
            ->route('role.list')
            ->with('success', __('layouts.role_added_successfully'));
        }catch (\Throwable $throwable){
            return redirect()->back()->with('error', $throwable->getMessage());
        }
    }
    
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $modules = Module::with('permissions')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('role.edit',compact('role','modules','rolePermissions'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id
        ]);

        $role = Role::where('id',$id)->first();

        if(!$role){
            return redirect()->back()
            ->with('error', __('data_not_found'));
        }

        $role->update([
            'name'=>$request->name,
            // 'slug'=> Str::slug($request->name),
        ]);
        $role->permissions()->sync($request->permission_ids);

        return redirect()
            ->route('role.list')
            ->with('success', __('layouts.permission_updated_successfully'));
    }

    public function delete($id)
    {
        try{
            $role = Role::where('id',$id)->where('id', '!=', 1)->first();

            if(!$role){
                return redirect()->back()
                ->with('error', __('layouts.you_can_not_delete_this_role'));
            }
            $role->delete();
            return redirect()->back()
            ->with('success', __('layouts.role_deleted_successfully'));

        }catch(\Throwable $throwable){
            if($throwable->getCode() == 23000){
                return redirect()->back()
                ->with('error', __('layouts.you_can_not_delete_this_role'));
            }
            return redirect()->back();
        }
    }
}
