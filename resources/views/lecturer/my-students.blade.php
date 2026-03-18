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

                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">My students</h1>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All My Students</h1>
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
                                <div class="flex items-center justify-center text-xs font-medium text-gray-500 uppercase">#</div>
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Reg No</th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Indur Supervisor</th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Indur Sup Phone</th>
                            
                            <th scope="col" class="p-4">Action</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="my_students_assessment-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-4/5 max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-800">Student <span id="assessed_student_name"></span> Assessment</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center close-assess-modal-btn">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>

                <div class="p-6">
                    @if(isset($assessment) && $assessment)
                        {{-- Show submitted assessment --}}
                        <div class="text-center py-8">
                            <div class="mb-4 flex justify-center">
                                <div class="rounded-full bg-green-100 p-3">
                                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Assessment Submitted</h3>
                            <p class="text-gray-500 mt-2">This assessment has already been submitted. You cannot edit it.</p>
                            <div class="mt-6 inline-block bg-gray-50 border rounded-lg p-4 text-left w-full">
                                @foreach([
                                    'practical_orientation' => 'Practical Orientation',
                                    'intellectual_activity' => 'Intellectual Activity',
                                    'independence' => 'Independence',
                                    'communication' => 'Communication',
                                    'technology_and_skills' => 'Technology & Skills',
                                    'innovativeness' => 'Innovativeness'
                                ] as $field => $label)
                                    <div class="mb-4">
                                        <span class="block text-xs font-semibold uppercase text-gray-400">{{ $label }}</span>
                                        <span class="text-sm font-bold text-gray-700">{{ $assessment->{$field.'_marks'} }} / 5</span>
                                        <p class="text-gray-600 text-sm">{{ $assessment->{$field.'_remarks'} }}</p>
                                    </div>
                                @endforeach
                                <div class="mt-4 font-bold text-gray-800">Total Marks: {{ $assessment->total_marks ?? 0 }} / 30</div>
                            </div>
                        </div>
                    @else
                        {{-- Show assessment form --}}
                        <form id="assessForm">
                            @csrf
                            <input type="hidden" id="attachment_student_id" name="attachment_student_id" value="">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <!-- Practical Orientation -->
                                <div>
                                    <label for="practical_orientation_marks" class="required block font-medium">Practical Orientation Marks (max 5)</label>
                                    <input type="number" min="0" max="5" id="practical_orientation_marks" name="practical_orientation_marks" class="marks-field w-full border rounded p-2" required>
                                    <small class="text-gray-500">Must be greater than 0</small>
                                </div>
                                <div>
                                    <label for="practical_orientation_remarks" class="required block font-medium">Practical Orientation Remarks</label>
                                    <textarea id="practical_orientation_remarks" name="practical_orientation_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                </div>

                                <!-- Intellectual Activity -->
                                <div>
                                    <label for="intellectual_activity_marks" class="required block font-medium">Intellectual Activity Marks (max 5)</label>
                                    <input type="number" min="0" max="5" id="intellectual_marks" name="intellectual_activity_marks" class="marks-field w-full border rounded p-2" required>
                                    <small class="text-gray-500">Must be greater than 0</small>
                                </div>
                                <div>
                                    <label for="intellectual_activity_remarks" class="required block font-medium">Intellectual Activity Remarks</label>
                                    <textarea id="intellectual_activity_remarks" name="intellectual_activity_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                </div>

                                <!-- Independence -->
                                <div>
                                    <label for="independence_marks" class="required block font-medium">Independence Marks (max 5)</label>
                                    <input type="number" min="0" max="5" id="independence_marks" name="independence_marks" class="marks-field w-full border rounded p-2" required>
                                    <small class="text-gray-500">Must be greater than 0</small>
                                </div>
                                <div>
                                    <label for="independence_remarks" class="required block font-medium">Independence Remarks</label>
                                    <textarea id="independence_remarks" name="independence_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                </div>

                                <!-- Communication -->
                                <div>
                                    <label for="communication_marks" class="required block font-medium">Communication Marks (max 5)</label>
                                    <input type="number" min="0" max="5" id="communication_marks" name="communication_marks" class="marks-field w-full border rounded p-2" required>
                                    <small class="text-gray-500">Must be greater than 0</small>
                                </div>
                                <div>
                                    <label for="communication_remarks" class="required block font-medium">Communication Remarks</label>
                                    <textarea id="communication_remarks" name="communication_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                </div>

                                <!-- Technology & Skills -->
                                <div>
                                    <label for="technology_and_skills_marks" class="required block font-medium">Technology & Skills Marks (max 5)</label>
                                    <input type="number" min="0" max="5" id="technology_and_skills_marks" name="technology_and_skills_marks" class="marks-field w-full border rounded p-2" required>
                                    <small class="text-gray-500">Must be greater than 0</small>
                                </div>
                                <div>
                                    <label for="technology_and_skills_remarks" class="required block font-medium">Technology & Skills Remarks</label>
                                    <textarea id="technology_and_skills_remarks" name="technology_and_skills_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                </div>

                                <!-- Innovativeness -->
                                <div>
                                    <label for="innovativeness_marks" class="required block font-medium">Innovativeness Marks (max 5)</label>
                                    <input type="number" min="0" max="5" id="innovativeness_marks" name="innovativeness_marks" class="marks-field w-full border rounded p-2" required>
                                    <small class="text-gray-500">Must be greater than 0</small>
                                </div>
                                <div>
                                    <label for="innovativeness_remarks" class="required block font-medium">Innovativeness Remarks</label>
                                    <textarea id="innovativeness_remarks" name="innovativeness_remarks" rows="3" class="w-full border rounded p-2" required></textarea>
                                </div>
                            </div>

                            <button type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Submit School Assessment</button>
                        </form>
                    @endif
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
                { data: 'company', name: 'company' },
                { data: 'industrial_supervisor', name: 'industrial_supervisor' },
                { data: 'industrial_supervisor_phone', name: 'industrial_supervisor_phone' },
               // { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        const assessModal = new Modal($('#my_students_assessment-modal')[0], {
            backdrop: 'static',
            closable: false
        });

        // Function to validate marks are greater than 0
        function validateMarks() {
            let isValid = true;
            let firstInvalidField = null;
            
            // Remove previous error styling
            $('.marks-field').removeClass('border-red-500');
            $('.error-message').remove();
            
            // Check each marks field
            $('.marks-field').each(function() {
                let value = $(this).val();
                let fieldName = $(this).attr('name');
                
                if (value === '' || value === null) {
                    isValid = false;
                    $(this).addClass('border-red-500');
                    $(this).after('<p class="error-message text-red-500 text-xs mt-1">This field is required</p>');
                    
                    if (!firstInvalidField) firstInvalidField = this;
                } else {
                    let numValue = parseFloat(value);
                    if (isNaN(numValue) || numValue <= 0) {
                        isValid = false;
                        $(this).addClass('border-red-500');
                        $(this).after('<p class="error-message text-red-500 text-xs mt-1">Marks must be greater than 0</p>');
                        
                        if (!firstInvalidField) firstInvalidField = this;
                    } else if (numValue > 5) {
                        isValid = false;
                        $(this).addClass('border-red-500');
                        $(this).after('<p class="error-message text-red-500 text-xs mt-1">Marks cannot exceed 5</p>');
                        
                        if (!firstInvalidField) firstInvalidField = this;
                    }
                }
            });
            
            // Scroll to first invalid field
            if (firstInvalidField) {
                $(firstInvalidField).focus();
                $('html, body').animate({
                    scrollTop: $(firstInvalidField).offset().top - 200
                }, 500);
            }
            
            return isValid;
        }

        // Real-time validation
        $(document).on('input', '.marks-field', function() {
            let value = $(this).val();
            
            // Remove error for this field
            $(this).removeClass('border-red-500');
            $(this).next('.error-message').remove();
            
            if (value !== '') {
                let numValue = parseFloat(value);
                if (!isNaN(numValue) && numValue > 0 && numValue <= 5) {
                    $(this).addClass('border-green-500');
                } else {
                    $(this).removeClass('border-green-500');
                }
            }
        });

        $(document).on('blur', '.marks-field', function() {
            let value = $(this).val();
            
            $(this).removeClass('border-red-500 border-green-500');
            $(this).next('.error-message').remove();
            
            if (value === '' || value === null) {
                $(this).addClass('border-red-500');
                $(this).after('<p class="error-message text-red-500 text-xs mt-1">Marks are required</p>');
            } else {
                let numValue = parseFloat(value);
                if (isNaN(numValue) || numValue <= 0) {
                    $(this).addClass('border-red-500');
                    $(this).after('<p class="error-message text-red-500 text-xs mt-1">Marks must be greater than 0</p>');
                } else if (numValue > 5) {
                    $(this).addClass('border-red-500');
                    $(this).after('<p class="error-message text-red-500 text-xs mt-1">Marks cannot exceed 5</p>');
                }
            }
        });

        $(document).on('click', '.assessBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#attachment_student_id').val(id);
            $('#assessed_student_name').html(name);
            
            $('#assessForm').hide();
            $('#assessment_display').remove();
            
            // Clear validation styling
            $('.marks-field').removeClass('border-red-500 border-green-500');
            $('.error-message').remove();

            $.get("{{ route('lecturer.assessment.check') }}", { student_id: id }, function(response) {
                if(response.exists) {
                    let totalScore = 0;
                    let html = `
                    <div id="assessment_display" class="bg-white p-6 rounded-xl border border-green-200 shadow-sm animate-fade-in">
                        <div class="flex items-center justify-center mb-6">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-center text-xl font-bold text-gray-800 mb-4">Assessment Already Submitted</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">`;

                    $.each(response.assessment, function(label, data) {
                        let marks = parseInt(data.marks) || 0;
                        totalScore += marks;
                        html += `
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">${label}</p>
                            <p class="text-sm font-black text-blue-600">${marks} / 5</p>
                            <p class="text-xs text-gray-600 mt-1 italic">"${data.remarks || 'No remarks provided'}"</p>
                        </div>`;
                    });

                    html += `
                        </div>
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg text-center border border-blue-100">
                            <p class="text-sm text-blue-800 font-medium">Total School Score: <span class="text-lg font-bold">${totalScore} / 30</span></p>
                        </div>
                    </div>`;

                    $('#assessForm').after(html);
                } else {
                    $('#assessForm')[0].reset();
                    $('#assessForm').show();
                }
            }).fail(function() {
                Swal.fire('Error', 'Could not check assessment status', 'error');
            });

            assessModal.show();
        });

        $('.close-assess-modal-btn').on('click', function () {
            assessModal.hide();
            // Clear validation styling
            $('.marks-field').removeClass('border-red-500 border-green-500');
            $('.error-message').remove();
        });

        $("#assessForm").on("submit", function(e) {
            e.preventDefault();
            
            // Validate marks are greater than 0
            if (!validateMarks()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error',
                    text: 'All marks must be greater than 0. Please check the highlighted fields.',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }
            
            let btn = $(this).find('button[type="submit"]');
            let originalText = btn.text();
            
            btn.prop("disabled", true).html('<span class="animate-spin inline-block mr-2">⏳</span> Submitting...');

            $.ajax({
                url: "{{ route('lecturer.assessment.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Assessment saved successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        assessModal.hide();
                        $("#assessForm")[0].reset();
                        table.ajax.reload(null, false);
                        
                        // Clear validation styling
                        $('.marks-field').removeClass('border-red-500 border-green-500');
                        $('.error-message').remove();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Could not save assessment';
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                },
                complete: function() {
                    btn.prop("disabled", false).text(originalText);
                }
            });
        });
    });
</script>

<style>
    .border-red-500 {
        border-color: #ef4444 !important;
        border-width: 2px !important;
    }
    
    .border-green-500 {
        border-color: #10b981 !important;
        border-width: 2px !important;
    }
    
    .error-message {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: block;
    }
    
    .required:after {
        content: " *";
        color: #ef4444;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .marks-field {
        transition: all 0.2s ease;
    }
    
    .marks-field:focus {
        outline: none;
        ring: 2px solid #3b82f6;
    }
</style>
@endsection