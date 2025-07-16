<x-layout>

   <div class="min-h-screen bg-gray-100 py-10 px-4">
    <div class="max-w-8xl mx-auto mt-15">
        <h2 class="text-4xl font-extrabold text-gray-800  text-center mb-4">📊 Reports Dashboard</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">

            <!-- Card 1: Total Jobs Completed -->
            <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-2xl p-8 shadow-xl flex items-center justify-between">
                <a href="{{route('superadmin.jobsreport')}}" class="flex w-full justify-between">
                    <div>
                        <h4 class="text-lg text-white">Total Jobs Details</h4>
                        <p class="text-4xl font-bold mt-2 text-white">{{$totalOrders}}</p>
                    </div>
                    <div class="text-white text-5xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </a>
            </div>

            <!-- Card 2: Credits Used -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-2xl p-8 shadow-xl flex items-center justify-between">
                <a href="{{route('creditsusage.report')}}" class="flex w-full justify-between">
                    <div>
                        <h4 class="text-lg text-white">Credits Used</h4>
                        <p class="text-4xl font-bold mt-2 text-white">{{$totalCreditsUsed}}</p>
                    </div>
                    <div class="text-white text-5xl">
                        <i class="fas fa-coins"></i>
                    </div>
                </a>
            </div>

            <!-- Card 3: Feedbacks Received -->
            {{-- <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white rounded-2xl p-8 shadow-xl flex items-center justify-between">
                <div>
                    <h4 class="text-lg">Feedbacks Received</h4>
                    <p class="text-4xl font-bold mt-2">75</p>
                </div>
                <div class="text-white text-5xl">
                    <i class="fas fa-comments"></i>
                </div>
            </div> --}}

            <!-- Card 4: Total Transactions -->
            <div class="bg-gradient-to-r from-pink-500 to-red-500 text-white rounded-2xl p-8 shadow-xl flex items-center justify-between">
                <a href="{{route('superadmin.transactionreport')}}" class="flex items-center justify-between w-full">
                    <div>
                        <h4 class="text-lg text-white">Total Transactions</h4>
                        <p class="text-4xl font-bold mt-2 text-white">${{$transactionTotal}}</p>
                    </div>
                    <div class="text-white text-5xl">
                        <i class="fas fa-wallet"></i>
                    </div>
                </a>
            </div>

            <!-- Card 5: Active Subscriptions -->
            {{-- <div class="bg-gradient-to-r from-teal-400 to-cyan-500 text-white rounded-2xl p-8 shadow-xl flex items-center justify-between">
                <div>
                    <h4 class="text-lg">Active Subscriptions</h4>
                    <p class="text-4xl font-bold mt-2">42</p>
                </div>
                <div class="text-white text-5xl">
                    <i class="fas fa-user-check"></i>
                </div>
            </div> --}}

            <!-- Card 6: Jobs In Progress -->
            {{-- <div class="bg-gradient-to-r from-gray-500 to-gray-700 text-white rounded-2xl p-8 shadow-xl flex items-center justify-between">
                <div>
                    <h4 class="text-lg">Jobs In Progress</h4>
                    <p class="text-4xl font-bold mt-2">16</p>
                </div>
                <div class="text-white text-5xl">
                    <i class="fas fa-spinner animate-spin"></i>
                </div>
            </div> --}}

        </div>
    </div>
</div>


</x-layout>