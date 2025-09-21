@extends('app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800  mb-8">
                {{ @$committee->id ? 'Edit' : 'Create' }} Member committee
            </h2>
    <div class="bg-white h-full p-8 rounded-xl shadow-md w-full max-w-2xl border border-gray-200">

        <form method="POST"
              action="{{ @$committee->id ? route('admin.committee.update', $committee->id) : route('admin.committee.store') }}"
              enctype="multipart/form-data">

            @csrf
            @if (@$committee->id)
                @method('PUT')
            @endif

            {{-- The old, consolidated error block has been removed --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block mb-2 text-base font-medium text-gray-700">Name</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name', @$committee->name) }}"
                           required class="w-full px-4 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="serial" class="block mb-2 text-base font-medium text-gray-700">Serial</label>
                    <input id="serial" name="serial" type="number"
                           value="{{ old('serial', @$committee->serial ?? 1) }}"
                           required class="w-full px-4 py-3 border @error('serial') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('serial')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block mb-2 text-base font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                            class="w-full px-4 py-3 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1" {{ old('status', @$committee->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', @$committee->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-10">
                <button type="submit"
                        class="w-full py-3 bg-blue-600 text-white text-lg font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
