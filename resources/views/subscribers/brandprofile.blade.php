

<x-layout>
 <div class="container-fluid mt-5 pt-4 mb-5 pb-5">
          <div class="page-inner">
          <div class="page-header">
      <h3 class="fw-bold mb-3">Brand Profile</h3>
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
          <a href="/brandprofile">Brand Profile</a>
        </li>
      </ul>
    </div>

  <div class="card cards">
 
  <div class="card-header d-flex justify-content-between align-items-center">
            <div class="search-sort-filter gap-2" style="display: flex;">
              <input type="text" class="form-control" id="brand_search" placeholder="Brand name....">
              <a href="{{route('brandprofile')}}" class="px-4 py-[9px] rounded-md bg-blue-500 text-white hidden" id="filter_reset">Reset</a>
            </div>


            <div class="top-bar">

            <div class="info-box me-3">
                <h6>Profile</h6>
                <div class="box-content">
                  <div class="half">
                    <strong>{{$count}}</strong><br><small>Added</small>
                  </div>
                  <div class="half">
                    <strong>10</strong><br><small>Total</small>
                  </div>
                </div>
              </div>

   
  
            @if ($count < 10)
              <a href="{{ route('addbrand') }}">
                <button class="add-btn">
                  <i class="fas fa-plus"></i> Add New Brand
                </button>
              </a>
            @else
              <button class="add-btn opacity-50 cursor-not-allowed" id="disable_btn" >
                <i class="fas fa-plus"></i> Add New Brand
              </button>
            @endif
            
  </div>

  </div>

@if(session('success'))
  <div class="mb-2 p-3 text-green-800 border-l-4 border-green-800 shadow-xs">
      {{ session('success') }}
  </div>
@elseif(session('deleted'))
  <div class="mb-2 p-3 text-red-800 border-l-4 border-red-800 shadow-xs">
      {{ session('deleted') }}
  </div>
@elseif(session('alert'))
  <div class="mb-2 p-3 text-red-800 border-l-4 border-red-800 shadow-xs">
      {{ session('alert') }}
  </div>
@endif

<div class="overflow-x-auto mt-2 p-3">

    <table class="min-w-full bg-white border border-gray-200 text-sm rounded-md table-auto">
        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr>
                <th class="p-3 text-left">Date</th>
                <th class="p-3 text-left">Brand</th>
                <th class="p-3 text-left">Industry</th>
                <th class="p-3 text-left">Website</th>
                <th class="p-3 text-left">Audience</th>
                <th class="p-3 text-left">Description</th>
                <th class="p-3 text-left">Logo</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-800" id="brands_table_body">
            @forelse ($brands as $brand)
                <tr class="border-t">
                    <td class="p-3">{{ \Carbon\Carbon::parse($brand->brand_date)->format('d M Y') }}</td>
                    <td class="p-3 font-semibold">{{ $brand->brand_name }}</td>
                    <td class="p-3">{{ $brand->industry ?? $brand->other_industry }}</td>
                    <td class="p-3">
                        @if($brand->web_address)
                            <a href="{{ $brand->web_address }}" target="_blank" class="text-blue-600 underline">
                                {{ $brand->web_address }}
                            </a>
                        @endif
                    </td>
                    <td class="p-3">{{ $brand->brand_audience }}</td>
                    <td class="p-3">{{ $brand->brand_description }}</td>
                    <td class="p-2">
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="Logo" class="w-16 h-16 object-contain rounded border" />
                        @endif
                    </td>

                    <td class="p-3 flex gap-3 items-center">
                      <a href="/view-brand/{{$brand->id}}" class="text-blue-600 underline">View</a>
                      <a href="{{ route('brand.edit', $brand->id) }}" class="text-blue-600 underline">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="p-3 text-center text-gray-500">No brand profiles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>






      <div>
        <div class="pro-tip">
          <strong>Pro Tips:</strong> Keep your brand's names, descriptions, logos, colors, fonts, and assets organized in a single place.
          This will help you save more time when making new requests.
        </div>
      </div>
</div>

          </div>
   </div>



  </x-layout>