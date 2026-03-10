@extends('layouts.master')


@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50">
        <div class="w-full max-w-7xl p-6 bg-white border border-gray-100 shadow-xl sm:p-8 rounded-2xl">

            {{-- HEADER --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">{{ __('layouts.order.list') }}</h4>
                    <p class="mt-1 text-sm text-gray-500">Manage and track all active order and deliveries.</p>
                </div>
                <a href="{{ route('order.create') }}"
                    class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-md sm:w-auto bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 hover:shadow-lg rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    {{ __('layouts.order.create') }}
                </a>
            </div>

            {{-- ADVANCED FILTER PANEL --}}
            <div class="p-4 mb-6 bg-gray-50 border border-gray-100 rounded-xl">
                <form action="#" method="GET">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">

                        {{-- Search Filter --}}
                        <div class="lg:col-span-2">
                            <label
                                class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" placeholder="Model number or name..."
                                    class="block w-full py-2.5 pl-9 pr-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>

                        {{-- Date Filter (Registered At) --}}
                        <div>
                            <label
                                class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Registered
                                Date</label>
                            <input type="date" name="registered_date"
                                class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        {{-- Remaining Days Filter --}}
                        <div>
                            <label
                                class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Remaining
                                Days</label>
                            <select name="remaining_days"
                                class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">All Timelines</option>
                                <option value="overdue">Overdue</option>
                                <option value="0_3">0 - 3 Days</option>
                                <option value="4_7">4 - 7 Days</option>
                                <option value="8_15">8 - 15 Days</option>
                                <option value="15_plus">15+ Days</option>
                            </select>
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <label
                                class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Delivery
                                Status</label>
                            <select name="status"
                                class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">All Statuses</option>
                                <option value="arranged">Arranged</option>
                                <option value="unarranged">Unarranged</option>
                                <option value="direct">Direct Delivery</option>
                                <option value="courier">Courier</option>
                            </select>
                        </div>
                    </div>

                    {{-- Filter Actions --}}
                    <div class="flex items-center justify-end mt-4 space-x-3">
                        <a href="{{ route('order.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors">
                            Clear Filters
                        </a>
                        <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg shadow-sm hover:bg-gray-900 transition-colors cursor-pointer">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            {{-- DATA TABLE --}}
            <div class="overflow-hidden border border-gray-200 rounded-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/80">
                            <tr class="text-xs font-bold tracking-wider text-left text-gray-500 uppercase">
                                <th scope="col" class="px-6 py-4">Model Details</th>
                                <th scope="col" class="px-6 py-4">Timeline</th>
                                <th scope="col" class="px-6 py-4">Delivery Info</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="text-sm bg-white divide-y divide-gray-100">

                            {{-- Row 1: High Priority, Arranged --}}
                            <tr class="transition-colors hover:bg-blue-50/50">

                                {{-- MODEL DETAILS (With Registered Date) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">MDL-10293</div>
                                    <div class="text-xs text-gray-600 mt-0.5 mb-1.5 font-medium">Pump Model X-200
                                    </div>
                                    <div class="text-[11px] text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Reg: Mar 01, 2026
                                    </div>
                                </td>

                                {{-- TIMELINE (Remaining Days + Correction Period) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1.5 items-start">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-xs font-bold text-orange-700 bg-orange-100 rounded-md">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            3 Days Remaining
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <span class="font-medium text-gray-700">Correction:</span> Mar 12 - 15
                                        </span>
                                    </div>
                                </td>

                                {{-- DELIVERY INFO --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">FedEx Freight</div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        Est: Mar 22, 2026
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1.5 items-start">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-red-700 bg-red-100 rounded-md">
                                            High Priority
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">
                                            Arranged
                                        </span>
                                    </div>
                                </td>

                                {{-- ACTIONS (Always Visible) --}}
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('order.view', 1) }}" title="View"
                                            class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" title="Edit"
                                            class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="#" title="Delete"
                                            class="p-2 text-red-500 transition-colors bg-red-50 border border-red-100 rounded-lg hover:text-red-700 hover:bg-red-100 hover:border-red-200">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 2: Normal Priority, Unarranged --}}
                            <tr class="transition-colors hover:bg-blue-50/50">

                                {{-- MODEL DETAILS (With Registered Date) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">MDL-10294</div>
                                    <div class="text-xs text-gray-600 mt-0.5 mb-1.5 font-medium">Motor Assembly
                                        Unit</div>
                                    <div class="text-[11px] text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Reg: Mar 05, 2026
                                    </div>
                                </td>

                                {{-- TIMELINE (Remaining Days + Correction Period) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1.5 items-start">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-xs font-bold text-gray-700 bg-gray-100 rounded-md">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            10 Days Remaining
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <span class="font-medium text-gray-700">Correction:</span> Mar 18 - 20
                                        </span>
                                    </div>
                                </td>

                                {{-- DELIVERY INFO --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Pending Carrier</div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        Est: Mar 30, 2026
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1.5 items-start">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-gray-600 bg-gray-100 rounded-md">
                                            Normal
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                            Unarranged
                                        </span>
                                    </div>
                                </td>

                                {{-- ACTIONS (Always Visible) --}}
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('order.view', 2) }}" title="View"
                                            class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" title="Edit"
                                            class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="#" title="Delete"
                                            class="p-2 text-red-500 transition-colors bg-red-50 border border-red-100 rounded-lg hover:text-red-700 hover:bg-red-100 hover:border-red-200">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium text-gray-900">1</span> to <span
                            class="font-medium text-gray-900">2</span> of <span
                            class="font-medium text-gray-900">12</span> results
                    </div>
                    <div class="flex gap-2">
                        <button
                            class="px-3 py-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 cursor-not-allowed opacity-50">Previous</button>
                        <button
                            class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</button>
                    </div>
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