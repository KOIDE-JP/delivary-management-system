@extends('layouts.master')
@section('content')
    <div class="min-h-screen py-8 sm:py-12 px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">
            <div class="form-card gradient-border rounded-2xl p-6 sm:p-8 md:p-10 bg-white shadow-lg border border-gray-200">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('layouts.add_freight_rate') }}</h2>

                    <form action="{{ route('freight-rates.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Destination --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.destination') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="destination_id" required
                                class="w-full px-4 py-2 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-blue-400">
                                <option value="">-- {{ __('layouts.select_destination') }} --</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}"
                                        {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination_id')
                                <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Carrier --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.carrier') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="carrier_id" required
                                class="w-full px-4 py-2 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-blue-400">
                                <option value="">-- {{ __('layouts.select_carrier') }} --</option>
                                @foreach($carriers as $carrier)
                                    <option value="{{ $carrier->id }}"
                                        {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                                        {{ $carrier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('carrier_id')
                                <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Truck Type --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.truck_type') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="truck_type_id" required
                                class="w-full px-4 py-2 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-blue-400">
                                <option value="">-- {{ __('layouts.select_truck_type') }} --</option>
                                @foreach($truckTypes as $truckType)
                                    <option value="{{ $truckType->id }}"
                                        {{ old('truck_type_id') == $truckType->id ? 'selected' : '' }}>
                                        {{ $truckType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('truck_type_id')
                                <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="relative">
                            <input placeholder=" " id="price" name="price" type="number"
                                step="0.01" min="0"
                                value="{{ old('price') }}" required
                                class="peer w-full px-4 py-3 sm:py-4 pt-5 sm:pt-8 text-slate-900 border-2 border-slate-200
                                rounded-xl placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400"/>
                            <label for="price"
                                class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200
                                peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500
                                peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2
                                peer-focus:text-xs peer-focus:text-blue-600 font-medium">
                                {{ __('layouts.price') }} ({{ __('layouts.tax_excluded') }}) <span class="text-red-500">*</span>
                            </label>
                            @error('price')
                                <div class="mt-2 text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        @error('combination')
                            <div class="p-3 bg-red-50 border border-red-300 text-red-600 text-sm rounded-lg">
                                {{ __('layouts.freight_rate_combination_exists') }}
                            </div>
                        @enderror

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="flex justify-center items-center px-6 py-2 border border-transparent text-sm
                                font-semibold rounded-lg text-white bg-gradient-to-tl from-blue-600 to-cyan-400
                                hover:scale-102 shadow-md hover:shadow-lg transition-all duration-200 active:opacity-80">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/>
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
