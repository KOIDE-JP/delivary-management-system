@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">
                {{ __('layouts.deleted_users') }}
            </h2>
            <div class="overflow-x-auto">
                <table id="allDataTable" class="min-w-full bg-white shadow-md rounded my-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm leading-4 tracking-wider font-medium text-gray-500 uppercase">{{ __('layouts.name') }}</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm leading-4 tracking-wider font-medium text-gray-500 uppercase">{{ __('layouts.email') }}</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm leading-4 tracking-wider font-medium text-gray-500 uppercase">{{ __('layouts.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($softDeletedUsers as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300 text-sm leading-5 text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300 text-sm leading-5 text-gray-900">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300 text-sm leading-5 text-gray-900">
                                    {{-- <form action="{{ route('users.restoreUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                            {{ __('layouts.restore') }}
                                        </button>
                                    </form> --}}
                                    <form action="{{ route('users.restoreUser', $user->id) }}" method="POST" class="inline" id="restoreForm-{{ $user->id }}">
                                        @csrf
                                        <button type="button"
                                            onclick="confirmRestore({{ $user->id }})"
                                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                            {{ __('layouts.restore') }}
                                        </button>
                                    </form>

                                    {{-- <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                            Force Delete
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    function confirmRestore(id) {
        Swal.fire({
            title: "{{ __('layouts.confirm_restore_title') }}",
            text: "{{ __('layouts.confirm_restore_text') }}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{ __('layouts.confirm_restore_yes') }}",
            cancelButtonText: "{{ __('layouts.confirm_restore_cancel') }}",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('restoreForm-' + id).submit();
            }
        });
    }
</script>

@endpush

