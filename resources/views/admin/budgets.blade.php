@extends('layouts.my_app')

@section('title', 'Lecturer Budget')

@section('content')
<div class="bg-white p-6 shadow-lg rounded">
    {{-- Header Section --}}
    <div class="mb-6 border-b pb-4 flex justify-between items-end">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 uppercase">Attachment Budget Breakdown</h2>
            <p class="text-sm text-gray-500 italic">Calculation based on job grades and visit locations</p>
        </div>
        <div class="text-right">
            <span class="text-xs text-gray-400 uppercase font-semibold">Total Budget Value</span>
            <div class="text-xl font-bold text-blue-900">
                Ksh {{ number_format($attachment_lecturers->sum(fn($l) => ($l->total_subsistence ?? 0) + ($l->total_transport ?? 0))) }}
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-[11px] border-b-2">
                    <th class="border p-3 text-left w-24">Ref ID</th>
                    <th class="border p-3 text-left">Lecturer Name</th>
                    <th class="border p-3 text-center">Grade</th>
                    <th class="border p-3 text-left">Visit Clusters</th>
                    <th class="border p-3 text-center">Total Students</th>
                    <th class="border p-3 text-right">Daily Rate</th>
                    <th class="border p-3 text-right">Subsistence</th>
                    <th class="border p-3 text-right">Transport</th>
                    <th class="border p-3 text-right bg-blue-100 text-blue-900 font-bold uppercase">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attachment_lecturers as $lecturer)
                    <tr class="hover:bg-gray-50 border-b">
                        {{-- Column 1: ID --}}
                        <td class="border p-3 font-mono text-blue-500 text-[10px]">
                            #{{ $lecturer->id }}
                        </td>
                        
                        {{-- Column 2: Name --}}
                        <td class="border p-3 font-bold text-gray-800">
                            {{ $lecturer->lecturer_name ?? 'N/A' }}
                        </td>

                        {{-- Column 3: Grade --}}
                        <td class="border p-3 text-center text-blue-700 font-semibold">
                            {{ $lecturer->dekut_grade ?? 'No Grade' }}
                        </td>

                        {{-- Column 4: Clusters with aggregated data --}}
                        <td class="border p-3">
                            @if(isset($lecturer->clusteredVisits) && count($lecturer->clusteredVisits) > 0)
                                @foreach($lecturer->clusteredVisits as $clusterData)
                                    <div class="flex flex-col text-[11px] mb-2 px-2 py-1.5 bg-gray-50 rounded border border-gray-100 {{ $clusterData['cluster'] == 'uncategorized' ? 'border-red-200 bg-red-50' : '' }}">
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold {{ $clusterData['cluster'] == 'uncategorized' ? 'text-red-600' : 'text-blue-700' }} capitalize">
                                                {{ str_replace('_', ' ', $clusterData['cluster']) }}
                                            </span>
                                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-[10px] font-bold">
                                                {{ $clusterData['total_students'] }} Student(s)
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center mt-1 text-[10px]">
                                            <span class="text-gray-600">
                                                Towns: {{ implode(', ', array_map('ucfirst', $clusterData['towns'])) }}
                                            </span>
                                            <span class="text-gray-500 font-medium">
                                                Transport: Ksh {{ number_format($clusterData['transport_cost']) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="text-[10px] text-gray-500 mt-1">
                                    <span class="font-semibold">{{ $lecturer->unique_cluster_count }} unique cluster(s)</span>
                                </div>
                            @else
                                <span class="text-red-400 italic text-[10px]">No assignments found</span>
                            @endif
                        </td>

                        {{-- Column 5: Total Students --}}
                        <td class="border p-3 text-center font-bold">
                            @if(isset($lecturer->assessmentVisits))
                                {{ collect($lecturer->assessmentVisits)->sum('students_count') }}
                            @else
                                0
                            @endif
                        </td>

                        {{-- Column 6: Daily Rate --}}
                        <td class="border p-3 text-right text-gray-500">{{ number_format($lecturer->daily_rate_used) }}</td>
                        
                        {{-- Column 7: Subsistence --}}
                        <td class="border p-3 text-right">{{ number_format($lecturer->total_subsistence) }}</td>
                        
                        {{-- Column 8: Transport (now based on unique clusters) --}}
                        <td class="border p-3 text-right">{{ number_format($lecturer->total_transport) }}</td>
                        
                        {{-- Column 9: Row Total --}}
                        <td class="border p-3 text-right font-bold bg-blue-50 text-blue-900">
                            Ksh {{ number_format(($lecturer->total_subsistence ?? 0) + ($lecturer->total_transport ?? 0)) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-12 text-center text-gray-400 italic">
                            No records found in attachment_lecturers table.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            
            {{-- Footer Grand Totals --}}
            @if($attachment_lecturers->isNotEmpty())
            <tfoot class="bg-gray-100 font-bold text-gray-800">
                <tr>
                    <td colspan="6" class="border p-3 text-right uppercase tracking-wider">Grand Totals</td>
                    <td class="border p-3 text-right">
                        {{ number_format($attachment_lecturers->sum('total_subsistence')) }}
                    </td>
                    <td class="border p-3 text-right">
                        {{ number_format($attachment_lecturers->sum('total_transport')) }}
                    </td>
                    <td class="border p-3 text-right bg-blue-900 text-white">
                        Ksh {{ number_format($attachment_lecturers->sum(fn($l) => ($l->total_subsistence ?? 0) + ($l->total_transport ?? 0))) }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection