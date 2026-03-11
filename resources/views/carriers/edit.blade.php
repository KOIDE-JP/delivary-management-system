@extends('layouts.master')
@section('content')
    <div class="min-h-screen py-8 sm:py-12 px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">
            <div class="form-card gradient-border rounded-2xl p-6 sm:p-8 md:p-10 bg-white shadow-lg border border-gray-200">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold mb-4">{{ __('layouts.edit_carrier') }}</h2>

                    <form action="{{ route('carriers.update', $carrier->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.name') }} <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="name" required
                                value="{{ old('name', $carrier->name) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"/>
                            @error('name')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-1">{{ __('layouts.status') }}</label>
                            <select name="status"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="1" {{ old('status', $carrier->status) == 1 ? 'selected' : '' }}>{{ __('layouts.active') }}</option>
                                <option value="0" {{ old('status', $carrier->status) == 0 ? 'selected' : '' }}>{{ __('layouts.inactive') }}</option>
                            </select>
                            @error('status')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="flex justify-center items-center px-6 py-2 border border-transparent text-sm
                                font-semibold rounded-lg text-white bg-gradient-to-tl from-blue-600 to-cyan-400
                                hover:scale-102 shadow-md hover:shadow-lg transition-all duration-200 active:opacity-80">
                                {{ __('layouts.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
