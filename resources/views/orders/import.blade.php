@extends('layouts.master')

@section('content')
    <div class="flex justify-center w-full min-h-screen p-4 sm:p-6 bg-gray-50/50">
        <div class="w-full max-w-4xl p-5 bg-white border border-gray-200 shadow-sm sm:p-8 rounded-2xl">

            {{-- HEADER --}}
            <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
                <div>
                    <h4 class="text-2xl font-extrabold tracking-tight text-gray-900">
                        {{ __('layouts.order.import') ?? 'Import Orders' }}
                    </h4>
                    <p class="mt-1 text-sm text-gray-500">{{ __('layouts.order.import_description') }}</p>
                </div>
                <a href="{{ route('order.index') }}"
                    class="text-sm font-medium text-blue-600 transition-colors hover:text-blue-800">
                    &larr; {{ __('layouts.back_to_orders') ?? 'Back to Orders' }}
                </a>
            </div>

            {{-- UPLOAD FORM --}}
            <form id="importForm" class="space-y-6">
                @csrf
                <div class="flex items-center justify-center w-full">
                    <label for="fileDropzone"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 font-semibold">{{ __('layouts.order.upload_instruction') }}</p>
                            <p class="text-xs text-gray-500">{{ __('layouts.order.upload_ins_files') }}</p>
                        </div>
                        <input id="fileDropzone" type="file" name="file" accept=".xlsx, .xls, .csv" class="hidden"
                            required />
                    </label>
                </div>

                <div id="selectedFileName" class="hidden text-sm font-medium text-center text-gray-700"></div>

                <div class="w-full flex justify-center">
                    <button type="submit" id="submitBtn"
                    class="w-50 px-5 py-3 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                    {{ __('layouts.order.start_import') }}
                </button>
                </div>
            </form>

            {{-- PROGRESS SECTION (Hidden by default) --}}
            <div id="progressSection" class="hidden mt-8 space-y-4">
                <div class="flex justify-between text-sm font-medium text-gray-700">
                    <span id="progressStatus">{{ __('layouts.order.uploading_file') }}</span>
                    <span id="progressPercentage">0%</span>
                </div>
                <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                    <div id="progressBar" class="h-3 bg-blue-600 rounded-full transition-all duration-300 ease-out"
                        style="width: 0%"></div>
                </div>
                <p id="progressCount" class="text-xs text-center text-gray-500"></p>
            </div>

            {{-- ALERTS --}}
            <div id="alertBox" class="hidden p-4 mt-6 rounded-lg"></div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileDropzone');
            const fileNameDisplay = document.getElementById('selectedFileName');
            const form = document.getElementById('importForm');
            const submitBtn = document.getElementById('submitBtn');
            const progressSection = document.getElementById('progressSection');
            const progressBar = document.getElementById('progressBar');
            const progressStatus = document.getElementById('progressStatus');
            const progressPercentage = document.getElementById('progressPercentage');
            const progressCount = document.getElementById('progressCount');
            const alertBox = document.getElementById('alertBox');

            // Show selected file name
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    fileNameDisplay.textContent = `{{ __('layouts.order.selected_file') }}: ${e.target.files[0].name}`;
                    fileNameDisplay.classList.remove('hidden');
                }
            });

            function showAlert(message, type = 'error') {
                alertBox.className =
                    `p-4 mt-6 rounded-lg text-sm ${type === 'error' ? 'bg-red-50 text-red-700 border-l-4 border-red-500' : 'bg-green-50 text-green-700 border-l-4 border-green-500'}`;
                alertBox.textContent = message;
                alertBox.classList.remove('hidden');
            }

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (fileInput.files.length === 0) return;

                // 1. Grab the form data FIRST while the input is still active
                const formData = new FormData(form);

                // 2. NOW disable the UI
                alertBox.classList.add('hidden');
                submitBtn.disabled = true;
                fileInput.disabled = true;
                progressSection.classList.remove('hidden');
                progressBar.style.width = '5%';
                progressStatus.textContent = '{{ __('layouts.order.uploading_file') }}...';

                try {
                    // STEP 1: Upload File
                    const uploadRes = await fetch("{{ route('order.import.upload') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json' // Add this line!
                        }
                    });

                    const uploadData = await uploadRes.json();

                    if (!uploadRes.ok || !uploadData.success) {
                        throw new Error(uploadData.message || 'Error uploading file.');
                    }

                    // STEP 2: Process Chunks
                    progressStatus.textContent = '{{ __('layouts.order.importing_records') }}...';
                    await processChunk(uploadData.file_id, 0, uploadData.total_rows);

                } catch (error) {
                    showAlert(error.message);
                    submitBtn.disabled = false;
                    fileInput.disabled = false;
                    progressSection.classList.add('hidden');
                }
            });

            async function processChunk(fileId, offset, totalRows) {
                try {
                    const res = await fetch("{{ route('order.import.process') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json' // Add this line!
                        },
                        body: JSON.stringify({
                            file_id: fileId,
                            offset: offset
                        })
                    });

                    const data = await res.json();
                    console.log(data);
                    

                    if (!res.ok || !data.success) {
                        throw new Error(data.message || 'Error processing data chunk.');
                    }

                    // Calculate Progress
                    let percent = Math.min(Math.round((data.processed / totalRows) * 100), 100);
                    progressBar.style.width = `${percent}%`;
                    progressPercentage.textContent = `${percent}%`;
                    progressCount.textContent = `${data.processed} of ${totalRows} rows processed`;

                    if (data.is_done) {
                        progressStatus.textContent = '{{ __('layouts.order.import_complete') }}';
                        progressBar.classList.replace('bg-blue-600', 'bg-green-500');
                        showAlert('{{ __('layouts.order.import_complete') }}', 'success');

                        // Optional: redirect back to index after a delay
                        setTimeout(() => {
                            window.location.href = "{{ route('order.index') }}";
                        }, 2000);
                    } else {
                        // Process next chunk
                        await processChunk(fileId, data.processed, totalRows);
                    }

                } catch (error) {
                    showAlert(error.message);
                    submitBtn.disabled = false;
                }
            }
        });
    </script>
@endpush
