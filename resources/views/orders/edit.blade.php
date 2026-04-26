@extends('layouts.master')
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
@section('content')
    <div class="flex justify-center w-full p-4 sm:p-6 bg-gray-50 min-h-screen">
        <div
            class="w-full max-w-6xl p-0 bg-white border border-gray-100 shadow-xl rounded-2xl overflow-hidden flex flex-col h-fit">

            {{-- HEADER --}}
            <div class="p-8 pb-6 border-b border-gray-100 bg-white">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-2xl font-bold text-gray-900">{{ __('layouts.edit_order') }}: #{{ $order->order_number }}
                    </h4>
                    <a href="{{ route('order.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                        &larr; {{ __('layouts.back_to_orders') }}
                    </a>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    {{-- Update the details for this order. Navigate through the steps to modify optional information. --}}
                    {{ __('layouts.update_the_details_for_this_order_navigate_through_the_steps_to_modify_optional_information') }}
                </p>

                {{-- Global Error Alert --}}
                @if ($errors->any())
                    <div class="mt-4 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                        <span class="font-medium">{{ __('layouts.please_correct_the_errors_below_to_proceed') }}</span>
                    </div>
                @endif
            </div>

            {{-- FORM ACTION & METHOD SPOOFING --}}
            <form action="{{ route('order.update', $order->id) }}" method="POST" id="wizard-form">
                @csrf

                {{-- STEPPER NAVIGATION --}}
                <div class="bg-gray-50/50 px-4 sm:px-8 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between relative overflow-x-auto custom-scrollbar pb-2">
                        <div
                            class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10 hidden sm:block">
                        </div>

                        @php
                            $steps = [
                                [
                                    'id' => 'step-basic',
                                    'label' => __('layouts.basic_info'),
                                    'req' => true,
                                    'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                [
                                    'id' => 'step-delivery',
                                    'label' => __('layouts.delivery'),
                                    'req' => false,
                                    'icon' =>
                                        'M8 19a2 2 0 100-4 2 2 0 000 4zm8 0a2 2 0 100-4 2 2 0 000 4zm-8-4H5a2 2 0 01-2-2V7a2 2 0 012-2h9a2 2 0 012 2v8M16 15h-2M16 8h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-1',
                                ],
                                [
                                    'id' => 'step-billing',
                                    'label' => __('layouts.billing'),
                                    'req' => false,
                                    'icon' =>
                                        'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                ],
                                [
                                    'id' => 'step-freight',
                                    'label' => __('layouts.freight'),
                                    'req' => false,
                                    'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
                                ],
                                [
                                    'id' => 'step-internal',
                                    'label' => __('layouts.dates'),
                                    'req' => false,
                                    'icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z',
                                ],
                            ];
                        @endphp

                        @foreach ($steps as $index => $step)
                            <div class="step-indicator flex flex-col items-center relative bg-gray-50/50 px-2 sm:px-4 cursor-default"
                                data-step="{{ $index }}">
                                <div
                                    class="step-circle w-10 h-10 rounded-full flex items-center justify-center border-2 bg-white transition-colors duration-200 {{ $index === 0 ? 'border-blue-600 text-blue-600' : 'border-gray-300 text-gray-400' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $step['icon'] }}"></path>
                                    </svg>
                                </div>
                                <div
                                    class="mt-2 text-xs font-medium text-center whitespace-nowrap {{ $index === 0 ? 'text-blue-600' : 'text-gray-500' }} step-label">
                                    {{ $step['label'] }}
                                    @if ($step['req'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB CONTENT PANELS --}}
                <div class="p-8 min-h-[400px]">

                    {{-- PANEL 0: BASIC INFORMATION --}}
                    <div id="panel-0" class="wizard-panel block">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">1.
                            {{ __('layouts.basic_information') }}</h5>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div>
                                <label
                                    class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.order_number') }}
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="order_number"
                                    value="{{ old('order_number', $order->order_number) }}" required
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('order_number') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('order_number')
                                    <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                @enderror
                                <div id="prefix_alert"
                                    class="hidden mt-3 flex items-start gap-2.5 p-3.5 rounded-xl bg-amber-50/60 backdrop-blur-md border border-amber-200/50 shadow-sm transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5 text-amber-500 shrink-0 mt-0.5">
                                        <path fill-rule="evenodd"
                                            d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <div class="text-xs font-medium leading-relaxed text-amber-800">
                                        <span
                                            class="font-bold text-amber-900">{{ __('layouts.unrecognized_prefix') }}:</span>
                                        {{ __('layouts.unrecognized_prefix_description') }}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.order_name') }}
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="order_name" value="{{ old('order_name', $order->order_name) }}"
                                    required
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('order_name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('order_name')
                                    <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.registered_date') }}
                                    <span class="text-red-500">*</span></label>
                                <input type="date" name="registered_date"
                                    value="{{ old('registered_date', $order->registered_date) }}" required
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('registered_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('registered_date')
                                    <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 1: DELIVERY & SHIPPING --}}
                    <div id="panel-1" class="wizard-panel hidden space-y-8">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">2.
                            {{ __('layouts.delivery_and_shipping') }}</h5>
                        <div>
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('layouts.delivery_details') }}</h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.due_date') }}</label>
                                    <input type="date" name="due_date" value="{{ old('due_date', $order->due_date) }}"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('due_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    @error('due_date')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.due_confidence') }}</label>
                                    <select name="due_confidence"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('due_confidence') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="" disabled
                                            {{ old('due_confidence', $order->due_confidence) ? '' : 'selected' }}>
                                            {{ __('layouts.select_status') }}</option>
                                        <option value="confirmed"
                                            {{ old('due_confidence', $order->due_confidence) == 'confirmed' ? 'selected' : '' }}>
                                            {{ __('layouts.confirmed') }}</option>
                                        <option value="unconfirmed"
                                            {{ old('due_confidence', $order->due_confidence) == 'unconfirmed' ? 'selected' : '' }}>
                                            {{ __('layouts.unconfirmed') }}</option>
                                    </select>
                                    @error('due_confidence')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.inspection_date') }}</label>
                                    <input type="date" name="inspection_date"
                                        value="{{ old('inspection_date', $order->inspection_date) }}"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('inspection_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    @error('inspection_date')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.priority') }}</label>
                                    <select name="priority"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('priority') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="no"
                                            {{ old('priority', $order->priority) == 'no' ? 'selected' : '' }}>
                                            {{ __('layouts.normal') }}</option>
                                        <option value="yes"
                                            {{ old('priority', $order->priority) == 'yes' ? 'selected' : '' }}>
                                            {{ __('layouts.high_priority') }}</option>
                                    </select>
                                    @error('priority')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('layouts.shipping_details') }}</h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.shipping_date') }}</label>
                                    <input type="date" name="shipping_date"
                                        value="{{ old('shipping_date', $order->shipping_date) }}"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('shipping_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    @error('shipping_date')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.shipping_status') }}</label>
                                    <select name="shipping_status"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('shipping_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="" disabled
                                            {{ old('shipping_status', $order->shipping_status) ? '' : 'selected' }}>
                                            {{ __('layouts.select_status') }}</option>
                                        <option value="unconfirmed"
                                            {{ old('shipping_status', $order->shipping_status) == 'unconfirmed' ? 'selected' : '' }}>
                                            {{ __('layouts.unconfirmed') }}</option>
                                        <option value="unarranged"
                                            {{ old('shipping_status', $order->shipping_status) == 'unarranged' ? 'selected' : '' }}>
                                            {{ __('layouts.unarranged') }}</option>
                                        <option value="arranged"
                                            {{ old('shipping_status', $order->shipping_status) == 'arranged' ? 'selected' : '' }}>
                                            {{ __('layouts.arranged') }}</option>
                                        <option value="direct_delivery"
                                            {{ old('shipping_status', $order->shipping_status) == 'direct_delivery' ? 'selected' : '' }}>
                                            {{ __('layouts.direct_delivery') }}</option>
                                        <option value="courier"
                                            {{ old('shipping_status', $order->shipping_status) == 'courier' ? 'selected' : '' }}>
                                            {{ __('layouts.courier') }}</option>
                                    </select>
                                    @error('shipping_status')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 2: DOCS & BILLING --}}
                    <div id="panel-2" class="wizard-panel hidden space-y-8">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">3.
                            {{ __('layouts.docs_&_billing') }}</h5>
                        <div>
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('layouts.document_submission') }}</h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.dw_status') }}</label>
                                    <select name="dw_status"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('dw_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="not_shipped"
                                            {{ old('dw_status', $order->dw_status) == 'not_shipped' ? 'selected' : '' }}>
                                            {{ __('layouts.not_shipped') }}
                                        </option>
                                        <option value="shipped"
                                            {{ old('dw_status', $order->dw_status) == 'shipped' ? 'selected' : '' }}>
                                            {{ __('layouts.shipped') }}
                                        </option>
                                        <option value="no_shipping_required"
                                            {{ old('dw_status', $order->dw_status) == 'no_shipping_required' ? 'selected' : '' }}>
                                            {{ __('layouts.no_shipping_required') }}
                                        </option>
                                    </select>
                                    @error('dw_status')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.quotation_status') }}</label>
                                    <select name="quotation_status"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('quotation_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="not_submitted"
                                            {{ old('quotation_status', $order->quotation_status) == 'not_submitted' ? 'selected' : '' }}>
                                            {{ __('layouts.not_submitted') }}</option>
                                        <option value="submitted"
                                            {{ old('quotation_status', $order->quotation_status) == 'submitted' ? 'selected' : '' }}>
                                            {{ __('layouts.submitted') }}</option>
                                        <option value="not_required"
                                            {{ old('quotation_status', $order->quotation_status) == 'not_required' ? 'selected' : '' }}>
                                            {{ __('layouts.not_required') }}</option>
                                    </select>
                                    @error('quotation_status')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.order_status') }}</label>
                                    <select name="order_status"
                                        class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('order_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="not_received"
                                            {{ old('order_status', $order->order_status) == 'not_received' ? 'selected' : '' }}>
                                            {{ __('layouts.not_received') }}</option>
                                        <option value="received"
                                            {{ old('order_status', $order->order_status) == 'received' ? 'selected' : '' }}>
                                            {{ __('layouts.received') }}</option>
                                        <option value="not_required"
                                            {{ old('order_status', $order->order_status) == 'not_required' ? 'selected' : '' }}>
                                            {{ __('layouts.not_required') }}</option>
                                    </select>
                                    @error('order_status')
                                        <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8 pt-6 border-t border-gray-100 md:grid-cols-2">
                            <div>
                                <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('layouts.client_schedule') }}</h6>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label
                                            class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.material_pickup_date') }}</label>
                                        <input type="date" name="material_pickup_date"
                                            value="{{ old('material_pickup_date', $order->material_pickup_date) }}"
                                            class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('material_pickup_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        @error('material_pickup_date')
                                            <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.inspection_due_date') }}</label>
                                        <input type="date" name="inspection_due_date"
                                            value="{{ old('inspection_due_date', $order->inspection_due_date) }}"
                                            class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('inspection_due_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        @error('inspection_due_date')
                                            <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.parts_pickup_date') }}</label>
                                        <input type="date" name="parts_pickup_date"
                                            value="{{ old('parts_pickup_date', $order->parts_pickup_date) }}"
                                            class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('parts_pickup_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        @error('parts_pickup_date')
                                            <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('layouts.billing_information') }}</h6>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label
                                            class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.inspection_slip_status') }}</label>
                                        <select name="inspection_slip_status"
                                            class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('inspection_slip_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <option value="not_received"
                                                {{ old('inspection_slip_status', $order->inspection_slip_status) == 'not_received' ? 'selected' : '' }}>
                                                {{ __('layouts.not_received') }}</option>
                                            <option value="received"
                                                {{ old('inspection_slip_status', $order->inspection_slip_status) == 'received' ? 'selected' : '' }}>
                                                {{ __('layouts.received') }}</option>
                                            <option value="not_required"
                                                {{ old('inspection_slip_status', $order->inspection_slip_status) == 'not_required' ? 'selected' : '' }}>
                                                {{ __('layouts.not_required') }}</option>
                                        </select>
                                        @error('inspection_slip_status')
                                            <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.invoice_status') }}</label>
                                        <select name="invoice_status"
                                            class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('invoice_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <option value="not_sent"
                                                {{ old('invoice_status', $order->invoice_status) == 'not_sent' ? 'selected' : '' }}>
                                                {{ __('layouts.not_sent') }}</option>
                                            <option value="sent"
                                                {{ old('invoice_status', $order->invoice_status) == 'sent' ? 'selected' : '' }}>
                                                {{ __('layouts.sent') }}</option>
                                            <option value="not_required"
                                                {{ old('invoice_status', $order->invoice_status) == 'not_required' ? 'selected' : '' }}>
                                                {{ __('layouts.not_required') }}</option>
                                        </select>
                                        @error('invoice_status')
                                            <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.order_amount') }}</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">¥</span>
                                            </div>
                                            <input type="number" step="0.01" name="order_amount"
                                                value="{{ old('order_amount', $order->order_amount) }}"
                                                class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border @error('order_amount') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        </div>
                                        @error('order_amount')
                                            <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 3: FREIGHT INFO --}}
                    <div id="panel-3" class="wizard-panel hidden">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">
                            {{ __('layouts.freight_info') }}
                        </h5>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">

                            {{-- Destination --}}
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    {{ __('layouts.destination') }}
                                </label>

                                <select name="destination"
                                    class="search_select block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('destination') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="" disabled>
                                        {{ __('layouts.select_destination') }}
                                    </option>

                                    @foreach ($destinations as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('destination', $order->destination) == $item->id ? 'selected' : '' }}>
                                            {{ $item->prefix . ' - ' . $item->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('destination')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Carrier --}}
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    {{ __('layouts.carrier') }}
                                </label>

                                <select name="carrier"
                                    class="search_select block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('carrier') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="" disabled>
                                        {{ __('layouts.select_carrier') }}
                                    </option>

                                    @foreach ($carriers as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('carrier', $order->carrier) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('carrier')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Truck Type --}}
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    {{ __('layouts.truck_type') }}
                                </label>

                                <select name="truck_type"
                                    class="search_select block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('truck_type') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="" disabled>
                                        {{ __('layouts.select_truck_type') }}
                                    </option>

                                    @foreach ($truckTypes as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('truck_type', $order->truck_type) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('truck_type')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Freight Master Price (Readonly) --}}
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    {{ __('layouts.freight_master_price') }}
                                </label>

                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">¥</span>
                                    </div>

                                    <input readonly type="number" step="0.01" name="freight_master_price"
                                        value="{{ old('freight_master_price', $order->freight_master_price) }}"
                                        class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-sm cursor-not-allowed opacity-60">
                                </div>
                            </div>

                            {{-- Freight Price --}}
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    {{ __('layouts.freight_price') }}
                                </label>

                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">¥</span>
                                    </div>

                                    <input type="number" step="0.01" name="freight_price"
                                        value="{{ old('freight_price', $order->freight_price) }}"
                                        class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border @error('freight_price') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                @error('freight_price')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Freight Note --}}
                            <div class="md:col-span-2 lg:col-span-2">
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    {{ __('layouts.freight_note') }}
                                </label>

                                <textarea name="freight_note" rows="3"
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('freight_note') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="{{ __('layouts.enter_freight_notes') }}">{{ old('freight_note', $order->freight_note) }}</textarea>

                                @error('freight_note')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- PANEL 4: INTERNAL DATES --}}
                    <div id="panel-4" class="wizard-panel hidden">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">
                            {{ __('layouts.internal_dates') }}</h5>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div>
                                <label
                                    class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.pickup_transfer_date') }}</label>
                                <input type="date" name="pickup_transfer_date"
                                    value="{{ old('pickup_transfer_date', $order->pickup_transfer_date) }}"
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('pickup_transfer_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('pickup_transfer_date')
                                    <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.sales_transfer_date') }}</label>
                                <input type="date" name="sales_transfer_date"
                                    value="{{ old('sales_transfer_date', $order->sales_transfer_date) }}"
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('sales_transfer_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('sales_transfer_date')
                                    <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block mb-1.5 text-sm font-semibold text-gray-700">{{ __('layouts.shipping_transfer_date') }}</label>
                                <input type="date" name="shipping_transfer_date"
                                    value="{{ old('shipping_transfer_date', $order->shipping_transfer_date) }}"
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('shipping_transfer_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('shipping_transfer_date')
                                    <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- WIZARD ACTION BUTTONS --}}
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <div class="flex gap-3">
                            <a href="{{ route('order.index') }}"
                                class="cursor-pointer px-6 py-2.5 font-semibold text-center text-gray-700 transition-colors bg-white border border-gray-300 hover:bg-gray-100 rounded-xl shadow-sm">
                                {{ __('layouts.cancel') }}
                            </a>
                            <button type="submit" id="btn-submit"
                                class="cursor-pointer px-8 py-2.5 font-semibold text-white transition-opacity bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">
                                {{ __('layouts.update_order') }}
                            </button>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" id="btn-prev"
                                class="hidden cursor-pointer px-6 py-2.5 font-semibold text-center text-gray-700 transition-colors bg-white border border-gray-300 hover:bg-gray-100 rounded-xl shadow-sm">
                                ← {{ __('layouts.previous') }}
                            </button>
                            <button type="button" id="btn-next"
                                class="cursor-pointer px-8 py-2.5 font-semibold text-white transition-opacity bg-gray-800 hover:bg-gray-900 rounded-xl shadow-md flex items-center">
                                {{ __('layouts.next_step') }} →
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .custom-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            const totalSteps = 5;
            let currentStep = 0;
            const destinations = @json($destinations);
            const $orderInput = $('input[name="order_number"]');
            const $selectedDestination = @json($order->destination ? (int)$order->destination : null);
            const $destinationSelect = $('select[name="destination"]');

            // --- SMART VALIDATION ROUTING ---
            let firstErrorElement = $('.error-text').first();
            if (firstErrorElement.length > 0) {
                let panelId = firstErrorElement.closest('.wizard-panel').attr('id');
                if (panelId) {
                    currentStep = parseInt(panelId.replace('panel-', ''));
                }
            }

            function updateUI() {
                $('.wizard-panel').addClass('hidden').removeClass('block');
                $('#panel-' + currentStep).removeClass('hidden').addClass('block');

                $('.step-indicator').each(function(index) {
                    let $circle = $(this).find('.step-circle');
                    let $label = $(this).find('.step-label');

                    if (index < currentStep) {
                        $circle.removeClass(
                                'border-gray-300 text-gray-400 border-blue-600 text-blue-600 bg-white')
                            .addClass('bg-blue-600 border-blue-600 text-white');
                        $label.removeClass('text-gray-500').addClass('text-blue-600');
                    } else if (index === currentStep) {
                        $circle.removeClass('border-gray-300 text-gray-400 bg-blue-600 text-white')
                            .addClass('bg-white border-blue-600 text-blue-600');
                        $label.removeClass('text-gray-500').addClass('text-blue-600');
                    } else {
                        $circle.removeClass('bg-blue-600 border-blue-600 text-white text-blue-600')
                            .addClass('bg-white border-gray-300 text-gray-400');
                        $label.removeClass('text-blue-600').addClass('text-gray-500');
                    }
                });

                if (currentStep === 0) {
                    $('#btn-prev').addClass('hidden');
                } else {
                    $('#btn-prev').removeClass('hidden');
                }

                if (currentStep === totalSteps - 1) {
                    $('#btn-next').addClass('hidden');
                } else {
                    $('#btn-next').removeClass('hidden');
                }
            }

            $('#btn-next').on('click', function() {
                let isValid = true;
                $('#panel-' + currentStep).find('input[required], select[required], textarea[required]')
                    .each(function() {
                        if (!this.checkValidity()) {
                            isValid = false;
                            this.reportValidity();
                            return false;
                        }
                    });

                if (isValid && currentStep < totalSteps - 1) {
                    currentStep++;
                    updateUI();
                }
            });

            $('#btn-prev').on('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    updateUI();
                }
            });






            // =========================
            // FREIGHT PRICE LOGIC
            // =========================
            function fetchFreightPrice() {
                let destination = $('select[name="destination"]').val();
                let carrier = $('select[name="carrier"]').val();
                let truckType = $('select[name="truck_type"]').val();

                if (destination && carrier && truckType) {
                    $.ajax({
                        url: "{{ route('freight-rates.getRateAjax') }}",
                        type: "GET",
                        data: {
                            destination_id: destination,
                            carrier_id: carrier,
                            truck_type_id: truckType,
                        },
                        success: function(response) {
                            if (response.price !== null) {
                                $('input[name="freight_price"]').val(response.price);
                                $('input[name="freight_master_price"]').val(response.price);
                            } else {
                                $('input[name="freight_price"]').val('');
                                $('input[name="freight_master_price"]').val('');
                            }
                        },
                        error: function() {
                            console.log('Error fetching freight rate');
                        }
                    });
                }
            }

            // Trigger on change
            $('select[name="destination"], select[name="carrier"], select[name="truck_type"]').on('change',
                function() {
                    fetchFreightPrice();
                });

            // 👉 Trigger on page load (for edit)
            if (
                $('select[name="destination"]').val() &&
                $('select[name="carrier"]').val() &&
                $('select[name="truck_type"]').val()
            ) {
                fetchFreightPrice();
            }

            updateUI();

            // Sync shipping_date with due_date
            $('input[name="due_date"]').on('change', function() {
                $('input[name="shipping_date"]').val($(this).val());
            });
            
            function updateDestination() {

                // 1. ADDED 'selected' to the default option string
                const defaultOption =
                    `<option value="" disabled selected>{{ __('layouts.select_destination') }}</option>`;

                $orderInput.on('input', function() {
                    const orderValue = $(this).val().trim();

                    // Clear the dropdown and append the default disabled option
                    $destinationSelect.empty().append(defaultOption);

                    if (orderValue.length >= 2) {
                        const enteredPrefix = orderValue.substring(0, 2).toLowerCase();

                        // Filter the destinations array
                        const filteredDestinations = destinations.filter(item => {
                            return item.prefix && item.prefix.toLowerCase() === enteredPrefix;
                        });

                        // Only append options if a match is found
                        if (filteredDestinations.length > 0) {
                            $('#prefix_alert').addClass('hidden');
                            filteredDestinations.forEach(item => {
                                if ($selectedDestination && $selectedDestination === item.id) {
                                    $destinationSelect.append(
                                        $('<option>', {
                                            value: item.id,
                                            text: `${item.prefix} - ${item.name}`,
                                            selected: true
                                        })
                                    );
                                } else {
                                    $destinationSelect.append(
                                        $('<option>', {
                                            value: item.id,
                                            text: `${item.prefix} - ${item.name}`
                                        })
                                    );
                                }
                            });
                        } else {
                            $('#prefix_alert').removeClass('hidden');
                        }
                    } else {
                        $('#prefix_alert').addClass('hidden');
                    }

                    // 2. FORCE Select2 to sit on the empty placeholder value after rebuilding
                    // $destinationSelect.val("").trigger('change');
                });

                // Handle Laravel's old() input state after a validation failure
                if ($orderInput.val().length >= 2) {
                    // Trigger the input event to run the filtering logic above
                    $orderInput.trigger('input');

                    // Re-select the previously chosen destination
                    const oldDestination = "{{ old('destination') }}";
                    if (oldDestination) {
                        // This will safely override the .val("") we forced in the input event
                        $destinationSelect.val(oldDestination).trigger('change');
                    }
                } else {
                    // Ensure Select2 reflects the empty/default state on initial fresh load
                    $destinationSelect.val("").trigger('change');
                }
            }

            updateDestination();
        });
    </script>
@endpush
