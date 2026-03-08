<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset(' img/favicon.png') }}" />
    <title>{{ __('layouts.siteTitle') }}</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('assets/css/perfect-scrollbar.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/css/tooltips.css') }}" rel="stylesheet" />
    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Main Styling -->

    <link href="{{ asset('assets/css/choices.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



    <script src="{{ asset('assets/js/choices.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <style>
        /* Custom button styling */
        /*
        .swal2-confirm {
            background-color: red;
            color: white;
        }

        .swal2-confirm:hover {
            background-color: #1d6d96;
        }

        .swal2-cancel {
            background-color: blue;
            color: white;
        }

        .swal2-cancel:hover {
            background-color: #c9302c;
        }
         */

        /* DataTables Wrapper Styling */
        .dataTables_wrapper {
            font-family: inherit;
        }

        /* Length and Filter Controls */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 2rem 0.5rem 0.75rem;
            font-size: 0.875rem;
            background-color: white;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            appearance: none;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_length select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            background-color: white;
            transition: all 0.15s ease;
            width: 250px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Table Styling */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        thead th {
            background: linear-gradient(to right, #f9fafb, #f3f4f6);
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
            position: relative;
        }

        thead th.sorting,
        thead th.sorting_asc,
        thead th.sorting_desc {
            cursor: pointer;
            padding-right: 30px;
        }

        thead th.sorting:after,
        thead th.sorting_asc:after,
        thead th.sorting_desc:after {
            /* position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.3;
        font-size: 0.8em; */
        }

        /*  thead th.sorting:after {
        content: "⇅";
        }

        thead th.sorting_asc:after {
            content: "↑";
            opacity: 1;
            color: #3b82f6;
        }

        thead th.sorting_desc:after {
            content: "↓";
            opacity: 1;
            color: #3b82f6;
        } */

        tbody tr {
            transition: background-color 0.15s ease;
            border-bottom: 1px solid #f3f4f6;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody tr.odd {
            background-color: white;
        }

        tbody tr.even {
            background-color: #fafafa;
        }

        tbody td {
            padding: 1rem;
            color: #1f2937;
            vertical-align: middle;
        }

        /* Pagination Styling */
        .dataTables_wrapper .dataTables_info {
            font-size: 0.875rem;
            color: #6b7280;
            padding: 1rem 0;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem 0;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-block;
            padding: 0.5rem 0.875rem;
            margin: 0 0.125rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: white;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            color: #111827;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white !important;
            cursor: default;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f9fafb;
            color: #9ca3af;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background-color: #f9fafb;
            border-color: #e5e7eb;
        }

        /* Processing Indicator */
        .dataTables_wrapper .dataTables_processing {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            font-size: 0.875rem;
            color: #374151;
            font-weight: 500;
            z-index: 1000;
        }

        .ant-input {
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        .ant-input:hover {
            border-color: #4096ff;
        }

        .ant-input:focus {
            border-color: #4096ff;
            box-shadow: 0 0 0 2px rgba(5, 145, 255, 0.1);
            outline: 0;
        }

        .form-card {
            background: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03), 0 1px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px 0 rgba(0, 0, 0, 0.02);
        }

        .ant-select:hover {
            border-color: #4096ff;
        }

        .ant-btn-primary {
            background: #1677ff;
            transition: all 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        .ant-btn-primary:hover {
            background: #4096ff;
        }
    </style>
    <link href="{{ asset('assets/css/site.css') }}" rel="stylesheet" />
    @stack('styles')
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <!-- sidenav  -->
    @include('layouts.sidebar')
    <!-- end sidenav -->
    <style>
        /* .border-main-nav{
            border-bottom: 1px solid #ddd;
            border-radius: 0px;
        } */
    </style>
    <main class="border-main-nav ease-soft-in-out xl:ml-68.5 ">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- end Navbar -->

        <div class="mb-16">
            @yield('content')
        </div>

        <!-- footer  -->
        @include('layouts.footer')
        <!-- footer end  -->
    </main>

    <!-- Global AJAX Loader -->
    <div id="ajaxLoader" class="fixed inset-0 bg-black/40 flex items-center justify-center z-[9999] hidden">
        <div class="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
    </div>

</body>

<!-- plugin for charts  -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<!-- plugin for scrollbar  -->
{{-- <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script> --}}
<!-- github button -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- main script file  -->
<script src="{{ asset('assets/js/dropdown.js') }}"></script>
<script src="{{ asset('assets/js/navbar-sticky.js') }}"></script>
<script src="{{ asset('assets/js/nav-pills.js') }}"></script>
<script src="{{ asset('assets/js/navbar-collapse.js') }}"></script>
<script src="{{ asset('assets/js/sidenav-burger.js') }}"></script>

<script src="{{ asset('assets/js/sidenav.js') }}"></script>

<script src="{{ asset('assets/js/modal.js') }}"></script>
<script src="{{ asset('assets/js/alert.js') }}"></script>
<script src="{{ asset('assets/js/accordion.js') }}"></script>

<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/assets/assets/scripts/choices.min.js"></script> --}}

{{-- <script src="{{ asset(' js/soft-ui-dashboard-tailwind.js?v=1.0.5')}}"></script> --}}
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/js/soft-ui-dashboard-pro-tailwind.min.js') }}"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        const file = event.target.files[0];
        if (!file) {
            preview.innerHTML = '<span class="text-gray-400 select-none">No image selected</span>';
            return;
        }

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = 'Selected image preview';
        img.className = 'object-contain w-full h-full';

        preview.appendChild(img);
    }

    window.dataTableLanguage = {
        sProcessing: "{{ __('layouts.sProcessing') }}",
        sLengthMenu: "{{ __('layouts.sLengthMenu') }}",
        sZeroRecords: "{{ __('layouts.sZeroRecords') }}",
        sInfo: "{{ __('layouts.sInfo') }}",
        sInfoEmpty: "{{ __('layouts.sInfoEmpty') }}",
        sInfoFiltered: "{{ __('layouts.sInfoFiltered') }}",
        sSearch: "{{ __('layouts.sSearch') }}",
        oPaginate: {
            sFirst: "{{ __('layouts.sFirst') }}",
            sPrevious: "{{ __('layouts.sPrevious') }}",
            sNext: "{{ __('layouts.sNext') }}",
            sLast: "{{ __('layouts.sLast') }}"
        }
    };

    $(document).ready(function() {
        $('#allDataTable').DataTable({
            "language": {
                "sProcessing": "{{ __('layouts.sProcessing') }}",
                "sLengthMenu": "{{ __('layouts.sLengthMenu') }}",
                "sZeroRecords": "{{ __('layouts.sZeroRecords') }}",
                "sInfo": "{{ __('layouts.sInfo') }}",
                "sInfoEmpty": "{{ __('layouts.sInfoEmpty') }}",
                "sInfoFiltered": "{{ __('layouts.sInfoFiltered') }}",
                "sSearch": "{{ __('layouts.sSearch') }}",

                "oPaginate": {
                    "sFirst": "{{ __('layouts.sFirst') }}",
                    "sPrevious": "{{ __('layouts.sPrevious') }}",
                    "sNext": "{{ __('layouts.sNext') }}",
                    "sLast": "{{ __('layouts.sLast') }}"
                }
            }
        });
    });

    // function confirmDelete() {
    //     Swal.fire({
    //         title: "{{ __('layouts.delete_confirm') }}",
    //         text: "{{ __('layouts.not_revert') }}",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: "{{ __('layouts.delete_confirm') }}",
    //         cancelButtonText: "{{ __('layouts.cancel_btn') }}",
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             console.log("Delete confirmed");

    //             document.getElementById('deleteForm')
    //                 .submit(); // Need to use this id for the delete so that it can be used in multiple places

    //         }
    //     });
    // }
    function confirmDelete(button) {
        Swal.fire({
            title: "{{ __('layouts.delete_confirm') }}",
            text: "{{ __('layouts.not_revert') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('layouts.delete_confirm') }}",
            cancelButtonText: "{{ __('layouts.cancel_btn') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }


    function prepareDelete(el) {
        const url = el.getAttribute('href');
        const form = document.getElementById('deleteForm');

        if (form) {
            form.setAttribute('action', url);
            confirmDelete();
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Show loader before any AJAX call starts
        $(document).ajaxStart(function() {
            $('#ajaxLoader').removeClass('hidden').addClass('flex');
        });

        // Hide loader when all AJAX calls complete
        $(document).ajaxStop(function() {
            $('#ajaxLoader').removeClass('flex').addClass('hidden');
        });

        $('.search_select').select2();

        const maxLength = 120;

        // Process each expandable text element
        $('.expandable-text').each(function() {
            const $container = $(this);
            const $textContent = $container.find('.text-content');
            const $toggleBtn = $container.find('.toggle-text');
            const fullText = $textContent.text().trim();

            // Only add toggle functionality if text exceeds max length
            if (fullText.length > maxLength) {
                const truncatedText = fullText.substring(0, maxLength) + '...';

                // Set initial truncated text
                $textContent.text(truncatedText);
                $textContent.data('full-text', fullText);
                $textContent.data('truncated-text', truncatedText);
                $textContent.data('expanded', false);

                // Show the toggle button
                $toggleBtn.removeClass('hidden');

                // Add click handler
                $toggleBtn.on('click', function(e) {
                    e.preventDefault();
                    const isExpanded = $textContent.data('expanded');

                    if (isExpanded) {
                        // Collapse
                        $textContent.text($textContent.data('truncated-text'));
                        $toggleBtn.text('{{ __('layouts.see_more') }}');
                        $textContent.data('expanded', false);
                    } else {
                        // Expand
                        $textContent.text($textContent.data('full-text'));
                        $toggleBtn.text('{{ __('layouts.see_less') }}');
                        $textContent.data('expanded', true);
                    }
                });
            }
        });
    });
</script>

@stack('scripts')

</html>
