<x-layout>
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
                    <p class="text-sm text-gray-500 mb-1">Request Type</p>
                    <p class="text-base font-semibold">{{$order->request_type}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Preferred Colors</p>
                    <p>{{$order->colors}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Size</p>
                    <p>{{$order->size}}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Assigned To</p>
                    <p>{{$admins->where('id', $order->assigned_to)->first()->name ?? 'Unknown'}}</p>
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

            </div>

            <!-- Output Formats -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Output Formats</h4>
                <div class="flex flex-wrap gap-2 mt-1">
                @php
                    $formats = json_decode($order->formats);
                @endphp
                
                @if(is_array($formats))
                    @foreach($formats as $format)
                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $format }}
                        </span>
                    @endforeach
                @endif
                
                </div>

                
            </div>

            <!-- Instructions -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 mb-1">Instructions</h4>
                <div class="mt-2 p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 whitespace-pre-line">
                    {{$order->instructions}}
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
                        <a href="{{ asset('storage/' . $file['path']) }}" download="reference.jpg">
                            <img src="{{ asset('storage/' . $file['path']) }}"
                                alt="Reference Image"
                                class="mx-auto h-58 w-full object-contain border border-gray-200 rounded-md shadow-sm">
                        </a>

                        <p class="text-sm text-gray-700 mt-2">
                            Name: <strong>{{ $file['original_name'] }}</strong>
                        </p>
                    </div>
                @endforeach

            </div>
    </div>



        </div>
    </div>
</x-layout>
