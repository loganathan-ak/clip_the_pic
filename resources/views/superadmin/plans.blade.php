<x-layout>
    <div class="container-fluid mt-8 pt-6 mb-8 pb-8"> {{-- Increased top and bottom padding/margin for more breathing room --}}
        <div class="page-inner max-w-8xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Added max-width and horizontal padding for better content containment --}}
            <div class="page-header flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8"> {{-- Adjusted for better responsiveness and spacing --}}
                <div class="mb-4 sm:mb-0">
                    <h3 class="fw-bold text-4xl text-gray-900 mb-2">Plans Overview</h3> {{-- Larger, bolder heading with improved color and margin --}}
                    <ul class="breadcrumbs flex items-center space-x-2 text-gray-600 text-sm"> {{-- Used flexbox for breadcrumbs, improved spacing --}}
                        <li class="nav-home">
                            <a href="/" class="hover:text-indigo-600 transition-colors duration-200"><i class="fas fa-house text-lg"></i></a> {{-- Larger icon, added hover effect --}}
                        </li>
                        <li class="separator"><i class="fa-solid fa-chevron-right text-xs"></i></li> {{-- Changed separator icon, smaller size --}}
                        <li class="nav-item"><a href="/" class="hover:text-indigo-600 transition-colors duration-200">Home</a></li>
                        <li class="separator"><i class="fa-solid fa-chevron-right text-xs"></i></li>
                        <li class="nav-item"><a href="{{route('plans.list')}}" class="hover:text-indigo-600 transition-colors duration-200 font-medium">Plans</a></li> {{-- Added font-medium to current page --}}
                    </ul>
                </div>
                <div>
                    <a href="{{ route('plans.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150"> {{-- More prominent button with better padding, shadow, and focus styles --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Plan
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mt-6"> {{-- Increased gap, added xl column for larger screens --}}
                @forelse ($plans as $plan)
                    <div class="bg-white shadow-xl rounded-2xl p-7 border border-gray-100 flex flex-col justify-between transform hover:scale-105 transition-all duration-300 ease-in-out"> {{-- Stronger shadow, more padding, added flex column for content alignment, and an appealing hover effect --}}
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800 mb-2">{{ $plan->name }}</h4> {{-- Larger, bolder plan name --}}
                            <p class="whitespace-pre-line text-gray-600 text-sm mb-4 leading-relaxed"> {{-- Adjusted text color, size, and line height for description --}}
                                {{ $plan->description ?? 'No description provided for this plan.'}}
                            </p>
                        </div>
                        <div class="mt-auto"> {{-- Pushes the following elements to the bottom --}}
                            <div class="text-xl font-extrabold text-indigo-700 mb-1">{{ $plan->credits }} Credits</div> {{-- Bolder credit display --}}
                            <div class="text-xl text-green-600 font-semibold mb-4">${{ number_format($plan->price, 2) }}</div> {{-- Larger price, consistent green color --}}
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-4"> {{-- Added top border for separation --}}
                                <span class="text-sm font-medium px-3 py-1 rounded-full {{ $plan->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"> {{-- Pill-style active/inactive status --}}
                                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <a href="{{ route('plans.edit', $plan->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200 flex items-center group"> {{-- Improved hover, added group for SVG hover --}}
                                    Edit
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 text-indigo-500 group-hover:text-indigo-700 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white shadow-lg rounded-2xl p-8 text-center border border-gray-200"> {{-- Styled empty state message --}}
                        <p class="text-gray-500 text-lg">No plans have been created yet.</p>
                        <a href="{{ route('plans.create') }}" class="mt-6 inline-flex items-center px-5 py-2.5 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            Create Your First Plan
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>