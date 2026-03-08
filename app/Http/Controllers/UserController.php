<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $authUser = auth()->user();

            $usersQuery = User::with(['role']);

            if ($authUser->role?->slug === 'super-admin') {
                // Super-admin sees all users except himself
                $usersQuery->where('id', '!=', $authUser->id);
            } 


            return DataTables::of($usersQuery)
                ->addIndexColumn()
                ->addColumn('role', function($user){
                    return $user->role ? $user->role->name : '-';
                })
                ->addColumn('status', function ($user) {
                    return $user->status === 'active'
                        ? '<span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">'.__('layouts.active').'</span>'
                        : '<span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded">'.__('layouts.inactive').'</span>';
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('users.edit', $user->id);
                    $deleteUrl = route('users.destroy', $user->id);

                    $actions = '<div class="text-center space-x-2">';

                    if (auth()->user()->hasPermission('users.edit')) {
                        $actions .= '
                            <a title="' . __('layouts.edit') . '" href="' . $editUrl . '"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fa-solid fa-pencil w-3 h-3"></i>
                            </a>
                        ';
                    }

                    if (auth()->user()->hasPermission('users.destroy')) {
                        $actions .= '
                            <form action="' . $deleteUrl . '"
                                method="POST" class="inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button title="' . __('layouts.delete') . '" type="button" onclick="confirmDelete(this)"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200 cursor-pointer"><i
                                        class="fa-solid fa-trash w-3 h-3"></i></button>
                            </form>
                        ';
                    }

                    $actions .= '</div>';
                    return $actions;
                })

               
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('admin.users.index');
    }



    public function create()
    {
        $roles = Role::where('id', '!=', '1')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'nullable|email|unique:users',
                'password' => 'required|min:6',
                'role_id' => 'required',
            ],
            [
                'name.required' => __('validation.custom_edit.name.required'),
                'username.required' => __('validation.custom_edit.username.required'),
                'username.unique' => __('validation.custom_edit.username.unique'),
                'email.email' => __('validation.custom_edit.email.email'),
                'email.unique' => __('validation.custom_edit.email.unique'),
                'password.required' => __('validation.custom_edit.password.required'),
                'password.min' => __('validation.custom_edit.password.min'),
                'role_id' => __('validation.custom_edit.role_id.required'),
            ],
        );

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => "active",
            'created_by' => auth()->id(),
        ];

        $user = User::create($userData);

        $user->userSetting()->create([
            'notifications_enabled' => $request->notifications_enabled ?? true,
        ]);

        return redirect()->route('users.index')->with('success', __('layouts.created_successfully'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::where('id', '!=', 1)->get(); 
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $user->id,
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:6',
                'status' => 'required',
                'role_id' => 'required',
            ],
            [
                'name.required' => __('validation.custom_edit.name.required'),
                'username.required' => __('validation.custom_edit.username.required'),
                'username.unique' => __('validation.custom_edit.username.unique'),
                'email.email' => __('validation.custom_edit.email.email'),
                'email.unique' => __('validation.custom_edit.email.unique'),
                'password.min' => __('validation.custom_edit.password.min'),
                'status.required' => __('validation.custom_edit.status.required'),
                'role_id.required' => __('validation.custom_edit.role_id.required'),
            ],
        );

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'status' => $request->status,
            'role_id' => $request->role_id,
        ];

        $role = Role::find($request->role_id);

        $user->update($userData);

        $user->userSetting()->create([
            'notifications_enabled' => $request->notifications_enabled,
        ]);

        return redirect()->route('users.index')->with('success',  __('layouts.updated_successfully'));
    }

    public function destroy(User $user)
    {
        
        $user->delete();
        return redirect()->route('users.index')->with('success',  __('layouts.deleted_successfully'));
        
    }

    public function showSoftDeleteUsers()
    {
        $softDeletedUsers = User::onlyTrashed()->get();
        return view('admin.users.soft_deleted', compact('softDeletedUsers'));
    }
    
    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')->with('success', __('layouts.user_restored_successfully'));
    }

    public function userSettings()
    {
        $user = auth()->user();
        $userSettings = UserSetting::where('user_id', $user->id)->with('country')->first();
        // $countries = Country::all();
        return view('admin.users.settings', compact('user', 'userSettings'));
    }

    public function updateUserSettings(Request $request)
    {
        $user = auth()->user();
        UserSetting::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'country_id' => $request->country_id,
                'language' => $request->language,
                'notifications_enabled' => $request->notifications_enabled,
            ]
        );

        return redirect()->route('user.settings', ['lang' => $request->language])
            ->with('success', __('layouts.settings_updated_successfully'));
    }

    public function userProfileUpdate()
    {
        $user = auth()->user();
        // dd($user);
        // $userSettings = UserSetting::where('user_id', $user->id)->with('country')->first();
        // $countries = Country::all();
        return view('admin.users.profile_update', compact('user'));
    }

    public function storeUserProfileUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate(
            [
                'name' => 'required',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
            ],
            [
                'name.required' => __('validation.custom_edit.name.required'),
                'email.email' => __('validation.custom_edit.email.email'),
                'email.unique' => __('validation.custom_edit.email.unique'),
            ],
        );

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profileUpdate')->with('success', __('layouts.user_profile_updated'));
    }

    public function changePassword()
    {
        $user = auth()->user();
        return view('admin.users.change_password', compact('user'));
    }

    public function storeChangePassword(Request $request)
    {
        $user = auth()->user();

        // dd($request->all());

        $request->validate(
            [
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'current_password.required' => __('validation.custom_edit.current_password.required'),
                'password.required' => __('validation.custom_edit.password.required'),
                'password.min' => __('validation.custom_edit.password.min'),
                'password.confirmed' => __('validation.custom_edit.password.confirmed'),
            ]
        );


        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => __('validation.custom_edit.current_password.invalid')]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.changePassword')->with('success', __('layouts.password_changed_successfully'));
    }
}
