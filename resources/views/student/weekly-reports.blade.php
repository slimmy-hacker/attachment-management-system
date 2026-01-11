@extends('layouts.my_app')

@section('title', 'Weekly Reports')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Submit Weekly Attachment Report</h1>

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

    <form method="POST" action="{{ route('student.weekly-reports.store') }}">
        @csrf
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label for="week_id" class="block text-sm font-medium mb-1">Week Number</label>
                <select name="week_id" id="week_id" class="w-full border p-2 rounded" required
                    @if($user_role !== 'student') disabled @endif>
                    <option value="">Select Week</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('week_id') == $i ? 'selected' : '' }}>Week {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="week_start_date" class="block text-sm font-medium mb-1">Week Start Date</label>
                <input type="date" name="week_start_date" id="week_start_date" value="{{ old('week_start_date') }}" 
                    class="w-full border p-2 rounded" required
                    @if($user_role !== 'student') disabled @endif>
            </div>

            <div>
                <label for="week_end_date" class="block text-sm font-medium mb-1">Week End Date</label>
                <input type="date" name="week_end_date" id="week_end_date" value="{{ old('week_end_date') }}" 
                    class="w-full border p-2 rounded" required
                    @if($user_role !== 'student') disabled @endif>
            </div>
        </div>

        <div class="mb-4">
            <label for="weekly_report" class="block text-sm font-medium mb-1">Report Description</label>
            <textarea name="weekly_report" id="weekly_report" rows="5" class="w-full border p-2 rounded" placeholder="Write what you accomplished this week..." required
                @if($user_role !== 'student') disabled @endif>{{ old('weekly_report') }}</textarea>
        </div>

        {{-- Industrial Supervisor Comment --}}
        <div class="mb-4">
            <label for="industrial_supervisor_comment" class="block text-sm font-medium mb-1">Industrial Supervisor Comment</label>
            <textarea name="industrial_supervisor_comment" id="industrial_supervisor_comment" rows="3" 
                class="w-full border p-2 rounded" placeholder="Supervisor's comments"
                @if($user_role !== 'industrial_supervisor') readonly @endif>{{ old('industrial_supervisor_comment') }}</textarea>
        </div>

        {{-- Lecturer Comment --}}
        <div class="mb-4">
            <label for="lecturer_comment" class="block text-sm font-medium mb-1">Lecturer Comment</label>
            <textarea name="lecturer_comment" id="lecturer_comment" rows="3" 
                class="w-full border p-2 rounded" placeholder="Lecturer's comments"
                @if($user_role !== 'lecturer') readonly @endif>{{ old('lecturer_comment') }}</textarea>
        </div>

        {{-- Approval Checkbox for Industrial Supervisor --}}
        @if($user_role === 'industrial_supervisor')
            <div class="mb-4 flex items-center space-x-2">
                <input type="checkbox" name="is_approved" id="is_approved" value="1" {{ old('is_approved') ? 'checked' : '' }}>
                <label for="is_approved" class="text-sm font-medium">Approve Weekly Report</label>
            </div>
        @endif

        {{-- Submit Button only for allowed roles --}}
        @if(in_array($user_role, ['student', 'industrial_supervisor', 'lecturer']))
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Weekly Report
            </button>
        @endif
    </form>

    <div class="border-t pt-6 mt-8">
        <h2 class="text-xl font-semibold mb-3">Submitted Reports</h2>
        <table class="w-full border table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Week Number</th>
                    <th class="p-2 border">Week Start Date</th>
                    <th class="p-2 border">Week End Date</th>
                    <th class="p-2 border">Weekly Report</th>
                    <th class="p-2 border">Supervisor Comment</th>
                    <th class="p-2 border">Lecturer Comment</th>
                    <th class="p-2 border">Approved</th>
                </tr>
            </thead>
            <tbody>
                @forelse($weeklyReports as $report)
                    <tr>
                        <td class="p-2 border">{{ $report->week_id }}</td>
                        <td class="p-2 border">{{ optional(\Carbon\Carbon::parse($report->week_start_date))->format('Y-m-d') }}</td>
                        <td class="p-2 border">{{ optional(\Carbon\Carbon::parse($report->week_end_date))->format('Y-m-d') }}</td>
                        <td class="p-2 border">{{ \Illuminate\Support\Str::limit($report->weekly_report, 50) }}</td>
                        <td class="p-2 border">{{ $report->industrial_supervisor_comment ?? '-' }}</td>
                        <td class="p-2 border">{{ $report->lecturer_comment ?? '-' }}</td>
                        <td class="p-2 border text-center">
                            @if($report->is_approved)
                                <span class="text-green-600 font-semibold">Yes</span>
                            @else
                                <span class="text-red-600 font-semibold">No</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-2 text-center text-gray-500">No reports submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
