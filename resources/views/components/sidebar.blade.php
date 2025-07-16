<style>
    .force-change {
        color: #f8832c !important;
    }
</style>
         
      
      <!-- Sidebar -->
      <div class="sidebar bg-gradient-to-r from-amber-600 to-orange-600">
        <div class="sidebar-logo ">
          <!-- Logo Header -->
          <div class="logo-header bg-gradient-to-r from-amber-600 to-orange-600" >
             <a href="#" class="logo">
                 {{-- <img
                   src="{{ asset('assets/img/obeth.webp') }}"
                   style="width: 160px; height: 50px; border-radius: 3px;"
                   alt="navbar brand"
                   class="navbar-brand"/> --}}
                   <h2 class="text-white">Clip The Pic</h2>
             </a>

              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right text-white"></i>
               </button>
                <button class="btn btn-toggle sidenav-toggler">
                 <i class="gg-menu-left text-white"></i>
                </button>
             </div>
               <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt text-white"></i>
               </button>
          </div>
          <!-- End Logo Header -->
        </div>


   <div class="sidebar-wrapper scrollbar scrollbar-inner bg-gradient-to-r from-amber-600 to-orange-600">
   <div class="sidebar-content">
    <ul class="nav nav-secondary">
      {{-- Subscriber Menu --}}
      @if(Auth::user()->role === 'subscriber')
        <li class="nav-item {{ request()->routeIs('subscribers.dashboard') ? 'bg-white rounded-md' : '' }}">
            <a href="{{ route('subscribers.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                <i class="fas fa-home {{ request()->routeIs('subscribers.dashboard') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                <p class="{{ request()->routeIs('subscribers.dashboard') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Dashboard</p>
            </a>
        </li>
    
          <li class="nav-item {{ request()->routeIs('requests') ? 'bg-white rounded-md' : '' }}">
              <a href="{{ route('requests') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-envelope-open-text {{ request()->routeIs('requests') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('requests') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Jobs</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('brandprofile') ? 'bg-white rounded-md' : '' }} ">
              <a href="{{ route('brandprofile') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-id-badge {{ request()->routeIs('brandprofile') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('brandprofile') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Brand Profiles</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('billing') ? 'bg-white rounded-md' : '' }}">
              <a href="{{ route('billing') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-file-invoice {{ request()->routeIs('billing') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('billing') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Billing</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('usage') ? 'bg-white rounded-md' : '' }}">
              <a href="{{ route('usage') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-chart-line {{ request()->routeIs('usage') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('usage') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Usage</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('helpcenter') ? 'bg-white rounded-md' : '' }}">
              <a href="{{ route('helpcenter') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-life-ring {{ request()->routeIs('helpcenter') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('helpcenter') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Help Center</p>
              </a>
          </li>
      @endif
  
      {{-- Admin Menu  --}}
         @if(Auth::user()->role === 'admin')
          <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'bg-white rounded-md' : '' }}">
              <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-home {{ request()->routeIs('admin.dashboard') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('admin.dashboard') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Dashboard</p>
              </a>
          </li>
          {{-- <li class="nav-item">
              <a href="{{ route('admin.orders') }}">
                  <i class="fas fa-box"></i>
                  <p>Jobs</p>
              </a>
          </li> --}}
          <li class="nav-item {{ request()->routeIs('admin.suborders') ? 'bg-white rounded-md' : '' }}">
              <a href="{{ route('admin.suborders') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-box {{ request()->routeIs('admin.suborders') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('admin.suborders') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Jobs List</p>
              </a>
          </li>
          {{-- <li class="nav-item">
              <a href="#">
                  <i class="fas fa-comments"></i>
                  <p>Chats</p>
              </a>
          </li> --}}
      @endif

            {{-- Admin Menu  --}}
            @if(Auth::user()->role === 'qualitychecker')
            <li class="nav-item {{ request()->routeIs('qc.dashboard') ? 'bg-white rounded-md' : '' }}">
                <a href="{{ route('qc.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                    <i class="fas fa-home {{ request()->routeIs('qc.dashboard') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                    <p class="{{ request()->routeIs('qc.dashboard') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('qc.mainorders') ? 'bg-white rounded-md' : '' }}">
                <a href="{{route('qc.mainorders')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                    <i class="fas fa-clipboard-check {{ request()->routeIs('qc.mainorders') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                    <p class="{{ request()->routeIs('qc.mainorders') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Main Jobs</p>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('qc.orders') ? 'bg-white rounded-md' : '' }}">
                <a href="{{ route('qc.orders') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                    <i class="fas fa-box {{ request()->routeIs('qc.orders') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                    <p class="{{ request()->routeIs('qc.orders') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Jobs</p>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('qc.lists') ? 'bg-white rounded-md' : '' }}">
                <a href="{{route('qc.lists')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                    <i class="fas fa-clipboard-check {{ request()->routeIs('qc.lists') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                    <p class="{{ request()->routeIs('qc.lists') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">QC List</p>
                </a>
            </li>
            @endif
  
      {{-- Superadmin Menu --}}
      @if(Auth::user()->role === 'superadmin')
          <li class="nav-item {{ request()->routeIs('superadmin.dashboard') ? 'bg-white rounded-md' : '' }}">
              <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-home {{ request()->routeIs('superadmin.dashboard') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('superadmin.dashboard') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Dashboard</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('superadmin.orders') ? 'bg-white rounded-md' : '' }}">
              <a href="{{route('superadmin.orders')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-box {{ request()->routeIs('superadmin.orders') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('superadmin.orders') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Jobs</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('superadmin.suborders') ? 'bg-white rounded-md' : '' }}">
            <a href="{{route('superadmin.suborders')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                <i class="fas fa-box {{ request()->routeIs('superadmin.suborders') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                <p class="{{ request()->routeIs('superadmin.suborders') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Sub Orders</p>
            </a>
        </li>
          <li class="nav-item {{ request()->routeIs('superadmin.subscribers') ? 'bg-white rounded-md' : '' }}">
              <a href="{{route('superadmin.subscribers')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-users {{ request()->routeIs('superadmin.subscribers') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('superadmin.subscribers') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Customers</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('superadmin.admins') ? 'bg-white rounded-md' : '' }}">
              <a href="{{route('superadmin.admins')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-user-shield {{ request()->routeIs('superadmin.admins') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('superadmin.admins') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Admins</p>
              </a>
          </li>
          <li class="nav-item {{ request()->routeIs('superadmin.enquires') ? 'bg-white rounded-md' : '' }}">
            <a href="{{route('superadmin.enquires')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                <i class="fas fa-folder-open {{ request()->routeIs('superadmin.enquires') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                <p class="{{ request()->routeIs('superadmin.enquires') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Enquires</p>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('plans.list') ? 'bg-white rounded-md' : '' }}">
            <a href="{{route('plans.list')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                <i class="fas fa-folder-open {{ request()->routeIs('plans.list') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                <p class="{{ request()->routeIs('plans.list') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Plans</p>
            </a>
        </li>
          <li class="nav-item {{ request()->routeIs('superadmin.reports') ? 'bg-white rounded-md' : '' }}">
              <a href="{{route('superadmin.reports')}}" class="flex items-center gap-2 px-3 py-2 rounded-md group hover:bg-white transition">
                  <i class="fas fa-chart-bar {{ request()->routeIs('superadmin.reports') ? 'force-change' : 'text-white group-hover:text-[#f8832c]' }}"></i>
                  <p class="{{ request()->routeIs('superadmin.reports') ? 'text-[#f8832c] font-semibold' : 'text-white group-hover:text-[#f8832c]' }}">Reports</p>
              </a>
          </li>
      @endif
  </ul>
  

   </div>
   </div>
</div>
      <!-- End Sidebar -->