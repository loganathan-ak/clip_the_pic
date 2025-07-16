<x-layout>
    <div class="max-w-7xl mx-auto mt-20 py-16 px-4 sm:px-6 lg:px-8 "> {{-- Increased vertical padding and max-width for a more spacious feel --}}
        <h2 class="text-5xl font-extrabold text-center mb-10 text-gray-900 leading-tight"> {{-- Larger, bolder, and darker heading with increased bottom margin --}}
            Choose the Perfect Plan for You
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 items-stretch"> {{-- Increased gap and ensured items stretch to the same height --}}
            @foreach ($plans as $index => $plan)
                <div class="relative bg-white rounded-3xl shadow-xl p-10 flex flex-col justify-between border-2 transform hover:scale-105 transition-all duration-300 ease-in-out {{ $index === 1 ? 'border-blue-600 shadow-2xl ring-4 ring-blue-200' : 'border-gray-200' }}"> {{-- More rounded corners, stronger shadow, thicker border, added ring for popular plan, and smoother transition --}}

                    @if ($index === 1)
                        <span class="absolute top-6 right-6 bg-blue-600 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-md transform rotate-3 origin-top-right"> {{-- Slightly larger, more pronounced tag with a subtle rotation and shadow --}}
                            ⭐ Most Popular
                        </span>
                    @endif

                    <div class="text-center">
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ $plan->name }}</h3> {{-- Larger, bolder plan name --}}
                        <p class="text-6xl font-extrabold text-blue-600 mb-6 leading-none">${{ number_format($plan->price, 2) }}</p> {{-- Even larger price with boldest font, tighter line height --}}
                        <p class="text-gray-700 text-xl mb-4">{{ $plan->credits }} Credits</p> {{-- Larger text for credits --}}
                        <div class="whitespace-pre-line text-gray-600 text-base mb-8 leading-relaxed"> {{-- Adjusted text color, size, and line height for description --}}
                            {{ $plan->description ?? 'No detailed description available for this plan.'}}
                        </div>
                    </div>

                    <form method="POST" action="{{route('paypal.create')}}" class="mt-auto"> {{-- Ensures the button is at the bottom --}}
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75 shadow-lg"> {{-- More prominent button with stronger hover and focus effects, and a shadow --}}
                            Get Started
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Optional: Add a section for FAQs or contact --}}
        <div class="text-center mt-20 text-gray-600">
            <p>Have questions about our plans? <a href="#" class="text-blue-600 hover:underline font-medium">Contact our support team</a>.</p>
        </div>
    </div>
</x-layout>