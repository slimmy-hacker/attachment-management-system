@extends('layouts.my_app')
@section('title')
   Lecturers Assignments
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
                                <a href="#" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Lecturer Assignment</a>
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
                    <div class="flex items-end gap-3 mt-3">
                        <form id="assign_lecturers_form"
                              class="flex flex-wrap items-end gap-4 bg-white p-4 rounded-lg shadow-sm">
                            @csrf

                            <!-- Attachment -->
                            <div class="w-64">
                                <label for="attachment_filter"
                                       class=" required block text-sm font-medium text-gray-700 mb-1">
                                    Attachment
                                </label>

                                <select name="attachment_id" id="attachment_filter" required
                                        class="w-full border border-gray-300 rounded-lg p-2 select2 bg-white text-sm">
                                    <option value="">Select Attachments</option>
                                    @foreach($attachments as $attachment)
                                        <option value="{{ $attachment->id }}">
                                            {{ $attachment->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Department -->
                            <div class="w-64">
                                <label for="department_id"
                                       class=" required block text-sm font-medium text-gray-700 mb-1">
                                    Select Department
                                </label>

                                <select name="department_id" id="department_filter" required
                                        class="select2 w-full p-2 border border-gray-300 rounded-lg text-sm focus:ring focus:border-blue-300">
                                    <option value="">-- Choose Department --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Assign Button -->
                            <div class="pt-6">
                                <button type="submit" id="assign_lecturers_btn"
                                        class="inline-flex items-center px-6 py-2.5
                       bg-blue-600 text-white text-sm font-medium
                       rounded-lg hover:bg-blue-700 transition">
                                    Assign
                                </button>
                            </div>

                        </form>
                        
                        <!-- TWO BUTTONS INSTEAD OF ONE -->
                        <div class="flex gap-2">
                            <!-- Button 1: Filter by Date -->
                            <button type="button" id="filterByDateBtn"
                                    class="inline-flex items-center px-4 py-2.5
                                   bg-indigo-600 text-white text-sm font-medium
                                   rounded-lg hover:bg-indigo-700 transition">
                                <i class="fa fa-calendar mr-2"></i> Filter by Date
                            </button>
                            
                            <!-- Button 2: Student Count -->
                            <button type="button" id="studentCountBtn"
                                    class="inline-flex items-center px-4 py-2.5
                                   bg-green-600 text-white text-sm font-medium
                                   rounded-lg hover:bg-green-700 transition">
                                <i class="fa fa-users mr-2"></i> Students per Lecturer
                            </button>
                        </div>
                    </div>

                    <table class="table-fixed min-w-full divide-y divide-gray-200" id="attarchment_schedules_table">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-2 w-12">
                                <div class="flex items-center justify-center text-xs font-medium text-gray-500 uppercase">
                                    #
                                </div>
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Attachment
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
                                Supervisor
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Company
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Town
                            </th>
                            <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                Phone Number
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
<!-- Custom Modal (no Bootstrap required) -->
<div id="customDateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: relative; width: 500px; margin: 100px auto; background: white; border-radius: 8px; padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;">Filter Students by End Date</h3>
            <button onclick="document.getElementById('customDateModal').style.display='none'" style="background: none; border: none; font-size: 24px;">&times;</button>
        </div>
        
        <form id="customDateFilterForm">
            <input type="hidden" name="attachment_id" id="custom_date_attachment_id">
            <input type="hidden" name="department_id" id="custom_date_department_id">
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Start Date (Optional)</label>
                <input type="date" name="start_date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">End Date <span style="color: red;">*</span></label>
                <input type="date" name="end_date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
            </div>
            
            <div style="text-align: right;">
                <button type="button" onclick="document.getElementById('customDateModal').style.display='none'" style="padding: 8px 16px; margin-right: 10px; background: #6c757d; color: white; border: none; border-radius: 4px;">Close</button>
                <button type="button" id="customApplyDateFilterBtn" style="padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px;">Apply Filter</button>
            </div>
        </form>
    </div>
</div>
    <!-- Results Modal (reused for both) -->
    <div class="modal fade" id="resultsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultsModalTitle">Results</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="filterResults"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        // Initialize DataTable
        var table = $("#attarchment_schedules_table").DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: "{{ route('admin.lecturerAssignment.index') }}",
                data: function (d) {
                    d.attachment_id = $('#attachment_filter').val();
                    d.department_id = $('#department_filter').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'attachment', name: 'attachment' },
                { data: 'name', name: 'name' },
                { data: 'reg_no', name: 'reg_no' },
                { data: 'department', name: 'department' },
                { data: 'lecturer', name: 'lecturer' },
                { data: 'company', name: 'company' },
                { data: 'town', name: 'town' },
                { data: 'phone_number', name: 'phone_number' },
            ]
        });
// Replace the Bootstrap modal code with this custom version
$('#filterByDateBtn').click(function() {
    let attachmentId = $('#attachment_filter').val();
    let departmentId = $('#department_filter').val();
    
    if (!attachmentId || !departmentId) {
        Swal.fire({
            icon: 'warning',
            title: 'Please select both Attachment and Department'
        });
        return;
    }
    
    $('#custom_date_attachment_id').val(attachmentId);
    $('#custom_date_department_id').val(departmentId);
    $('#customDateModal').show();
});

$('#customApplyDateFilterBtn').click(function() {
    let endDate = $('input[name="end_date"]').val();
    
    if (!endDate) {
        Swal.fire({
            icon: 'warning',
            title: 'Please select an end date'
        });
        return;
    }
    
    let formData = $('#customDateFilterForm').serialize();
    
    $.ajax({
        url: "{{ route('lecturer-assignment.filter-by-date') }}",
        method: 'GET',
        data: formData,
        beforeSend: function() {
            $('#customApplyDateFilterBtn').html('Loading...');
            $('#customApplyDateFilterBtn').prop('disabled', true);
        },
        success: function(response) {
            $('#customDateModal').hide();
            $('#customDateFilterForm')[0].reset();
            displayResults(response, 'date');
        },
        error: function(xhr) {
            let res = xhr.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: res?.message || 'Something went wrong'
            });
        },
        complete: function() {
            $('#customApplyDateFilterBtn').html('Apply Filter');
            $('#customApplyDateFilterBtn').prop('disabled', false);
        }
    });
});
        // =========================================
        // OPTION 2: Student Count per Lecturer
        // =========================================
        $('#studentCountBtn').click(function() {
            let attachmentId = $('#attachment_filter').val();
            let departmentId = $('#department_filter').val();
            
            if (!attachmentId || !departmentId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select both Attachment and Department'
                });
                return;
            }
            
            $.ajax({
                url: "{{ route('lecturer-assignment.student-count') }}",
                method: 'GET',
                data: {
                    attachment_id: attachmentId,
                    department_id: departmentId
                },
                beforeSend: function() {
                    $('#studentCountBtn').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                },
                success: function(response) {
                    displayResults(response, 'count');
                },
                error: function(xhr) {
                    let res = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res?.message || 'Something went wrong'
                    });
                },
                complete: function() {
                    $('#studentCountBtn').html('<i class="fa fa-users mr-2"></i> Students per Lecturer');
                }
            });
        });// =========================================
// Display Results Function - WITH STUDENT DETAILS
// =========================================
function displayResults(response, type) {
    let title = type === 'date' ? 'Students Filtered by End Date' : 'Student Count by Lecturer';
    
    // Calculate summary statistics
    let totalStudents = response.total_students;
    let totalLecturers = response.total_lecturers;
    let averagePerLecturer = totalLecturers > 0 ? (totalStudents / totalLecturers).toFixed(2) : 0;
    
    // Find min and max from summary data
    let studentCounts = response.summary.map(item => item.student_count);
    let minStudents = studentCounts.length > 0 ? Math.min(...studentCounts) : 0;
    let maxStudents = studentCounts.length > 0 ? Math.max(...studentCounts) : 0;
    
    let minLecturers = response.summary.filter(item => item.student_count === minStudents).map(item => item.lecturer_name).join(', ');
    let maxLecturers = response.summary.filter(item => item.student_count === maxStudents).map(item => item.lecturer_name).join(', ');
    
    // Start building HTML
    let html = `
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="resultsOverlay">
            <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-lg bg-white" style="max-width: 1200px; max-height: 90vh; overflow-y: auto;">
                <div class="flex justify-between items-center mb-4 sticky top-0 bg-white pt-2 pb-2 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fa ${type === 'date' ? 'fa-calendar' : 'fa-users'} mr-2 text-indigo-600"></i>${title}
                    </h3>
                    <button type="button" id="closeResultsBtn" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
    `;
    
    // ===== DATE-SPECIFIC UI =====
    if (type === 'date') {
        let startDate = response.filters?.start_date 
            ? new Date(response.filters.start_date).toLocaleDateString('en-GB') 
            : 'Any';
        let endDate = response.filters?.end_date 
            ? new Date(response.filters.end_date).toLocaleDateString('en-GB') 
            : 'Any';
        
        let earliestEndDate = response.date_range_info?.earliest_end_date 
            ? new Date(response.date_range_info.earliest_end_date).toLocaleDateString('en-GB') 
            : 'N/A';
        let latestEndDate = response.date_range_info?.latest_end_date 
            ? new Date(response.date_range_info.latest_end_date).toLocaleDateString('en-GB') 
            : 'N/A';
        
        html += `
            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-200 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="text-xs text-indigo-600 font-medium uppercase">SELECTED RANGE</span>
                        <div class="text-sm font-semibold text-indigo-800 mt-1">${startDate} → ${endDate}</div>
                    </div>
                    <div>
                        <span class="text-xs text-indigo-600 font-medium uppercase">AVAILABLE DATES</span>
                        <div class="text-sm font-semibold text-indigo-800 mt-1">${earliestEndDate} → ${latestEndDate}</div>
                    </div>
                    <div>
                        <span class="text-xs text-indigo-600 font-medium uppercase">STUDENTS IN RANGE</span>
                        <div class="text-sm font-semibold text-indigo-800 mt-1">${totalStudents} students</div>
                    </div>
                </div>
            </div>
        `;
    } else {
        html += `
            <div class="bg-green-50 p-4 rounded-lg border border-green-200 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-green-600 font-medium uppercase">TOTAL STUDENTS</span>
                        <div class="text-sm font-semibold text-green-800 mt-1">All ${totalStudents} students</div>
                    </div>
                    <div>
                        <span class="text-xs text-green-600 font-medium uppercase">TOTAL LECTURERS</span>
                        <div class="text-sm font-semibold text-green-800 mt-1">${totalLecturers} lecturers</div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Summary Cards
    html += `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Total Students</div>
                <div class="text-2xl font-bold text-blue-800">${totalStudents}</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="text-sm text-green-600 font-medium">Total Lecturers</div>
                <div class="text-2xl font-bold text-green-800">${totalLecturers}</div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="text-sm text-purple-600 font-medium">Average</div>
                <div class="text-2xl font-bold text-purple-800">${averagePerLecturer}</div>
            </div>
            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                <div class="text-sm text-orange-600 font-medium">Range</div>
                <div class="text-sm font-semibold text-orange-800">${minStudents} - ${maxStudents}</div>
            </div>
        </div>
        
        <!-- Min/Max Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-red-50 p-3 rounded-lg border border-red-200">
                <div class="text-sm text-red-600 font-medium">Minimum (${minStudents} students)</div>
                <div class="text-sm text-red-800">${minLecturers}</div>
            </div>
            <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                <div class="text-sm text-green-600 font-medium">Maximum (${maxStudents} students)</div>
                <div class="text-sm text-green-800">${maxLecturers}</div>
            </div>
        </div>
    `;
    
    // Detailed Lecturer Cards with Student Lists
    html += `<div class="space-y-4 mt-4">`;
    
    if (response.detailed && response.detailed.length > 0) {
        // Sort by student count (highest first)
        let sortedDetailed = [...response.detailed].sort((a, b) => b.student_count - a.student_count);
        
        $.each(sortedDetailed, function(index, lecturer) {
            let percentage = ((lecturer.student_count / totalStudents) * 100).toFixed(1);
            
            html += `
                <div class="border rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                        <div>
                            <span class="font-semibold text-gray-800">${lecturer.lecturer_name}</span>
                            <span class="ml-2 text-sm text-gray-600">(${lecturer.student_count} students, ${percentage}% of total)</span>
                        </div>
                        <button type="button" class="toggle-details text-blue-600 hover:text-blue-800 text-sm" data-target="details-${index}">
                            <i class="fa fa-chevron-down"></i> Show Students
                        </button>
                    </div>
                    <div id="details-${index}" class="hidden p-4 bg-white">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">#</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Student Name</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Reg No</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Company</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Town</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">End Date</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Phone</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
            `;
            
            $.each(lecturer.students, function(idx, student) {
                html += `
                    <tr>
                        <td class="px-3 py-2 text-sm text-gray-900">${idx + 1}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">${student.student_name}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">${student.reg_no}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">${student.company_name}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">${student.town}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">${student.end_date}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">${student.phone}</td>
                    </tr>
                `;
            });
            
            html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        });
    } else {
        html += `<div class="text-center py-8 text-gray-500">No data found</div>`;
    }
    
    html += `
            </div>
            
            <!-- Footer -->
            <div class="mt-6 flex justify-between items-center border-t pt-4">
                <div class="text-xs text-gray-400">
                    <i class="fa fa-info-circle mr-1"></i>
                    ${type === 'date' ? `End date filter: ${response.filters?.start_date || 'any'} to ${response.filters?.end_date || 'any'}` : 'All students'}
                </div>
                <div>
                    <button type="button" id="closeResultsBtn2" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    `;
    
    
    $('#resultsOverlay').remove();
    
    
    $('body').append(html);
    
    
    $('.toggle-details').click(function() {
        let target = $(this).data('target');
        $('#' + target).toggleClass('hidden');
        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
    });
    
    
    $('#closeResultsBtn, #closeResultsBtn2').click(function() {
        $('#resultsOverlay').remove();
    });
}

        
        $("#assign_lecturers_form").on("submit", function(e) {
            e.preventDefault();
            let btn = $("#assign_lecturers_btn");
            btn.prop("disabled", true).text('Assigning...');

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.lecturerAssignment.generate') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Lecturers Assigned Successfully',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message || 'Failed to Assign Lecturers'
                        });
                    }
                },
                error: function(xhr) {
                    let res = xhr.responseJSON;
                    if (res && res.errors) {
                        let messages = Object.values(res.errors).flat().join("\n");
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: messages
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong'
                        });
                    }
                },
                complete: function() {
                    btn.prop("disabled", false).text('Assign');
                }
            });
        });

        
        $('#attachment_filter').on('change', function () {
            table.ajax.reload(null, false);
        });
        
        $('#department_filter').on('change', function () {
            table.ajax.reload(null, false);
        });
    });
</script>
@endsection