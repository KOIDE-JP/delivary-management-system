@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-xl p-4 md:p-8 border border-gray-100 max-w-2xl mx-auto">
            <h4 class="text-2xl font-bold text-gray-800 mb-6 px-16">{{ __('layouts.update_user_settings') }}</h4>

            @if (session('success'))
                <div class="mb-4 mx-16 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-5">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.store-settings') }}" method="POST" class="space-y-6 md:px-16">
                @csrf
                <!-- Country -->
                <div class="mb-2">
                    <label for="country" class="block text-sm font-medium mb-1">{{ __('layouts.country') }}</label>
                    <select name="country_id" id="country"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none search_select">
                        <option value="">{{ __('layouts.select_country') }}</option>
                        {{-- @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ old('country_id', $userSettings->country_id ?? null) == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach --}}
                    </select>
                    @error('country_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Language -->
                <div class="mb-2">
                    <label for="language" class="block text-sm font-medium mb-1">{{ __('layouts.language') }}</label>
                    <select name="language" id="language"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="jp" {{ old('language', $userSettings->language ?? app()->getLocale()) == 'jp' ? 'selected' : '' }}>
                            {{ __('layouts.japanese') }}
                        </option>
                        <option value="en" {{ old('language', $userSettings->language ?? app()->getLocale()) == 'en' ? 'selected' : '' }}>
                            {{ __('layouts.english') }}
                        </option>
                    </select>
                    @error('language')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notifications Enabled -->
                <div class="mb-2">
                    <label for="notifications_enabled" class="block text-sm font-medium mb-1">{{ __('layouts.notifications_enabled') }}</label>
                    <select name="notifications_enabled" id="notifications_enabled"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="0" {{ old('notifications_enabled', $userSettings->notifications_enabled ?? null) == 0 ? 'selected' : '' }}>
                            {{ __('layouts.no') }}
                        </option>
                        <option value="1" {{ old('notifications_enabled', $userSettings->notifications_enabled ?? null) == 1 ? 'selected' : '' }}>
                            {{ __('layouts.yes') }}
                        </option>
                    </select>
                    @error('notifications_enabled')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="w-full">
                    <button type="submit"
                        class="inline-block w-30 px-4 py-2 mt-4 font-semibold text-center text-white uppercase transition-all bg-gradient-to-tl from-blue-600 to-cyan-400 rounded shadow hover:scale-105 active:opacity-85 text-sm">
                        {{ __('layouts.update') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
