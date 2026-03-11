@extends('layouts.master')
@section('content')
    <div class="min-h-screen py-8 sm:py-12 px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">
            <div class="form-card gradient-border rounded-2xl p-6 sm:p-8 md:p-10 bg-white shadow-lg border border-gray-200">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold mb-4">{{ __('layouts.edit_freight_rate') }}</h2>

                    <form action="{{ route('freight-rates.update', $freightRate->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Destination --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.destination') }} <span class="text-red-600">*</span>
                            </label>
                            <select name="destination_id" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="">-- {{ __('layouts.select') }} --</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}"
                                        {{ old('destination_id', $freightRate->destination_id) == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Carrier --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.carrier') }} <span class="text-red-600">*</span>
                            </label>
                            <select name="carrier_id" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="">-- {{ __('layouts.select') }} --</option>
                                @foreach($carriers as $carrier)
                                    <option value="{{ $carrier->id }}"
                                        {{ old('carrier_id', $freightRate->carrier_id) == $carrier->id ? 'selected' : '' }}>
                                        {{ $carrier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('carrier_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Truck Type --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.truck_type') }} <span class="text-red-600">*</span>
                            </label>
                            <select name="truck_type_id" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="">-- {{ __('layouts.select') }} --</option>
                                @foreach($truckTypes as $truckType)
                                    <option value="{{ $truckType->id }}"
                                        {{ old('truck_type_id', $freightRate->truck_type_id) == $truckType->id ? 'selected' : '' }}>
                                        {{ $truckType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('truck_type_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                {{ __('layouts.price') }} ({{ __('layouts.tax_excluded') }}) <span class="text-red-600">*</span>
                            </label>
                            <input type="number" name="price" step="0.01" min="0" required
                                value="{{ old('price', $freightRate->price) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"/>
                            @error('price')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-1">{{ __('layouts.status') }}</label>
                            <select name="status"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="1" {{ old('status', $freightRate->status) == 1 ? 'selected' : '' }}>{{ __('layouts.active') }}</option>
                                <option value="0" {{ old('status', $freightRate->status) == 0 ? 'selected' : '' }}>{{ __('layouts.inactive') }}</option>
                            </select>
                            @error('status')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        @error('combination')
                            <div class="mb-4 p-3 bg-red-50 border border-red-300 text-red-600 text-sm rounded-lg">
                                {{ __('layouts.freight_rate_combination_exists') }}
                            </div>
                        @enderror

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
