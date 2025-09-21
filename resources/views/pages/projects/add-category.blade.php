@extends('app')

@section('content')
<form method="POST" action="{{ @$category->id ? route('admin.project-categories.update', $category->id) : route('admin.project-categories.store') }}"
    enctype="multipart/form-data">
    <div class="flex justify-between items-center ">
        <h2 class="text-3xl pt-6 px-5 font-bold text-gray-800 mb-2">
            {{ @$album->id ? 'Edit' : 'Add' }} Project Category
        </h2>
        <div class="pt-6 px-5 flex items-center justify-end">
            <a href="{{ url()->previous() }}"
                class="py-3 px-6 bg-white text-lg font-semibold
                       rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-md">
                &larr; Back
            </a>
        </div>
    </div>
    @csrf
    @if (@$category->id)
    @method('PUT')
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6 p-4 sm:p-6 lg:p-8">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg w-full border border-gray-200">

            <div class="grid grid-cols-1 mt-6">
                <div class="lg:col-span-8 bg-white ">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-3">Header</h3>
                    <div class="space-y-6">

                        <div>
                            <label for="name" class="block mb-2 text-base font-medium text-gray-700">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('caption', @$category->name) }}" required
                                class="w-full px-4 py-2 bg-white border @error('name') border-red-500 @else border-gray-300 @enderror
                                rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('name')
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="serial"
                                    class="block mb-2 text-base font-medium text-gray-700">Serial</label>
                                <input id="serial" name="serial" type="number"
                                    value="{{ old('serial', @$category->serial ?? 1) }}"
                                    class="w-full px-4 py-2 bg-white border @error('serial') border-red-500 @else border-gray-300 @enderror
                                    rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('serial')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="status"
                                    class="block mb-2 text-base font-medium text-gray-700">Status</label>
                                <select id="status" name="status"
                                    class="w-full px-4 py-2 bg-white border @error('status') border-red-500 @else border-gray-300 @enderror
                                    rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="1" {{ old('status', @$category->status) != '0' ? 'selected' : ''
                                        }}>Active</option>
                                    <option value="0" {{ old('status', @$category->status) == '0' ? 'selected' : ''
                                        }}>Inactive</option>
                                </select>
                                @error('status')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="bg-white px-6 py-6 sm:px-8 sm:py-6 rounded-2xl shadow-lg w-full border border-gray-200">
            <div class="flex justify-between border-b border-gray-200 pb-2">
                <div class="flex flex-col justify-end">
                    <h3 class="text-lg font-semibold text-gray-800 leading-tight">Text & Image</h3>
                </div>
                <button type="submit"
                        class="py-3 px-6 bg-blue-600 text-white text-lg font-semibold
                                rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-md">
                    {{ @$member->id ? 'Update ' : 'Save ' }}
                </button>
            </div>
            <div class="grid grid-cols-1 mt-4">

                <div class="lg:col-span-4 rounded-xl">

                    <div class="mb-4">
                        <label for="short_text" class="block mb-2 text-base font-medium text-gray-700">Short Description</label>
                        <textarea id="short_text" name="short_text" rows="5"
                                class="w-full px-4 py-3 border @error('short_text') border-red-500 @else border-gray-300 @enderror
                                rounded-md shadow-sm
                                focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('short_text', @$category->short_text) }}</textarea>
                        @error('short_text')
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col items-center text-center">

                        <div id="image-preview-container"
                            class="w-full h-64 sm:h-72 bg-gray-200 rounded-lg flex items-center justify-center border-2 @error('image') border-red-500 @else border-dashed border-gray-300 @enderror mb-4 overflow-hidden py-6 px-4">
                            @if (!empty($category->image))
                            {{-- <img id="preview" src="{{ asset('storage/' . $category->image) }}" alt="Current Image" --}}
                            <img id="preview" src="{{ supaUrl($category->image) }}" alt="Current Image"
                                class="max-h-full max-w-full object-contain rounded-md">
                            @else
                            <img id="preview" src="#" alt="Image Preview"
                                class="max-h-full max-w-full object-contain rounded-md hidden">
                            <span id="preview-placeholder" class="text-gray-500">Image Preview</span>
                            @endif
                        </div>

                        <label for="image"
                            class="w-full cursor-pointer bg-white border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-100 transition-colors shadow-sm text-center">
                            <span>{{ @$category->id ? 'Change Image' : 'Select Image' }}</span>
                            <input id="image" name="image" type="file" accept="image/*" class="hidden"
                                onchange="previewImage(event)">
                        </label>
                        @error('image')
                        <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 10MB</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection


@push('script-stack')
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
