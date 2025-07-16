
<x-layout>
    <div class="container-fluid mt-5 pt-5 mb-5 pb-5">
      <div class="page-inner">
        <div
          class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
        >
          <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
            <h6 class="op-7 mb-2">Obeth Graphics Designer's Dashboard</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <a href="{{route('admin.suborders')}}">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                        {{-- <i class="fas fa-users"></i> --}}
                        <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                          <path fill-rule="evenodd" d="M5 4a2 2 0 0 0-2 2v1h10.968l-1.9-2.28A2 2 0 0 0 10.532 4H5ZM3 19V9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm9-8.5a1 1 0 0 1 1 1V13h1.5a1 1 0 1 1 0 2H13v1.5a1 1 0 1 1-2 0V15H9.5a1 1 0 1 1 0-2H11v-1.5a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                        </svg>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Total Projects</p>
                        <h4 class="card-title">{{$totalOrders}}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <a href="{{route('admin.dashiboardorders', 'Completed')}}">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-info bubble-shadow-small">
                        <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                          <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z" clip-rule="evenodd"/>
                        </svg>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Completed Projects</p>
                        <h4 class="card-title">{{$completedOrders ?? 0}}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <a href="{{route('admin.dashiboardorders', 'Pending')}}">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-success bubble-shadow-small">
                        {{-- <i class="fas fa-luggage-cart"></i> --}}
                        <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Pending Projects</p>
                        <h4 class="card-title">{{$pendingOrders ?? 0}}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <a href="{{route('admin.dashiboardorders', 'Quality Checking')}}">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-secondary bubble-shadow-small" >
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Quality Checking</p>
                        <h4 class="card-title">{{$rejectedOrders ?? 0}}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card card-round">
              <div class="card-header">
                <div class="grid grid-col-1">
                    <div class="card-title mb-3">Pendign & In Progress Jobs</div>   
                        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                          <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                            <tr>
                              <th class="px-4 py-3 text-left">Job id</th>
                                <th class="px-4 py-3 text-left">Project Title</th>
                                <th class="px-4 py-3 text-left">Service</th>
                                <th class="px-4 py-3 text-left">Sub-Service</th>
                                <th class="px-4 py-3 text-left">Created By</th>
                                <th class="px-4 py-3 text-left">Duration</th>
                                <th class="px-4 py-3 text-left">No.of files</th>
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
                                      <td class="px-4 py-3"><a href="{{ route('admin.vieworders', $order->id) }}" class="hover:underline">{{ $order->job_id ?? '-' }}</a></td>
                                      <td class="px-4 py-3">{{ $order->project_title ?? '-' }}</td>
                                      <td class="px-4 py-3">{{ $order->request_type ?? '-' }}</td>
                                      <td class="px-4 py-3">{{ $order->sub_services ?? '-' }}</td>
                                      <td class="px-4 py-3">{{ $users->where('id', $order->assigned_to)->first()->name ?? '-' }}</td>
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
                                          <a href="{{ route('admin.vieworders', $order->id) }}" class="text-indigo-600 hover:underline">View</a>
                                          <a href="{{ route('admin.editorders', $order->id) }}" class="text-indigo-600 hover:underline">Edit</a>
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