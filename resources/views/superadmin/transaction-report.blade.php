<x-layout>
    <div class="container-fluid mt-5 p-5 mb-5 ">

        <h2>Transaction Report</h2>

        <form method="GET" action="{{route('superadmin.transactionreport')}}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <!-- User -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white">
                    <option value="">All Users</option>
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
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        
            <!-- To Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="p-3 bg-white w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        
            <!-- Filter & Reset Buttons -->
            <div class="flex flex-col gap-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Actions</label>
                
                <!-- Filter -->
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    Filter
                </button>

                <!-- Reset -->
                <a href="{{ route('superadmin.transactionreport') }}" class="w-full inline-block text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                    Reset
                </a>
            </div>

        </form>
        
    
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border-b">User</th>
                        <th class="px-4 py-3 border-b">Plan</th>
                        <th class="px-4 py-3 border-b">Credits</th>
                        <th class="px-4 py-3 border-b">Amount</th>
                        <th class="px-4 py-3 border-b">Payment Method</th>
                        <th class="px-4 py-3 border-b">Transaction ID</th>
                        <th class="px-4 py-3 border-b">Date</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-2">
                                {{ $users->where('id', $tx->user_id)->first()->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $plans->where('id', $tx->plan_id)->first()->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2">{{ $tx->credits_purchased }}</td>
                            <td class="px-4 py-2">${{ number_format($tx->amount_paid, 2) }}</td>
                            <td class="px-4 py-2 capitalize">{{ $tx->payment_method }}</td>
                            <td class="px-4 py-2 font-mono text-xs">{{ $tx->transaction_id }}</td>
                            <td class="px-4 py-2">{{ $tx->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                No transactions found.
                            </td>
                        </tr>
                    @endforelse

                    @if($transactions->count() > 0)
                    <tr class="bg-gray-100 font-semibold">
                        <td class="px-4 py-2 text-right" colspan="2">Total</td>
                        <td class="px-4 py-2">{{ $totalCredits }}</td>
                        <td class="px-4 py-2">${{ number_format($totalAmount, 2) }}</td>
                        <td class="px-4 py-2" colspan="3"></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
    
        <div class="mt-4">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
</x-layout>