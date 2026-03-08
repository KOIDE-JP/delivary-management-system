@extends('layouts.master')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl mb-4">{{ __('Edit File') }}</h2>

    @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('files.update', $file) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="file_name" class="block mb-1 font-bold">{{ __('File Name') }}</label>
            <input type="text" name="file_name" id="file_name" value="{{ old('file_name', $file->file_name) }}" class="w-full border rounded px-3 py-2" required>
            @error('file_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- <div class="mb-4">
            <label for="file_url" class="block mb-1 font-bold">{{ __('File URL') }}</label>
            <input type="url" name="file_url" id="file_url" value="{{ old('file_url', $file->file_url) }}" class="w-full border rounded px-3 py-2" required>
            @error('file_url')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="folder_path" class="block mb-1 font-bold">{{ __('Folder Path') }}</label>
            <input type="text" name="folder_path" id="folder_path" value="{{ old('folder_path', $file->folder_path) }}" class="w-full border rounded px-3 py-2">
            @error('folder_path')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div> --}}

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ __('Update') }}
        </button>
    </form>
</div>
@endsection
