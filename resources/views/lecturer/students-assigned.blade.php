@extends('layouts.my_app')

@section('title', 'Students Assigned')

@section('content')
    <h1>Students Assigned to Me</h1>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($students->isEmpty())
        <p>No students have been assigned to you yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Attachment Company</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->course ?? 'N/A' }}</td>
                        <td>{{ $student->company->name ?? 'Not Assigned' }}</td>
                        <td>
                            <a href="{{ route('lecturer.reports') }}" class="btn btn-info btn-sm">View Reports</a>
                            <a href="{{ route('lecturer.evaluate') }}" class="btn btn-primary btn-sm">Feedback</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
