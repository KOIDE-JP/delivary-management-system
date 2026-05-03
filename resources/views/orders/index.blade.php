@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50/50">
        <div class="w-full max-w-7xl p-5 bg-white border border-gray-200 shadow-sm sm:p-8 rounded-2xl">

            {{-- HEADER --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                        {{ __('layouts.order.list') ?? 'Orders' }}</h4>
                    <p class="mt-1.5 text-sm text-gray-500 font-medium">
                        {{ __('layouts.manage_and_track_all_active_order_and_deliveries') }}
                    </p>
                </div>
                <div class="">
                    @if (auth()->user()->hasPermission('order.create'))
                        <a href="{{ route('order.create') }}"
                            class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm sm:w-auto bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 hover:shadow rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            {{ __('layouts.order.create') ?? 'Create Order' }}
                        </a>
                    @endif
                    @if (auth()->user()->hasPermission('order.import'))
                        <a href="{{ route('order.import') }}"
                            class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 shadow-sm sm:w-auto bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 hover:shadow rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3-3m0 0l3 3m-3-3v7">
                                </path>
                            </svg>
                            {{ __('layouts.order.import') ?? 'Import Orders' }}
                        </a>
                    @endif
                </div>
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

            {{-- ADVANCED FILTER PANEL --}}
            <div class="p-5 mb-8 bg-gray-50/80 border border-gray-200 rounded-xl">
                <form id="filter-form">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-5">
                        <div class="lg:col-span-2">
                            <label
                                class="block mb-2 text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('layouts.search') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="filter-search"
                                    placeholder="{{ __('layouts.search_placeholder') }}"
                                    class="block w-full py-2.5 pl-10 pr-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors placeholder-gray-400">
                            </div>
                        </div>

                        <div>
                            <label
                                class="block mb-2 text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('layouts.registered_date') }}</label>
                            <input type="date" name="registered_date" id="filter-date"
                                class="block w-full py-2.5 px-3.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        </div>

                        <div>
                            <label
                                class="block mb-2 text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('layouts.remaining_days') }}</label>
                            <select name="remaining_days" id="filter-days"
                                class="block w-full py-2.5 px-3.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                                <option value="">{{ __('layouts.all_timelines') }}</option>
                                <option value="overdue">{{ __('layouts.overdue') }}</option>
                                <option value="0_3">{{ __('layouts.0_3_days') }}</option>
                                <option value="4_7">{{ __('layouts.4_7_days') }}</option>
                                <option value="8_15">{{ __('layouts.8_15_days') }}</option>
                                <option value="15_plus">{{ __('layouts.15_plus_days') }}</option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block mb-2 text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ __('layouts.delivery_status') }}</label>
                            <select name="status" id="filter-status"
                                class="block w-full py-2.5 px-3.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                                <option value="">{{ __('layouts.all_statuses') }}</option>
                                <option value="arranged">{{ __('layouts.arranged') }}</option>
                                <option value="unarranged">{{ __('layouts.unarranged') }}</option>
                                <option value="direct_delivery">{{ __('layouts.direct_delivery') }}</option>
                                <option value="courier">{{ __('layouts.courier') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-5 space-x-3">
                        <button type="button" id="btn-clear-filters"
                            class="px-4 py-2.5 text-sm font-semibold text-gray-600 bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200/50 transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200">
                            {{ __('layouts.clear_filters') }}
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-lg shadow-sm hover:bg-black transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                            {{ __('layouts.apply_filters') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- DATA TABLE --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table id="orders-table" class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="bg-gray-50/80 border-b border-gray-200">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">
                                    {{ __('layouts.remaining_days') ?? 'Remaining Days' }}</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">
                                    {{ __('layouts.order_details') }}</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">
                                    {{ __('layouts.delivery_info') }}</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap">
                                    {{ __('layouts.status') }}</th>
                                {{-- Added w-[1%] to shrink Action column --}}
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase whitespace-nowrap text-right w-[1%]">
                                    {{ __('layouts.actions') }}</th>
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
        /* Modernized Tailwind integration for DataTables */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1.25rem;
            padding: 1rem 1.5rem 0 1.5rem;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.25rem 2rem 0.25rem 0.75rem;
            font-size: 0.875rem;
            background-color: #fff;
        }

        .dataTables_wrapper .dataTables_info {
            padding: 1.25rem 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            background: white;
            margin: 0 0.25rem;
            padding: 0.375rem 0.75rem;
            color: #4b5563 !important;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f9fafb !important;
            border-color: #d1d5db;
            color: #111827 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #f3f4f6 !important;
            color: #111827 !important;
            border-color: #d1d5db;
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* FIX: Explicitly set Row Borders */
        table.dataTable tbody tr {
            border-bottom: 1px solid #e5e7eb !important;
        }

        table.dataTable tbody tr:last-child {
            border-bottom: none !important;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            border-bottom: none;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid #e5e7eb;
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
        function confirmOrderDelete(button) {
            Swal.fire({
                title: "{{ __('layouts.move_to_trash') ?? 'Move to Trash?' }}",
                text: "{{ __('layouts.order_can_be_recovered') ?? 'You can recover this order from trash later.' }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: "{{ __('layouts.move_to_trash') ?? 'Move to Trash' }}",
                cancelButtonText: "{{ __('layouts.cancel_btn') ?? 'Cancel' }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'px-5 py-2.5 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors mr-3 cursor-pointer',
                    cancelButton: 'px-5 py-2.5 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition-colors cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $(button).closest('form').submit();
                }
            });
        }

        $(document).ready(function() {
            let table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: "{{ route('order.index') }}",
                    data: function(d) {
                        d.custom_search = $('#filter-search').val();
                        d.registered_date = $('#filter-date').val();
                        d.remaining_days = $('#filter-days').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [{
                        data: 'remaining_days',
                        name: 'due_date'
                    },
                    {
                        data: 'order_details',
                        name: 'order_number'
                    },
                    {
                        data: 'delivery_info',
                        name: 'carrier'
                    },
                    {
                        data: 'status',
                        name: 'shipping_status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-right w-[1%] whitespace-nowrap'
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).addClass('px-6 py-4 whitespace-nowrap align-middle');
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

            // Event delegation for delete buttons
            $(document).on('click', '.btn-delete-order', function(e) {
                e.preventDefault();
                confirmOrderDelete(this);
            });
        });
    </script>
@endpush
