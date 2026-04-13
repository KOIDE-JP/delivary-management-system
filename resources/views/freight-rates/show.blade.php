@extends('layouts.master')
@section('content')
<div class="min-h-screen py-8 sm:py-12 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ __('layouts.freight_rate_details') }}</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('freight-rates.edit', $freightRate->id) }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg text-white
                    bg-gradient-to-tl from-blue-600 to-cyan-400 shadow-md hover:shadow-lg
                    hover:scale-102 transition-all duration-200 active:opacity-80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('layouts.edit') }}
                </a>
                <a href="{{ route('freight-rates.index') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg text-gray-600
                    bg-white border-2 border-gray-200 hover:border-gray-300 shadow-sm
                    hover:shadow-md transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('layouts.back') }}
                </a>
            </div>
        </div>

        {{-- Details Card --}}
        <div class="gradient-border rounded-2xl p-6 sm:p-8 bg-white shadow-lg border border-gray-200">
            <h2 class="text-base font-semibold text-gray-700 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ __('layouts.freight_rate_information') }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">{{ __('layouts.destination') }}</p>
                    <p class="text-gray-800 font-semibold">{{ $freightRate->destination->name ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">{{ __('layouts.carrier') }}</p>
                    <p class="text-gray-800 font-semibold">{{ $freightRate->carrier->name ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">{{ __('layouts.truck_type') }}</p>
                    <p class="text-gray-800 font-semibold">{{ $freightRate->truckType->name ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">{{ __('layouts.price') }} ({{ __('layouts.tax_excluded') }})</p>
                    <p class="text-gray-800 font-semibold">¥{{ number_format($freightRate->price, 2) }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">{{ __('layouts.status') }}</p>
                    @if($freightRate->status)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>{{ __('layouts.active') }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>{{ __('layouts.inactive') }}
                        </span>
                    @endif
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">{{ __('layouts.created_at') }}</p>
                    <p class="text-gray-800 font-semibold">{{ $freightRate->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Activity Log Timeline --}}
        <div class="gradient-border rounded-2xl p-6 sm:p-8 bg-white shadow-lg border border-gray-200">
            <h2 class="text-base font-semibold text-gray-700 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('layouts.activity_log') }}
                <span class="ml-auto text-xs font-medium text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                    {{ $activityLogs->count() }} {{ __('layouts.records') }}
                </span>
            </h2>

            @if($activityLogs->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                    <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-sm">{{ __('layouts.no_activity_logs') }}</p>
                </div>
            @else

                {{--
                    DB stores already-translated values because controller passes __() to logActivity().
                    So we compare $log->action against the current language's translated strings.
                --}}
                @php
                    $actionCreated       = 'action_created';
                    $actionUpdated       = 'action_updated';
                    $actionDeleted       = 'action_deleted';
                    $actionStatusUpdated = 'action_status_updated';
                    $statusSuccess       = 'status_success';
                    $statusFailed        = 'status_failed';
                    $statusWarning       = 'status_warning';
                @endphp

                <div class="relative">
                    {{-- Vertical line --}}
                    <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-100"></div>

                    <div class="space-y-4">
                        @foreach($activityLogs as $log)
                            <div class="relative flex gap-4 pl-2">

                                {{-- Icon Circle --}}
                                <div class="relative z-10 flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center shadow-sm border-2
                                    @if($log->action === $actionCreated)           bg-green-50   border-green-200
                                    @elseif($log->action === $actionUpdated)       bg-blue-50    border-blue-200
                                    @elseif($log->action === $actionDeleted)       bg-red-50     border-red-200
                                    @elseif($log->action === $actionStatusUpdated) bg-emerald-50 border-emerald-200
                                    @else                                          bg-gray-50    border-gray-200
                                    @endif">

                                    @if($log->action === $actionCreated)
                                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    @elseif($log->action === $actionUpdated)
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    @elseif($log->action === $actionDeleted)
                                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    @elseif($log->action === $actionStatusUpdated)
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-100 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-2 mb-1">

                                        {{-- Action Badge --}}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                            @if($log->action === $actionCreated)           bg-green-100   text-green-700
                                            @elseif($log->action === $actionUpdated)       bg-blue-100    text-blue-700
                                            @elseif($log->action === $actionDeleted)       bg-red-100     text-red-600
                                            @elseif($log->action === $actionStatusUpdated) bg-emerald-100 text-emerald-700
                                            @else                                          bg-gray-100    text-gray-600
                                            @endif">
                                            {{ __('layouts.' . $log->action) }}
                                        </span>

                                        {{-- Log Status Badge --}}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($log->log_status === $statusSuccess)       bg-emerald-50 text-emerald-600
                                            @elseif($log->log_status === $statusFailed)    bg-red-50     text-red-500
                                            @elseif($log->log_status === $statusWarning)   bg-yellow-50  text-yellow-600
                                            @else                                          bg-gray-100   text-gray-500
                                            @endif">
                                            {{ __('layouts.' . $log->log_status) }}
                                        </span>

                                        {{-- Timestamp --}}
                                        <span class="text-xs text-gray-400 ml-auto">
                                            {{ $log->created_at->format('Y-m-d H:i') }}
                                        </span>
                                    </div>

                                    {{-- Message --}}
                                    @if($log->log_message)
                                        @php
                                            $msg = json_decode($log->log_message, true);
                                        @endphp

                                        @if($msg && isset($msg['key']))
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ __('layouts.' . $msg['key'], [
                                                    'from' => __('layouts.' . $msg['from']),
                                                    'to'   => __('layouts.' . $msg['to']),
                                                ]) }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ __('layouts.' . $log->log_message) }}
                                            </p>
                                        @endif
                                    @endif

                                    {{-- Performed by --}}
                                    @if($log->user)
                                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $log->user->name }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection