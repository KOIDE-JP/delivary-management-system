@extends('layouts.master')

@section('content')
<div class="flex justify-center w-full p-4 sm:p-6 bg-gray-50 min-h-screen">
    <div class="w-full max-w-6xl p-8 bg-white border border-gray-100 shadow-xl rounded-2xl">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h4 class="text-2xl font-bold text-gray-900">Create Order</h4>
                <p class="mt-1 text-sm text-gray-500">Fill in the details below to generate a new order.</p>
            </div>
        </div>

        <form action="#" method="POST">
            @csrf

            {{-- BASIC INFORMATION --}}
            <div class="p-6 mb-8 border border-gray-100 rounded-xl bg-gray-50/50">
                <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Basic Information
                </h5>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Number</label>
                        <input type="text" placeholder="e.g. ORD-10293" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Name</label>
                        <input type="text" placeholder="Enter order name" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Registered Date</label>
                        <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                </div>
            </div>

            {{-- DELIVERY INFORMATION --}}
            <div class="p-6 mb-8 border border-gray-100 rounded-xl bg-gray-50/50">
                <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Delivery Information
                </h5>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Due Date</label>
                        <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Due Confidence</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>Select status</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="unconfirmed">Unconfirmed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Inspection Date</label>
                        <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Priority</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="no">Normal (No)</option>
                            <option value="yes">High (Yes)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- SHIPPING INFORMATION --}}
            <div class="p-6 mb-8 border border-gray-100 rounded-xl bg-gray-50/50">
                <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Shipping Information
                </h5>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Shipping Date</label>
                        <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Shipping Status</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>Select status</option>
                            <option value="unconfirmed">Unconfirmed</option>
                            <option value="unarranged">Unarranged</option>
                            <option value="arranged">Arranged</option>
                            <option value="direct_delivery">Direct Delivery</option>
                            <option value="courier">Courier</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- DOCUMENT SUBMISSION --}}
            <div class="p-6 mb-8 border border-gray-100 rounded-xl bg-gray-50/50">
                <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Document Submission
                </h5>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">DW Status</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="undelivered">Undelivered</option>
                            <option value="delivered">Delivered</option>
                            <option value="not_required">Not Required</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Quotation Status</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="submitted">Submitted</option>
                            <option value="not_submitted">Not Submitted</option>
                            <option value="not_required">Not Required</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Status</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="received">Received</option>
                            <option value="not_received">Not Received</option>
                            <option value="not_required">Not Required</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- CLIENT SCHEDULE & BILLING (Grouped for better layout) --}}
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                {{-- CLIENT SCHEDULE --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Client Schedule
                    </h5>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Material Pickup Date</label>
                            <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Inspection Due Date</label>
                            <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Parts Pickup Date</label>
                            <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>
                </div>

                {{-- BILLING INFORMATION --}}
                <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50">
                    <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Billing Information
                    </h5>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Inspection Slip Status</label>
                            <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="received">Received</option>
                                <option value="not_received">Not Received</option>
                                <option value="not_required">Not Required</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Invoice Status</label>
                            <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="sent">Sent</option>
                                <option value="not_sent">Not Sent</option>
                                <option value="not_required">Not Required</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Amount</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" placeholder="0.00" class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FREIGHT SECTION --}}
            <div class="p-6 mt-8 mb-8 border border-gray-100 rounded-xl bg-gray-50/50">
                <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Freight Information
                </h5>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Destination</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>Select Destination</option>
                            <option value="ny">New York, NY</option>
                            <option value="ca">Los Angeles, CA</option>
                            <option value="tx">Houston, TX</option>
                            <option value="il">Chicago, IL</option>
                            <option value="fl">Miami, FL</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Carrier</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>Select Carrier</option>
                            <option value="fedex">FedEx Freight</option>
                            <option value="ups">UPS Supply Chain</option>
                            <option value="dhl">DHL Express</option>
                            <option value="xpo">XPO Logistics</option>
                            <option value="private">Private Fleet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Truck Type</label>
                        <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>Select Truck Type</option>
                            <option value="flatbed">Flatbed</option>
                            <option value="dry_van">Dry Van</option>
                            <option value="refrigerated">Refrigerated (Reefer)</option>
                            <option value="box_truck">Box Truck</option>
                            <option value="step_deck">Step Deck</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Freight Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" placeholder="0.00" class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            {{-- INTERNAL DATES --}}
            <div class="p-6 mb-8 border border-gray-100 rounded-xl bg-gray-50/50">
                <h5 class="flex items-center mb-5 text-lg font-bold text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    Internal Dates
                </h5>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Pickup Transfer Date</label>
                        <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Sales Transfer Date</label>
                        <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Shipping Transfer Date</label>
                        <input type="date" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="pt-6 mt-8 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-start gap-3 sm:max-w-md">
                    <a href="{{ route('order.index') }}" id="cancelDepartmentModalBtn"
                        class="flex-1 px-6 py-3 font-semibold text-center text-gray-700 transition-colors bg-gray-200 hover:bg-gray-300 rounded-xl">
                        {{ __('layouts.cancel') }}
                    </a>
                    
                    <button type="submit" id="submitDepartmentBtn"
                        class="cursor-pointer flex-1 px-6 py-3 font-semibold text-white transition-opacity bg-gradient-to-r from-blue-600 to-cyan-400 hover:opacity-90 rounded-xl shadow-md">
                        {{ __('layouts.save') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('styles')
    <style>
        /* Add any custom overriding styles here if necessary */
    </style>
@endpush

@push('scripts')
    <script>
        // Custom scripts here
    </script>
@endpush