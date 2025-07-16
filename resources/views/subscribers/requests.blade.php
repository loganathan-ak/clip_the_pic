<x-layout>
  <div class="container-fluid mt-5 pt-4 mb-5 pb-5">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Jobs</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="/">
              <i class="fas fa-house"></i>
            </a>
          </li>
          <li class="separator">
            <i class="fa-solid fa-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="/">Home</a>
          </li>
          <li class="separator">
            <i class="fa-solid fa-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="/requests">Jobs</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div class="search-sort-filter" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" class="form-control" id="job_search" placeholder="Search...">
            
                <select id="status_filter" class="form-control px-3 py-2 border rounded-md">
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="Draft">Draft</option>
                    <option value="Quoted">Quoted</option>
                    <option value="Quote Approved">Quote Approved</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Quality Checking">Quality Checking</option>
                </select>
            
                <a href="{{ route('requests') }}" class="px-4 py-[9px] rounded-md bg-blue-500 text-white hidden" id="filter_reset">Reset</a>
              </div>
            

              <div class="d-flex flex-wrap gap-3">
                <div class="info-box">
                  <h6>Credits</h6>
                  <div class="box-content">
                    <div class="">
                      <strong>{{$currentUserCredits}}</strong><br><small>Total</small>
                    </div>
                  </div>
                </div>


                <div class="info-box text-center">
                  <h6>Completed Requests</h6>
                  <div class="single-value">
                    ({{ $completedOrders ?? 0 }})
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
        
                <a class="btn btn-success" href="{{ route('create.order') }}" 
                    {{-- href="{{ Auth::user()->credits == 0 ? '#' : route('create.order') }}"  --}}
                    {{-- onclick="{{ Auth::user()->credits == 0 ? 'alertNoCredits(); return false;' : '' }}" --}}
                >
                    Create New Job
                </a>
                </div>
              
              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif




              <div class="overflow-x-auto mt-6">
                <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg" >
                    <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                        <tr>
                          <th class="px-4 py-3 text-left">Job Id</th>
                            <th class="px-4 py-3 text-left">Project Title</th>
                            <th class="px-4 py-3 text-left">Service</th>
                            <th class="px-4 py-3 text-left">Size</th>
                            <th class="px-4 py-3 text-left">Duration</th>
                            <th class="px-4 py-3 text-left">Credits</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-800" id="orders_table_body">
                        @foreach($orders as $order)
                            @php
                                $statusColors = [
                                    'Pending' => 'bg-yellow-200',
                                    'Draft' => 'bg-gray-200',
                                    'Quoted' => 'bg-blue-200',
                                    'Quote Approved' => 'bg-orange-200',
                                    'In Progress' => 'bg-indigo-100',
                                    'Completed' => 'bg-green-200',
                                    'Quality Checking' => 'bg-purple-200',
                                ];
                            
                                $statusTextColors = [
                                    'Pending' => 'text-yellow-800',
                                    'Draft' => 'text-gray-700',
                                    'Quoted' => 'text-blue-800',
                                    'Quote Approved' => 'bg-orange-800',
                                    'In Progress' => 'text-indigo-800',
                                    'Completed' => 'text-green-800',
                                    'Quality Checking' => 'text-purple-800',
                                ];
                            
                                $status = $order->status ?? 'Pending';
                                $rowClass = $statusColors[$status] ?? 'bg-white';
                                $badgeTextClass = $statusTextColors[$status] ?? 'text-gray-800';
                              @endphp
                            <tr class="{{ $rowClass }}">
                                <td class="px-4 py-2"><a href="{{ route('view.order', $order->id) }}" class="hover:underline">{{ $order->order_id }}</a></td>
                                <td class="px-4 py-2">{{ $order->project_title }}</td>
                                <td class="px-4 py-2">{{ $order->request_type }}</td>
                                <td class="px-4 py-2">{{ $order->size ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    {{ $order->duration ?? 'N/A' }}hrs
                                </td>
                                <td class="px-4 py-2">                             
                                  {{$credits->where('order_id', $order->id)->first()->credits_used ?? 'N/A'}}
                                </td>

                                <td class="px-4 py-3">
                                  <span class="px-2 py-1 rounded-full text-sm font-medium capitalize {{ $badgeTextClass }} bg-white border">
                                    {{ $status === "pending" ? 'New' : $status }}
                                  </span>
                              </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('view.order', $order->id) }}" class="text-indigo-600 hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            

            </div>
          </div>
        </div>
      </div>




    </div>
  </div>
  <script>
    function alertNoCredits() {
      alert('You have no credits left. Please purchase more to create a new request.');
    }
  </script>
</x-layout>