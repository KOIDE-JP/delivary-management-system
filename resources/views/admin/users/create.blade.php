@extends('layouts.master')
@section('content')
    <style>
    </style>

    <div class="min-h-screen py-8 sm:py-12 px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">

            <!-- Form Card -->
            <div class="form-card gradient-border rounded-2xl p-6 sm:p-8 md:p-10">
                <div class="relative z-[0]">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Name Field -->
                        <div class=" mb-6">
                            <div class="relative">
                                <input placeholder=" " id="name" name="name" type="text"
                                    value="{{ old('name') }}" required
                                    class="peer w-full px-4 py-1 sm:py-4 pt-5 sm:pt-6 text-slate-900 ant-input border-2 border-slate-200 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400" />
                                <label for="name"
                                    class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200 peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2 peer-focus:text-xs peer-focus:text-blue-600 peer-[:not(:placeholder-shown)]:top-1.5 sm:peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-600 font-medium">
                                    {{ __('layouts.name') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <div class="mt-2 flex items-center text-red-500 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Username Field -->
                        <div class=" mb-6">
                            <div class="relative">
                                <input placeholder=" " id="username" name="username" type="text"
                                    value="{{ old('username') }}" required
                                    class="peer w-full px-4 py-3 sm:py-4 pt-5 sm:pt-6 text-slate-900 ant-input border-2 border-slate-200 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400" />
                                <label for="username"
                                    class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200 peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2 peer-focus:text-xs peer-focus:text-blue-600 peer-[:not(:placeholder-shown)]:top-1.5 sm:peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-600 font-medium">
                                    {{ __('layouts.username') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('username')
                                <div class="mt-2 flex items-center text-red-500 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="relative mb-6">
                            <div class="relative">
                                <input placeholder=" " id="email" name="email" type="email"
                                    value="{{ old('email') }}"
                                    class="peer w-full px-4 py-3 sm:py-4 pt-5 sm:pt-6 text-slate-900 ant-input border-2 border-slate-200 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400" />
                                <label for="email"
                                    class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200 peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2 peer-focus:text-xs peer-focus:text-blue-600 peer-[:not(:placeholder-shown)]:top-1.5 sm:peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-600 font-medium">
                                    {{ __('layouts.email') }}
                                </label>
                                <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <div class="mt-2 flex items-center text-red-500 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="relative mb-6">
                            <div class="relative">
                                <input placeholder=" " id="password" name="password" type="text" required
                                    class="peer w-full px-4 py-3 sm:py-4 pt-5 sm:pt-6 pr-24 text-slate-900 ant-input border-2 border-slate-200 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400" />
                                <label for="password"
                                    class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200 peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2 peer-focus:text-xs peer-focus:text-blue-600 peer-[:not(:placeholder-shown)]:top-1.5 sm:peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-600 font-medium">
                                    {{ __('layouts.password') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" onclick="generatePassword()"
                                        class="text-xs font-medium text-blue-600 hover:text-blue-700 px-2 py-1 rounded-lg hover:bg-blue-50 transition-all duration-200">
                                        {{ __('layouts.generate') }}
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <div class="mt-2 flex items-center text-red-500 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Role Field -->
                        <div class="relative mb-6">
                            <label for="role_id" class="block text-sm font-medium text-slate-700 mb-2">
                                {{ __('layouts.user_role') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select  id="role_id" name="role_id" required
                                    class="w-full px-4 py-3 sm:py-4 text-slate-900 ant-select border-2 border-slate-200 rounded-xl input-focus transition-all duration-200 focus:outline-none focus:border-blue-400 appearance-none cursor-pointer">
                                    <option value="" selected>{{ __('layouts.select_user_role') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            data-role-slug="{{ $role->slug }}" 
                                            {{ $role->id == request()->role_id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('role_id')
                                <div class="mt-2 flex items-center text-red-500 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <!-- Submit Button -->
                            <button type="submit"
                                class="flex px-6 py-2 font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-400 rounded-lg shadow-md hover:scale-105 transition active:opacity-80 cursor-pointer">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                                {{ __('layouts.create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
