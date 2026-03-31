@extends('layouts.master')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">{{ __('layouts.dashboard') }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <a href="{{ route('users.index') }}" class="bg-white shadow rounded-xl p-4 flex items-center hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-users text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_users') }}</span>
                <p class="text-2xl font-bold">{{ $user_count }}</p>
            </div>
        </a>

        <a href="{{ route('destinations.index') }}" class="bg-white shadow rounded-xl p-4 flex items-center hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-location-dot text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_destinations') }}</span>
                <p class="text-2xl font-bold">{{ $destination_count }}</p>
            </div>
        </a>

        <a href="{{ route('carriers.index') }}" class="bg-white shadow rounded-xl p-4 flex items-center hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg shadow-lg mr-4">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM3 4h2l2.5 10h9.5l2-7H6" />
                    </svg>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_carriers') }}</span>
                <p class="text-2xl font-bold">{{ $carrier_count }}</p>
            </div>
        </a>

        <a href="{{ route('truck-types.index') }}" class="bg-white shadow rounded-xl p-4 flex items-center hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-400 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-truck-moving text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_truck_types') }}</span>
                <p class="text-2xl font-bold">{{ $truck_type_count }}</p>
            </div>
        </a>

        <a href="{{ route('freight-rates.index') }}" class="bg-white shadow rounded-xl p-4 flex items-center hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-money-bill-wave text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_freight_rates') }}</span>
                <p class="text-2xl font-bold">{{ $freight_rate_count }}</p>
            </div>
        </a>

        <a href="{{ route('order.index') }}" class="bg-white shadow rounded-xl p-4 flex items-center hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-box text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_orders') }}</span>
                <p class="text-2xl font-bold">{{ $order_count }}</p>
            </div>
        </a>

    </div>
</div>
@endsection