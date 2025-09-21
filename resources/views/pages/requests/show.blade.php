@extends('app')

@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Member Request Details</h1>
            <p class="text-gray-600">Reviewing application for: <span class="font-semibold">{{ $req->name }}</span></p>
        </div>
        <a href="{{ route('admin.requests.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>Back to All Requests
        </a>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        {{-- Card Header with Actions --}}
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-wrap justify-between items-center">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Application #{{ $req->id }}</h3>
                <p class="text-sm text-gray-500">Submitted on: {{ $req->created_at->format('F d, Y, h:i A') }}</p>
            </div>
            <div class="flex items-center gap-3 mt-4 sm:mt-0">
                {{-- Approve/Reject Forms --}}
                <form method="GET" action="{{ route('admin.requests.add', $req->id) }}">
                    @csrf
                    {{-- @method('PATCH') --}}
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg flex items-center shadow-sm">
                        <i data-lucide="check" class="w-4 h-4 mr-2"></i>Approve
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.requests.reject', $req->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg flex items-center shadow-sm">
                        <i data-lucide="x" class="w-4 h-4 mr-2"></i>Reject
                    </button>
                </form>
            </div>
        </div>

        {{-- Applicant Details --}}
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Photo and Status --}}
                <div class="lg:col-span-1 text-center">
                    {{-- The src now points to a secure file-serving route for viewing --}}
                    <img src="{{ route('admin.requests.file.view', ['id' => $req->id, 'type' => 'photo']) }}"
                         alt="Applicant Photo"
                         class="w-48 h-48 object-cover rounded-full mx-auto border-4 border-white shadow-lg -mt-16 bg-gray-200"
                         onerror="this.onerror=null;this.src='https://placehold.co/192x192/e2e8f0/718096?text=Photo';">

                    <h2 class="text-2xl font-bold text-gray-800 mt-4">{{ $req->name }}</h2>
                    <p class="text-gray-500">{{ $req->profession ?? 'Profession not specified' }}</p>
                    <div class="mt-4">
                        @if ($req->status == 'approved')
                            <span class="px-4 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                        @elseif ($req->status == 'rejected')
                            <span class="px-4 py-1 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-4 py-1 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Review</span>
                        @endif
                    </div>
                </div>

                {{-- Right Column: Detailed Info --}}
                <div class="lg:col-span-2">
                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-500">Father's Name</span>
                            <span class="text-gray-900 text-base">{{ $req->father_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-500">Mother's Name</span>
                            <span class="text-gray-900 text-base">{{ $req->mother_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-500">Phone Number</span>
                            <span class="text-gray-900 text-base">{{ $req->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-500">Blood Group</span>
                            <span class="text-gray-900 text-base">{{ $req->blood_grp ?? 'N/A' }}</span>
                        </div>
                        <div class="flex flex-col md:col-span-2">
                            <span class="font-medium text-gray-500">Address</span>
                            <span class="text-gray-900 text-base">{{ $req->address ?? 'N/A' }}</span>
                        </div>
                    </div>

                    {{-- Documents Section with Download links --}}
                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-8 mb-4">Documents</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="font-medium text-gray-500 text-sm">Photo</span>
                            @if($req->photo)
                                <a href="{{ route('admin.requests.file.download', ['id' => $req->id, 'type' => 'photo']) }}"
                                   class="mt-1 flex items-center text-blue-600 hover:underline">
                                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                    Download Photo
                                </a>
                            @else
                                <p class="text-gray-500 mt-1 text-sm">No photo uploaded.</p>
                            @endif
                        </div>
                        <div>
                            <span class="font-medium text-gray-500 text-sm">National ID (NID)</span>
                             @if($req->NID)
                                <a href="{{ route('admin.requests.file.download', ['id' => $req->id, 'type' => 'nid']) }}"
                                   class="mt-1 flex items-center text-blue-600 hover:underline">
                                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                    Download NID Document
                                </a>
                            @else
                                <p class="text-gray-500 mt-1 text-sm">No NID document was uploaded.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
         {{-- Footer with Delete Action --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
             <form action="{{ route('admin.requests.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Danger! This will permanently delete the request. Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 hover:text-white hover:bg-red-600 border border-red-600 rounded-lg flex items-center">
                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>Delete Request
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
