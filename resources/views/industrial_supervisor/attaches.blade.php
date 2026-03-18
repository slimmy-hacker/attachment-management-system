@extends('layouts.my_app')
@section('title')
    Attachment students
@endsection
@section('content')

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="#" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Attachment Students</a>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All My Students</h1>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200" id="attaches_table">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase w-12">#</th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Reg No</th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                               
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="assess-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow border-t-4 border-green-600">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Student <span id="assessed_student_name" class="text-green-600"></span> Assessment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center close-assess-modal-btn">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>

                <div class="p-6">
                    <form id="assessForm" class="hidden">
                        >
    @csrf
    <input type="hidden" id="attachment_student_id" name="attachment_student_id" value="">

    <div class="mb-5 p-4 bg-indigo-50 border border-indigo-100 rounded-2xl flex justify-between items-center">
        <span class="text-sm font-bold text-indigo-900">Total Calculated Score</span>
        <span id="totalScoreDisplay" class="text-2xl font-black text-indigo-700">0 / 40</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        @php
        $fields = [
            'punctuality' => ['label' => 'Punctuality', 'max' => 2],
            'attendance' => ['label' => 'Attendance', 'max' => 2],
            'basic_skills' => ['label' => 'Basic Skills', 'max' => 4],
            'general_office_applications' => ['label' => 'General Office Apps', 'max' => 4],
            'technical_applications' => ['label' => 'Technical Apps', 'max' => 4],
            'area_of_specialization' => ['label' => 'Specialization', 'max' => 4],
            'scientific_and_technical_knowledge' => ['label' => 'Scientific Knowledge', 'max' => 2],
            'intelligence' => ['label' => 'Intelligence', 'max' => 2],
            'learning_ability' => ['label' => 'Learning Ability', 'max' => 2],
            'responsibility_acceptance' => ['label' => 'Responsibility', 'max' => 2],
            'acceptability_to_colleagues' => ['label' => 'acceptability_to_colleagues', 'max' => 2],
            'improvisation' => ['label' => 'Improvisation', 'max' => 2],
            'environment_adjustment' => ['label' => 'Env Adjustment', 'max' => 2],
            'dependability_and_reliability' => ['label' => 'Dependability', 'max' => 2],
            'organization_and_planning' => ['label' => 'Org & Planning', 'max' => 2],
            'effective_time_use' => ['label' => 'Effective Time Use', 'max' => 2]
        ];
        @endphp

        @foreach($fields as $name => $info)
        <div>
            <label for="{{ $name }}_marks" class="required block font-medium">{{ $info['label'] }} Marks (max {{ $info['max'] }})</label>
            <input type="number" min="0" max="{{ $info['max'] }}" id="{{ $name }}_marks" name="{{ $name }}_marks" class="score-input w-full border rounded p-2" required>
        </div>
        
        <div>
            <label for="{{ $name }}_remarks" class="required block font-medium">{{ $info['label'] }} Remarks</label>
            <textarea id="{{ $name }}_remarks" name="{{ $name }}_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
        </div>
        @endforeach
    </div>

    <button type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Submit Assessment</button>
</form>
                </div>

                <div class="p-4 border-t flex justify-end">
                    <button type="button" class="close-assess-modal-btn px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('student.student_attachment_details_modal')
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $("#attaches_table").DataTable({
            processing: true,
            serverSide: true,
            ordering: false,             
            ajax: "{{ route('industrial_supervisor.attaches') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'reg_no', name: 'reg_no' },
                { data: 'department', name: 'department' },
               // { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        const assessModal = new Modal($('#assess-modal')[0], {
            backdrop: 'static',
            closable: false
        });

        $(document).on('click', '.assessBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#attachment_student_id').val(id);
            $('#assessed_student_name').html(name);
            $('#assessForm').hide();
            $('#assessment_display').remove();

            
            $.get("{{ route('industrial_supervisor.checkIndustry') }}", { student_id: id }, function(response) {
                if(response.exists) {
                    let totalScore = 0;
                    let html = `
                    <div id="assessment_display" class="bg-white p-2 animate-fade-in">
                        <div class="flex items-center justify-center mb-6">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-center text-xl font-bold text-gray-800 mb-6 uppercase tracking-tight">Industry Assessment Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">`;

                    $.each(response.assessment, function(label, data) {
                        let marks = parseInt(data.marks) || 0;
                        totalScore += marks;
                        html += `
                        <div class="p-3 bg-white border-l-4 border-green-500 rounded shadow-sm border border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">${label.replace(/_/g, ' ')}</p>
                            <p class="text-sm font-black text-green-600">${marks} Marks</p>
                            <p class="text-xs text-gray-600 mt-1 italic leading-tight border-t pt-1">"${data.remarks || 'N/A'}"</p>
                        </div>`;
                    });

                    html += `
                        </div>
                        <div class="mt-8 p-6 bg-green-600 rounded-xl text-center text-white shadow-lg">
                            <p class="text-xs font-bold opacity-80 uppercase">Total Industrial Score</p>
                            <p class="text-4xl font-black">${totalScore} / 40</p>
                        </div>
                    </div>`;

                    $('#assessForm').after(html);
                } else {
                    $('#assessForm')[0].reset();
                    $('#assessForm').show();
                }
                assessModal.show();
            }).fail(function() {
                Swal.fire('Error', 'Could not check assessment status', 'error');
            });
        });

        $('.close-assess-modal-btn').on('click', function () {
            assessModal.hide();
        });

        $("#assessForm").on("submit", function(e) {
            e.preventDefault();
            let btn = $(this).find('button[type="submit"]');
            btn.prop("disabled", true).text('Processing...');

            $.ajax({
                url: "{{ route('industrial_supervisor.assessment.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
                        assessModal.hide();
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                    }
                },
                error: function (xhr) {
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong';
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                },
                complete: function () {
                    btn.prop("disabled", false).text("Submit Industry Assessment");
                }
            });
        });
    });
</script>
@endsection