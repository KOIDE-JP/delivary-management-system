@extends('layouts.master')
@section('content')
    <div class="min-h-screen py-8 sm:py-12 px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">
            <div class="form-card gradient-border rounded-2xl p-6 sm:p-8 md:p-10 bg-white shadow-lg border border-gray-200">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('layouts.add_carrier') }}</h2>

                    <form action="{{ route('carriers.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Name --}}
                        <div class="relative">
                            <input placeholder=" " id="name" name="name" type="text"
                                value="{{ old('name') }}" required
                                class="peer w-full px-4 py-3 sm:py-4 pt-5 sm:pt-8 text-slate-900 border-2 border-slate-200
                                rounded-xl placeholder-transparent transition-all duration-200 focus:outline-none focus:border-blue-400"/>
                            <label for="name"
                                class="absolute left-4 top-3 sm:top-4 text-slate-600 text-xs sm:text-sm transition-all duration-200
                                peer-placeholder-shown:text-sm sm:peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500
                                peer-placeholder-shown:top-3 sm:peer-placeholder-shown:top-4 peer-focus:top-1.5 sm:peer-focus:top-2
                                peer-focus:text-xs peer-focus:text-blue-600 font-medium">
                                {{ __('layouts.name') }} <span class="text-red-500">*</span>
                            </label>
                            @error('name')
                                <div class="mt-2 flex items-center text-red-500 text-xs sm:text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="flex justify-center items-center px-6 py-2 border border-transparent text-sm
                                font-semibold rounded-lg text-white bg-gradient-to-tl from-blue-600 to-cyan-400
                                hover:scale-102 shadow-md hover:shadow-lg transition-all duration-200 active:opacity-80">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/>
                                </svg>
                                {{ __('layouts.create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
