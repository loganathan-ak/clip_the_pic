<x-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mt-5">
        <!-- Order Details Card -->
        <div class="bg-white shadow-xl rounded-2xl p-8 space-y-10 border border-gray-100">
            
            <!-- Back Button -->
            <div>
                <a href="" class="inline-flex items-center text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full shadow transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Orders
                </a>
            </div>

            <!-- Title -->
            <div class="border-b pb-4">
                <h1 class="text-3xl font-extrabold text-gray-800">📝 Order Summary</h1>
            </div>

            <!-- Grid Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Project Title</p>
                    <p class="text-base font-semibold">{{ $order->project_title }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Request Type</p>
                    <p class="text-base font-semibold">{{ $order->request_type ?? $order->other_request_type }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Preferred Colors</p>
                    <p>{{ $order->colors ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Size</p>
                    <p>{{ $order->size === 'Other' ? $order->other_size : $order->size }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Software</p>
                    <p>{{ $order->software === 'Other' ? $order->other_software : $order->software }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Pre-approved Credits</p>
                    <p>{{ $order->pre_approve ?? '0' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Rush Request</p>
                    <span class="inline-block px-3 py-1 text-white text-xs font-semibold rounded-full
                        {{ $order->rush ? 'bg-red-600' : 'bg-gray-400' }}">
                        {{ $order->rush ? 'Yes' : 'No' }}
                    </span>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Brand Profile</p>
                    <p class="font-semibold">{{ optional($order->brandProfile)->brand_name ?? 'Not Linked' }}</p>
                </div>
            </div>

            <!-- Output Formats -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Output Formats</h4>
                @php $formats = explode(',', $order->formats); @endphp
                <div class="flex flex-wrap gap-2 mt-1">
                    @foreach($formats as $format)
                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ trim($format) }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Instructions -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Instructions</h4>
                <div class="mt-2 p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 whitespace-pre-line">
                    {{ $order->instructions }}
                </div>
            </div>

            <!-- Reference Files -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Reference Files</h4>
                @if($order->reference_files)
                    <ul class="list-disc ml-6 mt-2 space-y-2 text-blue-600 text-sm">
                        @foreach(json_decode($order->reference_files, true) as $file)
                            <li>
                                <a href="{{ asset('storage/' . $file['path']) }}" target="_blank"
                                   class="underline hover:text-blue-800">
                                    {{ $file['original_name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No files uploaded.</p>
                @endif
            </div>
        </div>
    </div>
</x-layout>
