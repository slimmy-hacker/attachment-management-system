@extends('layouts.my_app')
@section('title')
   Assessments
@endsection
@section('content')

<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
    <div class="mb-1 w-full">
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="#" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Assessments</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">List</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Assessments List</h1>
        </div>
    </div>
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden">

                <!-- Button to open modal -->
                <button id="openAssessmentsBtn" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    View Assessments
                </button>

                <!-- Modal -->
                <div id="assessmentsModal" tabindex="-1" aria-hidden="true" 
                     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-50">

                    <div class="relative p-4 w-11/12 max-w-7xl max-h-full bg-white rounded shadow-lg overflow-auto">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">Assessments</h3>
                            <button type="button" id="closeAssessmentsModal" class="text-gray-400 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414-1.414L8.586 10l-4.95-4.95A1 1 0 115.05 3.636L10 8.586z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal body -->
                        <div class="p-4">
                            <table id="assessments_table" class="table-fixed min-w-full divide-y divide-gray-200" >
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 w-12 text-center text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Reg No</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Lecturer</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Lecturer Marks</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Industrial Supervisor</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Industrial Marks</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Total Marks</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="p-4">Action</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($assessments as $index => $assessment)
                                    @php
                                        $student = $assessment->attachmentStudent->student ?? null;
                                        $user = $student->user ?? null;
                                        $program = $student->program ?? null;

                                        $lecturerMarks = $assessment->lecturer_total_marks ?? 0;
                                        $industrialMarks = $assessment->industrial_supervisor_total_marks ?? 0;
                                        $totalMarks = $lecturerMarks + $industrialMarks;
                                    @endphp
                                    <tr>
                                        <td class="p-2 text-center">{{ $index + 1 }}</td>
                                        <td class="p-4">{{ $user->name ?? '' }}</td>
                                        <td class="p-4">{{ $student->reg_no ?? '' }}</td>
                                        <td class="p-4">{{ $program->name ?? '' }}</td>
                                        <td class="p-4">{{ $assessment->lecturer->user->name ?? '' }}</td>
                                        <td class="p-4 font-semibold">{{ $lecturerMarks }}</td>
                                        <td class="p-4">{{ $assessment->industrialSupervisor->user->name ?? '' }}</td>
                                        <td class="p-4 font-semibold">{{ $industrialMarks }}</td>
                                        <td class="p-4 font-semibold">{{ $totalMarks }}</td>
                                        <td class="p-4">{{ ucfirst($assessment->status ?? 'Pending') }}</td>
                                        <td class="p-4">
                                            <a href="{{ route('admin.assessments', $assessment->id) }}" class="text-blue-600 hover:underline">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex justify-end p-4 border-t rounded-b">
                            <button type="button" id="closeAssessmentsBtn" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">Close</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Initialize DataTable when modal opens
        let dataTableInitialized = false;

        $('#openAssessmentsBtn').on('click', function () {
            $('#assessmentsModal').removeClass('hidden');

            if (!dataTableInitialized) {
                $('#assessments_table').DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                });
                dataTableInitialized = true;
            }
        });

        $('#closeAssessmentsBtn, #closeAssessmentsModal').on('click', function () {
            $('#assessmentsModal').addClass('hidden');
        });

        // Optional: close modal when clicking outside content
        $('#assessmentsModal').on('click', function (e) {
            if (e.target === this) {
                $('#assessmentsModal').addClass('hidden');
            }
        });
    });
</script>
@endsection
