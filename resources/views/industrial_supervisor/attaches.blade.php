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
                            <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="#" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Attachment Students</a>
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
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Attached Students</h1>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                    <table class="table-fixed min-w-full divide-y divide-gray-200" id="attaches_table">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-2 w-12">
                                <div class="flex items-center justify-center text-xs font-medium text-gray-500 uppercase">
                                    #
                                </div>
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Student
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Reg No
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Department
                            </th>
                           
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Status
                            </th>
                            <th scope="col" class="p-4">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- Upload Students Modal -->
    <div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="add-schedule-modal">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow relative">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Upload Students
                    </h3>
                    <button type="button" class="close-modal-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                 
                <div class="p-6 space-y-6">
                    <form id="scheduleForm" enctype="multipart/form-data">
                        @csrf()
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                                <label for="name" class="text-sm font-medium text-gray-900 block mb-2">Students Excel <span class="text-red-500">*</span></label>

                                <input type="file" name="file" accept=".csv,.xlsx,.xls"
                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                   focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                       placeholder="e.g. 2025 Attachment Intake"
                                       required>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="items-center p-6 border-t border-gray-200 rounded-b">
                            <button id="uploadBtn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium
                               rounded-lg text-sm px-5 py-2.5 text-center"
                                    type="submit">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="add-student-modal">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow relative">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Student
                    </h3>
                    <button type="button" class="close-add-modal-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id ="addStudentForm" >
    @csrf





    <!-- Submit button -->
    <button type="submit" id="addStudentBtn"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
        Add
    </button>
</form>
                </div>
            </div>
        </div>
    </div>
      <!-- Assess Student Modal -->
<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="assess-modal">
    <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
        <div class="bg-white rounded-lg shadow relative">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">Assess Student</h3>
                <button type="button" class="close-assess-modal-btn text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

             <div class="p-2">
         <div class="p-2 max-h-[80vh] overflow-y-auto">
         <form id="assessForm">
            @csrf
        <input type="hidden" name="attachment_student_id" id="attachment_student_id">


         <div class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label for="punctuality_marks" class="required block font-medium">Punctuality Marks(max2)</label>
                <input type="number" min="0" max="5" id="punctuality_marks" name="punctuality_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="punctuality_remarks" class="required block font-medium">Punctuality Remarks</label>
                <textarea id="punctuality_remarks" name="ppunctuality_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="attendance_marks" class="required block font-medium">Attendance Marks(max2)</label>
                <input type="number" min="0" max="5" id="attendance_marks" name="attendance_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="attendance_remarks" class="required block font-medium">Attendance Remarks</label>
                <textarea id="attendance_remarks" name="attendance_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
               <label for="basic_skils_marks" class="required block font-medium">Basic Skills Marks(max4)</label>
                <input type="number" min="0" max="5" id="basic_skilsn_marks" name="basic_skils_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
              <label for="basic_skils_remarks" class="required block font-medium">Basic Skills Remarks</label>
             <textarea id="basic_skils_remarks" name="basic_skils_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
                <label for="general_office_applications_marks" class="required block font-medium">General Office Applications Marks(max4)</label>
                <input type="number" min="0" max="5" id="general_office_applications_marks" name="general_office_applications_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for=" general_office_applications_remarks" class="required block font-medium">General Office Applications Remarks</label>
                <textarea id="general_office_applications_remarks" name="general_office_applications_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
                <label for="technical_applications_marks" class="required block font-medium">Technical Applications Marks(max4)</label>
                <input type="number" min="0" max="5" id="technical_applications_marks" name="technical_applicationss_marks" class="w-full border rounded p-2" required>
             </div>
            <div>
                <label for="technical_applications" class="required block font-medium">Technical Applications Remarks</label>
               <textarea id="technical_applications_remarks" name="technical_applications_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
           </div>
            <div>               
                <label for="area_of_specialization_marks" class="required block font-medium">Area Of Specialization Marks(max4)</label>
                <input type="number" min="0" max="5" id="area_of_specialization_marks" name="area_of_specialization_marks" class="w-full border rounded p-2" required>
          </div>
         <div> 
             <label for="area_of_specialization_remarks" class="required block font-medium">Area Of Specialization Remarks</label>
             <textarea id="area_of_specialization_remarks" name="area_of_specialization_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
         </div>
           <div>
                <label for="scientific_and_technical_knowledge_marks" class="required block font-medium">Scientific And Technical Knowledge Marks(max2)</label>
                <input type="number" min="0" max="5" id="scientific_and_technical_knowledge_marks" name="scientific_and_technical_knowledgel_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="scientific_and_technical_knowledge_remarks" class="required block font-medium">Scientific And Technical Knowledge Remarks</label>
                <textarea id="scientific_and_technical_knowledge_remarks" name="scientific_and_technical_knowledgel_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
                <label for="intelligence_marks" class="required block font-medium">Intelligence Marks(max2)</label>
                <input type="number" min="0" max="5" id="intelligence_marks" name="intelligence_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="intelligence_remarks" class="required block font-medium">Intelligence Remarks</label>
                <textarea id="intelligence_remarks" name="intelligence_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
               <label for="learning_ability_marks" class="required block font-medium">Learning Ability Marks(max2)</label>
                <input type="number" min="0" max="5" id="learning_ability_marks" name="learning_ability_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
              <label for="learning_ability_remarks" class="required block font-medium">Learning Ability Remarks</label>
             <textarea id="learning_ability_remarks" name="learning_ability_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div> 
                <label for="responsibility_acceptance_marks" class="required block font-medium">Responsibility Acceptance Marks(max2)</label>
                <input type="number" min="0" max="5" id="responsibility_acceptance_marks" name="responsibility_acceptance_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for=" responsibility_acceptance_remarks" class="required block font-medium">Responsibility Acceptance  Remarks</label>
                <textarea id="responsibility_acceptance_remarks" name="responsibility_acceptance_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
                <label for="improvisation_marks" class="required block font-medium">Improvisation Marks(max2)</label>
                <input type="number" min="0" max="5" id="improvisation_marks" name="improvisation_marks" class="w-full border rounded p-2" required>
             </div>
            <div>
                <label for="improvisation_remarks" class="required block font-medium">Improvisation Remarks</label>
               <textarea id="improvisation_remarks" name="improvisation_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
           </div>
            <div>               
                <label for="environment_adjustment_marks" class="required block font-medium">Environment Adjustment Marks(max2)</label>
                <input type="number" min="0" max="5" id="environment_adjustment_marks" name="environment_adjustment_marks" class="w-full border rounded p-2" required>
          </div>
         <div> 
             <label for="environment_adjustment_remarks" class="required block font-medium">Environment Adjustment Remarks</label>
             <textarea id="environment_adjustment_remarks" name="environment_adjustment_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
         </div>
          <div>
                <label for="dependability_and_reliability_marks" class="required block font-medium">Dependability And Reliability Marks(max2)</label>
                <input type="number" min="0" max="5" id="dependability_and_reliability_marks" name="dependability_and_reliability_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="dependability_and_reliability_remarks" class="required block font-medium">Dependability And Relibility Remarks</label>
                <textarea id="dependability_and_reliability_remarks" name="dependability_and_reliability_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
               <label for="organization_and_planning_marks" class="required block font-medium">Organizatiion And Planning Marks(max2)</label>
                <input type="number" min="0" max="5" id="organization_and_planning_marks" name="organization_and_planning_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
              <label for="organization_and_planning_remarks" class="required block font-medium">Organization And Planning Remarks</label>
             <textarea id="organization_and_planning_remarks" name="organization_and_planning_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div> 
                <label for="effective_time_use_marks" class="required block font-medium">Effective Time Use Marks(max2)</label>
                <input type="number" min="0" max="5" id="effective_time_use_marks" name="effective_time_use_marks" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label for="effective_time_use_remarks" class="required block font-medium">Effective Time Use  Remarks</label>
                <textarea id="effective_time_use_remarks" name="effective_time_use_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Submit Industry Assessment</button>
    </form>
</div>
    
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
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

    
        const assessModal = new Modal($('#assess-modal')[0], {
                            backdrop: 'static',
                            closable: false
                            });

// open modal when assess button is clicked
$(document).on('click', '.assessBtn', function () {
    $("#assessForm")[0].reset();
    let id = $(this).data('id');
    let name = $(this).data('name');
    $('#attachment_student_id').val(id);
    $('#assessed_student_name').html(name);

    assessModal.show();
});

// close button
$('.close-assess-modal-btn').on('click', function () {
    assessModal.hide();
});

// submit assessment
$("#assessForm").on("submit", function(e) {
    e.preventDefault();
    let btn = $("#assessBtn");
    btn.prop("disabled", true).text('Submitting...');

    $.ajax({
        url: "{{ route('industrial_supervisor.assessment.store') }}", // <-- Add this route
        type: "POST",
        data: $(this).serialize(),
          success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // optionally reset form and close modal
                            $(this)[0].reset();
                            modal.hide();
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function (xhr) {
                        let res = xhr.responseJSON;
                        if (res && res.errors) {
                            let messages = Object.values(res.errors).flat().join("\n");
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: "Validation failed:\n" + messages,
                                showConfirmButton: false,
                                timer: 9000,
                                timerProgressBar: true
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Something went wrong',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    complete: function () {
                        // ALWAYS re-enable button after request completes
                        btn.prop("disabled", false).html("Add");
                    }
    });
});


    });
</script>


@endsection
