@extends('layouts.my_app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">Industrial Supervisor Assessment</h1>

    <form id="assessmentForm" class="space-y-8 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
    @csrf
    
    <input type="hidden" name="attachment_student_id" value="{{ $student->id }}">

    <div class="space-y-6">
        @php
            $fields = [
                'punctuality' => 'Punctuality',
                'attendance' => 'Attendance',
                'basic_skills' => 'Basic Skills',
                'general_office_applications' => 'General Office Apps',
                'technical_applications' => 'Technical Apps',
                'area_of_specialization' => 'Area of Specialization',
                'scientific_and_technical_knowledge' => 'Scientific & Tech Knowledge',
                'intelligence' => 'Intelligence',
                'learning_ability' => 'Learning Ability',
                'responsibility_acceptance' => 'Responsibility Acceptance',
                'improvisation' => 'Improvisation',
                'environment_adjustment' => 'Environment Adjustment',
                'dependability_and_reliability' => 'Dependability & Reliability',
                'organization_and_planning' => 'Organization & Planning',
                'effective_time_use' => 'Effective Time Use',
            ];
        @endphp

        @foreach($fields as $key => $label)
        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 transition-all hover:shadow-md">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                <label class="text-sm font-black text-gray-800 uppercase tracking-wide">{{ $label }}</label>
                
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-gray-400">SCORE (0-5):</span>
                    <input type="number" name="{{ $key }}_marks" min="0" max="5" 
                           class="w-20 bg-white border-none rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 font-bold text-center shadow-sm" 
                           placeholder="0" required>
                </div>
            </div>

            <div>
                <label for="{{ $key }}_remarks" class="block mb-2 text-xs font-bold text-gray-500 uppercase">Supervisor Remarks</label>
                <textarea name="{{ $key }}_remarks" id="{{ $key }}_remarks" rows="2" 
                          class="w-full bg-white border-none rounded-xl p-4 focus:ring-2 focus:ring-indigo-500 font-semibold text-gray-700 shadow-sm" 
                          placeholder="Provide specific feedback for {{ strtolower($label) }}..." required></textarea>
            </div>
        </div>
        @endforeach
    </div>

    <button type="submit" class="w-full bg-indigo-600 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-indigo-700 hover:-translate-y-1 transition-all">
        SUBMIT EVALUATION
    </button>
</form>
</div>

@endsection
