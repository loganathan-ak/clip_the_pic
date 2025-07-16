<x-layout>
    <div class="w-full mx-auto py-10 px-6 mt-5">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 mt-5">📋 Customers List</h2>
  
        <form method="GET" action="{{ route('superadmin.subscribers') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
          <!-- User Filter -->
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Subscriber</label>
              <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm p-3 bg-white">
                  <option value="">All Subscribers</option>
                  @foreach($users as $user)
                      <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                          {{ $user->name }}
                      </option>
                  @endforeach
              </select>
          </div>
      
          <!-- From Date -->
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
              <input type="date" name="from_date" value="{{ request('from_date') }}"
                     class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm">
          </div>
      
          <!-- To Date -->
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
              <input type="date" name="to_date" value="{{ request('to_date') }}"
                     class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm">
          </div>
      
          <!-- Actions -->
          <div class="flex flex-col gap-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Actions</label>
              <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                  Filter
              </button>
              <a href="{{ route('superadmin.subscribers') }}"
                 class="w-full inline-block text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400">
                  Reset
              </a>
          </div>
      </form>
      
  
        <div class="card-header d-flex justify-content-between align-items-center mb-2">
          {{-- <div class="search-sort-filter flex gap-x-2">
            <input type="text" class="form-control" placeholder="Search name, email, number.." id="userSearch">
            <a href="{{ route('superadmin.subscribers') }}" class="px-4 py-[9px] rounded-md bg-blue-500 text-white hidden" id="filter_reset">Reset</a>
          </div> --}}
          <div>
              <button onclick="exportTableToExcel('myTable')" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v8m0 0l-3-3m3 3l3-3m-6 5h6a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v6" />
                  </svg>
                  Export
              </button>
  
          </div>
        </div>
  
        <!-- Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <!-- Add horizontal scroll -->
          <div class="overflow-x-auto max-w-full">
              <!-- Optional: Limit vertical height -->
              <div class="max-h-[600px] overflow-y-auto">
                  <table class="w-full table-auto" id="myTable">
                      <thead class="bg-gray-100 text-gray-700">
                          <tr class="">
                              <th class="px-4 py-3 text-left text-sm">S.No</th>
                              <th class="px-4 py-3 text-left text-sm">Name</th>
                              <th class="px-4 py-3 text-left text-sm">Mobile</th>
                              <th class="px-4 py-3 text-left text-sm">Email</th>
                              <th class="px-4 py-3 text-left text-sm">Avl.credits</th>
                              <th class="px-4 py-3 text-left text-sm">Joined</th>
                          </tr>
                      </thead>
                      <tbody class="text-gray-700 divide-y" id="subscriber_body">
                          @forelse($subscribers as $subscriber)
                              <tr>
                                  <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                  <td class="px-4 py-2">{{ $subscriber->name }}</td>
                                  <td class="px-4 py-2">{{ $subscriber->mobile }}</td>
                                  <td class="px-4 py-2">{{ $subscriber->email }}</td>
                                  <td class="px-4 py-2">{{ $subscriber->credits }}</td>
                                  <td class="px-4 py-2">{{ $subscriber->created_at->format('d M, Y') }}</td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="12" class="px-4 py-4 text-center text-gray-500">
                                      No subscribers found.
                                  </td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      
          <!-- Pagination -->
          <div class="p-4">
              {{-- Your pagination links go here --}}
          </div>
      </div>
      
    </div>
  
      <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script>
  
      function exportTableToExcel(tableId, filename = 'table_data.xlsx') {
          const table = document.getElementById(tableId);
          if (!table) {
              console.error('Table not found with ID:', tableId);
              return;
          }
  
          const ws = XLSX.utils.table_to_sheet(table);
          const wb = XLSX.utils.book_new();
          XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
          XLSX.writeFile(wb, filename);
      }
  
  
      function toggleFullText(element) {
          
          const shortText = element.querySelector('.short-text');
          const fullText = element.querySelector('.full-text');
  
          if (shortText.classList.contains('hidden')) {
              shortText.classList.remove('hidden');
              fullText.classList.add('hidden');
          } else {
              shortText.classList.add('hidden');
              fullText.classList.remove('hidden');
          }
      }
      
      </script>
  </x-layout>
  