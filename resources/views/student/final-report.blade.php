@extends('layouts.my_app')

@section('title', 'Final Report')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Submit Final Attachment Report</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('student.final-report.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
        <label for="title" class="block text-sm font-medium mb-1">Report Title</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border p-2 rounded" placeholder="Enter report title" required>
    </div>

    <div class="mb-4">
        <label for="content" class="block text-sm font-medium mb-1">Summary of Attachment Experience</label>
        <textarea name="content" id="content" rows="6" class="w-full border p-2 rounded" placeholder="Summarize your overall attachment experience..." required>{{ old('content') }}</textarea>
    </div>

    <div class="mb-4">
        <label for="final_report_file" class="block text-sm font-medium mb-1">Upload Final Report File (PDF/DOCX)</label>
        <input type="file" name="final_report_file" id="final_report_file" class="w-full border p-2 rounded" accept=".pdf,.doc,.docx" required>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Submit Final Report
    </button>
</form>

</div>
@endsection
