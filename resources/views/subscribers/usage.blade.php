<x-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8"> {{-- Adjusted padding and max-width for overall page content --}}
      <div class="page-inner">
          {{-- Page Header / Breadcrumbs --}}
          <div class="page-header flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8"> {{-- Improved responsiveness for header --}}
              <div class="mb-4 sm:mb-0">
                  <h3 class="fw-bold text-4xl text-gray-900 mb-2">Usage Overview</h3> {{-- Larger, bolder heading --}}
                  <ul class="breadcrumbs flex items-center space-x-2 text-gray-600 text-sm">
                      <li class="nav-home">
                          <a href="/" class="hover:text-indigo-600 transition-colors duration-200"><i class="fas fa-home text-lg"></i></a>
                      </li>
                      <li class="separator"><i class="fa-solid fa-chevron-right text-xs"></i></li>
                      <li class="nav-item"><a href="/" class="hover:text-indigo-600 transition-colors duration-200">Home</a></li>
                      <li class="separator"><i class="fa-solid fa-chevron-right text-xs"></i></li>
                      <li class="nav-item"><a href="/usage" class="hover:text-indigo-600 transition-colors duration-200 font-medium">Usage</a></li>
                  </ul>
              </div>
          </div>

          {{-- Date Filter Section --}}
          <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100"> {{-- Card styling for the filter --}}
              <h4 class="text-xl font-semibold text-gray-800 mb-5">Filter Usage History</h4>
              <form method="GET" action="{{ route('usage') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 items-end"> {{-- Responsive grid for filter inputs --}}
                  <div>
                      <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                      <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}"
                          class="p-2 bg-white w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                  </div>

                  <div>
                      <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                      <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}"
                          class="p-2 bg-white w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                  </div>

                  <div>
                      <button type="submit"
                          class="w-full bg-indigo-600 text-white px-4 py-2.5 rounded-md hover:bg-indigo-700 transition duration-200 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                          Apply Filter
                      </button>
                  </div>

                  <div>
                      <a href="{{ route('usage') }}"
                          class="w-full inline-flex justify-center items-center bg-gray-200 text-gray-800 px-4 py-2.5 rounded-md hover:bg-gray-300 transition duration-200 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                          Reset Filters
                      </a>
                  </div>
              </form>
          </div>

          {{-- Statistics Cards --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8"> {{-- Grid for 2 stats cards --}}
              <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center justify-center border border-gray-100 text-center">
                  <p class="text-gray-500 text-sm mb-1">Total Credits Used</p>
                  <p class="text-4xl font-extrabold text-blue-600">{{ $usages->sum('credits_used') ?? '0' }}</p>
              </div>
              <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center justify-center border border-gray-100 text-center">
                  <p class="text-gray-500 text-sm mb-1">Total Orders</p>
                  <p class="text-4xl font-extrabold text-green-600">{{ $usages->count() }}</p>
              </div>
          </div>

          {{-- Order Summary Section --}}
          <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Your Order History</h3> {{-- Specific heading for orders --}}

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6"> {{-- Main grid for order cards, 2 per row on large screens --}}
              @forelse($usages as $usage)
                  @php
                      $order = $orders->where('id', $usage->order_id)->first();
                      $status = strtolower($order->status ?? 'unknown'); // Default to 'unknown'
                      $statusClass = match($status) {
                          'completed' => 'bg-green-100 text-green-800',
                          'in progress' => 'bg-yellow-100 text-yellow-800',
                          'quality checking' => 'bg-blue-100 text-blue-800',
                          'rejected' => 'bg-red-100 text-red-800',
                          default => 'bg-gray-100 text-gray-800',
                      };
                  @endphp

                  @if($order)
                      <div class="order-card bg-white rounded-xl shadow-md p-6 border border-gray-100 flex flex-col transform hover:scale-103 transition-transform duration-300 ease-in-out"> {{-- Card styling and hover effect --}}
                          <div class="flex justify-between items-start mb-3">
                              <h4 class="text-lg font-bold text-gray-900">
                                  Job ID #{{ $usage->job_id ?? $order->id }}
                              </h4>
                              <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}"> {{-- Pill-style status --}}
                                  {{ ucfirst($order->status) }}
                              </span>
                          </div>

                          <p class="text-gray-700 text-base mb-2">
                              <span class="font-semibold">{{ $order->project_title }}</span>
                          </p>
                          <p class="text-gray-500 text-sm mb-4">
                              Created On: {{ $usage->created_at->format('F j, Y \a\t h:i A') }} {{-- Created Date display --}}
                          </p>

                          <div class="border-t border-gray-100 pt-4 mt-auto"> {{-- Push to bottom --}}
                              <p class="text-md text-gray-800 mb-3">
                                  <span class="font-semibold">Credits Used:</span> <span class="text-indigo-600 font-bold">{{ $usage->credits_used }}</span>
                              </p>
                              <a href="{{ route('view.order', $order->id) }}"
                                  class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition duration-200 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-.758l3.68-3.68m0 0l3.708-3.708m-2.922 2.922a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.102 1.101m-.758.758l-3.68 3.68" />
                                  </svg>
                                  View Project
                              </a>
                          </div>
                      </div>
                  @endif
              @empty
                  <div class="col-span-full bg-white rounded-xl shadow-lg p-8 text-center border border-gray-100">
                      <p class="text-gray-500 text-lg mb-4">No usage data found for the selected period.</p>
                      <a href="{{ route('usage') }}"
                          class="inline-flex items-center px-5 py-2.5 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                          Reset Filters to See All Usage
                      </a>
                  </div>
              @endforelse
          </div>
      </div>
  </div>
</x-layout>