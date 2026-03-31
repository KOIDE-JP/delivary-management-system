@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50">
        <div class="w-full max-w-7xl p-6 bg-white border border-gray-100 shadow-xl sm:p-8 rounded-2xl">

            {{-- HEADER --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">{{ __('layouts.order.list') ?? 'Orders' }}</h4>
                    <p class="mt-1 text-sm text-gray-500">Manage and track all active order and deliveries.</p>
                </div>
                <a href="{{ route('order.create') }}"
                    class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-md sm:w-auto bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 hover:shadow-lg rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('layouts.order.create') ?? 'Create Order' }}
                </a>
            </div>

            {{-- ADVANCED FILTER PANEL --}}
            <div class="p-4 mb-6 bg-gray-50 border border-gray-100 rounded-xl">
                <form id="filter-form">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">
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
                                <input type="text" name="search" id="filter-search"
                                    placeholder="Model number or name..."
                                    class="block w-full py-2.5 pl-9 pr-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label
                                class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Registered
                                Date</label>
                            <input type="date" name="registered_date" id="filter-date"
                                class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        <div>
                            <label
                                class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Remaining
                                Days</label>
                            <select name="remaining_days" id="filter-days"
                                class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">All Timelines</option>
                                <option value="overdue">Overdue</option>
                                <option value="0_3">0 - 3 Days</option>
                                <option value="4_7">4 - 7 Days</option>
                                <option value="8_15">8 - 15 Days</option>
                                <option value="15_plus">15+ Days</option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Delivery
                                Status</label>
                            <select name="status" id="filter-status"
                                class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">All Statuses</option>
                                <option value="arranged">Arranged</option>
                                <option value="unarranged">Unarranged</option>
                                <option value="direct_delivery">Direct Delivery</option>
                                <option value="courier">Courier</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4 space-x-3">
                        <button type="button" id="btn-clear-filters"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors cursor-pointer">
                            Clear Filters
                        </button>
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
                    {{-- Added ID 'orders-table', removed tbody --}}
                    <table id="orders-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/80">
                            <tr class="text-xs font-bold tracking-wider text-left text-gray-500 uppercase">
                                <th scope="col" class="px-6 py-4">Order Details</th>
                                <th scope="col" class="px-6 py-4">Timeline</th>
                                <th scope="col" class="px-6 py-4">Delivery Info</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- DataTables Core CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Tailwind fixes for DataTables default elements */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
            padding: 0 1.5rem;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            background: white;
            margin: 0 0.25rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #f3f4f6;
            color: #111827 !important;
            border-color: #d1d5db;
        }

        table.dataTable thead th {
            border-bottom: 1px solid #e5e7eb;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        /* Hide default search box since we have a custom one */
        .dataTables_filter {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            let table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('order.index') }}",
                    data: function(d) {
                        d.custom_search = $('#filter-search').val();
                        d.registered_date = $('#filter-date').val();
                        d.remaining_days = $('#filter-days').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [
                    // 'data' targets the addColumn name in Controller
                    // 'name' targets the actual DB column for searching/sorting
                    { data: 'order_details', name: 'order_number' },
                    { data: 'timeline',      name: 'due_date' },
                    { data: 'delivery_info', name: 'carrier' },
                    { data: 'status',        name: 'shipping_status' },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false, 
                        className: 'text-right' 
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('transition-colors hover:bg-blue-50/50 bg-white divide-y divide-gray-100 text-sm');
                    $('td', row).addClass('px-6 py-4 whitespace-nowrap');
                }
            });

            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });

            $('#btn-clear-filters').on('click', function() {
                $('#filter-form')[0].reset();
                table.draw();
            });
        });
    </script>
@endpush
