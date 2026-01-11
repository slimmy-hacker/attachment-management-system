@extends('layouts.my_app')

@section('title', 'Weekly Reports Review - Industrial Supervisor')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Review Weekly Attachment Reports</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @forelse ($weeklyReports as $report)
        <div class="border p-4 mb-6 rounded shadow-sm">
            <p><strong>Week {{ $report->week_id }}</strong> ({{ \Carbon\Carbon::parse($report->week_start_date)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($report->week_end_date)->format('Y-m-d') }})</p>
            <p class="mb-3 whitespace-pre-line">{{ $report->weekly_report ?? 'No report content' }}</p>

            <form method="POST" action="{{ route('industrial_supervisor.weekly-reports.update', $report->id) }}">
                @csrf
                @method('PUT')

                <label class="block font-semibold mb-1" for="industrial_supervisor_comment_{{ $report->id }}">
                    Industrial Supervisor Comment
                </label>
                <textarea name="industrial_supervisor_comment" id="industrial_supervisor_comment_{{ $report->id }}" rows="4" required
                    class="w-full border p-2 rounded mb-3">{{ old('industrial_supervisor_comment', $report->industrial_supervisor_comment) }}</textarea>

                <div class="flex items-center mb-3 space-x-2">
                    <input type="checkbox" name="is_approved" id="is_approved_{{ $report->id }}" value="1" {{ $report->is_approved ? 'checked' : '' }}>
                    <label for="is_approved_{{ $report->id }}" class="font-medium">Approve Weekly Report</label>
                </div>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Save Comment & Approval
                </button>
            </form>
        </div>
    @empty
        <p class="text-gray-600">No weekly reports available for review.</p>
    @endforelse
</div>
@endsection
