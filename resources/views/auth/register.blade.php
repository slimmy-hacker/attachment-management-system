{{-- resources/views/auth/register-portal.blade.php --}}
@extends('layouts.guest')

@section('title', ucfirst($portal) . ' Registration')
@php
if($portal=='student')
    $reg_route = route('register.portal.student');
else{
    $reg_route = route('register.portal.store', ['portal' => $portal]);
}
@endphp
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md border border-gray-300">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800 border-b pb-3">
            Register as {{ ucfirst($portal) }}
        </h2>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg text-sm border border-red-300">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.portal.store', ['portal' => $portal]) }}" class="space-y-4">
            @csrf

            {{-- Common Fields --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>

            {{-- Student Fields --}}
            @if($portal === 'student')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Registration Number</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Course</label>
                    <input type="text" name="course" value="{{ old('course') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telephone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
            @endif

            {{-- Supervisor Fields --}}
            @if($portal === 'lecturer')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Staff Number</label>
                    <input type="text" name="staff_number" value="{{ old('staff_number') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Grade</label>
                    <input type="text" name="grade" value="{{ old('grade') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telephone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
            @endif

            {{-- Industry Fields --}}
            @if($portal === 'industrial_supervisor')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Student Name</label>
                    <input type="text" name="student_name" value="{{ old('student_name') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role in Company</label>
                    <input type="text" name="role" value="{{ old('role') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telephone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
            @endif

            {{-- Admin Fields --}}
            @if($portal === 'admin')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telephone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" required
                           class="mt-1 w-full border-gray-300 rounded-lg p-2">
                </div>
            @endif

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="mt-1 w-full border-gray-300 rounded-lg p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="mt-1 w-full border-gray-300 rounded-lg p-2">
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition">
                Register
            </button>

            <p class="text-sm text-center text-gray-600 mt-4">
                Already registered?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
