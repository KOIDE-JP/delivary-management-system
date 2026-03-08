@extends('layouts.master')
@section('content')

    <div class="container mx-auto max-w-7xl p-6">
        <div class="bg-white rounded-xl shadow-xl p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-2xl font-bold text-gray-800">{{ __('layouts.role_list') }}</h4>
                {{-- @permission('role.create') --}}
                    {{-- <a href="{{ route('role.create') }}"
                        class="transition-all inline-flex items-center px-4 py-2 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-105 text-white font-medium text-sm rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 duration-200">
                        + {{ __('layouts.create_role') }}
                    </a> --}}
                {{-- @endpermission --}}
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <table id="rolesTable" class="w-full text-sm text-center border rounded-lg overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr class="">
                        <th class="px-4 py-2 text-center">#</th>
                        <th class="px-4 py-2 text-center">{{ __('layouts.name') }}</th>
                        {{-- <th class="border px-4 py-2">{{ __('layouts.permissions') }}</th> --}}
                            <th class="px-4 py-2 text-center">{{ __('layouts.action') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
        </div>
    </div> 
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#rolesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('role.list') }}",
                language: window.dataTableLanguage || {},
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
               
                ],
                order: [[1, 'desc']],
            });
        });
    </script>
@endpush