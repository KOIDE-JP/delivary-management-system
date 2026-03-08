@extends('layouts.master')

@section('content')
<div class="container mx-auto max-w-5xl p-6 space-y-6">

    {{-- Page Header Card --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            {{ __('layouts.add_new_role') }}
        </h2>

        <form action="{{ route('role.store') }}" method="post" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('layouts.name') }} <span class="text-red-600">*</span>
                </label>
                <input 
                    required 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    type="text"
                    placeholder="{{ __('layouts.enter_role_name') }}"
                    placeholder="Enter role name"
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                />
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
    </div> {{-- End Page Header Card --}}

    {{-- Permissions Section Card --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ __('layouts.permissions_list') }}
        </h2>

        {{-- Select All --}}
        <div class="flex items-center gap-2 mb-4">
            <input 
                type="checkbox" 
                id="select-all" 
                onchange="checkAll(this)" 
                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
            >
            <label for="select-all" class="text-gray-700 font-medium">
                {{ __('layouts.check_all_uncheck_all') }}
            </label>
        </div>

        {{-- Permissions by Module --}}
        <div class="space-y-6">
            @foreach($modules as $module)
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">
                        {{ ucwords($module->name) }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($module->permissions as $permission)
                            <label class="flex items-center gap-2 p-2 bg-white border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input 
                                    type="checkbox" 
                                    name="permission_ids[]" 
                                    value="{{ $permission->id }}" 
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                >
                                <span class="text-gray-700 text-sm">
                                    {{ ucwords(Str::replace('.', ' ', $permission->name)) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end mt-6">
            <button type="submit"
                class="px-6 py-2 font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-400 rounded-lg shadow-md hover:scale-105 transition active:opacity-80">
                {{ __('layouts.create') }}
            </button>
        </div>
    </div> {{-- End Permissions Section Card --}}
    </form>
</div>

<script>
    function checkAll(source) {
        let checkboxes = document.querySelectorAll('input[name="permission_ids[]"]');
        checkboxes.forEach(cb => cb.checked = source.checked);
    }
</script>
@endsection
