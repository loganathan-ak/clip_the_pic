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

        <form action="{{ route('update.order', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Project Title *</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $order->project_title) }}" required>
            </div>

        <!-- Request Type -->
        <div class="mb-3">
            <label for="request_type" class="form-label fw-semibold">Select Service*</label>

            <div class="row">
                <div class="col-md-6">
                <select id="service" class="form-select" name="request_type" required>
                    <option value="">Select Service</option>
                </select>
                </div>
                <div class="col-md-6">
                <select id="subService" class="form-select mt-2" name="sub_services" disabled>
                    <option value="">Select Sub Service</option>
                </select>
                </div>
            </div>
            <div class="mb-3">
                    <label for="duration"><strong>Duration</strong></label>
                    <select name="duration" id="duration" class="form-select" required>
                        @foreach([
                            1 => '1 Hour – 5 Additional credits per image',
                            2 => '2 Hours – 4 Additional credits per image',
                            4 => '4 Hours – 3 Additional credits per image',
                            8 => '8 Hours – 2 Additional credits per image',
                            12 => '12 Hours – 1 Additional credit per image',
                            18 => '18 Hours – Standard Delivery time',
                            24 => '24 Hours – 5% Discount',
                            48 => '48 Hours – 6% Discount',
                            72 => '72 Hours – 7% Discount',
                            96 => '96 Hours – 8% Discount',
                            120 => '120 Hours – 9% Discount',
                            144 => '144 Hours – 10% Discount',
                            168 => '168 Hours – 11% Discount',
                            192 => '192 Hours – 12% Discount'
                        ] as $value => $label)
                            <option value="{{ $value }}" {{ old('duration', $order->duration) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
            </div>
            
            <div id="outputFormats" class="mt-3 flex items-center gap-3" style="display: none;">
                <label class="mr-2"><strong>Output Formats:</strong></label>
                <div id="outputFormatList" class="flex flex-wrap gap-2"></div>
            </div>
            
        </div>

            <!-- Instructions (Rich Text) -->
            <div class="mb-3">
                <label for="instructions" class="form-label"><strong>Instructions:</strong></label>
                <textarea name="instructions" id="instructions" class="form-control" rows="6">{{ old('instructions', $order->instructions) }}</textarea>
            </div>

            <!-- Instructions (Rich Text) -->
            <div class="mb-3">
                <label for="admin_notes" class="form-label"><strong>Admin Notes:</strong></label>
                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="6">{{ old('admin_notes', $order->admin_notes) }}</textarea>
            </div>

            <!-- Color & Size -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="colors" class="form-label fw-semibold">Preferred Colors</label>
                    <input type="text" class="form-control" name="colors" id="colors" value="{{ old('colors', $order->colors) }}" placeholder="e.g., #ffffff, #000000">
                </div>
                <div class="col-md-6">
                    <label for="size" class="form-label fw-semibold">Size</label>
                    <select class="form-select" id="size" name="size">
                        <option value="">Select Size</option>
                        <option value="1080x1080" {{ $order->size == '1080x1080' ? 'selected' : '' }}>1080x1080 (Instagram)</option>
                        <option value="1920x1080" {{ $order->size == '1920x1080' ? 'selected' : '' }}>1920x1080 (HD)</option>
                        <option value="A4" {{ $order->size == 'A4' ? 'selected' : '' }}>A4</option>
                        <option value="Other" {{ $order->size == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <input type="text" name="other_size" id="other_size" class="form-control collapse input-toggle" value="{{ old('other_size', $order->other_size) }}" placeholder="Enter size" />
                </div>
            </div>

            <!-- Software to Use -->
            <div class="mb-3">
                <label for="software" class="form-label fw-semibold">Software to Use</label>
                <select class="form-select" id="software" name="software">
                    <option value="">Select Software</option>
                    <option value="Adobe Photoshop" {{ $order->software == 'Adobe Photoshop' ? 'selected' : '' }}>Adobe Photoshop</option>
                    <option value="Adobe Illustrator" {{ $order->software == 'Adobe Illustrator' ? 'selected' : '' }}>Adobe Illustrator</option>
                    <option value="Canva" {{ $order->software == 'Canva' ? 'selected' : '' }}>Canva</option>
                    <option value="Figma" {{ $order->software == 'Figma' ? 'selected' : '' }}>Figma</option>
                    <option value="Other" {{ $order->software == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <input type="text" name="other_software" id="other_software" class="form-control collapse input-toggle" value="{{ old('other_software', $order->other_software) }}" placeholder="Enter software" />
            </div>

            <!-- Brand Profile -->
            <div class="mb-3">
                <label for="brand_profile_id" class="form-label fw-semibold">Select Brand Profile *</label>
                <select class="form-select" id="brand_profile_id" name="brand_profile_id">
                    <option value="">Choose Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $order->brands_profile_id == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>

        

            <!-- Pre-approve budget -->
            <div class="mb-3">
                <label for="pre_approve" class="form-label fw-semibold">Pre-approve Up To (₹)</label>
                <input type="number" class="form-control" name="pre_approve" id="pre_approve" value="{{ old('pre_approve', $order->pre_approve) }}" min="0" step="1">
            </div>

            <!-- Reference Files Upload -->
            <div class="mb-3">
                <label for="reference_files" class="form-label fw-semibold">Upload Reference Files</label>
                <input class="form-control" type="file" name="reference_files[]" id="reference_files" multiple >
            
                @if($order->reference_files)
                    <div class="mt-3 d-flex flex-wrap gap-3">
                        @foreach(json_decode($order->reference_files) as $file)
                            @php
                                $extension = pathinfo($file->original_name, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']);
                            @endphp
            
                            @if($isImage)
                                <div style="width: 150px; position: relative;">
                                    <img src="{{ asset('storage/' . $file->path) }}" 
                                         alt="{{ $file->original_name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 100%; max-height: 150px;">
                                    <small class="d-block text-truncate mt-1">{{ $file->original_name }}</small>
                                </div>
                            @else
                                <div style="width: 150px;">
                                    <a href="{{ asset('storage/' . $file->path) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary w-100">
                                        View {{ strtoupper($extension) }}
                                    </a>
                                    <small class="d-block text-truncate mt-1">{{ $file->original_name }}</small>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            




            <!-- Requested By -->
        <div class="mb-3">
            <label for="user_id" class="form-label fw-semibold">Requested By</label>
            <input type="text" class="form-control" value="{{$subscribers->where('id', $order->created_by)->first()->name ?? 'N/A' }}" disabled>
            <input type="hidden" name="user_id" value="{{ $order->created_by }}">
        </div>

        <!-- Assign To Admin -->
        <div class="mb-3 hidden">
            <label for="assigned_to" class="form-label fw-semibold">Assign To</label>
            <select name="assigned_to" id="assigned_to" class="form-select">
                <option value="">Select Admin</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $order->assigned_to == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div>
              
              <!-- ✅ Editable Status Field -->
            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select name="status" id="status" class="form-select" >
                    <option value="">Select Status</option>
                    @foreach(['Pending', 'In Progress', 'Completed', 'Quality Checking', 'Quoted'] as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="some-container">
                @if(($creditsUsage->status ?? null) === 'approved' && isset($creditsUsage->updated_at)  && $order->status !== 'Completed')
                    {{-- The input field that will hold the countdown value --}}
                    <label>Duration : </label>
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
                <button type="submit" class="btn btn-primary px-4 py-2">Update Request</button>
            </div>
        </form>
    </div>

    <!-- Include Rich Text Editor -->
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        window.onload = function() {
            CKEDITOR.replace('instructions');
        };

        $(document).ready(function(){
            $('#software, #request_type, #size').on('change', function(){
                let getDiv = $(this).closest('div');
                let value = $(this).val();
                let toggleInput = getDiv.find('.input-toggle');
                
                if(value === 'Other'){
                    toggleInput.removeClass('collapse');
                } else {
                    toggleInput.addClass('collapse').val(''); // also clears input when hidden
                }
            });
        });




/////////////////////////////////////////////

    const serviceData = {
        "Clipping Paths": {
            "Original Background": ["JPG", "EPS", "TIFF", "PSD"],
            "Transparent Background": ["PNG", "TIFF", "PSD"],
            "White Background": ["JPG", "PNG", "EPS", "TIFF", "PSD"],
            "Custom Background": ["JPG", "PNG", "EPS", "TIFF", "PSD"]
        },
        "Masking": {
            "Transparent Layer or Channel Mask": ["PSD", "TIFF"],
            "Transparent Background": ["PNG", "PSD", "TIFF"],
            "White Background": ["PNG", "PSD", "TIFF"],
            "Custom Background": ["PNG", "PSD", "TIFF"]
        },
        "Remove Background": {
            "Transparent Background": ["PNG", "PSD", "TIFF"],
            "White Background": ["JPEG", "PNG", "PSD", "TIFF"],
            "Custom Background": ["JPG", "PNG", "EPS", "TIFF", "PSD"]
        },
        "Color Correction": {
            "Color Correction": ["JPG", "PNG", "PSD", "TIFF", "EPS", "Layered PSD", "Layered TIFF"]
        },
        "Retouch": {
            "Retouch": ["JPG", "PNG", "PSD", "TIFF", "Layered PSD", "Layered TIFF"]
        },
        "Vector": {
            "Vector": ["Illustrator EPS", "Photoshop EPS", "Illustrator file (ai)"]
        }
    };

$(document).ready(function () {
    const $service = $('#service');
    const $subService = $('#subService');
    const $outputBox = $('#outputFormats');
    const $outputList = $('#outputFormatList');

    // 1. Fill Service options
    Object.keys(serviceData).forEach(service => {
        $service.append(new Option(service, service));
    });

    // 2. Preselect service if available
    if (selectedService) {
        $service.val(selectedService).trigger('change');
    }

    // 3. When Service changes, populate Sub Services
    $service.on('change', function () {
        const service = $(this).val();
        $subService.empty().append('<option value="">Select Sub Service</option>').prop('disabled', true);
        $outputBox.hide();
        $outputList.empty();

        if (service) {
            Object.keys(serviceData[service]).forEach(sub => {
                $subService.append(new Option(sub, sub));
            });
            $subService.prop('disabled', false);

            // 4. Preselect sub-service after a short delay (wait for DOM update)
            if (selectedService === service && selectedSubService) {
                setTimeout(() => {
                    $subService.val(selectedSubService).trigger('change');
                }, 100);
            }
        }
    });

    // 5. When Sub Service changes, populate Output Formats
    $subService.on('change', function () {
        const service = $service.val();
        const subService = $(this).val();
        $outputList.empty();
        $outputBox.hide();

        if (service && subService) {
            const formats = serviceData[service][subService];
            formats.forEach((format, index) => {
                const isChecked = selectedFormats.includes(format) ? 'checked' : '';
                const checkbox = `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="formats[]" value="${format}" id="format${index}" ${isChecked}>
                        <label class="form-check-label" for="format${index}">${format}</label>
                    </div>
                `;
                $outputList.append(checkbox);
            });
            $outputBox.show();
        }
    });

    // Optional: trigger change on service to start everything
    if (selectedService) {
        $service.trigger('change');
    }
});

    </script>

    <script>
    const selectedService = @json(old('request_type', $order->request_type));
    const selectedSubService = @json(old('sub_services', $order->sub_services));
    const selectedFormats = @json(old('formats', $order->formats ?? []));
</script>

</x-layout>
