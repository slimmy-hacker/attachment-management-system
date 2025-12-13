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
                <div class="shadow overflow-hidden">

                    <table class="table-fixed min-w-full divide-y divide-gray-200" id="my_students_table">
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
    </div>

                <div id="my_students_assessment-modal" tabindex="-1" aria-hidden="true"  data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-4/5 max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm ">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                <h3 class="text-lg font-semibold text-gray-">
                                    Student <span id="assessed_student_name"></span> Assement
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center close-assess-modal-btn">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                                <div class="p-2">
                                     <form id="assessForm">

                                @csrf
                                <!-- Hidden student ID, set dynamically -->
                                <input type="hidden" id="attachment_student_id" name="attachment_student_id" value="">

                                <div class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div >
                                        <label for="practical_marks" class="required block font-medium">Practical Marks(max 5)</label>
                                        <input type="number" min="0" max="5" id="practical_marks" name="practical_marks" class="w-full border rounded p-2" required>
                                    </div>
                                    <div >
                                        <label for="practical_remarks" class="required block font-medium">Practical Remarks</label>
                                        <textarea id="practical_remarks" name="practical_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                    </div>
                                    <div>
                                        <label for="communication_marks" class="required block font-medium">Communication Marks</label>
                                        <input type="number" min="0" max="5" id="communication_marks" name="communication_marks" class="w-full border rounded p-2" required>
                                    </div>
                                    <div>
                                        <label for="communication_remarks" class="required block font-medium">Report Remarks</label>
                                        <textarea id="communication_remarks" name="communication_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                    </div>
                                    <div>
                                        <label for="report_marks" class="required block font-medium">Report Marks</label>
                                        <input type="number" min="0" max="5" id="report_marks" name="report_marks" class="w-full border rounded p-2" required>
                                    </div>
                                    <div>
                                        <label for="report_remarks" class="required block font-medium">Report Remarks</label>
                                        <textarea id="report_remarks" name="report_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                    </div>

                                    <div>
                                        <label for="presentation_marks" class="required block font-medium">Presentation Marks</label>
                                        <input type="number" min="0" max="5" id="presentation_marks" name="presentation_marks" class="w-full border rounded p-2" required>
                                    </div>
                                    <div>
                                        <label for="presentation_remarks" class="required block font-medium">Presentation Remarks</label>
                                        <textarea id="presentation_remarks" name="presentation_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                    </div>

                                    <div>
                                        <label for="skills_marks" class="required block font-medium">Skills Marks</label>
                                        <input type="number" min="0" max="5" id="presentation_marks" name="skills_marks" class="w-full border rounded p-2" required>
                                    </div>
                                    <div>
                                        <label for="skills_remarks" class="required block font-medium">Skills Remarks</label>
                                        <textarea id="skills_remarks" name="skills_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                    </div>

                                    <div>
                                        <label for="innovativeness_marks" class="required block font-medium">Innovativeness Marks</label>
                                        <input type="number" min="0" max="5" id="presentation_marks" name="innovativeness_marks" class="w-full border rounded p-2" required>
                                    </div>
                                    <div>
                                        <label for="innovativeness_remarks" class="required block font-medium">Innovativeness Remarks</label>
                                        <textarea id="innovativeness_remarks" name="innovatiness_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                    </div>
                                </div>



                                <button type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Submit School Assessment</button>


                            </form>
                                </div>
                            <button  type="button" class="text-white inline-flex items-center bg-gray-300 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center close-assess-modal-btn">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                close
                            </button>
                        </div>
                    </div>
                </div>

    @include('student.student_attachment_details_modal')

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $("#my_students_table").DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: "{{ route('lecturer.my-students') }}",
                data: function (d) {
                    d.attachment_id = $('#attachment_filter').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },

                { data: 'name', name: 'name' },
                { data: 'reg_no', name: 'reg_no' },
                { data: 'department', name: 'department' },

                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        const assessModal = new Modal($('#my_students_assessment-modal')[0], {
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
        url: "{{ route('lecturer.assessment.store') }}", // <-- Add this route
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Assessment Saved',
                timer: 2000,
                showConfirmButton: false
            });

            assessModal.hide();
            $("#assessForm")[0].reset();
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Could not save assessment'
            });
        },
        complete: function() {
            btn.prop("disabled", false).text('Submit Assessment');
        }
    });
});


    });
</script>
@endsection
