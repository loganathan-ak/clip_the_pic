<x-layout>
    <div class="max-w-3xl mx-auto mt-25 bg-white p-10 rounded-2xl shadow-xl border border-gray-100"> {{-- Increased margin-top, padding, roundedness, and shadow for a premium feel --}}
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Plan Details</h2> {{-- Larger, bolder, centered title with more bottom margin --}}
        <div class="flex justify-end mb-3">
              {{-- Delete Plan Form --}}
              <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-600 px-6 mb-10 py-2.5 rounded hover:bg-red-700 hover:text-white shadow-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    Delete Plan
                </button>
            </form>
        </div>
        <form action="{{ route('plans.edit', $plan->id) }}" method="POST"> {{-- Changed route to 'update' for PUT method --}}
            @csrf
            @method('PUT')

            <div class="mb-5"> {{-- Slightly more margin-bottom for better spacing --}}
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label> {{-- Added margin-bottom to label --}}
                <input type="text" id="name" name="name" value="{{ old('name', $plan->name) }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out placeholder-gray-400"> {{-- Added padding, border, transition, and a placeholder --}}
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror {{-- Slightly darker red for error messages --}}
            </div>

            <div class="mb-5">
                <label for="credits" class="block text-sm font-medium text-gray-700 mb-1">Credits</label>
                <input type="number" id="credits" name="credits" value="{{ old('credits', $plan->credits) }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out placeholder-gray-400">
                @error('credits') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (USD)</label>
                <input type="text" id="price" name="price" value="{{ old('price', $plan->price) }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out placeholder-gray-400">
                @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6"> {{-- Increased margin-bottom for text area --}}
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="e.g., More value for your money&#10;* Feature 1&#10;* Feature 2"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out placeholder-gray-400">{{ old('description', $plan->description) }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8"> {{-- More margin-bottom for the checkbox --}}
                <label for="is_active" class="inline-flex items-center cursor-pointer"> {{-- Added cursor-pointer for better UX --}}
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                        class="rounded text-indigo-600 border-gray-300 shadow-sm focus:ring-indigo-500 h-5 w-5"> {{-- Slightly larger checkbox --}}
                    <span class="ml-2 text-base text-gray-700">Set as Active Plan</span> {{-- Slightly larger text for checkbox label, more descriptive --}}
                </label>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-100"> {{-- Added top padding, border for separation, and ensured items are centered --}}
                <a href="{{ route('plans.list') }}" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out flex items-center group"> {{-- Added hover effect and aligned text with an optional icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500 group-hover:text-gray-700 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Plans
                </a>
                <div class="flex items-center space-x-4"> {{-- Container for Update and Delete buttons --}}
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 shadow-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        Update Plan
                    </button>
                </div>
            </div>
        </form>
                          
    </div>
</x-layout>