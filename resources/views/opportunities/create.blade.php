@extends('layouts.my_app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <h2 class="text-xl font-bold mb-4">Post New Attachment Opportunity</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-3">{{ session('success') }}</div>
    @endif

    <form action="{{ route('opportunities.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium text-gray-700">Title</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Description</label>
            <textarea name="description" class="w-full border rounded-lg p-2" rows="5" required></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Location</label>
            <input type="text" name="location" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Expiry Period (in days)</label>
            <input type="number" name="expiry_days" class="w-full border rounded-lg p-2" min="1" max="90" required>
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Post Opportunity
        </button>
    </form>
</div>
@endsection
