@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50">
        <div class="w-full max-w-6xl p-6 bg-white border border-gray-100 shadow-xl sm:p-8 rounded-2xl">

            {{-- HEADER & ACTIONS --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">{{ __('layouts.view_order') }}</h4>
                    <p class="mt-1 text-sm text-gray-500">Order details for <span
                            class="font-semibold text-gray-700">ORD-10293</span></p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('order.index') }}"
                        class="min-w-[9rem] flex-1 px-2 py-2 font-semibold text-center text-gray-700 transition-colors bg-gray-200 hover:bg-gray-300 rounded-xl">
                        Back to List
                    </a>
                    <a href="{{ route('order.view', 1) }}"
                        class="min-w-[9rem] cursor-pointer flex-1 px-2 py-2 font-semibold text-center text-white transition-opacity bg-gradient-to-r from-blue-600 to-cyan-400 hover:opacity-90 rounded-xl shadow-md">
                        Edit Order
                    </a>
                </div>
            </div>

            {{-- SESSION MESSAGES --}}
            @if (session('success'))
                <div class="flex items-start p-4 mb-6 text-green-700 border-l-4 border-green-500 rounded-lg bg-green-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-start p-4 mb-6 text-red-700 border-l-4 border-red-500 rounded-lg bg-red-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-9.293a1 1 0 011.414-1.414L10 8.586l1.707-1.707a1 1 0 011.414 1.414L11.414 10l1.707 1.707a1 1 0 01-1.414 1.414L10 11.414l-1.707 1.707a1 1 0 01-1.414-1.414L8.586 10l-1.707-1.707z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            <div id="ajax-success-message"
                class="hidden p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-lg"></div>
            <div id="ajax-error-message" class="hidden p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded-lg">
            </div>

            {{-- ORDER DETAILS GRID --}}
            <div class="space-y-6">

                {{-- BASIC INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Basic Information</h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Order Number</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">ORD-10293</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Order Name</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">Industrial Valve Supply Q3</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registered Date</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">Oct 24, 2023</p>
                        </div>
                    </div>
                </div>

                {{-- DELIVERY INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Delivery Information</h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Due Date</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">Nov 15, 2023</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Due Confidence</p>
                            <div class="mt-1">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Inspection Date</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">Nov 10, 2023</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Priority</p>
                            <div class="mt-1">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">High
                                    (Yes)</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SHIPPING INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Shipping Information</h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Shipping Date</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">Nov 12, 2023</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Shipping Status</p>
                            <div class="mt-1">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Arranged</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENT SUBMISSION & BILLING (Grouped for grid balance) --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Document Submission
                        </h5>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">DW Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">Delivered</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Quotation Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">Submitted</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Order Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">Received</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Billing Information
                        </h5>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Inspection Slip Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">Received</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Invoice Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">Not Sent</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Order Amount</p>
                                <p class="mt-1 text-xl font-bold text-blue-600">¥12,450.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FREIGHT INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Freight Information</h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Destination</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">Houston, TX</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Carrier</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">FedEx Freight</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Truck Type</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">Flatbed</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Freight Price</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">¥850.00</p>
                        </div>
                    </div>
                </div>

                {{-- SCHEDULES & DATES --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Client Schedule</h5>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Material Pickup Date</p>
                                <p class="text-sm font-semibold text-gray-900">Oct 28, 2023</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Inspection Due Date</p>
                                <p class="text-sm font-semibold text-gray-900">Nov 10, 2023</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Parts Pickup Date</p>
                                <p class="text-sm font-semibold text-gray-900">Nov 12, 2023</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">Internal Dates</h5>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Pickup Transfer Date</p>
                                <p class="text-sm font-semibold text-gray-900">Oct 29, 2023</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Sales Transfer Date</p>
                                <p class="text-sm font-semibold text-gray-900">Oct 30, 2023</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Shipping Transfer Date</p>
                                <p class="text-sm font-semibold text-gray-900">Nov 13, 2023</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    @includeIf('components.activity-log-component')
                </div>

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
