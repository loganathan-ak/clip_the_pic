<x-layout>
    <div class="container-fluid mt-5 p-5 mb-5">
        <h2 class="text-xl font-bold mb-4">Credits Usage Report</h2>

        <form method="GET" action="{{ route('creditsusage.report') }}" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="from_date" class="block text-sm">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-input border px-2 py-1 rounded">
            </div>

            <div>
                <label for="to_date" class="block text-sm">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-input border px-2 py-1 rounded">
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
                <a href="{{ route('creditsusage.report') }}" class="ml-2 text-sm text-red-500">Reset</a>
            </div>
        </form>

        <div class="mb-4">
            <p><strong>Total Credits Used:</strong> {{ $totalCreditsUsed }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($usages as $usage)
                @php
                    $order = $orders->where('id', $usage->order_id)->first();
                    $statusColor = match($usage->status) {
                        'approved' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'rejected' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
        
                <div class="border rounded-xl shadow-sm p-4 bg-white">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-sm font-semibold text-gray-700">Job ID: {{ $usage->job_id }}</h4>
                        <span class="text-xs px-2 py-1 rounded {{ $statusColor }}">
                            {{ ucfirst($usage->status) }}
                        </span>
                    </div>
                    <p class="text-gray-600 mb-1"><strong>Order:</strong> {{ $order->project_title ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-1"><strong>Credits Used:</strong> {{ $usage->credits_used }}</p>
                    <p class="text-gray-500 text-xs"><strong>Date:</strong> {{ $usage->created_at->format('d M Y') }}</p>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-6">
                    No usage records found.
                </div>
            @endforelse
        </div>
        
    </div>
</x-layout>
