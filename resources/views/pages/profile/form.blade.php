{{-- FILE: resources/views/profile/edit.blade.php --}}
@extends('app')

@section('content')
<div class="w-full min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-lg border border-gray-200">

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Edit Your Profile</h2>
            <p class="text-center text-gray-500 mb-8">Update your name and profile picture.</p>

            @csrf
            @method('PATCH') {{-- Use PATCH for updates --}}

            {{-- Success Message --}}
            @if (session('status') === 'profile-updated')
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-600">
                    <p>Your profile has been saved successfully.</p>
                </div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6">
                <!-- Profile Photo Upload -->
                <div>
                    <label class="block mb-2 text-base font-medium text-gray-700">Profile Photo</label>
                    <div class="flex items-center gap-4">
                        {{-- Current Image --}}
                        <img id="photo-preview"
                             src="{{ asset('storage/' . auth()->user()->image) ?? 'https://placehold.co/128x128/e2e8f0/718096?text=Photo' }}"
                             alt="Current Profile Photo"
                             class="w-20 h-20 object-cover rounded-full border-2 border-gray-200">

                        {{-- File Input --}}
                        <input id="photo" name="image" type="file" accept="image/*"
                               class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                               onchange="previewPhoto(event)">
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block mb-2 text-base font-medium text-gray-700">Full Name</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name', auth()->user()->name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Email (Read-only) -->
                <div>
                    <label for="email" class="block mb-2 text-base font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email"
                           value="{{ auth()->user()->email }}"
                           disabled {{-- Prevent editing the email --}}
                           class="w-full px-4 py-3 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
                </div>
            </div>

            <!-- Submit -->
            <div class="mt-10">
                <button type="submit"
                        class="w-full py-3 bg-blue-600 text-white text-lg font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script-stack')
<script>
    function previewPhoto(event) {
        const input = event.target;
        const preview = document.getElementById('photo-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
