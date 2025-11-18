@extends('layouts.guest')

@section('title', 'Select Portal')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md text-center">
        <h2 class="text-2xl font-semibold mb-6">Select Portal to Register</h2>

        <div class="grid grid-cols-1 gap-4">
            <a href="{{ route('register.portal', 'student') }}" class="bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">🎓 Student</a>
            <a href="{{ route('register.portal', 'lecturer') }}" class="bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">👨‍🏫 Supervisor</a>
            <a href="{{ route('register.portal', 'industrial_supervisor') }}" class="bg-yellow-600 text-white py-2 rounded-lg hover:bg-yellow-700">🏭 Industry</a>
            <a href="{{ route('register.portal', 'company') }}" class="bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">🏢 Company</a>

        </div>

        <p class="text-gray-600 text-sm mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>
</div>
@endsection
