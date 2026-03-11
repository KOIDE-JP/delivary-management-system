@extends('layouts.master')

@section('content')
<div class="flex justify-center w-full p-4 sm:p-6 bg-gray-50 min-h-screen">
    {{-- Removed flex-grow to prevent unwanted stretching --}}
    <div class="w-full max-w-6xl p-0 bg-white border border-gray-100 shadow-xl rounded-2xl overflow-hidden flex flex-col h-fit">

        {{-- HEADER --}}
        <div class="p-8 pb-6 border-b border-gray-100 bg-white">
            <h4 class="text-2xl font-bold text-gray-900">Create Order</h4>
            <p class="mt-1 text-sm text-gray-500">Fill in the basic details to generate a new order. Navigate tabs for additional information.</p>
        </div>

        <form action="#" method="POST">
            @csrf

            {{-- TAB NAVIGATION --}}
            <div class="border-b border-gray-200 bg-gray-50/50 px-4 sm:px-8">
                <nav class="flex -mb-px space-x-6 overflow-x-auto custom-scrollbar" aria-label="Tabs">
                    <button type="button" data-target="panel-basic" class="tab-btn active-tab cursor-pointer flex items-center py-4 px-1 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Basic Info <span class="ml-2 bg-blue-100 text-blue-600 py-0.5 px-2 rounded-full text-xs">Required</span>
                    </button>

                    <button type="button" data-target="panel-delivery" class="tab-btn inactive-tab cursor-pointer flex items-center py-4 px-1 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Delivery & Shipping
                    </button>

                    <button type="button" data-target="panel-billing" class="tab-btn inactive-tab cursor-pointer flex items-center py-4 px-1 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Docs & Billing
                    </button>

                    <button type="button" data-target="panel-freight" class="tab-btn inactive-tab cursor-pointer flex items-center py-4 px-1 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Freight Info
                    </button>

                    <button type="button" data-target="panel-internal" class="tab-btn inactive-tab cursor-pointer flex items-center py-4 px-1 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        Internal Dates
                    </button>
                </nav>
            </div>

            {{-- TAB CONTENT PANELS --}}
            <div class="p-8">
                
                {{-- PANEL 1: BASIC INFORMATION --}}
                <div id="panel-basic" class="tab-panel block">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Number <span class="text-red-500">*</span></label>
                            <input type="text" placeholder="e.g. ORD-10293" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Order Name <span class="text-red-500">*</span></label>
                            <input type="text" placeholder="Enter order name" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Registered Date <span class="text-red-500">*</span></label>
                            <input type="date" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>
                </div>

                {{-- PANEL 2: DELIVERY & SHIPPING --}}
                <div id="panel-delivery" class="tab-panel hidden space-y-8">
                    <div>
                        <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Delivery Details</h6>
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
                                    <option value="no">Normal</option>
                                    <option value="yes">High Priority</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100">
                        <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Shipping Details</h6>
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
                </div>

                {{-- PANEL 3: DOCS & BILLING --}}
                <div id="panel-billing" class="tab-panel hidden space-y-8">
                    <div>
                        <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Document Submission</h6>
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

                    <div class="grid grid-cols-1 gap-8 pt-6 border-t border-gray-100 md:grid-cols-2">
                        <div>
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Client Schedule</h6>
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
                        <div>
                            <h6 class="mb-4 text-sm font-bold text-gray-500 uppercase tracking-wider">Billing Information</h6>
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
                                            <span class="text-gray-500 sm:text-sm">¥</span>
                                        </div>
                                        <input type="number" placeholder="0" class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PANEL 4: FREIGHT INFO (Japan Locations & Carriers) --}}
                <div id="panel-freight" class="tab-panel hidden">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Destination</label>
                            <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="" disabled selected>Select Prefecture</option>
                                <option value="tokyo">Tokyo</option>
                                <option value="osaka">Osaka</option>
                                <option value="kanagawa">Kanagawa</option>
                                <option value="aichi">Aichi</option>
                                <option value="saitama">Saitama</option>
                                <option value="fukuoka">Fukuoka</option>
                                <option value="hokkaido">Hokkaido</option>
                                <option value="hyogo">Hyogo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Carrier</label>
                            <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="" disabled selected>Select Carrier</option>
                                <option value="yamato">Yamato Transport (Kuroneko)</option>
                                <option value="sagawa">Sagawa Express</option>
                                <option value="japan_post">Japan Post (Yu-Pack)</option>
                                <option value="nippon_express">Nippon Express (Nittsu)</option>
                                <option value="seino">Seino Transportation</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Truck Type</label>
                            <select class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="" disabled selected>Select Truck Type</option>
                                <option value="flatbed">Flatbed</option>
                                <option value="dry_van">Dry Van</option>
                                <option value="refrigerated">Refrigerated (Cool Ta-Q-Bin)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Freight Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">¥</span>
                                </div>
                                <input type="number" placeholder="0" class="block w-full py-2.5 pl-8 pr-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PANEL 5: INTERNAL DATES --}}
                <div id="panel-internal" class="tab-panel hidden">
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

            </div>

            {{-- FIXED ACTION BUTTONS --}}
            {{-- Removed mt-auto so this section hugs the content directly --}}
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('order.index') ?? '#' }}" 
                       class="cursor-pointer px-6 py-2.5 font-semibold text-center text-gray-700 transition-colors bg-white border border-gray-300 hover:bg-gray-100 rounded-xl shadow-sm">
                        {{ __('layouts.cancel') ?? 'Cancel' }}
                    </a>
                    <button type="submit" 
                        class="cursor-pointer px-8 py-2.5 font-semibold text-white transition-opacity bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">
                        {{ __('layouts.save') ?? 'Save Order' }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Active Tab Styles */
    .active-tab {
        border-color: #3b82f6 !important; 
        color: #2563eb !important; 
    }
    
    /* Inactive Tab Styles */
    .inactive-tab {
        border-color: transparent;
        color: #6b7280; 
    }
    .inactive-tab:hover {
        border-color: #d1d5db; 
        color: #374151; 
    }

    /* Hide scrollbar for the tab navigation */
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
        $('.tab-btn').on('click', function() {
            // Hide all panels
            $('.tab-panel').addClass('hidden').removeClass('block');

            // Reset all buttons to inactive state
            $('.tab-btn').removeClass('active-tab').addClass('inactive-tab');

            // Show target panel
            const targetId = $(this).attr('data-target');
            $('#' + targetId).removeClass('hidden').addClass('block');

            // Set clicked button to active
            $(this).removeClass('inactive-tab').addClass('active-tab');
        });
    });
</script>
@endpush