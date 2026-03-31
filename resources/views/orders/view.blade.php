@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50">
        <div class="w-full max-w-6xl p-6 bg-white border border-gray-100 shadow-xl sm:p-8 rounded-2xl">

            {{-- HEADER & ACTIONS --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">{{ __('layouts.order.view') ?? 'View Order' }}</h4>
                    <p class="mt-1 text-sm text-gray-500">Order details for <span class="font-semibold text-gray-700">{{ $order->order_number }}</span></p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('order.index') }}"
                        class="min-w-[9rem] flex-1 px-2 py-2 font-semibold text-center text-gray-700 transition-colors bg-gray-200 hover:bg-gray-300 rounded-xl">
                        Back to List
                    </a>
                    <a href="{{ route('order.edit', $order->id) }}"
                        class="min-w-[9rem] cursor-pointer flex-1 px-2 py-2 font-semibold text-center text-white transition-opacity bg-gradient-to-r from-blue-600 to-cyan-400 hover:opacity-90 rounded-xl shadow-md">
                        Edit Order
                    </a>
                </div>
            </div>

            {{-- SESSION MESSAGES --}}
            @if (session('success'))
                <div class="flex items-start p-4 mb-6 text-green-700 border-l-4 border-green-500 rounded-lg bg-green-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-start p-4 mb-6 text-red-700 border-l-4 border-red-500 rounded-lg bg-red-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-9.293a1 1 0 011.414-1.414L10 8.586l1.707-1.707a1 1 0 011.414 1.414L11.414 10l1.707 1.707a1 1 0 01-1.414 1.414L10 11.414l-1.707 1.707a1 1 0 01-1.414-1.414L8.586 10l-1.707-1.707z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- ORDER DETAILS GRID --}}
            <div class="space-y-6">

                {{-- BASIC INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Basic Information
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Order Number</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Order Name</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->order_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registered Date</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ $order->registered_date ? \Carbon\Carbon::parse($order->registered_date)->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- DELIVERY INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Delivery Information
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Due Date</p>
                            <p class="mt-1 text-base font-semibold text-red-600">
                                {{ $order->due_date ? \Carbon\Carbon::parse($order->due_date)->format('M d, Y') : 'Pending' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Due Confidence</p>
                            <div class="mt-1">
                                @if($order->due_confidence == 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                                @elseif($order->due_confidence == 'unconfirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Unconfirmed</span>
                                @else
                                    <span class="text-gray-500 text-sm">N/A</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Inspection Date</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ $order->inspection_date ? \Carbon\Carbon::parse($order->inspection_date)->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Priority</p>
                            <div class="mt-1">
                                @if($order->priority == 'yes')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">High</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Normal</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SHIPPING INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Shipping Information
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Shipping Date</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ $order->shipping_date ? \Carbon\Carbon::parse($order->shipping_date)->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Shipping Status</p>
                            <div class="mt-1">
                                @php
                                    $statusColors = [
                                        'arranged' => 'bg-blue-100 text-blue-800',
                                        'unarranged' => 'bg-yellow-100 text-yellow-800',
                                        'direct_delivery' => 'bg-green-100 text-green-800',
                                        'courier' => 'bg-purple-100 text-purple-800',
                                        'unconfirmed' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $colorClass = $statusColors[$order->shipping_status] ?? 'bg-gray-100 text-gray-800';
                                    $displayText = $order->shipping_status ? ucwords(str_replace('_', ' ', $order->shipping_status)) : 'N/A';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ $displayText }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENT SUBMISSION & BILLING --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Document Submission
                        </h5>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">DW Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->dw_status ?? 'N/A')) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Quotation Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->quotation_status ?? 'N/A')) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Order Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->order_status ?? 'N/A')) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Billing Information
                        </h5>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Inspection Slip Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->inspection_slip_status ?? 'N/A')) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Invoice Status</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->invoice_status ?? 'N/A')) }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Order Amount</p>
                                <p class="mt-1 text-xl font-bold text-blue-600">
                                    {{ $order->order_amount ? '¥' . number_format($order->order_amount, 2) : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FREIGHT INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Freight Information
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Destination</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->destination ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Carrier</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->carrier ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Truck Type</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->truck_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Freight Price</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $order->freight_price ? '¥' . number_format($order->freight_price, 2) : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- SCHEDULES & DATES --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Client Schedule
                        </h5>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Material Pickup Date</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->material_pickup_date ? \Carbon\Carbon::parse($order->material_pickup_date)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Inspection Due Date</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->inspection_due_date ? \Carbon\Carbon::parse($order->inspection_due_date)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Parts Pickup Date</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->parts_pickup_date ? \Carbon\Carbon::parse($order->parts_pickup_date)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            Internal Dates
                        </h5>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Pickup Transfer Date</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->pickup_transfer_date ? \Carbon\Carbon::parse($order->pickup_transfer_date)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Sales Transfer Date</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->sales_transfer_date ? \Carbon\Carbon::parse($order->sales_transfer_date)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">Shipping Transfer Date</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->shipping_transfer_date ? \Carbon\Carbon::parse($order->shipping_transfer_date)->format('M d, Y') : 'N/A' }}
                                </p>
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