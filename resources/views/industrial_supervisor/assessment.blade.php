@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">Industrial Supervisor Assessment</h1>

    <form action="{{ route('attachment-assessment.industrial.store') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id ?? '' }}">

        <div class="space-y-4">
            <div>
                <label for="attendance_marks" class="block font-medium">Attendance Marks</label>
                <input type="number" min="0" max="100" id="attendance_marks" name="attendance_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="attendance_remarks" class="block font-medium">Attendance Remarks</label>
                <textarea id="attendance_remarks" name="attendance_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="punctuality_marks" class="block font-medium">Punctuality Marks</label>
                <input type="number" min="0" max="100" id="punctuality_marks" name="punctuality_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="punctuality_remarks" class="block font-medium">Punctuality Remarks</label>
                <textarea id="punctuality_remarks" name="punctuality_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="work_quality_marks" class="block font-medium">Work Quality Marks</label>
                <input type="number" min="0" max="100" id="work_quality_marks" name="work_quality_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="work_quality_remarks" class="block font-medium">Work Quality Remarks</label>
                <textarea id="work_quality_remarks" name="work_quality_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="teamwork_marks" class="block font-medium">Teamwork Marks</label>
                <input type="number" min="0" max="100" id="teamwork_marks" name="teamwork_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="teamwork_remarks" class="block font-medium">Teamwork Remarks</label>
                <textarea id="teamwork_remarks" name="teamwork_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="discipline_marks" class="block font-medium">Discipline Marks</label>
                <input type="number" min="0" max="100" id="discipline_marks" name="discipline_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="discipline_remarks" class="block font-medium">Discipline Remarks</label>
                <textarea id="discipline_remarks" name="discipline_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit Industrial Assessment</button>
    </form>
</div>

@endsection
