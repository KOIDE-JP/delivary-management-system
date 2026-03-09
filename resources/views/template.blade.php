@extends('layouts.master')
@section('content')
    <div class="w-full flex justify-center p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-xl p-2 sm:p-6 border border-gray-100 w-full">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <h4 class="text-xl sm:text-2xl font-bold text-gray-800">{{ __('layouts.order_list') }}</h4>
                <a href="{{ route('order.create') }}"
                    class="w-full sm:w-auto transition-all inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 hover:shadow-lg text-white font-medium text-sm rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('layouts.create_order') }}
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-9.293a1 1 0 011.414-1.414L10 8.586l1.707-1.707a1 1 0 011.414 1.414L11.414 10l1.707 1.707a1 1 0 01-1.414 1.414L10 11.414l-1.707 1.707a1 1 0 01-1.414-1.414L8.586 10l-1.707-1.707z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            <div id="ajax-success-message"
                class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg"></div>
            <div id="ajax-error-message" class="hidden mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            </div>

            
        </div>
    </div>
@endsection
@push('styles')
    <style>
    </style>
@endpush

@push('scripts')
    <script></script>
@endpush
