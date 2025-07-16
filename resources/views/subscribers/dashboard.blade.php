
<x-layout>
  <script src="https://cdn.scaleflex.it/filerobot/js-transform/v3/filerobot-image-editor.min.js"></script>

        <div class="container-fluid mt-5 pt-5 mb-5 pb-5">
          <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Obeth Graphics Subscribers Dashboard</h6>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="grid grid-cols-2 col-span-2 gap-x-5">
                    <div>
                      <div class="card card-stats card-round">
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
                                <p class="card-category">Requests</p>
                                <h4 class="card-title">{{$ordersCount}}</h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="card card-stats card-round">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col-icon">
                              <div
                                class="icon-big text-center icon-info bubble-shadow-small"
                              >
                                {{-- <i class="fas fa-user-check"></i> --}}
                                <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                  <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z" clip-rule="evenodd"/>
                                </svg>
                                
                              </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                              <div class="numbers">
                                <p class="card-category">Brands</p>
                                <h4 class="card-title">{{$brandsCount}} / 10</h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div >
                      <div class="card card-stats card-round">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col-icon">
                              <div
                                class="icon-big text-center icon-success bubble-shadow-small"
                              >
                                {{-- <i class="fas fa-luggage-cart"></i> --}}
                                <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                                </svg>
                                
                              </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                              <div class="numbers">
                                <p class="card-category">Credits Points</p>
                                <h4 class="card-title">{{$currentUserCredits}}</h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="card card-stats card-round">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col-icon">
                              <div
                                class="icon-big text-center icon-secondary bubble-shadow-small"
                              >
                                <i class="far fa-check-circle"></i>
                              </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                              <div class="numbers">
                                <p class="card-category">Completed Projects</p>
                                <h4 class="card-title">{{$completedProjects}}</h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="grid overflow-x-auto">
                  <div class="card card-round ">
                    <div class="card-header">
                      <div class="card-head-row card-tools-still-right flex justify-between">
                        <div class="card-title">Transaction History</div>
                        <a href="{{route('billing')}}">View all</a>
                      </div>
                    </div>
                    <div class="card-body p-0">
                      <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0 min-w-4xl">
                          <thead class="thead-light">
                            <tr>
                              <th scope="col">Payment Number</th>
                              <th scope="col" class="text-end">Date & Time</th>
                              <th scope="col" class="text-end">Amount</th>
                              <th scope="col" class="text-end">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                              <th scope="row">
                                <button
                                  class="btn btn-icon btn-round btn-success btn-sm me-2"
                                >
                                  <i class="fa fa-check"></i>
                                </button>
                                {{$transaction->transaction_id}}
                              </th>
                              <td class="text-end">{{$transaction->created_at}}</td>
                              <td class="text-end">${{$transaction->amount_paid}}</td>
                              <td class="text-end">
                                <span class="badge badge-success">Completed</span>
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
            <div class="row ">
              <!-- Left: Table (8 columns) -->
              <div class="col-md-9 mb-5 bg-white pt-3 pb-3">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <a 
                      class="btn btn-success" 
                      href="{{ Auth::user()->credits == 0 ? '#' : route('create.order') }}" 
                      onclick="{{ Auth::user()->credits == 0 ? 'alertNoCredits(); return false;' : '' }}"
                    >
                      Create New Job
                    </a>
                  </div>
            
                  @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                  @endif
            
                  <div class="overflow-x-auto mt-6">
                    <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                      <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                        <tr>
                          <th class="px-4 py-3 text-left">S.No</th>
                          <th class="px-4 py-3 text-left">Date</th>
                          <th class="px-4 py-3 text-left">Order ID</th>
                          <th class="px-4 py-3 text-left">Project Title</th>
                          <th class="px-4 py-3 text-left">Request Type</th>
                          <th class="px-4 py-3 text-left">Duration</th>
                          <th class="px-4 py-3 text-left">Status</th>
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
                          <tr onclick="window.location='{{ route('view.order', $order->id) }}';"  
                            class="{{ $rowClass }}">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $order->order_id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $order->project_title }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $order->request_type }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $order->duration }}hrs</td>
                            <td class="px-4 py-3">
                              <span class="px-2 py-1 rounded-full text-sm font-medium capitalize {{ $badgeTextClass }} bg-white border">
                                {{ $status === "pending" ? 'New' : $status }}
                              </span>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  
                </div>
              </div>
            
              <!-- Right: Chart (2 columns) -->
              <div class="col-md-3">
                <div class="card card-round h-100">
                  <div class="card-header">
                    <div class="card-head-row">
                      <div class="card-title">Projects Statistics</div>
                    </div>
                  </div>
                  <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="myChart" style="max-width: 100%; height: auto;"></canvas>
                  </div>
                </div>
              </div>
            </div>
            



            <div id="editor_container"></div>



          </div>
        </div>
 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const data = {
    labels: ['Completed', 'In Progress', 'Pending', 'Quality Checking'],
    datasets: [{
      label: 'Order Status',
      data: [{{ $completed }}, {{ $inProgress }}, {{ $pending }}, {{$qualityChecking}}],
      backgroundColor: ['#05e841', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(3 120 207)'],
      hoverOffset: 6
    }]
  };

  const config = {
    type: 'doughnut',
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Order Status Overview'
        }
      }
    },
  };

  const ctx = document.getElementById('myChart').getContext('2d');
  new Chart(ctx, config);
        </script>
      </x-layout>