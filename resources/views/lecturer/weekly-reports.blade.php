@extends('layouts.my_app')

@section('title', 'Weekly Reports')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        Weekly Attachment Reports
    </h1>

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

    {{-- ========================= --}}
    {{-- STUDENT SUBMISSION FORM --}}
    {{-- ========================= --}}
    @if($user_role === 'student')
        <form method="POST" action="{{ route('student.weekly-reports.store') }}" class="mb-10">
            @csrf

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Week Number</label>
                    <select name="week_id" class="w-full border p-2 rounded" required>
                        <option value="">Select Week</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">Week {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Week Start Date</label>
                    <input type="date" name="week_start_date"
                           class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Week End Date</label>
                    <input type="date" name="week_end_date"
                           class="w-full border p-2 rounded" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Weekly Report</label>
                <textarea name="weekly_report"
                          rows="4"
                          class="w-full border p-2 rounded"
                          required></textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Weekly Report
            </button>
        </form>
    @endif

    {{-- ========================= --}}
    {{-- LIST OF WEEKLY REPORTS --}}
    {{-- ========================= --}}
    <h2 class="text-xl font-semibold mb-4">Submitted Weekly Reports</h2>

    @forelse($weeklyReports as $report)
        <div class="border rounded p-4 mb-6 shadow-sm">

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Week</label>
                    <input type="text"
                           value="Week {{ $report->week_id }}"
                           class="w-full border p-2 rounded bg-gray-100"
                           readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Start Date</label>
                    <input type="text"
                           value="{{ \Carbon\Carbon::parse($report->week_start_date)->format('Y-m-d') }}"
                           class="w-full border p-2 rounded bg-gray-100"
                           readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">End Date</label>
                    <input type="text"
                           value="{{ \Carbon\Carbon::parse($report->week_end_date)->format('Y-m-d') }}"
                           class="w-full border p-2 rounded bg-gray-100"
                           readonly>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Weekly Report</label>
                <textarea rows="4"
                          class="w-full border p-2 rounded bg-gray-100"
                          readonly>{{ $report->weekly_report }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">
                    Industrial Supervisor Comment
                </label>
                <textarea rows="3"
                          class="w-full border p-2 rounded bg-gray-100"
                          readonly>{{ $report->industrial_supervisor_comment ?? 'No comment yet' }}</textarea>
            </div>

            {{-- ========================= --}}
            {{-- LECTURER COMMENT SECTION --}}
            {{-- ========================= --}}
            @if($user_role === 'lecturer')
                <form method="POST"
                      action="{{ route('lecturer.weekly-reports.update', $report->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">
                            Lecturer Comment
                        </label>
                        <textarea name="lecturer_comment"
                                  rows="3"
                                  class="w-full border p-2 rounded"
                                  required>{{ old('lecturer_comment', $report->lecturer_comment) }}</textarea>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Save Comment
                    </button>
                </form>
            @endif

            {{-- ========================= --}}
            {{-- STUDENT VIEW OF COMMENTS --}}
            {{-- ========================= --}}
            @if($user_role === 'student' && $report->lecturer_comment)
                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1">
                        Lecturer Comment
                    </label>
                    <textarea rows="3"
                              class="w-full border p-2 rounded bg-gray-100"
                              readonly>{{ $report->lecturer_comment }}</textarea>
                </div>
            @endif

        </div>
    @empty
        <p class="text-gray-500 text-center">
            No weekly reports submitted yet.
        </p>
    @endforelse

</div>
@endsection
