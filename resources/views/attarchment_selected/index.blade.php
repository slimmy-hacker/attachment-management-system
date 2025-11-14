@extends('layouts.my_app')

@section('title')
    Select Attarchment
@endsection

@section('content')

        {{-- Page Header --}}
        <div class="bg-white shadow-sm py-4 px-6 sticky top-0 z-10">
            <h1 class="text-2xl font-bold text-gray-800">Select Attachment Period</h1>
            <p class="text-sm text-gray-500">Choose a period to continue</p>
        </div>

        {{-- Page Body --}}
        <div>
            @if($periods->isEmpty())
                <div class="flex-1 flex p-6items-center justify-center">
                    <div class="bg-white rounded-2xl shadow-md p-10 text-center max-w-md w-full">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3">No Available Periods</h2>
                        <p class="text-gray-500">There are currently no attachment periods. Please check back later.</p>
                    </div>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl">
                    @foreach($periods as $period)
                        <form action="{{ route('attachment.store') }}" method="POST" class="group">
                            @csrf
                            <input type="hidden" name="period_id" value="{{ $period->id }}">
                            <button type="submit"
                                    class="block w-full text-left bg-white p-6 rounded-2xl shadow-sm border border-transparent hover:border-blue-400 hover:shadow-md transition-all duration-200 focus:ring-2 focus:ring-blue-500">
                                <div class="flex flex-col">
                                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600">
                                        {{ $period->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($period->start_date)->format('M d, Y') }}
                                        —
                                        {{ \Carbon\Carbon::parse($period->end_date)->format('M d, Y') }}
                                    </p>

                                    @php


                                        $today = \Carbon\Carbon::today();
                                        $start = \Carbon\Carbon::parse($period->start_date);
                                        $end = \Carbon\Carbon::parse($period->end_date);

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
