@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50/50">
        <div class="w-full max-w-7xl p-5 bg-white border border-gray-200 shadow-sm sm:p-8 rounded-2xl">

            {{-- HEADER --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ __('layouts.order.trashed_list') ?? 'Trashed Orders' }}</h4>
                    <p class="mt-1.5 text-sm text-gray-500 font-medium">
                        {{ __('layouts.order.manage_deleted_orders') ?? 'Restore or permanently delete removed orders.' }}
                    </p>
                </div>
                <a href="{{ route('order.index') }}"
                    class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-semibold text-gray-700 transition-all duration-200 shadow-sm sm:w-auto bg-white border border-gray-300 hover:bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('layouts.back_to_orders') ?? 'Back to Orders' }}
                </a>
            </div>

            {{-- SESSION MESSAGES --}}
            @if (session('success'))
                <div class="flex items-start p-4 mb-6 text-green-700 border-l-4 border-green-500 rounded-lg bg-green-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-start p-4 mb-6 text-red-700 border-l-4 border-red-500 rounded-lg bg-red-50">
                    <svg class="flex-shrink-0 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-9.293a1 1 0 011.414-1.414L10 8.586l1.707-1.707a1 1 0 011.414 1.414L11.414 10l1.707 1.707a1 1 0 01-1.414 1.414L10 11.414l-1.707 1.707a1 1 0 01-1.414-1.414L8.586 10l-1.707-1.707z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- SEARCH PANEL --}}
            <div class="p-5 mb-8 bg-gray-50/80 border border-gray-200 rounded-xl">
                <form id="filter-form">
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="block mb-2 text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('layouts.search') ?? 'Search' }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="filter-search"
                                    placeholder="{{ __('layouts.search_placeholder') ?? 'Search by Order Number or Name' }}"
                                    class="block w-80 py-2.5 pl-10 pr-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors placeholder-gray-400">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- DATA TABLE --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table id="trashed-table" class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="bg-gray-50/80 border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">{{ __('layouts.order_details') ?? 'Order Details' }}</th>
                                <th scope="col" class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">{{ __('layouts.deleted_at') ?? 'Deleted At' }}</th>
                                <th scope="col" class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">{{ __('layouts.delivery_info') ?? 'Delivery Info' }}</th>
                                <th scope="col" class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">{{ __('layouts.status') ?? 'Status' }}</th>
                                <th scope="col" class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap text-right w-[1%]">{{ __('layouts.actions') ?? 'Actions' }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Exact same Tailwind/DataTables formatting as the index page */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter { margin-bottom: 1.25rem; padding: 1rem 1.5rem 0 1.5rem; }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db; border-radius: 0.5rem; padding: 0.25rem 2rem 0.25rem 0.75rem;
            font-size: 0.875rem; background-color: #fff;
        }
        .dataTables_wrapper .dataTables_info { padding: 1.25rem 1.5rem; font-size: 0.875rem; color: #6b7280; font-weight: 500; }
        .dataTables_wrapper .dataTables_paginate { padding: 1rem 1.5rem; font-size: 0.875rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { 
            border-radius: 0.5rem; border: 1px solid #e5e7eb; background: white; margin: 0 0.25rem; 
            padding: 0.375rem 0.75rem; color: #4b5563 !important; font-weight: 500; transition: all 0.2s ease;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f9fafb !important; border-color: #d1d5db; color: #111827 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { 
            background: #f3f4f6 !important; color: #111827 !important; border-color: #d1d5db; font-weight: 600;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { opacity: 0.5; cursor: not-allowed; }
        
        table.dataTable tbody tr { border-bottom: 1px solid #e5e7eb !important; background-color: #ffffff; transition: background-color 0.2s; }
        table.dataTable tbody tr:hover { background-color: #f9fafb !important; }
        table.dataTable tbody tr:last-child { border-bottom: none !important; }
        table.dataTable thead th, table.dataTable thead td { border-bottom: none; }
        table.dataTable.no-footer { border-bottom: 1px solid #e5e7eb; }
        .dataTables_filter { display: none; }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            let table = $('#trashed-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[1, 'desc']], // Order by 'deleted_at' descending by default
                ajax: {
                    url: "{{ route('order.trashed') }}",
                    data: function(d) {
                        d.custom_search = $('#filter-search').val();
                    }
                },
                columns: [
                    { data: 'order_details', name: 'order_number' },
                    { data: 'deleted_at',    name: 'deleted_at' },
                    { data: 'delivery_info', name: 'carrier' },
                    { data: 'status',        name: 'shipping_status' },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false, 
                        className: 'text-right w-[1%] whitespace-nowrap' 
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).addClass('px-6 py-4 whitespace-nowrap align-middle text-sm');
                }
            });

            // Trigger table reload on keyup in the custom search bar
            $('#filter-search').on('keyup', function() {
                table.draw();
            });
            
            // Prevent standard form submission
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });
        });

    </script>
@endpush