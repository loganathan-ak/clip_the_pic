<x-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .cursor-pointer {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .service-card:hover .card-body,
        .subservice-card:hover .card-body {
            background-color: #e9f2fc !important;
            transform: scale(1.02);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .card-body {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

    </style>
    
    
    
    
    
    <div class="mt-5 mb-5 p-5" >
        <h2 class="fw-bold mb-4">New Job Request Form</h2>
    
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

        <div class="mb-5" id="main-service-cards">
            {{-- <h3 class="mb-3">Choose a Design Service</h3> --}}
            <div id="services-card-container" class="row g-3">
                <!-- JS will populate service cards here -->
            </div>
        </div>
        
        <div class="mb-5 d-none" id="sub-service-cards">
            {{-- <h4 class="mb-3">Choose a Sub-Service</h4> --}}
            <div id="subservices-card-container" class="row g-3">
                <!-- JS will populate sub-service cards here -->
            </div>
        </div>
        
    
        <div id="design-form" class="hidden">
            <form action="" method="POST" enctype="multipart/form-data" id="main-form">
                @csrf
                <input type="hidden" id="service" name="request_type">
                <input type="hidden" id="subService" name="sub_services">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" id="backToSubServices" class="btn btn-light btn-lg px-4 py-2 rounded-pill d-flex align-items-center shadow-sm transition-all duration-300 hover:scale-105 hover:shadow-md">
                        <i class="bi bi-arrow-left me-2 text-primary"></i>
                        <span class="fw-semibold text-primary">Go Back</span>
                    </button>
                </div>
             
                <div id="form-heading">
                </div>

                <!-- Reference Files Upload -->
                <div class="mb-3">
                    <label for="reference_files" class="form-label fw-semibold">Upload Reference Files</label>
                    <input class="form-control" type="file" name="reference_files[]" id="reference_files" multiple>
                </div>
                <div id="preview-container" class="flex flex-wrap gap-4 mt-3"></div>
        
                <!-- Instructions (Rich Text) -->
                <div class="mb-3">
                    <label for="instructions" class="form-label"><strong>Instructions:</strong></label>
                    <textarea name="instructions" id="instructions" class="form-control" rows="6">{{ old('instructions') }}</textarea>
                </div>
        
                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Project Title *</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>
        
                <!-- Request Type -->
                <div class="mb-3">
                    {{-- <label for="request_type" class="form-label fw-semibold">Select Service*</label> --}}
        
                    {{-- <div class="row">
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
                    </div> --}}
                    
                    <div id="outputFormats" class="mt-3 flex items-center gap-3" style="display: none;">
                        <label class="mr-2"><strong>Output Formats:</strong></label>
                        <div id="outputFormatList" class="flex flex-wrap gap-2"></div>
                    </div>
                    
                </div>
        
                <!-- Color & Size -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="colors" class="form-label fw-semibold">Preferred Colors</label>
                        <input type="text" class="form-control" name="colors" id="colors" value="{{ old('colors') }}" placeholder="e.g., #ffffff, #000000">
                    </div>
                    <div class="col-md-6">
                        <label for="size" class="form-label fw-semibold">Size</label>
                        <select class="form-select" id="size" name="size">
                            <option value="">Select Size</option>
                            <option value="1080x1080" {{ old('size') == '1080x1080' ? 'selected' : '' }}>1080x1080 (Instagram)</option>
                            <option value="1920x1080" {{ old('size') == '1920x1080' ? 'selected' : '' }}>1920x1080 (HD)</option>
                            <option value="A4" {{ old('size') == 'A4' ? 'selected' : '' }}>A4</option>
                            <option value="Other" {{ old('size') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        
                        <input type="text" name="other_size" id="other_size" class="form-control collapse input-toggle" value="{{ old('other_size') }}" placeholder="Enter size"/>
                        
                    </div>
                </div>
        
                <div class="row mb-3">
                    <div class="col-md-6">
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
                                <option value="{{ $value }}" {{ old('duration', 18) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status"><strong>Job Status</strong></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Publish</option>
                            <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        <div class="form-text text-muted mt-1" id="status-help">
                            <span id="status-message">
                                {{ old('status') == 'Draft' ? 'This job post will not be visible to others. Only you can see it.' : 'Published jobs will be visible to our team.' }}
                            </span>
                        </div>
                    </div>
                    
                </div>
        
                <!-- Brand Profile -->
                <div class="mb-3">
                    <label for="brand_profile_id" class="form-label fw-semibold">Select Brand Profile *</label>
                    <select class="form-select" id="brand_profile_id" name="brand_profile_id">
                        <option value="">Choose Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_profile_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brand_name }}
                            </option>
                        @endforeach
                    </select>    
                </div>
        
                <!-- Pre-approve budget -->
                {{-- <div class="mb-3">
                    <label for="pre_approve" class="form-label fw-semibold">Pre-approve Up To (No.of credits)</label>
                    <input type="number" class="form-control" name="pre_approve" id="pre_approve" min="0" step="1" value="{{ old('pre_approve') }}">
                </div> --}}
        
                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Include Rich Text Editor -->
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    
    <script>
         let filesArray = [];
    
    function renderPreviews() {
        $('#preview-container').empty();
    
        filesArray.forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;
    
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewHtml = `
                    <div class="position-relative me-3 mb-3" style="width: 120px;">
                        <img src="${e.target.result}" class="img-thumbnail" style="height: 100px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image" data-index="${index}">&times;</button>
                    </div>
                `;
                $('#preview-container').append(previewHtml);
            };
            reader.readAsDataURL(file);
        });
    
        // Update the input element with current files
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        $('#reference_files')[0].files = dataTransfer.files;
    }
    
    $('#reference_files').on('change', function(e) {
        // ✅ Merge new files while avoiding duplicates
        const newFiles = Array.from(e.target.files);

        // Prevent duplicates by comparing file names + size
        newFiles.forEach(file => {
            if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                filesArray.push(file);
            }
        });

        renderPreviews();
    });
    
    $(document).on('click', '.remove-image', function() {
        const index = $(this).data('index');
        filesArray.splice(index, 1);
        renderPreviews();
    });
    
    
    /////////////////////////////////////////////
    
    $(document).ready(function(){
        $('#software, #size').on('change', function(){
            let getDiv = $(this).closest('div');
            let value = $(this).val();
            let toggleInput = getDiv.find('.input-toggle');
            
            if(value === 'Other'){
                toggleInput.removeClass('collapse ');
            } else {
                toggleInput.addClass('collapse ').val(''); // also clears input when hidden
            }
        });
    });
    
    
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

const serviceMeta = {
    "Clipping Paths":      {
        icon: "/Clipping-Paths.png", 
        description: "Precisely cut out subjects from their backgrounds."
    },
    "Masking":             {
        icon: "/Masking.png",
        description: "Isolate complex subjects like hair or fur with precision."
    },
    "Remove Background": {
        icon: "/Remove-Background.png",
        description: "Quickly eliminate unwanted backgrounds from your images."
    },
    "Color Correction":    {
        icon: "/Color-Correction.png",
        description: "Enhance and balance the colors in your photos."
    },
    "Retouch":             {
        icon: "/Retouch.png",
        description: "Perfect imperfections and refine image details."
    },
    "Vector":              {
        icon: "/vector-pen.png",
        description: "Convert raster images into scalable vector graphics."
    }
};

// ✅ Render Main Services
function renderServiceCards() {
    const container = document.getElementById('services-card-container');
    container.innerHTML = ''; // Clear previous content

    const headingRow = document.createElement('div');
    headingRow.className = 'col-12 mb-4';
    headingRow.innerHTML = `<h3 class="text-center text-primary-emphasis fw-bold">Choose a Service</h3>`;
    container.appendChild(headingRow);

    for (const service in serviceData) {
        const meta = serviceMeta[service] || {};
        const iconData = meta.icon || "bi-tools";
        const description = meta.description || "No description available."; // Get the description

        let iconHtml;
        const imageExtensions = ['.png', '.jpg', '.jpeg', '.gif', '.svg'];
        if (imageExtensions.some(ext => iconData.includes(ext))) {
            iconHtml = `<img src="${iconData}" alt="${service} icon" class="service-icon-img img-fluid" style="width: 60px; height: 60px; object-fit: contain;">`;
        } else {
            iconHtml = `<i class="bi ${iconData} fs-1 text-primary mb-2"></i>`;
        }

        const card = document.createElement('div');
        card.className = 'col-md-4 mb-4';
        card.innerHTML = `
            <div class="card h-100 service-card cursor-pointer border-0 shadow-sm rounded-4 transition-transform hover:scale-105">
                <div class="card-body bg-light-subtle p-4 rounded-4 d-flex flex-column align-items-center justify-content-center text-center gap-2" data-service="${service}">
                    ${iconHtml}
                    <h5 class="card-title mb-1 fw-semibold">${service}</h5>
                    <p class="card-text text-muted text-sm px-2">${description}</p> </div>
            </div>
        `;
        container.appendChild(card);
    }
}

// ... (rest of your JavaScript code remains the same)
// ✅ Render Sub-services
function renderSubServiceCards(service) {
    const container = document.getElementById('subservices-card-container');
    container.innerHTML = ''; // Clear previous content

    // Add a row for the back button and sub-service heading
    const headerRow = document.createElement('div');
    headerRow.className = 'col-12 mb-4 d-flex align-items-center justify-content-between';
    headerRow.innerHTML = `
        <button id="backToServices" class="btn btn-light btn-lg px-4 py-2 rounded-pill d-flex align-items-center shadow-sm transition-all duration-300 hover:scale-105 hover:shadow-md">
                        <i class="bi bi-arrow-left me-2 text-primary"></i>
                        <span class="fw-semibold text-primary">Go Back</span>
                    </button>
        <h3 class="flex-grow-1 text-center text-primary-emphasis fw-bold mb-0 me-5">Select a Sub-Service for ${service}</h3>
        <div></div> `;
    container.appendChild(headerRow);

    const subServices = Object.keys(serviceData[service]);

    subServices.forEach(sub => {
        const card = document.createElement('div');
        card.className = 'col-md-4 mb-4';
        card.innerHTML = `
            <div class="card h-100 subservice-card cursor-pointer border-0 shadow-sm rounded-4 transition-transform hover:scale-105">
                <div class="card-body bg-white p-3 rounded-4 d-flex align-items-center gap-3" data-sub="${sub}">
                    <i class="bi bi-chevron-double-right fs-4 text-secondary"></i>
                    <h6 class="mb-0 fw-semibold">${sub}</h6>
                </div>
            </div>
        `;
        container.appendChild(card);
    });

    // Animate to sub-service cards
    $('#main-service-cards').slideUp(400, function () {
        $('#sub-service-cards').hide().removeClass('d-none').slideDown(400);
        // Scroll to top of sub-services if needed
        $('html, body').animate({
            scrollTop: $('#sub-service-cards').offset().top
        }, 300);
    });
}

// ✅ Render Output Formats
function renderOutputFormats(service, subService) {
    const $outputBox = $('#outputFormats');
    const $outputList = $('#outputFormatList');

    $outputList.empty();
    $outputBox.hide(); // Hide initially

    if (service && subService) {
        const formats = serviceData[service][subService] || [];
        formats.forEach((format, index) => {
            const radio = `
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="formats" value="${format}" id="format${format.replace(/\s+/g, '')}${index}">
                    <label class="form-check-label" for="format${format.replace(/\s+/g, '')}${index}">${format}</label>
                </div>
            `;
            $outputList.append(radio);
        });

        if (formats.length > 0) {
            $outputBox.slideDown(300);
        }
    }
}

// Function to reset to main services view
function backToMainServices() {
    $('#sub-service-cards').slideUp(400, function() {
        // Clear sub-service and output format selections
        $('#subService').val('');
        $('#outputFormats').slideUp(200); // Hide output formats if visible
        $('#design-form').slideUp(400, function() {
            $(this).addClass('hidden'); // Hide the form completely
        });

        $('#main-service-cards').hide().slideDown(400);
        // Scroll back to main services section
        $('html, body').animate({
            scrollTop: $('#main-service-cards').offset().top
        }, 600);
    });
}


// ✅ Initial Bindings
$(document).ready(function () {
    renderServiceCards();

    // Main Service Click
    $(document).on('click', '.service-card', function () {
        const selectedService = $(this).find('.card-body').data('service');
        $('#service').val(selectedService); // Set hidden input value
        renderSubServiceCards(selectedService);
    });

    // Sub-service Click
    $(document).on('click', '.subservice-card', function () {
        const selectedSub = $(this).find('.card-body').data('sub');
        const selectedService = $('#service').val();

        $('#subService').val(selectedSub); // Set hidden input value

        // Render output formats
        renderOutputFormats(selectedService, selectedSub);

        // Show the form
        $('#sub-service-cards').slideUp(400, function () {
            $('#design-form').hide().removeClass('hidden').slideDown(400);
            $('#form-heading').append(`<h3 class="mb-3 flex justify-center fw-semibold">Great! You've chosen <strong> ${selectedService}</strong> with the sub-service <strong>${selectedSub}</strong>.</h3>
`);
        });

        // Scroll to form
        $('html, body').animate({
            scrollTop: $('#design-form').offset().top
        }, 600);
    });

    // Back button for Sub-services click (NEW)
    $(document).on('click', '#backToServices', function() {
        backToMainServices();
    });

    // Optionally, if you have a "Back" button on the main form to go back to sub-services
    // You'd need to add a button with an ID like 'backToSubServices' in your HTML form
    $(document).on('click', '#backToSubServices', function() {
        const selectedService = $('#service').val();
        $('#design-form').slideUp(400, function() {
            $(this).addClass('hidden');
            renderSubServiceCards(selectedService); // Re-render sub-services for selected service
            $('#sub-service-cards').hide().removeClass('d-none').slideDown(400);
            $('html, body').animate({ scrollTop: $('#sub-service-cards').offset().top }, 600);
        });
    });
});
    //////////////////////////////////////

    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('status');
        const statusMessage = document.getElementById('status-message');

        const messages = {
            Draft: 'This job post will not be visible to others. Only you can see it.',
            Pending: 'Published jobs will be visible to your team or subscribers.'
        };

        statusSelect.addEventListener('change', function () {
            statusMessage.textContent = messages[this.value] || '';
        });
    });
    
    </script>
    </x-layout>
    