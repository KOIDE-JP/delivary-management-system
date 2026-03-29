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
                            <label class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="filter-search" placeholder="Model number or name..." class="block w-full py-2.5 pl-9 pr-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Registered Date</label>
                            <input type="date" name="registered_date" id="filter-date" class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Remaining Days</label>
                            <select name="remaining_days" id="filter-days" class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">All Timelines</option>
                                <option value="overdue">Overdue</option>
                                <option value="0_3">0 - 3 Days</option>
                                <option value="4_7">4 - 7 Days</option>
                                <option value="8_15">8 - 15 Days</option>
                                <option value="15_plus">15+ Days</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-gray-600 uppercase tracking-wider">Delivery Status</label>
                            <select name="status" id="filter-status" class="block w-full py-2.5 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">All Statuses</option>
                                <option value="arranged">Arranged</option>
                                <option value="unarranged">Unarranged</option>
                                <option value="direct_delivery">Direct Delivery</option>
                                <option value="courier">Courier</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4 space-x-3">
                        <button type="button" id="btn-clear-filters" class="px-4 py-2 text-sm font-medium text-gray-600 bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors cursor-pointer">
                            Clear Filters
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg shadow-sm hover:bg-gray-900 transition-colors cursor-pointer">
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
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { margin-bottom: 1rem; padding: 0 1.5rem; }
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { padding: 1rem 1.5rem; font-size: 0.875rem; color: #6b7280; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { border-radius: 0.375rem; border: 1px solid #e5e7eb; background: white; margin: 0 0.25rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #f3f4f6; color: #111827 !important; border-color: #d1d5db; }
        table.dataTable thead th { border-bottom: 1px solid #e5e7eb; }
        table.dataTable.no-footer { border-bottom: none; }
        /* Hide default search box since we have a custom one */
        .dataTables_filter { display: none; } 
    </style>
@endpush

@push('scripts')
    {{-- DataTables Core JS --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('order.index') }}",
                    data: function(d) {
                        // Pass custom filter values to the controller
                        d.custom_search = $('#filter-search').val();
                        d.registered_date = $('#filter-date').val();
                        d.remaining_days = $('#filter-days').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [
                    {
                        data: 'order_number',
                        name: 'order_number',
                        render: function(data, type, row) {
                            return `
                                <div class="font-bold text-gray-900">${row.order_number}</div>
                                <div class="text-xs text-gray-600 mt-0.5 mb-1.5 font-medium">${row.order_name}</div>
                                <div class="text-[11px] text-gray-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Reg: ${row.registered_date ? row.registered_date : 'N/A'}
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'due_date',
                        name: 'due_date',
                        render: function(data, type, row) {
                            // You can add logic here to calculate actual remaining days based on due_date
                            let daysTxt = data ? data : 'Pending'; 
                            return `
                                <div class="flex flex-col gap-1.5 items-start">
                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold text-orange-700 bg-orange-100 rounded-md">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Due: ${daysTxt}
                                    </span>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'carrier',
                        name: 'carrier',
                        render: function(data, type, row) {
                            return `
                                <div class="text-sm font-medium text-gray-900">${row.carrier ? row.carrier : 'Pending Carrier'}</div>
                                <div class="mt-1 text-xs text-gray-500">Est: ${row.shipping_date ? row.shipping_date : 'TBD'}</div>
                            `;
                        }
                    },
                    {
                        data: 'shipping_status',
                        name: 'shipping_status',
                        render: function(data, type, row) {
                            let priorityHtml = row.priority === 'yes' 
                                ? `<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-red-700 bg-red-100 rounded-md mb-1">High Priority</span>`
                                : `<span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold text-gray-600 bg-gray-100 rounded-md mb-1">Normal</span>`;
                            
                            let statusText = row.shipping_status ? row.shipping_status.toUpperCase() : 'PENDING';
                            let statusColor = row.shipping_status === 'arranged' ? 'text-blue-700 bg-blue-100' : 'text-yellow-800 bg-yellow-100';

                            return `
                                <div class="flex flex-col items-start">
                                    ${priorityHtml}
                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium ${statusColor} rounded-full">
                                        ${statusText}
                                    </span>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-right',
                        render: function(data, type, row) {
                            // Generating dynamic route URLs
                            let viewUrl = `/order/${data}`;
                            let editUrl = `/order/${data}/edit`;
                            
                            return `
                                <div class="flex items-center justify-end gap-2">
                                    <a href="${viewUrl}" title="View" class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="${editUrl}" title="Edit" class="p-2 text-gray-600 transition-colors bg-gray-100 border border-gray-200 rounded-lg hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="#" title="Delete" class="p-2 text-red-500 transition-colors bg-red-50 border border-red-100 rounded-lg hover:text-red-700 hover:bg-red-100 hover:border-red-200">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            `;
                        }
                    }
                ],
                // Tailwind classes for the table rows
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('transition-colors hover:bg-blue-50/50 bg-white divide-y divide-gray-100 text-sm');
                    $('td', row).addClass('px-6 py-4 whitespace-nowrap');
                }
            });

            // Handle Custom Filter Submission
            $('#filter-form').on('submit', function(e) {
                e.preventDefault(); // Stop normal page reload
                table.draw();       // Trigger DataTables AJAX request
            });

            // Handle Clear Filters
            $('#btn-clear-filters').on('click', function() {
                $('#filter-form')[0].reset(); // Reset form inputs
                table.draw();                 // Trigger DataTables to reload with empty filters
            });
        });
    </script>
@endpush