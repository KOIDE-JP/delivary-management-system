@extends('layouts.master')

@section('content')
<div class="w-full flex justify-center p-4 sm:p-6">
    <div class="bg-white rounded-xl shadow-xl p-6 border border-gray-100 w-full">

        <div class="flex justify-between items-center mb-6">
            <h4 class="text-xl font-bold text-gray-800">Create Order</h4>
        </div>

        <form>

            {{-- BASIC INFORMATION --}}
            <div class="border-b pb-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Basic Information</h5>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Order Number</label>
                        <input type="text" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Order Name</label>
                        <input type="text" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Registered Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                </div>
            </div>


            {{-- DELIVERY INFORMATION --}}
            <div class="border-b pb-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Delivery Information</h5>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Due Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Due Confidence</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Confirmed</option>
                            <option>Unconfirmed</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Inspection Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Priority</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>No</option>
                            <option>Yes</option>
                        </select>
                    </div>

                </div>
            </div>


            {{-- SHIPPING INFORMATION --}}
            <div class="border-b pb-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Shipping Information</h5>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Shipping Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Shipping Status</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Unconfirmed</option>
                            <option>Unarranged</option>
                            <option>Arranged</option>
                            <option>Direct Delivery</option>
                            <option>Courier</option>
                        </select>
                    </div>

                </div>
            </div>


            {{-- DOCUMENT SUBMISSION --}}
            <div class="border-b pb-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Document Submission</h5>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">DW Status</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Undelivered</option>
                            <option>Delivered</option>
                            <option>Not Required</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Quotation Status</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Submitted</option>
                            <option>Not Submitted</option>
                            <option>Not Required</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Order Status</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Received</option>
                            <option>Not Received</option>
                            <option>Not Required</option>
                        </select>
                    </div>

                </div>
            </div>


            {{-- CLIENT SCHEDULE --}}
            <div class="border-b pb-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Client Schedule</h5>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Material Pickup Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Inspection Due Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Parts Pickup Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                </div>
            </div>


            {{-- BILLING INFORMATION --}}
            <div class="border-b pb-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Billing Information</h5>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Inspection Slip Status</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Received</option>
                            <option>Not Received</option>
                            <option>Not Required</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Invoice Status</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Sent</option>
                            <option>Not Sent</option>
                            <option>Not Required</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Order Amount</label>
                        <input type="number" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                </div>
            </div>


            {{-- FREIGHT SECTION --}}
            <div class="border-b pb-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Freight Information</h5>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Destination</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Select</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Carrier</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Select</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Truck Type</label>
                        <select class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                            <option>Select</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Freight Price</label>
                        <input type="number" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                </div>
            </div>


            {{-- INTERNAL DATES --}}
            <div class="mb-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4">Internal Dates</h5>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Pickup Transfer Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Sales Transfer Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Shipping Transfer Date</label>
                        <input type="date" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                </div>
            </div>


            {{-- ACTION BUTTONS --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('order.index') }}"
                    class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 text-sm">
                    Cancel
                </a>

                <button
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm shadow">
                    Save Order
                </button>

            </div>

        </form>
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
