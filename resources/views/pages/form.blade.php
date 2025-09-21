@extends('app')

@section('content')
<div class="w-full min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-4xl border border-gray-200">
        <form onsubmit="handleSubmit(event)" enctype="multipart/form-data">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Submit Your Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block mb-2 text-base font-medium text-gray-700">Name</label>
                    <input id="name" name="name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-2 text-base font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block mb-2 text-base font-medium text-gray-700">Role</label>
                    <select id="role" name="role" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="developer">Developer</option>
                        <option value="designer">Designer</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block mb-2 text-base font-medium text-gray-700">Upload Image</label>
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4 4 4m4-8h4v12H4V4h4m4 0h4m0 0v4" />
                        </svg>
                        <input id="image" name="image" type="file" accept="image/*" class="w-full text-base text-gray-700">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="mt-10">
                <button type="submit" class="w-full py-3 bg-blue-600 text-white text-lg font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
