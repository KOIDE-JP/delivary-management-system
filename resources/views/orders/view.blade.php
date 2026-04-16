@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50">
        <div class="w-full max-w-6xl p-6 bg-white border border-gray-100 shadow-xl sm:p-8 rounded-2xl">

            {{-- HEADER & ACTIONS --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">{{ __('layouts.order.view') }}</h4>
                    <p class="mt-1 text-sm text-gray-500">{{ __('layouts.order_details_for') }} <span class="font-semibold text-gray-700">{{ $order->order_number }}</span></p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('order.index') }}"
                        class="min-w-[9rem] flex-1 px-2 py-2 font-semibold text-center text-gray-700 transition-colors bg-gray-200 hover:bg-gray-300 rounded-xl">
                        {{ __('layouts.back_to_list') }}
                    </a>
                    <a href="{{ route('order.edit', $order->id) }}"
                        class="min-w-[9rem] cursor-pointer flex-1 px-2 py-2 font-semibold text-center text-white transition-opacity bg-gradient-to-r from-blue-600 to-cyan-400 hover:opacity-90 rounded-xl shadow-md">
                        {{ __('layouts.edit_order') }}
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
                        {{ __('layouts.basic_information') }}
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.order_number') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.order_name') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->order_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.registered_date') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ $order->registered_date ? \Carbon\Carbon::parse($order->registered_date)->format('M d, Y') : __('layouts.na') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- DELIVERY INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('layouts.delivery_information') }}
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.due_date') }}</p>
                            <p class="mt-1 text-base font-semibold text-red-600">
                                {{ $order->due_date ? \Carbon\Carbon::parse($order->due_date)->format('M d, Y') : __('layouts.pending') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.due_confidence') }}</p>
                            <div class="mt-1">
                                @if($order->due_confidence == 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ __('layouts.confirmed') }}</span>
                                @elseif($order->due_confidence == 'unconfirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ __('layouts.unconfirmed') }}</span>
                                @else
                                    <span class="text-gray-500 text-sm">{{ __('layouts.na') }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.inspection_date') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ $order->inspection_date ? \Carbon\Carbon::parse($order->inspection_date)->format('M d, Y') : __('layouts.na') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.priority') }}</p>
                            <div class="mt-1">
                                @if($order->priority == 'yes')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ __('layouts.high') }}</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ __('layouts.normal') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SHIPPING INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        {{ __('layouts.shipping_information') }}
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.shipping_date') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ $order->shipping_date ? \Carbon\Carbon::parse($order->shipping_date)->format('M d, Y') : __('layouts.na') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.shipping_status') }}</p>
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
                                    // $displayText = $order->shipping_status ? ucwords(str_replace('_', ' ', $order->shipping_status)) : 'N/A';
                                    //  Convert status to display text using localization
                                    $displayText = __('layouts.' . ($order->shipping_status ?? 'na'));
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
                            {{ __('layouts.document_submission') }}
                        </h5>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.dw_status') }}</p>
                                {{-- <p class="mt-1 text-base font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->dw_status ?? 'N/A')) }}</p> --}}
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ __('layouts.' . ($order->dw_status ?? 'na')) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.quotation_status') }}</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ __('layouts.' . ($order->quotation_status ?? 'na')) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.order_status') }}</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ __('layouts.' . ($order->order_status ?? 'na')) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('layouts.billing_information') }}
                        </h5>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.inspection_slip_status') }}</p>
                                {{-- <p class="mt-1 text-base font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->inspection_slip_status ?? 'N/A')) }}</p> --}}
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ __('layouts.' . ($order->inspection_slip_status ?? 'na')) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.invoice_status') }}</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ __('layouts.' . ($order->invoice_status ?? 'na')) }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.order_amount') }}</p>
                                <p class="mt-1 text-xl font-bold text-blue-600">
                                    {{ $order->order_amount ? '¥' . number_format($order->order_amount, 2) : __('layouts.na') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FREIGHT INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        {{ __('layouts.freight_information') }}
                    </h5>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.destination') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->destination->name ?? __('layouts.na') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.carrier') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->carrier ?? __('layouts.na') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.truck_type') }}</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->truck_type ?? __('layouts.na') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('layouts.freight_price') }}</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ $order->freight_price ? '¥' . number_format($order->freight_price, 2) : __('layouts.na') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- SCHEDULES & DATES --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('layouts.client_schedule') }}
                        </h5>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.material_pickup_date') }}</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->material_pickup_date ? \Carbon\Carbon::parse($order->material_pickup_date)->format('M d, Y') : __('layouts.na') }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.inspection_due_date') }}</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->inspection_due_date ? \Carbon\Carbon::parse($order->inspection_due_date)->format('M d, Y') : __('layouts.na') }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.parts_pickup_date') }}</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->parts_pickup_date ? \Carbon\Carbon::parse($order->parts_pickup_date)->format('M d, Y') : __('layouts.na') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                        <h5 class="flex items-center gap-2 mb-4 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            {{ __('layouts.internal_dates') }}
                        </h5>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.pickup_transfer_date') }}</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->pickup_transfer_date ? \Carbon\Carbon::parse($order->pickup_transfer_date)->format('M d, Y') : __('layouts.na') }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.sales_transfer_date') }}</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->sales_transfer_date ? \Carbon\Carbon::parse($order->sales_transfer_date)->format('M d, Y') : __('layouts.na') }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-500">{{ __('layouts.shipping_transfer_date') }}</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $order->shipping_transfer_date ? \Carbon\Carbon::parse($order->shipping_transfer_date)->format('M d, Y') : __('layouts.na') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="mt-3">
                    @includeIf('components.activity-log-component')
                </div> --}}


                {{-- ===================== ACTIVITY LOG TIMELINE ===================== --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center gap-2 mb-6 text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('layouts.activity_log') }}
                        <span class="ml-auto text-xs font-medium text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                            {{ $activityLogs->total() }} {{ __('layouts.records') }}
                        </span>
                    </h5>
 
                    @if($activityLogs->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-sm">{{ __('layouts.no_activity_logs') }}</p>
                        </div>
                    @else
 
                        @php
                            $actionCreated       = 'action_created';
                            $actionUpdated       = 'action_updated';
                            $actionDeleted       = 'action_deleted';
                            $actionStatusUpdated = 'action_status_updated';
                            $statusSuccess       = 'status_success';
                            $statusFailed        = 'status_failed';
                            $statusWarning       = 'status_warning';
                        @endphp
 
                        <div class="relative">
                            {{-- Vertical line --}}
                            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-100"></div>
 
                            <div class="space-y-4">
                                @foreach($activityLogs as $log)
                                    <div class="relative flex gap-4 pl-2">
 
                                        {{-- Icon Circle --}}
                                        <div class="relative z-10 flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center shadow-sm border-2
                                            @if($log->action === $actionCreated)           bg-green-50   border-green-200
                                            @elseif($log->action === $actionUpdated)       bg-blue-50    border-blue-200
                                            @elseif($log->action === $actionDeleted)       bg-red-50     border-red-200
                                            @elseif($log->action === $actionStatusUpdated) bg-emerald-50 border-emerald-200
                                            @else                                          bg-gray-50    border-gray-200
                                            @endif">
 
                                            @if($log->action === $actionCreated)
                                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            @elseif($log->action === $actionUpdated)
                                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            @elseif($log->action === $actionDeleted)
                                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            @elseif($log->action === $actionStatusUpdated)
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @else
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @endif
                                        </div>
 
                                        {{-- Content --}}
                                        <div class="flex-1 bg-white rounded-xl p-4 border border-gray-100 min-w-0">
                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
 
                                                {{-- Action Badge --}}
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                    @if($log->action === $actionCreated)           bg-green-100   text-green-700
                                                    @elseif($log->action === $actionUpdated)       bg-blue-100    text-blue-700
                                                    @elseif($log->action === $actionDeleted)       bg-red-100     text-red-600
                                                    @elseif($log->action === $actionStatusUpdated) bg-emerald-100 text-emerald-700
                                                    @else                                          bg-gray-100    text-gray-600
                                                    @endif">
                                                    {{ __('layouts.' . $log->action) }}
                                                </span>
 
                                                {{-- Log Status Badge --}}
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($log->log_status === $statusSuccess)     bg-emerald-50 text-emerald-600
                                                    @elseif($log->log_status === $statusFailed)  bg-red-50     text-red-500
                                                    @elseif($log->log_status === $statusWarning) bg-yellow-50  text-yellow-600
                                                    @else                                        bg-gray-100   text-gray-500
                                                    @endif">
                                                    {{ __('layouts.' . $log->log_status) }}
                                                </span>
 
                                                {{-- Timestamp --}}
                                                <span class="text-xs text-gray-400 ml-auto">
                                                    {{ $log->created_at->format('Y-m-d H:i') }}
                                                </span>
                                            </div>
 
                                            {{-- Message --}}
                                            @if($log->log_message)
                                                @php
                                                    $msg = json_decode($log->log_message, true);
                                                @endphp
 
                                                @if($msg && isset($msg['key']))
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        {{ __('layouts.' . $msg['key'], [
                                                            'from' => __('layouts.' . $msg['from']),
                                                            'to'   => __('layouts.' . $msg['to']),
                                                        ]) }}
                                                    </p>
                                                @else
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        {{ __('layouts.' . $log->log_message) }}
                                                    </p>
                                                @endif
                                            @endif
 
                                            {{-- Performed by --}}
                                            @if($log->user)
                                                <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    {{ $log->user->name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
 
                            {{-- Pagination --}}
                            <div class="mt-6">
                                {{ $activityLogs->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                {{-- ===================== END ACTIVITY LOG ===================== --}}

            </div>

        </div>
    </div>
@endsection