@extends('layouts.my_app')

@section('title')
    Select Attachment
@endsection

@section('content')

    {{-- Page Header --}}
    <div class="bg-white shadow-sm py-4 px-6 sticky top-0 z-10">
        <h1 class="text-2xl font-bold text-gray-800">Select Attachment Period</h1>
        <p class="text-sm text-gray-500">Choose a period to continue</p>
    </div>


    <div>
        @if($attachment_students->isEmpty())
            <div class="flex-1 flex p-6items-center justify-center">
                <div class="bg-white rounded-2xl shadow-md p-10 text-center max-w-md w-full">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">No Available Periods</h2>
                    <p class="text-gray-500">You are currently not assigned any attachment. Please check back later.</p>
                </div>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl">
                @foreach($attachment_students as $attachment)
                    <form action="{{ route('attachment_selected.store') }}" method="POST" class="group">
                        @csrf
                        <input type="hidden" name="attachment_id" value="{{ $attachment->attachment->id }}">
                        <input type="hidden" name="attachment_student_id" value="{{ $attachment->id }}">
                        <input type="hidden" name="attachment_name" value="{{ $attachment->attachment->name }}">
                        <button type="submit"
                                class="block w-full text-left bg-white p-6 rounded-2xl shadow-sm border border-transparent hover:border-blue-400 hover:shadow-md transition-all duration-200 focus:ring-2 focus:ring-blue-500">
                            <div class="flex flex-col">
                                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600">
                                    {{ $attachment->attachment->name }}
                                </h3>
                                @php


                                    $today = \Carbon\Carbon::today();
                                    $start = \Carbon\Carbon::parse($attachment->attachment->start_date);
                                    $end = \Carbon\Carbon::parse($attachment->attachment->end_date);

                                    if ($today->lt($start)) {
                                        $computedState = 'upcoming';
                                        $stateColor = 'text-yellow-600';
                                    } elseif ($today->between($start, $end)) {
                                        $computedState = 'active';
                                        $stateColor = 'text-green-600';
                                    } else {
                                        $computedState = 'closed';
                                        $stateColor = 'text-red-600';
                                    }
                                @endphp
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $start->format('M d, Y') }}
                                    —
                                    {{ $end->format('M d, Y') }}
                                </p>



                                <p class="mt-3 text-xs font-medium {{ $stateColor }}">
                                    State: {{ ucfirst($computedState) }}
                                </p>

                            </div>
                        </button>
                    </form>
                @endforeach
            </div>
        @endif
    </div>
@endsection
