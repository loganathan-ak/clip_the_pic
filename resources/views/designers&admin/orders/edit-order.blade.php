<x-layout>
    <div class="mt-5 mb-5 p-5">
        <h2 class="fw-bold mb-4">Edit Design Request Form</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <h5 class="font-bold mb-2">Please fix the following errors:</h5>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.updateorders', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Project Title -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Project Title *</label>
                <input type="text" class="form-control" value="{{ old('title', $order->project_title) }}" readonly>
            </div>

            <!-- Type of Request -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Service*</label>
                <input type="text" class="form-control" value="{{ $order->request_type }}" readonly />
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Sub-service*</label>
                <input type="text" class="form-control" value="{{ $order->sub_services }}" readonly />
            </div>

            <!-- Instructions -->
            <div class="mb-3">
                <label class="form-label"><strong>Instructions:</strong></label>
                <textarea class="form-control" rows="6" readonly>{{ old('instructions', $order->instructions) }}</textarea>
            </div>

            <!-- Colors and Size -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Preferred Colors</label>
                    <input type="text" class="form-control" value="{{ old('colors', $order->colors) }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Size</label>
                    <select class="form-select" disabled>
                        <option value="1080x1080" {{ $order->size == '1080x1080' ? 'selected' : '' }}>1080x1080</option>
                        <option value="1920x1080" {{ $order->size == '1920x1080' ? 'selected' : '' }}>1920x1080</option>
                        <option value="A4" {{ $order->size == 'A4' ? 'selected' : '' }}>A4</option>
                        <option value="Other" {{ $order->size == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <input type="text" class="form-control collapse" value="{{ $order->other_size }}" readonly />
                </div>
            </div>

            <!-- Output Format -->
            @php $selectedFormats = json_decode($order->formats, true) ?? []; @endphp
            <div class="mb-3">
                <label class="form-label fw-semibold">Output Format</label><br>
                {{-- @foreach(['PDF', 'AI', 'EPS', 'PNG', 'JPG', 'PSD'] as $format)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="{{ $format }}" {{ in_array($format, $selectedFormats) ? 'checked' : '' }} disabled>
                        <label class="form-check-label">{{ $format }}</label>
                    </div>
                @endforeach --}}
                <input class="form-check-input" type="checkbox" value="{{ $order->formats->file_type ?? '' }}" {{ $order->formats ? 'checked' : '' }} disabled>
                <label class="form-check-label">{{ $order->formats->file_type ?? 'N/A' }}</label>

            </div>

            <!-- Reference Files -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Uploaded Reference Files</label>
            
                @if($order->reference_files)
                    <ul class="list-unstyled mt-2">
                        {{-- Assuming $order->reference_files is cast to 'array' in your Order model,
                             or if it's a JSON string of objects, then json_decode is needed.
                             Let's stick to the json_decode approach to be safe,
                             and then access the 'path' property as discussed before. --}}
                        @foreach(json_decode($order->reference_files) as $fileObject)
                            <li>
                                <a href="{{ asset('storage/' . $fileObject->path) }}" target="_blank" class="text-primary">
                                    {{-- Use $fileObject->original_name if available and you want to show that,
                                         otherwise basename($fileObject->path) is fine --}}
                                    {{ $fileObject->original_name ?? basename($fileObject->path) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 italic">No reference files uploaded.</p>
                @endif
            </div>

            <!-- Assign To -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Assigned To</label>
                <select class="form-select" disabled>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ $order->assigned_to == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- ✅ Editable Status Field -->
            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">Select Status</option>
                    @foreach(['Pending', 'In Progress', 'Completed', 'Quality Checking', 'Quoted'] as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>


            <div class="some-container">
                @if(($creditsUsage->status ?? null) === 'approved' && isset($creditsUsage->updated_at)  && $order->status !== 'Completed')
                    {{-- The input field that will hold the countdown value --}}
                    <input type="text" id="countdown" name="completed_time" class="font-semibold text-red-600" readonly />
                    {{-- Added 'readonly' because it's dynamically set by JS --}}
            
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const durationHours = {{ $order->duration ?? 4 }};
                            const duration = durationHours * 60 * 60; // in seconds
            
                            // Use updated_at from creditsUsage as the start time for the countdown
                            // This aligns with your backend's $updatedTime logic
                            const startTime = {{ \Carbon\Carbon::parse($creditsUsage->updated_at)->timestamp }};
                            const endTime = startTime + duration;
            
                            const countdownEl = document.getElementById('countdown');
            
                            function updateCountdown() {
                                const now = Math.floor(Date.now() / 1000);
                                let remaining = endTime - now;
            
                                const isNegative = remaining < 0;
                                const absRemaining = Math.abs(remaining);
            
                                const hrs = Math.floor(absRemaining / 3600);
                                const mins = Math.floor((absRemaining % 3600) / 60);
                                const secs = absRemaining % 60;
            
                                // Format as HH:MM:SS
                                const formattedTime = `${isNegative ? '-' : ''}${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                                countdownEl.value = formattedTime; // Set the value of the input field
            
                                // Change color based on remaining time
                                countdownEl.classList.toggle("text-red-600", isNegative);
                                countdownEl.classList.toggle("text-gray-700", !isNegative);
            
                                // Re-run every second
                                setTimeout(updateCountdown, 1000);
                            }
            
                            updateCountdown();
                        });
                    </script>
            
                @else
                    <p>{{ $order->duration }} Hrs</p>
                @endif
            </div>
            <!-- Submit -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Update Status</button>
            </div>
        </form>
    </div>
</x-layout>
