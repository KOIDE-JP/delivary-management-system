@extends('layouts.master')
@section('content')



<style>
    /* Custom button styling */
    .swal2-cancel {
        background-color: blue; /* Red background for Cancel button */
        color: white; /* Text color for Cancel button */
    }

    .swal2-confirm {
        background-color: red; /* Blue background for Confirm button */
        color: white; /* Text color for Confirm button */
    }

    /* Optional: You can customize the hover effects */
    .swal2-cancel:hover {
        background-color: #c9302c; /* Darker red for hover effect */
    }

    .swal2-confirm:hover {
        background-color: #1d6d96; /* Darker blue for hover effect */
    }



#userTable{
    padding-top: 1rem !important;
}
.dataTables_wrapper .dataTables_paginate{
    padding-top: 1rem !important;
}
.dataTables_wrapper .dataTables_info{
    padding-top: 1rem !important;
}
</style>
<div class="min-h-[60vh] flex items-center">
    <div class=" w-[75%] mx-auto p-6 border-black/12.5 shadow-soft-xl relative z-20 min-w-0 flex-col  break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
        <div class="container mx-auto min-w-lg p-6">
            <h2 class="text-xl font-bold mb-4">
                {{-- User List --}}
                {{ __('layouts.file_lists') }}
            </h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table id="userTable" class="min-w-full bg-white shadow-md rounded my-4">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">{{ __('layouts.uploader') }}</th>
                        <th class="px-4 py-2">{{ __('layouts.file_name') }}</th>
                        <th class="px-4 py-2">{{ __('layouts.file_url') }}</th>
                        <th class="px-4 py-2">{{ __('layouts.folder_path') }}</th>
                        <th class="px-4 py-2">{{ __('layouts.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($files as $index => $file)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $file->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $file->file_name }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ $file->file_url }}" target="_blank" class="text-blue-600 underline">View</a>
                            </td>
                            <td class="px-4 py-2">{{ $file->folder_path }}</td>
                            <td class="px-4 py-2">
                                {{-- <a href="{{ route('files.edit', $file) }}" class="text-blue-500">{{ __('layouts.edit') }}</a> | --}}
                                <form action="{{ route('files.destroy', $file) }}" method="POST" class="inline" id="deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-500" onclick="confirmDelete()">
                                        {{ __('layouts.delete') }}
                                    </button>
                                </form>
{{-- 
                                <form action="{{ route('files.destroy', $file) }}" method="POST" class="inline" onsubmit="return confirm('Delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">{{ __('layouts.delete') }}</button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No files found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "language": {
                    "sProcessing": "{{ __('layouts.sProcessing') }}",
                    "sLengthMenu": "{{ __('layouts.sLengthMenu') }}",
                    "sZeroRecords": "{{ __('layouts.sZeroRecords') }}",
                    "sInfo": "{{ __('layouts.sInfo') }}",
                    "sInfoEmpty": "{{ __('layouts.sInfoEmpty') }}",
                    "sInfoFiltered": "{{ __('layouts.sInfoFiltered') }}",
                    "sSearch": "{{ __('layouts.sSearch') }}",

                    // "sFirst": "{{ __('layouts.sFirst') }}",
                    // "sPrevious": "{{ __('layouts.sPrevious') }}",
                    // "sNext": "{{ __('layouts.sNext') }}",
                    // "sLast": "{{ __('layouts.sLast') }}"

                    "oPaginate": {
                        "sFirst": "{{ __('layouts.sFirst') }}",
                        "sPrevious": "{{ __('layouts.sPrevious') }}",
                        "sNext": "{{ __('layouts.sNext') }}",
                        "sLast": "{{ __('layouts.sLast') }}"
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#userTable').DataTable();
        });
    </script>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: "{{ __('layouts.delete_confirm') }}",//'Are you sure?',
                text: "{{ __('layouts.not_revert') }}",//"You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',  // Blue color for 'Yes'
                cancelButtonColor: '#d33',      // Red color for 'Cancel'
                confirmButtonText: "{{ __('layouts.delete_confirm') }}", //'Yes, delete it!',
                cancelButtonText: "{{ __('layouts.cancel_btn') }}", //'Cancel',      // Custom text for the Cancel button
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if user clicks 'Yes'
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>


@endpush
@endsection