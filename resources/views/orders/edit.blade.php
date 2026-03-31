@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full p-4 sm:p-6 bg-gray-50 min-h-screen">
        <div class="w-full max-w-6xl p-0 bg-white border border-gray-100 shadow-xl rounded-2xl overflow-hidden flex flex-col h-fit">

            {{-- HEADER --}}
            <div class="p-8 pb-6 border-b border-gray-100 bg-white">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-2xl font-bold text-gray-900">Edit Order: #{{ $order->order_number }}</h4>
                    <a href="{{ route('order.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                        &larr; Back to List
                    </a>
                </div>
                <p class="mt-1 text-sm text-gray-500">Update the details for this order. Navigate through the steps to modify optional information.</p>
                
                {{-- Global Error Alert --}}
                @if ($errors->any())
                    <div class="mt-4 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                        <span class="font-medium">Please correct the errors below to proceed.</span>
                    </div>
                @endif
            </div>

            {{-- FORM ACTION & METHOD SPOOFING --}}
            <form action="{{ route('order.update', $order->id) }}" method="POST" id="wizard-form">
                @csrf
                @method('PUT')

                {{-- STEPPER NAVIGATION --}}
                <div class="bg-gray-50/50 px-4 sm:px-8 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between relative overflow-x-auto custom-scrollbar pb-2">
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10 hidden sm:block"></div>
                        
                        @php
                            $steps = [
                                ['id' => 'step-basic', 'label' => 'Basic Info', 'req' => true, 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['id' => 'step-delivery', 'label' => 'Delivery', 'req' => false, 'icon' => 'M8 19a2 2 0 100-4 2 2 0 000 4zm8 0a2 2 0 100-4 2 2 0 000 4zm-8-4H5a2 2 0 01-2-2V7a2 2 0 012-2h9a2 2 0 012 2v8M16 15h-2M16 8h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-1'],
                                ['id' => 'step-billing', 'label' => 'Billing', 'req' => false, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['id' => 'step-freight', 'label' => 'Freight', 'req' => false, 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                                ['id' => 'step-internal', 'label' => 'Dates', 'req' => false, 'icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
                            ];
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="step-indicator flex flex-col items-center relative bg-gray-50/50 px-2 sm:px-4 cursor-default" data-step="{{ $index }}">
                                <div class="step-circle w-10 h-10 rounded-full flex items-center justify-center border-2 bg-white transition-colors duration-200 {{ $index === 0 ? 'border-blue-600 text-blue-600' : 'border-gray-300 text-gray-400' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"></path>
                                    </svg>
                                </div>
                                <div class="mt-2 text-xs font-medium text-center whitespace-nowrap {{ $index === 0 ? 'text-blue-600' : 'text-gray-500' }} step-label">
                                    {{ $step['label'] }}
                                    @if($step['req']) <span class="text-red-500">*</span> @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB CONTENT PANELS --}}
                <div class="p-8 min-h-[400px]">

                    {{-- PANEL 0: BASIC INFORMATION --}}
                    <div id="panel-0" class="wizard-panel block">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">1. Basic Information</h5>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Number <span class="text-red-500">*</span></label>
                                <input type="text" name="order_number" value="{{ old('order_number', $order->order_number) }}" required
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('order_number') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('order_number') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Name <span class="text-red-500">*</span></label>
                                <input type="text" name="order_name" value="{{ old('order_name', $order->order_name) }}" required
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('order_name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('order_name') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Registered Date <span class="text-red-500">*</span></label>
                                <input type="date" name="registered_date" value="{{ old('registered_date', $order->registered_date) }}" required
                                    class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('registered_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('registered_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 1: DELIVERY & SHIPPING --}}
                    <div id="panel-1" class="wizard-panel hidden space-y-8">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">2. Delivery & Shipping</h5>
                        <div>
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Delivery Details</h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Due Date</label>
                                    <input type="date" name="due_date" value="{{ old('due_date', $order->due_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('due_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    @error('due_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Due Confidence</label>
                                    <select name="due_confidence" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('due_confidence') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="" disabled {{ old('due_confidence', $order->due_confidence) ? '' : 'selected' }}>Select status</option>
                                        <option value="confirmed" {{ old('due_confidence', $order->due_confidence) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="unconfirmed" {{ old('due_confidence', $order->due_confidence) == 'unconfirmed' ? 'selected' : '' }}>Unconfirmed</option>
                                    </select>
                                    @error('due_confidence') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Inspection Date</label>
                                    <input type="date" name="inspection_date" value="{{ old('inspection_date', $order->inspection_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('inspection_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    @error('inspection_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Priority</label>
                                    <select name="priority" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('priority') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="no" {{ old('priority', $order->priority) == 'no' ? 'selected' : '' }}>Normal</option>
                                        <option value="yes" {{ old('priority', $order->priority) == 'yes' ? 'selected' : '' }}>High Priority</option>
                                    </select>
                                    @error('priority') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Shipping Details</h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Shipping Date</label>
                                    <input type="date" name="shipping_date" value="{{ old('shipping_date', $order->shipping_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('shipping_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    @error('shipping_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Shipping Status</label>
                                    <select name="shipping_status" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('shipping_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="" disabled {{ old('shipping_status', $order->shipping_status) ? '' : 'selected' }}>Select status</option>
                                        <option value="unconfirmed" {{ old('shipping_status', $order->shipping_status) == 'unconfirmed' ? 'selected' : '' }}>Unconfirmed</option>
                                        <option value="unarranged" {{ old('shipping_status', $order->shipping_status) == 'unarranged' ? 'selected' : '' }}>Unarranged</option>
                                        <option value="arranged" {{ old('shipping_status', $order->shipping_status) == 'arranged' ? 'selected' : '' }}>Arranged</option>
                                        <option value="direct_delivery" {{ old('shipping_status', $order->shipping_status) == 'direct_delivery' ? 'selected' : '' }}>Direct Delivery</option>
                                        <option value="courier" {{ old('shipping_status', $order->shipping_status) == 'courier' ? 'selected' : '' }}>Courier</option>
                                    </select>
                                    @error('shipping_status') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 2: DOCS & BILLING --}}
                    <div id="panel-2" class="wizard-panel hidden space-y-8">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">3. Docs & Billing</h5>
                        <div>
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Document Submission</h6>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">DW Status</label>
                                    <select name="dw_status" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('dw_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="undelivered" {{ old('dw_status', $order->dw_status) == 'undelivered' ? 'selected' : '' }}>Undelivered</option>
                                        <option value="delivered" {{ old('dw_status', $order->dw_status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="not_required" {{ old('dw_status', $order->dw_status) == 'not_required' ? 'selected' : '' }}>Not Required</option>
                                    </select>
                                    @error('dw_status') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Quotation Status</label>
                                    <select name="quotation_status" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('quotation_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="submitted" {{ old('quotation_status', $order->quotation_status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                        <option value="not_submitted" {{ old('quotation_status', $order->quotation_status) == 'not_submitted' ? 'selected' : '' }}>Not Submitted</option>
                                        <option value="not_required" {{ old('quotation_status', $order->quotation_status) == 'not_required' ? 'selected' : '' }}>Not Required</option>
                                    </select>
                                    @error('quotation_status') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Status</label>
                                    <select name="order_status" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('order_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="received" {{ old('order_status', $order->order_status) == 'received' ? 'selected' : '' }}>Received</option>
                                        <option value="not_received" {{ old('order_status', $order->order_status) == 'not_received' ? 'selected' : '' }}>Not Received</option>
                                        <option value="not_required" {{ old('order_status', $order->order_status) == 'not_required' ? 'selected' : '' }}>Not Required</option>
                                    </select>
                                    @error('order_status') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8 pt-6 border-t border-gray-100 md:grid-cols-2">
                            <div>
                                <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Client Schedule</h6>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Material Pickup Date</label>
                                        <input type="date" name="material_pickup_date" value="{{ old('material_pickup_date', $order->material_pickup_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('material_pickup_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        @error('material_pickup_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Inspection Due Date</label>
                                        <input type="date" name="inspection_due_date" value="{{ old('inspection_due_date', $order->inspection_due_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('inspection_due_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        @error('inspection_due_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Parts Pickup Date</label>
                                        <input type="date" name="parts_pickup_date" value="{{ old('parts_pickup_date', $order->parts_pickup_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('parts_pickup_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        @error('parts_pickup_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Billing Information</h6>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Inspection Slip Status</label>
                                        <select name="inspection_slip_status" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('inspection_slip_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <option value="received" {{ old('inspection_slip_status', $order->inspection_slip_status) == 'received' ? 'selected' : '' }}>Received</option>
                                            <option value="not_received" {{ old('inspection_slip_status', $order->inspection_slip_status) == 'not_received' ? 'selected' : '' }}>Not Received</option>
                                            <option value="not_required" {{ old('inspection_slip_status', $order->inspection_slip_status) == 'not_required' ? 'selected' : '' }}>Not Required</option>
                                        </select>
                                        @error('inspection_slip_status') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Invoice Status</label>
                                        <select name="invoice_status" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('invoice_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <option value="sent" {{ old('invoice_status', $order->invoice_status) == 'sent' ? 'selected' : '' }}>Sent</option>
                                            <option value="not_sent" {{ old('invoice_status', $order->invoice_status) == 'not_sent' ? 'selected' : '' }}>Not Sent</option>
                                            <option value="not_required" {{ old('invoice_status', $order->invoice_status) == 'not_required' ? 'selected' : '' }}>Not Required</option>
                                        </select>
                                        @error('invoice_status') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Amount</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">¥</span>
                                            </div>
                                            <input type="number" step="0.01" name="order_amount" value="{{ old('order_amount', $order->order_amount) }}" class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border @error('order_amount') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        </div>
                                        @error('order_amount') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 3: FREIGHT INFO --}}
                    <div id="panel-3" class="wizard-panel hidden">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">4. Freight Info</h5>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Destination</label>
                                <input type="text" name="destination" value="{{ old('destination', $order->destination) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('destination') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('destination') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Carrier</label>
                                <input type="text" name="carrier" value="{{ old('carrier', $order->carrier) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('carrier') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('carrier') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Truck Type</label>
                                <input type="text" name="truck_type" value="{{ old('truck_type', $order->truck_type) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('truck_type') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('truck_type') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Freight Price</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">¥</span>
                                    </div>
                                    <input type="number" step="0.01" name="freight_price" value="{{ old('freight_price', $order->freight_price) }}" class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border @error('freight_price') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                @error('freight_price') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 4: INTERNAL DATES --}}
                    <div id="panel-4" class="wizard-panel hidden">
                        <h5 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">5. Internal Dates</h5>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Pickup Transfer Date</label>
                                <input type="date" name="pickup_transfer_date" value="{{ old('pickup_transfer_date', $order->pickup_transfer_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('pickup_transfer_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('pickup_transfer_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Sales Transfer Date</label>
                                <input type="date" name="sales_transfer_date" value="{{ old('sales_transfer_date', $order->sales_transfer_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('sales_transfer_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('sales_transfer_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Shipping Transfer Date</label>
                                <input type="date" name="shipping_transfer_date" value="{{ old('shipping_transfer_date', $order->shipping_transfer_date) }}" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border @error('shipping_transfer_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('shipping_transfer_date') <p class="mt-1 text-xs text-red-600 error-text">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- WIZARD ACTION BUTTONS --}}
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <div class="flex gap-3">
                            <a href="{{ route('order.index') }}" class="cursor-pointer px-6 py-2.5 font-semibold text-center text-gray-700 transition-colors bg-white border border-gray-300 hover:bg-gray-100 rounded-xl shadow-sm">
                                Cancel
                            </a>
                            <button type="button" id="btn-prev" class="hidden cursor-pointer px-6 py-2.5 font-semibold text-center text-gray-700 transition-colors bg-white border border-gray-300 hover:bg-gray-100 rounded-xl shadow-sm">
                                ← Previous
                            </button>
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="button" id="btn-next" class="cursor-pointer px-8 py-2.5 font-semibold text-white transition-opacity bg-gray-800 hover:bg-gray-900 rounded-xl shadow-md flex items-center">
                                Next Step →
                            </button>
                            <button type="submit" id="btn-submit" class="cursor-pointer px-8 py-2.5 font-semibold text-white transition-opacity bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">
                                Update Order
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
        .custom-scrollbar::-webkit-scrollbar { display: none; }
        .custom-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            const totalSteps = 5;
            let currentStep = 0;

            // --- SMART VALIDATION ROUTING ---
            let firstErrorElement = $('.error-text').first();
            if(firstErrorElement.length > 0) {
                let panelId = firstErrorElement.closest('.wizard-panel').attr('id');
                if(panelId) {
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
                        $circle.removeClass('border-gray-300 text-gray-400 border-blue-600 text-blue-600 bg-white').addClass('bg-blue-600 border-blue-600 text-white');
                        $label.removeClass('text-gray-500').addClass('text-blue-600');
                    } else if (index === currentStep) {
                        $circle.removeClass('border-gray-300 text-gray-400 bg-blue-600 text-white').addClass('bg-white border-blue-600 text-blue-600');
                        $label.removeClass('text-gray-500').addClass('text-blue-600');
                    } else {
                        $circle.removeClass('bg-blue-600 border-blue-600 text-white text-blue-600').addClass('bg-white border-gray-300 text-gray-400');
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
                $('#panel-' + currentStep).find('input[required], select[required], textarea[required]').each(function() {
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

            updateUI();
        });
    </script>
@endpush