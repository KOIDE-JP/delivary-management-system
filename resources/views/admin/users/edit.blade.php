@extends('layouts.master')
@section('content')
    <style>
        .margin-b-1rem {
            margin-bottom: 1rem;
        }

        .margin-b-8rem {
            margin-bottom: 4rem;
        }
    </style>

    <div class="container mx-auto p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-xl p-4 md:p-8 border border-gray-100 max-w-2xl mx-auto">
            <h2 class="text-xl font-bold margin-b-8rem">
                {{ __('layouts.edit_user') }}
            </h2>

            <form action="{{ route('users.update', $user) }}" method="POST" class="md:px-8 space-y-4">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium mb-1">{{ __('layouts.name') }}</label>
                    <input type="text" id="name" name="name" placeholder="{{ __('layouts.name') }}"
                        value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-2">
                    <label for="username" class="block text-sm font-medium mb-1">{{ __('layouts.username') }}</label>
                    <input type="text" id="username" name="username" placeholder="{{ __('layouts.username') }}"
                        value="{{ old('username', $user->username) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('username') border-red-500 @enderror"
                        required>
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium mb-1">{{ __('layouts.email') }}</label>
                    <input type="email" id="email" name="email" placeholder="{{ __('layouts.email') }}"
                        value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="block text-sm font-medium mb-1">{{ __('layouts.edit_pass') }}</label>
                    <div class="flex items-center gap-2">
                        <input id="password" type="text" name="password" placeholder="{{ __('layouts.edit_pass') }}"
                            class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('password') border-red-500 @enderror">
                        <button type="button" onclick="generatePassword()"
                            class="text-black text-sm border px-3 py-2 rounded hover:bg-gray-100">
                            {{ __('layouts.generate_password') }}
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Role -->
                <div class="mb-2">
                    <label for="role_id" class="block text-sm font-medium mb-1">{{ __('layouts.user_role') }}
                        <span class="text-red-600">*</span>
                    </label>
                    <select required id="role_id" name="role_id"
                        class="cursor-pointer form-select appearance-none
                            block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding bg-no-repeat
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        aria-label="Default select example">
                        <option value="">{{ __('layouts.select_user_role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                data-role-slug="{{ $role->slug }}" 
                                {{ $role->id == old('role_id', $user->role_id) ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Notifications -->
                <div class="flex items-center gap-2 my-1">
                    <input id="receive_low_stock" type="checkbox" name="notifications_enabled" value="1"
                        {{ isset($user) && optional($user->userSetting)->notifications_enabled ? 'checked' : '' }}>
                    <label for="receive_low_stock">{{ __('layouts.receive_notifications') }}</label>
                </div>

                <!-- Status -->
                <div class="mb-2">
                    <label for="status" class="block text-sm font-medium mb-1">{{ __('layouts.status') }}</label>
                    <select name="status" id="status"
                        class="cursor-pointer w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('status') border-red-500 @enderror"
                        required>
                        <option value="active" {{ old('status', $user->status) == "active" ? 'selected' : '' }}>
                            {{ __('layouts.active') }}</option>
                        <option value="inactive" {{ old('status', $user->status) == "inactive" ? 'selected' : '' }}>
                            {{ __('layouts.inactive') }}</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="w-full flex justify-end text-center mt-4">
                    <button type="submit"
                        class="flex justify-center items-center px-6 py-2 border border-transparent text-sm font-semibold rounded-lg text-white 
                            bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 shadow-md hover:shadow-lg transition-all duration-200 active:opacity-80 cursor-pointer">
                        {{ __('layouts.update_user') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function generatePassword() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            let password = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }
            document.getElementById("password").value = password;
        }
    </script>
    {{-- <script>
    const roleSelect = document.getElementById('role_id');
    const assignWrapper = document.getElementById('assign_to_wrapper');
    

    roleSelect.addEventListener('change', function() {
        if (this.value == '10') { // person-in-charge
            assignWrapper.style.display = 'block';
        } else {
            assignWrapper.style.display = 'none';
            document.getElementById('assigned_to').value = '';
        }
    });
</script> --}}
    <script>
        const roleSelect = document.getElementById('role_id');
        const assignWrapper = document.getElementById('assign_to_wrapper');

        function checkRoleSlug() {
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const roleSlug = selectedOption.getAttribute('data-role-slug');
            const assignedToInput = document.getElementById('assigned_to');

            if (roleSlug === 'person-in-charge') {
                assignWrapper.style.display = 'block';
                assignedToInput.setAttribute('required', 'required');
            } else {
                assignWrapper.style.display = 'none';
                assignedToInput.removeAttribute('required');
                document.getElementById('assigned_to').value = '';
            }
        }

        roleSelect.addEventListener('change', checkRoleSlug);

        // On page load (for old value / validation errors)
        window.addEventListener('DOMContentLoaded', checkRoleSlug);
    </script>
@endpush

