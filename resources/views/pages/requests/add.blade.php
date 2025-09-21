@extends('app')

@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    {{-- Page Header --}}
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Member Request</h1>
            <p class="text-gray-600">Editing application for: <span class="font-semibold">{{ $req->name }}</span></p>
        </div>
        <a href="{{ route('admin.requests.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>Back to All Requests
        </a>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">

        {{-- Main form for editing applicant details --}}
        {{-- This form now correctly points to a generic update route --}}
        <form action="{{ route('admin.requests.approve', $req->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-12">
                    {{-- Left Column: Photo and Status --}}
                    {{-- STYLING NOTE: Added pt-16 to push content down, giving the overlapping image space --}}
                    <div class="lg:col-span-1 text-center pt-16">
                        {{-- STYLING NOTE: The image is pulled up with a negative margin to overlap the card's top edge --}}
                        <img src="{{ route('admin.requests.file.view', ['id' => $req->id, 'type' => 'photo']) }}"
                             alt="Applicant Photo"
                             class="w-48 h-48 object-cover rounded-full mx-auto border-4 border-white shadow-lg -mt-32 bg-gray-200"
                             onerror="this.onerror=null;this.src='https://placehold.co/192x192/e2e8f0/718096?text=Photo';">

                        {{-- Name Input --}}
                        <div class="mt-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 sr-only">Full Name</label>
                            {{-- STYLING NOTE: Enhanced input field styling --}}
                            <input type="text" name="name" id="name" value="{{ old('name', $req->name) }}"
                                   class="mt-1 block w-full text-center text-xl font-bold rounded-md bg-gray-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                        </div>

                        {{-- Profession Input --}}
                        <div class="mt-2">
                             <label for="profession" class="block text-sm font-medium text-gray-700 sr-only">Profession</label>
                             {{-- STYLING NOTE: Enhanced input field styling --}}
                            <input type="text" name="profession" id="profession" value="{{ old('profession', $req->profession) }}"
                                   class="mt-1 block w-full text-center text-base text-gray-600 rounded-md bg-gray-50 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                        </div>

                        {{-- Status Display --}}
                        <div class="mt-4">
                            @if ($req->status == 'approved')
                                <span class="px-4 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            @elseif ($req->status == 'rejected')
                                <span class="px-4 py-1 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                            @else
                                <span class="px-4 py-1 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Review</span>
                            @endif
                        </div>
                        @if ($errors->any())
                            <div class="mb-4 rounded-md bg-red-50 p-4">
                                <ul class="list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Right Column: Detailed Info Form Fields --}}
                    <div class="lg:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            {{-- Shared class for all form inputs for consistency --}}
                            @php
                                $inputClasses = "mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition";
                            @endphp

                            {{-- Father's Name Input --}}
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700">Father's Name</label>
                                <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $req->father_name) }}" class="{{ $inputClasses }}">
                            </div>

                            {{-- Mother's Name Input --}}
                            <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700">Mother's Name</label>
                                <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $req->mother_name) }}" class="{{ $inputClasses }}">
                            </div>

                            {{-- Phone Input --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $req->phone) }}" class="{{ $inputClasses }}">
                            </div>

                            {{-- Blood Group Input --}}
                            <div>
                                <label for="blood_grp" class="block text-sm font-medium text-gray-700">Blood Group</label>
                                <input type="text" name="blood_grp" id="blood_grp" value="{{ old('blood_grp', $req->blood_grp) }}" class="{{ $inputClasses }}">
                            </div>

                            {{-- Address Input --}}
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" id="address" rows="3" class="{{ $inputClasses }}">{{ old('address', $req->address) }}</textarea>
                            </div>

                            {{-- STYLED: Committee Dropdown --}}
                            <div class="md:col-span-2">
                                <label for="committee_id" class="block text-sm font-medium text-gray-700">Assign to Committee</label>
                                <select name="committee_id" id="committee_id" class="{{ $inputClasses }}">
                                    <option value="">-- Select a Committee --</option>
                                    @foreach ($committees as $committee)
                                        <option value="{{ $committee->id }}" {{ old('committee_id', $req->committee_id) == $committee->id ? 'selected' : '' }}>
                                            {{ $committee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Documents Section with Upload fields --}}
                        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-8 mb-4">Documents</h3>
                        <div class="space-y-6">
                            {{-- Photo Upload --}}
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Update Photo</label>
                                <input type="file" name="photo" id="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                @if($req->photo)
                                    <a href="{{ route('admin.requests.file.download', ['id' => $req->id, 'type' => 'photo']) }}" class="mt-2 inline-flex items-center text-xs text-blue-600 hover:underline">
                                        <i data-lucide="download-cloud" class="w-3 h-3 mr-1"></i> Download Current Photo
                                    </a>
                                @endif
                            </div>

                            {{-- NID Upload --}}
                            <div>
                                <label for="nid" class="block text-sm font-medium text-gray-700">Update National ID (NID)</label>
                                <input type="file" name="nid" id="nid" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                @if($req->NID)
                                    <a href="{{ route('admin.requests.file.download', ['id' => $req->id, 'type' => 'nid']) }}" class="mt-2 inline-flex items-center text-xs text-blue-600 hover:underline">
                                        <i data-lucide="download-cloud" class="w-3 h-3 mr-1"></i> Download Current NID
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Submission Button --}}
                <div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2.5 font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center shadow-sm transition-colors">
                        <i data-lucide="save" class="w-4 h-4 mr-2"></i>Update Information
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
