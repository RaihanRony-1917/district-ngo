@extends('app')
@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Membership Requests</h1>
            <p class="text-gray-600">Review, approve, or reject new member applications.</p>
        </div>
    </div>

    {{-- Stats Grid can be included here --}}
    {{-- @include('partials.request-stats') --}}

    {{-- Requests Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">All Applications</h3>
        </div>

        {{-- Desktop Table View --}}
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Father's Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($reqs as $req)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ route('admin.requests.file.view', ['id' => $req->id, 'type' => 'photo']) }}"
                                     alt="Applicant Photo"
                                     class="w-12 h-12 object-cover rounded-full border-2 border-gray-200"
                                     onerror="this.onerror=null;this.src='https://placehold.co/48x48/e2e8f0/718096?text=Photo';">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $req->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $req->father_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $req->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($req->status == 'approved')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                @elseif ($req->status == 'rejected')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $req->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('admin.requests.show', $req->id) }}" class="text-gray-600 hover:text-blue-600" title="View Details"><i data-lucide="eye" class="w-5 h-5"></i></a>
                                    <form method="GET" action="{{ route('admin.requests.add', $req->id) }}" onsubmit="return confirm('Approve this member?');">
                                        <button type="submit" class="text-gray-600 hover:text-green-600" title="Approve"><i data-lucide="check" class="w-5 h-5"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.requests.reject', $req->id) }}" onsubmit="return confirm('Reject this member?');">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-yellow-600" title="Reject"><i data-lucide="x" class="w-5 h-5"></i></button>
                                    </form>
                                    <form action="{{ route('admin.requests.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Delete this request permanently?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-600 hover:text-red-600" title="Delete"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No membership requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
            @forelse ($reqs as $req)
            <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-4">
                <div class="flex items-center gap-4">
                    <img src="{{ route('admin.requests.file.view', ['id' => $req->id, 'type' => 'photo']) }}"
                         alt="Applicant Photo"
                         class="w-16 h-16 object-cover rounded-full border-2 border-gray-200"
                         onerror="this.onerror=null;this.src='https://placehold.co/64x64/e2e8f0/718096?text=Photo';">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">{{ $req->name ?? 'N/A' }}</h4>
                        <p class="text-sm text-gray-600">{{ $req->phone ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">Father: {{ $req->father_name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center border-t pt-3">
                    @if ($req->status == 'approved')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                    @elseif ($req->status == 'rejected')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    @endif
                    <div class="flex items-center gap-4 text-sm">
                        <a href="{{ route('admin.requests.show', $req->id) }}" class="text-gray-600 hover:text-blue-600" title="View Details"><i data-lucide="eye" class="w-5 h-5"></i></a>
                        <form method="POST" action="{{ route('admin.requests.approve', $req->id) }}" onsubmit="return confirm('Approve this member?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-gray-600 hover:text-green-600" title="Approve"><i data-lucide="check" class="w-5 h-5"></i></button>
                        </form>
                        <form method="POST" action="{{ route('admin.requests.reject', $req->id) }}" onsubmit="return confirm('Reject this member?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-gray-600 hover:text-yellow-600" title="Reject"><i data-lucide="x" class="w-5 h-5"></i></button>
                        </form>
                        <form action="{{ route('admin.requests.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Delete this request permanently?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-600 hover:text-red-600" title="Delete"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">No membership requests found.</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $reqs->links() }}
        </div>
    </div>
</main>
@endsection
