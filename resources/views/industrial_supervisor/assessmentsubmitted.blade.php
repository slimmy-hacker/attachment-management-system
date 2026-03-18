@extends('layouts.my_app')
@section('title')
   Attacchment assessment submitted successfully
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">

            <!-- Success Icon -->
            <div class="flex justify-center mb-6">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Message -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                 Submitted Successfully
            </h2>

            <p class="text-sm text-gray-600 mb-8">
                Your assessment submitted and saved successfully.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="javascript:void(0)" data-id="{{$attachment_student_id}}"
                   class="inline-flex items-center justify-center px-6 py-2.5
                      text-sm font-medium text-white bg-blue-600
                      rounded-lg hover:bg-blue-700 transition close-assess-modal-btn">
                    Preview Assessment
                </a>

                <a href="{{ route('student.portal') }}"
                   class="inline-flex items-center justify-center px-6 py-2.5
                      text-sm font-medium text-gray-700 bg-gray-100
                      rounded-lg hover:bg-gray-200 transition">
                    Go to Dashboard
                </a>
            </div>

        </div>
    </div>
    @include('assessment.industrial_supervisor')
@endsection
