<x-layout>
    <div class="container-fluid mt-5 p-5 mb-5">
        <h2>All Jobs Report</h2>

        <form method="GET" action="#" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="from_date">From Date</label>
                    <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">-- All Users --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
                    <a href="{{ route('superadmin.jobsreport') }}" class="btn btn-secondary mt-2">Reset</a>
                </div>
            </div>
        </form>
        

    <table class="min-w-full bg-white text-sm text-left border border-gray-200">
        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 border-b w-10"></th> <!-- Arrow column -->
                <th class="px-4 py-3 border-b">Order ID</th>
                <th class="px-4 py-3 border-b">Project Title</th>
                <th class="px-4 py-3 border-b">Request Type</th>
                <th class="px-4 py-3 border-b">Created By</th>
                <th class="px-4 py-3 border-b">User Mail</th>
                <th class="px-4 py-3 border-b">No.of files</th>
                <th class="px-4 py-3 border-b">Status</th>
                <th class="px-4 py-3 border-b">Created At</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @forelse($jobs as $job)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="px-4 py-2 text-center">
                        @if($job->subOrders->count() > 0)
                            <button type="button" class="toggle-suborders" data-id="{{ $job->id }}">
                                ▼
                            </button>
                        @endif
                    </td>
                    <td class="px-4 py-2"><a href="{{ route('view.order', $job->id) }}" class="hover:underline">{{ $job->order_id }}</a></td>
                    <td class="px-4 py-2">{{ $job->project_title }}</td>
                    <td class="px-4 py-2">{{ $job->request_type }}</td>
                    <td class="px-4 py-2">{{ $users->where('id', $job->created_by)->first()->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{$users->where('id', $job->created_by)->first()->email ?? 'Unknown'}}</td>
                    @php
                        $referenceFiles = json_decode($job->reference_files, true);
                        $referenceCount = is_array($referenceFiles) ? count($referenceFiles) : 0;
                    @endphp
                    <td class="px-4 py-3">{{ $referenceCount }} File{{ $referenceCount !== 1 ? 's' : '' }}</td>
                    <td class="px-4 py-2">{{ $job->status }}</td>
                    <td class="px-4 py-2">{{ $job->created_at->format('d-m-Y') }}</td>
                </tr>

                @if($job->subOrders->count() > 0)
                <tr class="hidden bg-gray-50 suborder-row" id="suborders-{{ $job->id }}">
                    <td colspan="6" class="px-4 py-3">
                        <table class="w-full text-md border border-gray-300">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-2 py-1 border">Job ID</th>
                                    <th class="px-2 py-1 border">Project Title</th>
                                    <th class="px-2 py-1 border">Request Type</th>
                                    <th class="px-4 py-3 border-b">No.of files</th>
                                    <th class="px-2 py-1 border">Status</th>
                                    <th class="px-2 py-1 border">Assigned To</th>
                                    <th class="px-2 py-1 border">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($job->subOrders as $sub)
                                    <tr class="border-b">
                                        <td class="px-2 py-1"><a href="{{ route('superadmin.viewsuborders', $sub->id) }}" class="hover:underline">{{ $sub->job_id }}</a></td>
                                        <td class="px-2 py-1">{{ $sub->project_title }}</td>
                                        <td class="px-2 py-1">{{ $sub->request_type }}</td>
                                        @php
                                            $referenceFiles = json_decode($sub->reference_files, true);
                                            $referenceCount = is_array($referenceFiles) ? count($referenceFiles) : 0;
                                        @endphp
                                        <td class="px-4 py-3">{{ $referenceCount }} File{{ $referenceCount !== 1 ? 's' : '' }}</td>
                                        <td class="px-2 py-1">{{ $sub->status }}</td>
                                        <td class="px-2 py-1">{{ $users->where('id', $sub->assigned_to)->first()->name ?? 'N/A' }}</td>
                                        <td class="px-2 py-1">{{ $sub->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endif
            
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">No jobs found for selected date range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    </div>
</x-layout>

<script>
       $(document).ready(function () {
        $('.toggle-suborders').on('click', function () {
            const jobId = $(this).data('id');
            const $suborderRow = $('#suborders-' + jobId);
            const $button = $(this);

            $suborderRow.toggleClass('hidden');

            // Toggle arrow direction
            if ($suborderRow.hasClass('hidden')) {
                $button.text('▼');
            } else {
                $button.text('▲');
            }
        });
    });
</script>
