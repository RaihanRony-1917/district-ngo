@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md border border-gray-200">
    <form method="POST" action="/login">
        @csrf
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Login</h2>

        <!-- Email -->
        <div class="mb-5">
            <label for="email" class="block mb-2 text-base font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" required value="{{ old('email', 'demo@gmail.com') }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block mb-2 text-base font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" required value="demo@gmail.com@123"
            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit" class="w-full py-3 bg-gray-800 text-white text-lg font-semibold rounded-md hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 transition-colors">
            Sign In
        </button>
    </form>
</div>
@endsection
