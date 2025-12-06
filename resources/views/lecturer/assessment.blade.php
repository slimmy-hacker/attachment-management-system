@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">School Supervisor Assessment</h1>

    <form action="{{ route('attachment-assessment.school.store') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id ?? '' }}">

        <div class="space-y-4">
            <div>
                <label for="practical_marks" class="block font-medium">Practical Marks</label>
                <input type="number" min="0" max="100" id="practical_marks" name="practical_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="practical_remarks" class="block font-medium">Practical Remarks</label>
                <textarea id="practical_remarks" name="practical_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="report_marks" class="block font-medium">Report Marks</label>
                <input type="number" min="0" max="100" id="report_marks" name="report_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="report_remarks" class="block font-medium">Report Remarks</label>
                <textarea id="report_remarks" name="report_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="presentation_marks" class="block font-medium">Presentation Marks</label>
                <input type="number" min="0" max="100" id="presentation_marks" name="presentation_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="presentation_remarks" class="block font-medium">Presentation Remarks</label>
                <textarea id="presentation_remarks" name="presentation_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Submit School Assessment</button>
    </form>
</div>
@endsection
