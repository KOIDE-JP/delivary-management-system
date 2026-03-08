@extends('layouts.master')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">{{ __('layouts.dashboard') }}</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white shadow rounded-xl p-4 flex items-center">
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg mr-4">
                <i class="fa-solid fa-bug text-white"></i>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-gray-500 font-medium">{{ __('layouts.total_users') }}</span>
                <p class="text-2xl font-bold">{{ $user_count }}</p>
            </div>
        </div>

    </div>

    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-xl p-6">
            
        </div>
    </div> --}}

</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

    </script>
@endpush

