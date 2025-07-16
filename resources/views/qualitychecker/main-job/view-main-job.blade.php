<x-layout>
    <style>
        h1 { color: #333; margin-bottom: 10px; }
           h2 { color: #555; margin-top: 20px; margin-bottom: 10px; }
           .controls { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; justify-content: center; }
           .input-group { display: flex; flex-direction: column; gap: 5px; }
           .input-group label { font-size: 0.9em; color: #666; }
           .input-group input { padding: 8px; border: 1px solid #ccc; border-radius: 5px; width: 150px; }
   
           .container {
               display: flex;
               flex-direction: column; /* Default to column for small screens */
               width: 90%;
               max-width: 1200px;
               border: 1px solid #e0e0e0;
               border-radius: 12px;
               overflow: hidden;
               box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
               background-color: #fff;
           }
           @media (min-width: 768px) {
               .container {
                   flex-direction: row; /* Row for larger screens */
               }
           }
           .image-section { flex: 2; position: relative; padding: 15px; background-color: #fefefe; display: flex; justify-content: center; align-items: center; }
           #imagePreview { width: 100%; height: auto; position: relative; display: flex; justify-content: center; align-items: center; }
           #uploadedImage { display: block; max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
           #annotationCanvas { position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: crosshair; }
           .annotation-list-section { flex: 1; padding: 15px; background-color: #f9f9f9; border-left: 1px solid #eee; }
           #annotationsList {
               border: 1px solid #ddd;
               padding: 10px;
               max-height: 400px; /* Increased height for more annotations */
               overflow-y: auto;
               border-radius: 8px;
               background-color: white;
               box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
           }
           .annotation-item {
               display: flex;
               justify-content: space-between;
               align-items: flex-start; /* Align items to start for multi-line comments */
               margin-bottom: 10px;
               padding-bottom: 10px;
               border-bottom: 1px dotted #e0e0e0;
               font-size: 14px;
               color: #444;
           }
           .annotation-item:last-child { border-bottom: none; }
           .remove-annotation {
               color: #dc3545;
               cursor: pointer;
               margin-left: 15px;
               font-weight: bold;
               font-size: 1.2em;
               transition: color 0.2s ease-in-out;
           }
           .remove-annotation:hover {
               color: #c82333;
           }
           button {
               padding: 10px 20px;
               border: none;
               border-radius: 5px;
               cursor: pointer;
               background-color: #007bff;
               color: white;
               font-size: 15px;
               font-weight: 600;
               transition: background-color 0.2s ease-in-out, transform 0.1s ease;
               box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
           }
           button:hover {
               background-color: #0056b3;
               transform: translateY(-1px);
           }
           button:active {
               transform: translateY(0);
               box-shadow: 0 1px 3px rgba(0, 123, 255, 0.3);
           }
           input[type="file"] {
               padding: 8px;
               border: 1px solid #ccc;
               border-radius: 5px;
               background-color: #fefefe;
           }
           /* Add some specific button colors */
           #drawCircleBtn { background-color: #28a745; } /* Green */
           #drawCircleBtn:hover { background-color: #218838; }
           #addTextBtn { background-color: #17a2b8; } /* Cyan */
           #addTextBtn:hover { background-color: #138496; }
           #eraseBtn { background-color: #ffc107; color: #333; } /* Yellow */
           #eraseBtn:hover { background-color: #e0a800; }
           #removeAllBtn { background-color: #dc3545; } /* Red */
           #removeAllBtn:hover { background-color: #c82333; }
           #submitBtn { background-color: #6f42c1; } /* Purple */
           #submitBtn:hover { background-color: #5a2d9c; }
   
           /* Loading Indicator */
           .loading-overlay {
               position: fixed;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               background: rgba(255, 255, 255, 0.8);
               display: flex;
               justify-content: center;
               align-items: center;
               z-index: 1000;
               display: none; /* Hidden by default */
           }
           .spinner {
               border: 8px solid #f3f3f3;
               border-top: 8px solid #3498db;
               border-radius: 50%;
               width: 60px;
               height: 60px;
               animation: spin 2s linear infinite;
           }
           @keyframes spin {
               0% { transform: rotate(0deg); }
               100% { transform: rotate(360deg); }
           }
    </style>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 mt-5 space-y-10">

        <!-- Order Summary Card -->
        <div class="w-full mx-auto bg-white shadow-xl rounded-2xl p-8 border border-gray-100 space-y-10">
            <!-- Title -->
            <div class="border-b pb-4">
                <h1 class="text-3xl font-extrabold text-gray-800">📝 Order Summary</h1>
            </div>

            <!-- Grid Fields (Short Dummy Data) -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-gray-800">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Project Title</p>
                    <p class="text-base font-semibold">{{$order->project_title}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Service</p>
                    <p class="text-base font-semibold">{{$order->request_type}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Service</p>
                    <p class="text-base font-semibold">{{$order->sub_services}}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Duration</p>
                  @if($order->completed_at == null)
                            @if(($creditsUsage->status ?? null) === 'approved' && isset($creditsUsage->updated_at))
                                <p id="countdown" class="font-semibold text-red-600">Loading...</p>

                                <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const durationHours = {{ $order->duration ?? 4 }};
                                    const duration = durationHours * 60 * 60; // in seconds

                                    const startTime = {{ \Carbon\Carbon::parse($creditsUsage->created_at)->timestamp }};
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

                                        countdownEl.textContent =
                                            `${isNegative ? '-' : ''}${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;

                                        // Change color if overdue
                                        countdownEl.classList.toggle("text-red-600", isNegative);
                                        countdownEl.classList.toggle("text-gray-700", !isNegative);

                                        setTimeout(updateCountdown, 1000);
                                    }

                                    updateCountdown();
                                });

                                </script>  
                            @else
                                <p>{{ $order->duration }} Hrs</p>
                            @endif
                    @else
                         <p>{{ $order->duration }} Hrs</p>
                     @endif  
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Completed At</p>
                    <p>{{$order->completed_at ?? '-'}}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Preferred Colors</p>
                    <p>{{$order->colors}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Size</p>
                    <p>{{$order->size}}</p>
                </div>
                
                {{-- <div>
                    <p class="text-sm text-gray-500 mb-1">Rush Request</p>
                    @if($order->rush === 1)
                    <span class="inline-block px-3 py-1 text-white text-xs font-semibold rounded-full bg-red-600">Yes</span>
                    @else
                    <span class="inline-block px-3 py-1 text-white text-xs font-semibold rounded-full bg-red-600">No</span>
                    @endif
                </div> --}}
                <div>
                    <p class="text-sm text-gray-500 mb-1">Assigned To</p>
                    <p>{{$admins->where('id', $order->assigned_to)->first()->name ?? 'Unknown'}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Create By</p>
                    <p>{{$subscribers->where('id', $order->created_by)->first()->name}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pre Approve</p>
                    <p>{{$order->pre_approve}}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Credits Total</p>
                    <p>{{$creditsUsage->credits_used ?? 'N/A'}}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Credits Status</p>
                    <p>{{$creditsUsage->status ?? 'N/A'}}</p>
                </div>

                @php
                $projectZip = \App\Models\Projectzip::where('order_id', $order->id)
                            ->where('job_id', $order->order_id)
                            ->first();
                @endphp
                <div>
                    <p class="text-sm text-gray-500 mb-1">Download Files</p>
                
                    @if ($projectZip)
                        <div class="mb-2 text-green-700">✔️ File already uploaded.</div>
                        <a href="{{ route('projectzips.download', $projectZip->id) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block">
                            ⬇️ Download ZIP
                        </a>
                    @else
                        <div class="mb-2 text-yellow-600">⚠️ No file uploaded yet.</div>
                    @endif
                
                    <!-- Upload Form -->
                    <form action="{{ route('projects.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="job_id" value="{{ $order->order_id }}">
                        
                        <input type="file" name="project_zip" id="project_zip" accept=".zip" required
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700">
                            {{ $projectZip ? 'Replace File' : 'Upload' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Output Formats -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Output Formats</h4>
                <div class="flex flex-wrap gap-2 mt-1">
                    {{-- @php
                    $formats = json_decode($order->formats);
                @endphp
                
                @if(is_array($formats))
                    @foreach($formats as $format)
                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $format }}
                        </span>
                    @endforeach
                @endif --}}

                <p>{{$order->formats ?? '-'}}</p>
                
                </div>
            </div>

            <!-- Instructions -->
            @if (empty($order->admin_notes))
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 mb-1">Instructions</h4>
                    <div class="mt-2 p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 whitespace-pre-line">
                        {{ $order->instructions }}
                    </div>
                </div>
            @endif

            @if (!empty($order->admin_notes))
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 mb-1">Admin Notes</h4>
                    <div class="mt-2 p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 whitespace-pre-line">
                        {{ $order->admin_notes }}
                    </div>
                </div>
            @endif

            
        </div>

                <!-- Work Preview + Chat Section -->
                <div class="mx-auto flex w-full gap-4">
                    <!-- Annotation Tool - 70% -->
                    <div class="w-full md:w-[70%]">
                        <h1 class="text-xl font-semibold mb-2">Image Annotation Tool</h1>
                        <button id="viewPreviewsBtn" class="mb-4 bg-blue-600 text-white px-4 py-1 rounded">View all previews</button>
                
                        <!-- Modal -->
                        <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
                            <div class="bg-white p-6 m-25 mx-auto max-w-4xl rounded-lg relative">
                                <span id="closePreviewModal" class="absolute top-2 right-4 text-2xl cursor-pointer">&times;</span>
                                <div id="previewCardsContainer" class="flex flex-wrap gap-4"></div>
                            </div>
                        </div>
                
                        <div class="controls mb-4 space-y-2">
                            <input type="file" id="fileInput" accept="image/*">
                            <div class="input-group hidden">
                                <input type="hidden" id="orderIdInput" value="{{ $order->id }}">
                                <input type="hidden" id="jobIdInput" value="{{ $order->order_id }}">
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button id="drawCircleBtn" class="btn">Draw Circle</button>
                                <button id="addTextBtn" class="btn">Add Text</button>
                                <button id="eraseBtn" class="btn">Erase</button>
                                <button id="removeAllBtn" class="btn">Remove All</button>
                                <button id="submitBtn" class="btn btn-primary">Submit Annotations</button>
                            </div>
                        </div>
                
                        <div class="container flex flex-col md:flex-row gap-6">
                            <div class="image-section relative w-full">
                                <div id="imagePreview" class="relative">
                                    <img id="uploadedImage" class="w-full hidden">
                                    <canvas id="annotationCanvas" class="absolute top-0 left-0 hidden"></canvas>
                                </div>
                            </div>
                            <div class="annotation-list-section w-full md:w-1/3">
                                <h2 class="text-lg font-semibold mb-2">Annotations</h2>
                                <div id="annotationsList" class="space-y-1"></div>
                            </div>
                        </div>
                
                        <div class="loading-overlay hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center" id="loadingOverlay">
                            <div class="spinner border-4 border-blue-500 border-t-transparent rounded-full w-12 h-12 animate-spin"></div>
                        </div>
                    </div>
            
                </div>
            

            @php
            $images = $order->reference_files ? json_decode($order->reference_files, true) : [];
            @endphp

            <div class="mt-10">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">📝 Review Rated Reference Images</h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($images as $file)
                            <div class="image-block border rounded-xl shadow-lg p-5 bg-white hover:shadow-xl transition duration-300 space-y-4 text-center">
                                <a href="{{ asset('storage/' . $file['path']) }}" download="{{ $file['original_name'] ?? 'reference.jpg' }}">
                                    <img src="{{ asset('storage/' . $file['path']) }}"
                                         alt="Reference Image"
                                         class="mx-auto h-58 w-full object-contain border border-gray-200 rounded-md shadow-sm">
                                </a>
            
                                <p class="text-sm text-gray-700 mt-2">
                                    Name: <strong>{{ $file['original_name'] ?? 'N/A' }}</strong><br>
                                    Credits: <strong>{{ $file['credits'] ?? 'N/A' }}</strong>
                                </p>
                            </div>
                @endforeach

            </div>
            </div>

    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

$(document).ready(function () {
    // Handle "Select all as" buttons
    $('.btn-select-all').on('click', function () {
        const value = $(this).data('value');
        $('.image-block').each(function () {
            const $block = $(this);
            $block.find('input[type="radio"]').prop('checked', false); // Clear all radios
            $block.find(`input[type="radio"][value="${value}"]`).prop('checked', true); // Check selected value
            $block.find('.custom-input').val(''); // Clear custom input
        });

        // Clear global custom input
        $('.custom-credit').val('');
    });

    // Handle "Apply" custom credits
    $('.btn-apply-custom').on('click', function () {
        const customCredit = $('.custom-credit').val();
        if (customCredit && parseInt(customCredit) > 0) {
            $('.image-block').each(function () {
                const $block = $(this);
                $block.find('input[type="radio"]').prop('checked', false);
                $block.find('input[type="radio"][value="custom"]').prop('checked', true);
                $block.find('input[name^="custom_credits"]').val(customCredit);
            });
        } else {
            alert('Please enter a valid custom credit value greater than 0.');
        }
    });

    // Clear custom input if a non-custom radio is selected
    $('.image-block').on('change', 'input[type="radio"][name^="complexity"]:not([value="custom"])', function () {
        $(this).closest('.image-block').find('.custom-input').val('');
    });

    // Focus on input when custom radio is selected
    $('.image-block').on('change', 'input[type="radio"][value="custom"]', function () {
        $(this).siblings('.custom-input').focus();
    });

    // When typing in custom input, check custom radio and uncheck others
    $('.image-block').on('input', '.custom-input', function () {
        const $block = $(this).closest('.image-block');
        $block.find('input[type="radio"]').prop('checked', false);
        $(this).siblings('input[type="radio"][value="custom"]').prop('checked', true);
    });
});










////////////////////////////////////////////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('fileInput');
            const orderIdInput = document.getElementById('orderIdInput');
            const jobIdInput = document.getElementById('jobIdInput');
            const imagePreview = document.getElementById('imagePreview');
            const uploadedImage = document.getElementById('uploadedImage');
            const annotationCanvas = document.getElementById('annotationCanvas');
            const ctx = annotationCanvas.getContext('2d');
            const drawCircleBtn = document.getElementById('drawCircleBtn');
            const addTextBtn = document.getElementById('addTextBtn');
            const eraseBtn = document.getElementById('eraseBtn');
            const removeAllBtn = document.getElementById('removeAllBtn');
            const submitBtn = document.getElementById('submitBtn');
            const annotationsList = document.getElementById('annotationsList');
            const loadingOverlay = document.getElementById('loadingOverlay');

            let currentImageURL = null;
            let annotationMode = null; // 'circle', 'text', 'erase'
            let annotations = []; // Stores all annotation objects
            let isDrawing = false; // For freehand erase
            let textInputActive = false; // Prevents multiple prompts
            let markCounter = 1; // For sequential numbering of circles

            // --- Canvas Sizing and Image Loading ---
            function updateCanvasSize() {
                // Ensure canvas matches the displayed image's dimensions
                if (uploadedImage.offsetWidth > 0 && uploadedImage.offsetHeight > 0) {
                    annotationCanvas.width = uploadedImage.offsetWidth;
                    annotationCanvas.height = uploadedImage.offsetHeight;
                }
            }

            function displayImage() {
                if (currentImageURL) {
                    uploadedImage.src = currentImageURL;
                    uploadedImage.style.display = 'block';
                    annotationCanvas.style.display = 'block';
                    uploadedImage.onload = () => {
                        // Update canvas size after image loads to ensure correct dimensions
                        updateCanvasSize();
                        redrawAnnotations(); // Redraw any existing annotations
                    };
                    // Call updateCanvasSize immediately in case image is cached and onload doesn't fire
                    updateCanvasSize();
                } else {
                    uploadedImage.style.display = 'none';
                    annotationCanvas.style.display = 'none';
                }
            }

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        currentImageURL = e.target.result; // Store the base64 data URL
                        displayImage();
                        annotations = []; // Clear annotations for new image
                        markCounter = 1; // Reset counter for new image
                        renderAnnotationsList(); // Clear the list
                    }
                    reader.readAsDataURL(file); // Read file as data URL
                } else {
                    // If no file selected, reset everything
                    currentImageURL = null;
                    displayImage();
                    annotations = [];
                    markCounter = 1;
                    renderAnnotationsList();
                }
            });

            // --- Annotation Mode Selection ---
            drawCircleBtn.addEventListener('click', () => {
                annotationMode = 'circle';
                isDrawing = false; // Disable freehand drawing
                textInputActive = false; // Ensure no prompt is active
            });

            addTextBtn.addEventListener('click', () => {
                annotationMode = 'text';
                isDrawing = false;
                textInputActive = false;
            });

            eraseBtn.addEventListener('click', () => {
                annotationMode = 'erase';
                isDrawing = true; // Enable freehand erasing
                textInputActive = false;
            });

            removeAllBtn.addEventListener('click', () => {
                annotations = []; // Clear all annotations
                markCounter = 1; // Reset counter
                redrawAnnotations(); // Clear canvas
                renderAnnotationsList(); // Clear list
            });

            // --- Canvas Interaction for Drawing/Adding ---
            annotationCanvas.addEventListener('click', function(e) {
                if (!currentImageURL) return; // Do nothing if no image is loaded

                const rect = annotationCanvas.getBoundingClientRect();
                // Calculate click coordinates relative to the canvas
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                if (annotationMode === 'circle' && !textInputActive) {
                    textInputActive = true; // Prevent multiple prompts
                    const comment = prompt("Enter comment for the circle:");
                    if (comment !== null) { // If user didn't cancel prompt
                        const newAnnotation = { id: Date.now(), type: 'circle', x: x, y: y, number: markCounter, comment: comment };
                        annotations.push(newAnnotation);
                        redrawAnnotations(); // Redraw all annotations including the new one
                        renderAnnotationsList(); // Update the list
                        markCounter++; // Increment for next circle
                    }
                    textInputActive = false;
                } else if (annotationMode === 'text' && !textInputActive) {
                    textInputActive = true;
                    const text = prompt("Enter text to add:");
                    if (text !== null) {
                        const comment = prompt("Enter comment for the text:");
                        if (comment !== null) {
                            const newAnnotation = { id: Date.now(), type: 'text', x: x, y: y, text: text, comment: comment };
                            annotations.push(newAnnotation);
                            redrawAnnotations();
                            renderAnnotationsList();
                        }
                    }
                    textInputActive = false;
                }
            });

            // --- Freehand Erase Logic ---
            annotationCanvas.addEventListener('mousedown', (e) => {
                if (currentImageURL && annotationMode === 'erase') {
                    isDrawing = true;
                    erase(e); // Start erasing immediately on mousedown
                }
            });

            annotationCanvas.addEventListener('mousemove', (e) => {
                if (currentImageURL && annotationMode === 'erase' && isDrawing) {
                    erase(e); // Continue erasing while mouse moves
                }
            });

            annotationCanvas.addEventListener('mouseup', () => {
                isDrawing = false;
                ctx.beginPath(); // End current path for erasing
            });

            annotationCanvas.addEventListener('mouseout', () => {
                isDrawing = false;
                ctx.beginPath();
            });

            function erase(e) {
                // Set composite operation to 'destination-out' to erase pixels
                ctx.globalCompositeOperation = 'destination-out';
                ctx.lineWidth = 15; // Eraser thickness
                ctx.lineCap = 'round';
                const rect = annotationCanvas.getBoundingClientRect();
                // Draw a line to erase
                ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
                ctx.stroke();
                ctx.beginPath(); // Start a new path from current point
                ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
                // Reset composite operation to default for drawing
                ctx.globalCompositeOperation = 'source-over';
                // Redraw existing annotations to ensure they are on top of the erased areas
                redrawAnnotations();
            }

            // --- Drawing Functions for Canvas ---
            function drawCircleWithNumber(x, y, number) {
                // Draw the red outline circle
                ctx.beginPath();
                ctx.arc(x, y, 12, 0, 2 * Math.PI); // Radius 12 for outline
                ctx.strokeStyle = 'red';
                ctx.lineWidth = 2;
                ctx.stroke();

                // Draw the filled red circle behind the number for better visibility
                ctx.beginPath();
                ctx.arc(x, y, 10, 0, 2 * Math.PI); // Slightly smaller radius for fill
                ctx.fillStyle = 'red';
                ctx.fill();

                // Draw the white number
                ctx.font = 'bold 10px sans-serif'; // Bold font for numbers
                ctx.fillStyle = 'white';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(number, x, y);
            }

            function drawText(text, x, y) {
                ctx.font = '16px sans-serif';
                ctx.fillStyle = 'blue';
                ctx.textAlign = 'left';
                ctx.textBaseline = 'top';
                ctx.fillText(text, x, y);
            }

            function redrawAnnotations() {
                ctx.clearRect(0, 0, annotationCanvas.width, annotationCanvas.height); // Clear entire canvas
                annotations.forEach(anno => {
                    if (anno.type === 'circle') {
                        drawCircleWithNumber(anno.x, anno.y, anno.number);
                    } else if (anno.type === 'text') {
                        // Corrected: use anno.x for x-coordinate
                        drawText(anno.text, anno.x, anno.y);
                    }
                });
            }

            // --- Annotation List Management ---
            function renderAnnotationsList() {
                annotationsList.innerHTML = ''; // Clear current list
                annotations.forEach(anno => {
                    const annotationItem = document.createElement('div');
                    annotationItem.classList.add('annotation-item');
                    let description = '';
                    if (anno.type === 'circle') {
                        description = `Circle #${anno.number}: ${anno.comment}`;
                    } else if (anno.type === 'text') {
                        description = `Text "${anno.text}": ${anno.comment}`;
                    }
                    annotationItem.textContent = description;

                    const removeButton = document.createElement('span');
                    removeButton.textContent = '❌';
                    removeButton.classList.add('remove-annotation');
                    removeButton.title = "Remove annotation";
                    removeButton.addEventListener('click', () => {
                        // Remove annotation from array
                        annotations = annotations.filter(a => a.id !== anno.id);
                        // Re-draw and re-render list
                        redrawAnnotations();
                        renderAnnotationsList();
                        // Note: Re-numbering circles after removal is complex and not implemented here.
                        // If strict sequential numbering is needed, you'd re-assign numbers to all circles
                        // after each removal and update the 'number' property in the annotations array.
                    });
                    annotationItem.appendChild(removeButton);
                    annotationsList.appendChild(annotationItem);
                });
            }

            // --- Submit Functionality ---
            submitBtn.addEventListener('click', async () => {
                if (!currentImageURL) {
                    alert("Please upload an image first.");
                    return;
                }

                const orderId = orderIdInput.value.trim(); // Get value from input
                const jobId = jobIdInput.value.trim();     // Get value from input

                if (!orderId || !jobId) {
                    alert("Please enter both Order ID and Job ID.");
                    return;
                }

                loadingOverlay.style.display = 'flex'; // Show loading spinner

                // Create a temporary canvas to merge image and annotations
                const finalCanvas = document.createElement('canvas');
                const finalCtx = finalCanvas.getContext('2d');

                // Set dimensions of the final canvas to match the original image
                const imgElement = new Image();
                imgElement.src = currentImageURL;

                imgElement.onload = async () => {
                    finalCanvas.width = imgElement.naturalWidth;
                    finalCanvas.height = imgElement.naturalHeight;

                    // Draw the original image onto the final canvas
                    finalCtx.drawImage(imgElement, 0, 0);

                    // Draw all annotations onto the final canvas (scaled to original image size)
                    // We need to calculate the scaling factor
                    const scaleX = finalCanvas.width / uploadedImage.offsetWidth;
                    const scaleY = finalCanvas.height / uploadedImage.offsetHeight;

                    annotations.forEach(anno => {
                        const scaledX = anno.x * scaleX;
                        const scaledY = anno.y * scaleY;

                        if (anno.type === 'circle') {
                            finalCtx.beginPath();
                            finalCtx.arc(scaledX, scaledY, 12 * scaleX, 0, 2 * Math.PI);
                            finalCtx.strokeStyle = 'red';
                            finalCtx.lineWidth = 2 * scaleX;
                            finalCtx.stroke();

                            finalCtx.beginPath();
                            finalCtx.arc(scaledX, scaledY, 10 * scaleX, 0, 2 * Math.PI);
                            finalCtx.fillStyle = 'red';
                            finalCtx.fill();

                            finalCtx.font = `bold ${10 * scaleX}px sans-serif`;
                            finalCtx.fillStyle = 'white';
                            finalCtx.textAlign = 'center';
                            finalCtx.textBaseline = 'middle';
                            finalCtx.fillText(anno.number, scaledX, scaledY);
                        } else if (anno.type === 'text') {
                            finalCtx.font = `${16 * scaleX}px sans-serif`;
                            finalCtx.fillStyle = 'blue';
                            finalCtx.textAlign = 'left';
                            finalCtx.textBaseline = 'top';
                            finalCtx.fillText(anno.text, scaledX, scaledY);
                        }
                    });

                    // Get the base64 data URL of the combined image
                    const markedImageDataURL = finalCanvas.toDataURL('image/jpeg', 0.9); // Quality 0.9 for JPEG

                    // Prepare data for Laravel
                    const data = {
                        order_id: orderId, // Now uses value from input field
                        job_id: jobId,     // Now uses value from input field
                        image: markedImageDataURL, // The base64 image data
                        feedbacks: JSON.stringify(annotations) // Annotations as JSON string
                    };

                    try {
                        const response = await fetch('/save-preview', { // Adjust this URL to your Laravel route
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '' // For Laravel CSRF protection
                            },
                            body: JSON.stringify(data)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            alert("Preview saved successfully!");

                            console.log("Server response:", result);
                            // You might want to clear annotations or redirect here
                            // To clear the canvas after successful save:
                            const ctx = annotationCanvas.getContext('2d');
                            if (ctx) {
                                ctx.clearRect(0, 0, annotationCanvas.width, annotationCanvas.height);
                                console.log("Annotation canvas cleared.");
                            }
                        } else {
                            alert("Error saving preview: " + (result.message || "Unknown error"));
                            console.error("Server error:", result);
                        }
                    } catch (error) {
                        console.error("Network or fetch error:", error);

                        alert("Could not connect to the server.");
                    } finally {
                        loadingOverlay.style.display = 'none'; // Hide loading spinner
                    }
                };
                imgElement.onerror = () => {
                    loadingOverlay.style.display = 'none';
                    alert("Failed to load original image for submission.");
                };
            });

            // Initial setup
            displayImage();
        }); // End DOMC






    document.getElementById("viewPreviewsBtn").addEventListener("click", function() {
    const orderId = document.getElementById("orderIdInput").value;
    const jobId = document.getElementById("jobIdInput").value;

    // Show the modal
    document.getElementById("previewModal").style.display = "block";

    // Clear any existing content
    document.getElementById("previewCardsContainer").innerHTML = "";

    // Fetch previews
    fetch(`/all-previews?order_id=${orderId}&job_id=${jobId}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                document.getElementById("previewCardsContainer").innerHTML = "<p>No previews found.</p>";
                return;
            }
data.forEach(preview => {
    const card = document.createElement('div');
    card.style = "border: 1px solid #ccc; border-radius: 8px; padding: 10px; width: 200px; margin: 10px;";

    let feedbacksHtml = "";

    try {
        const feedbacks = JSON.parse(preview.feedback);
        feedbacksHtml = feedbacks.map(fb => `
            <div style="margin-bottom: 6px;">
                <strong>#${fb.number}</strong>: ${fb.comment}
            </div>
        `).join("");
    } catch (e) {
        feedbacksHtml = "<em>Invalid feedback format</em>";
    }

    card.innerHTML = `
        <a href="/storage/${preview.image_path}" download><img src="/storage/${preview.image_path}" alt="Preview Image" style="width: 100%; border-radius: 4px;"></a>
        <p><strong>Feedback:</strong></p>
        <div style="font-size: 14px;">${feedbacksHtml}</div>
    `;

    document.getElementById("previewCardsContainer").appendChild(card);
});

        })
        .catch(err => {
            document.getElementById("previewCardsContainer").innerHTML = "<p>Error loading previews.</p>";
            console.error(err);
        });
});

// Close modal
document.getElementById("closePreviewModal").addEventListener("click", function() {
    document.getElementById("previewModal").style.display = "none";
});
</script>
</x-layout>
