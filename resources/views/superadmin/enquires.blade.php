


<x-layout>
    <div class="container-fluid mt-5 pt-4 mb-5 pb-5">
      <div class="page-inner">
        <div class="page-header">
          <h3 class="fw-bold mb-3">Enquiries</h3>
          <ul class="breadcrumbs mb-3">
            <li class="nav-home">
              <a href="{{route('superadmin.dashboard')}}">
                <i class="fas fa-house"></i>
              </a>
            </li>
            <li class="separator">
              <i class="fa-solid fa-arrow-right"></i>
            </li>
            <li class="nav-item">
              <a href="{{route('superadmin.dashboard')}}">Home</a>
            </li>
            <li class="separator">
              <i class="fa-solid fa-arrow-right"></i>
            </li>
            <li class="nav-item">
              <a href="{{route('superadmin.enquires')}}">Enquiries</a>
            </li>
          </ul>
        </div>
    
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="search-sort-filter flex gap-x-2">
                  <input type="text" class="form-control" placeholder="Search name, email, number.." id="searchEnquiry">
                  <a href="{{ route('superadmin.enquires') }}" class="px-4 py-[9px] rounded-md bg-blue-500 text-white hidden" id="filter_reset">Reset</a>
                </div>
              </div>
    
              <div class="card-body">
                
              @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
              @endif
    
    
    
              <div class="overflow-x-auto mt-6">
                  <table class="min-w-full divide-y divide-gray-200 shadow-sm rounded-md border border-gray-300">
                      <thead class="bg-gray-100 text-left text-gray-700 text-sm uppercase tracking-wider">
                          <tr>
                              <th class="px-4 py-2">Name</th>
                              <th class="px-4 py-2">Email</th>
                              <th class="px-4 py-2">Phone</th>
                              <th class="px-4 py-2">Subject</th>
                              <th class="px-4 py-2">Message</th>
                              <th class="px-4 py-2">File</th>
                              <th class="px-4 py-2">Submitted At</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 text-sm text-gray-800" id="enquiry_body">
                          @forelse($enquiries as $enquiry)
                              <tr>
                                  <td class="px-4 py-2">{{ $enquiry->name }}</td>
                                  <td class="px-4 py-2">{{ $enquiry->email }}</td>
                                  <td class="px-4 py-2">{{ $enquiry->phone }}</td>
                                  <td class="px-4 py-2">{{ $enquiry->subject }}</td>
                                  <td class="px-4 py-2 max-w-xs overflow-hidden truncate" title="{{ $enquiry->message }}">
                                      {{ Str::limit($enquiry->message, 50) }}
                                  </td>
                                  <td class="px-4 py-2">
                                      @if($enquiry->file)
                                          <a href="{{ asset('storage/' . $enquiry->file) }}" target="_blank" class="text-blue-600 underline">Download</a>
                                      @else
                                          <span class="text-gray-400">No File</span>
                                      @endif
                                  </td>
                                  <td class="px-4 py-2">{{ $enquiry->created_at->format('Y-m-d') }}</td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="7" class="px-4 py-4 text-center text-gray-500">No enquiries found.</td>
                              </tr>
                          @endforelse
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