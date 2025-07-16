


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
                <div class="search-sort-filter" style="display: flex;">
                  <input type="text" class="form-control" id="qc_list_search" placeholder="Search...">
              
                  <a href="{{ route('qc.lists') }}" class="px-4 py-[9px] rounded-md bg-blue-500 text-white hidden" id="filter_reset">Reset</a>
                </div>
    

              </div>
    
              <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
    
    
    
                <div class="overflow-x-auto mt-6">
                  <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                      <thead id="orders_table_head" class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                        <tr>
                          <th class="px-4 py-3 text-left">Job id</th>
                          <th class="px-4 py-3 text-left">Project Title</th>
                          <th class="px-4 py-3 text-left">Service</th>
                          <th class="px-4 py-3 text-left">Sub-Service</th>
                          <th class="px-4 py-3 text-left">Assigned To</th>
                          <th class="px-4 py-3 text-left">Duration</th>
                          <th class="px-4 py-3 text-left">No.of files</th>
                          <th class="px-4 py-3 text-left">Status</th>
                          <th class="px-4 py-3 text-left">Actions</th>
                      </tr>
                      </thead>
                      <tbody id="orders_table_body" class="divide-y divide-gray-200 text-sm text-gray-800">
                        @foreach($orders as $order)
                            @php
                            $statusColors = [
                                'Pending' => 'bg-yellow-200',
                                'Draft' => 'bg-gray-200',
                                'Quoted' => 'bg-blue-200',
                                'In Progress' => 'bg-indigo-100',
                                'Completed' => 'bg-green-200',
                                'Quality Checking' => 'bg-purple-200',
                            ];
                        
                            $statusTextColors = [
                                'Pending' => 'text-yellow-800',
                                'Draft' => 'text-gray-700',
                                'Quoted' => 'text-blue-800',
                                'In Progress' => 'text-indigo-800',
                                'Completed' => 'text-green-800',
                                'Quality Checking' => 'text-purple-800',
                            ];
                        
                            $status = $order->status ?? 'Pending';
                            $rowClass = $statusColors[$status] ?? 'bg-white';
                            $badgeTextClass = $statusTextColors[$status] ?? 'text-gray-800';
                          @endphp
                        
                              <tr class="{{ $rowClass }}">
                                  <td class="px-4 py-2"><a href="{{ route('qc.view', $order->id) }}" class="hover:underline">{{ $order->job_id }}</a></td>
                                  <td class="px-4 py-2">{{ $order->project_title }}</td>
                                  <td class="px-4 py-2">{{ $order->request_type }}</td>
                                  <td class="px-4 py-2">{{ $order->sub_services }}</td>
                                  <td class="px-4 py-2">{{ \App\Models\User::find($order->assigned_to)->name ?? 'N/A' }}</td>
                                  <td class="px-4 py-3">{{ $order->duration ?? '-' }}Hrs</td>
                                  @php
                                      $referenceFiles = json_decode($order->reference_files, true);
                                      $referenceCount = is_array($referenceFiles) ? count($referenceFiles) : 0;
                                  @endphp

                                  <td class="px-4 py-3">{{ $referenceCount }} File{{ $referenceCount !== 1 ? 's' : '' }}</td>
                                  <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-sm font-medium capitalize {{ $badgeTextClass }} bg-white border">
                                      {{ $status === "pending" ? 'New' : $status }}
                                    </span>
                                </td>
                                  <td class="px-4 py-2 flex gap-3">
                                      <a href="{{ route('qc.view', $order->id) }}" class="text-indigo-600 hover:underline">View</a>
                                      <a href="{{ route('qc.ordersedit', $order->id) }}" class="text-indigo-600 hover:underline">Edit</a>
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
</x-layout>