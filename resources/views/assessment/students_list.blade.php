

@extends('layouts.my_app') ->

@section('content')
    <h1>Students List</h1>

    @if ($students->count())
        <ul>
            @foreach ($students as $student)
                <li>
                    {{ $student->name }} 
                   
                    <a href="{{ route('industrial_supervisor.assessment', $student->id) }}">Assess</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No students assigned yet.</p>
    @endif
@endsection
