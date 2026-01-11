@extends('layouts.my_app')

@section('title', 'Budget Template')

@section('content')
<div class="bg-white p-6 shadow rounded">

    <h2 class="text-center font-bold mb-4">Budget Template</h2>

    <table class="w-full border-collapse border text-sm">
        <thead>
            <tr>
                <th class="border p-2">S/N</th>
                <th class="border p-2">Lecturer</th>
                <th class="border p-2">Areas/Towns</th>
                <th class="border p-2">No. of students</th>
                <th class="border p-2">Daily Allowance</th>
                <th class="border p-2">Subsistence amount</th>
                <th class="border p-2">Transport amount</th>
                <th class="border p-2">Subtotal (kshs)</th>
            </tr>
        </thead>

        <tbody>
            @foreach($lecturers as $index => $lecturer)
                @php
                    $daily = optional($lecturer->jobGrade)->daily_allowance;
                    $visits = optional($lecturer->assessmentVisits) ?? collect();

                    $totalStudents = 0;
                    $totalSubsistence = 0;
                    $totalTransport = 0;
                    $towns = [];
                @endphp

                @foreach($visits as $visit)
                    @php
                        $days = $visit->days ?? 0;
                        $studentsCount = $visit->students_count ?? 0;
                        $transport = $visit->transport_amount ?? 0;

                        $subsistence = ($daily && $daily > 0) ? $daily * $days * $studentsCount : 0;

                        $totalStudents += $studentsCount;
                        $totalSubsistence += $subsistence;
                        $totalTransport += $transport;

                        if ($visit->town) {
                            $towns[] = $visit->town;
                        }
                    @endphp
                @endforeach

                <tr>
                    <td class="border p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ optional($lecturer->user)->name ?? 'No Name' }}</td>

                    <td class="border p-2">{{ implode(', ', array_unique($towns)) }}</td>
                    <td class="border p-2 text-center">{{ $totalStudents }}</td>
                    <td class="border p-2 text-right">{{ number_format($daily ?? 0) }}</td>
                    <td class="border p-2 text-right">{{ number_format($totalSubsistence) }}</td>
                    <td class="border p-2 text-right">{{ number_format($totalTransport) }}</td>
                    <td class="border p-2 text-right">{{ number_format($totalSubsistence + $totalTransport) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
