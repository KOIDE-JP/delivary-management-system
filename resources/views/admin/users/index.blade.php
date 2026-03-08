@extends('layouts.master')
@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white shadow rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg md:text-2xl font-bold text-gray-800">{{ __('layouts.user_list') }}</h4>
                <a href="{{ route('users.create') }}"
                    class="transition-all inline-flex items-center px-4 py-2 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-105 text-white font-medium text-sm rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 duration-200">
                    + {{ __('layouts.create_user') }}
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            <div class="overflow-x-auto px-4">
                <table id="usersTable" class="w-full text-sm border-collapse border border-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-center">#</th>
                            <th>{{ __('layouts.name') }}</th>
                            <th>{{ __('layouts.email') }}</th>
                            <th>{{ __('layouts.username') }}</th>
                            <th>{{ __('layouts.role') }}</th>
                            <th>{{ __('layouts.status') }}</th>
                            <th>{{ __('layouts.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                language: window.dataTableLanguage || {},
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    // {data: 'created_at', name: 'created_at'},
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'desc']
                ],
            });
        });
    </script>
@endpush
