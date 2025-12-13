@extends('layouts.my_app')
@section('title')
   Attachies
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
                <div class="shadow overflow-hidden"> <div class="flex items-end gap-3 mt-3">
                        <div class="w-64">
                            <label for="attachment_filter" class="block text-sm font-medium text-gray-700">
                                Attachment
                            </label>

                            <select name="attachment_filter" id="attachment_filter"
                                    class="w-full border border-gray-300 rounded-lg p-2 select2 bg-white text-sm">
                                <option value="">All Attachments</option>
                                @foreach($attachments as $attachment)
                                    <option value="{{ $attachment->id }}">{{ $attachment->name }}</option>
                                @endforeach
                            </select>
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
                                Status
                            </th>
                            <th scope="col" class="p-4">
                                <div class="flex space-x-2 justify-end">
                                    <button type="button" id="open-add-modal-btn" class="w-auto text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center">
                                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        Add
                                    </button>
                                    <button type="button" id="open-modal-btn" class="w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center">
                                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        Upload
                                    </button>
                                </div>
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

    <!-- Student -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Select Student
        </label>
        <select name="student_id"  class="select2 block w-full p-2 border rounded focus:ring focus:border-blue-300">
            <option value="">-- choose student --</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}">
                    {{ $student->reg_no }} - {{ $student->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Attachment -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Select Attachment
        </label>
        <select name="attachment_id" class="select2 block w-full p-2 border rounded focus:ring focus:border-blue-300">
            <option value="">-- choose attachment --</option>
            @foreach ($attachments as $attachment)
                <option value="{{ $attachment->id }}" >
                    {{ $attachment->name}}
                </option>
            @endforeach
        </select>
    </div>

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

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        // Initialize modals
        const uploadModal = new Modal($('#add-schedule-modal')[0], {
            backdrop: 'static',
            closable: false
        });
        const addModal = new Modal($('#add-student-modal')[0], {
            backdrop: 'static',
            closable: false
        });


        $('#open-modal-btn').on('click', function () {
            uploadModal.show();
        });
        $('.close-modal-btn').on('click', function () {
            uploadModal.hide();
        });

        $('#open-add-modal-btn').on('click', function () {
            addModal.show();
        });
        $('.close-add-modal-btn').on('click', function () {
            addModal.hide();
        });

        var table = $("#attarchment_schedules_table").DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: "{{ route('admin.attachment_student.index') }}",
                data: function (d) {
                    d.attachment_id = $('#attachment_filter').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'attachment', name: 'attachment' },
                { data: 'name', name: 'name' },
                { data: 'reg_no', name: 'reg_no' },
                { data: 'department', name: 'department' },
                { data: 'lecturer', name: 'lecturer' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Upload form submit
        $("#scheduleForm").on("submit", function (e) {
            e.preventDefault();
            let btn = $("#uploadBtn");
            btn.prop("disabled", true).html('Uploading <span class="loading-dots"></span>');
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.attachment_student.upload') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "success") {
                        let stats = response.stats;
                        let failureHtml = "";

                        if (stats.fail_count > 0) {
                            failureHtml += "<ul class='list-group'>";
                            stats.failed_records.forEach(function (item) {
                                failureHtml += `<li class="list-group-item text-danger">${item.reason}</li>`;
                            });
                            failureHtml += "</ul>";
                        }

                        let htmlMsg = `
                            <strong>Upload Completed!</strong><br>
                            <strong>Successful:</strong> ${stats.success_count}<br>
                            <strong>Failed:</strong> ${stats.fail_count}<br><br>
                            ${failureHtml}
                        `;

                        Swal.fire({
                            icon: stats.fail_count > 0 ? "warning" : "success",
                            title: "Import Report",
                            html: htmlMsg,
                            width: 600,
                        });

                        $("#scheduleForm")[0].reset();
                        uploadModal.hide();
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
                    $("#uploadBtn").prop("disabled", false).html("Upload");
                }
            });
        });

        // Add student form submit (example)
        $("#addStudentForm").on("submit", function(e) {
            e.preventDefault();
            let btn = $("#addStudentBtn");
            btn.prop("disabled", true).text('Adding...');

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.attachment_student.add') }}",  // Define this route to handle add student
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Student Added Successfully',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        addModal.hide();
                        table.ajax.reload(null, false);
                        $("#addStudentForm")[0].reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message || 'Failed to add student'
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
                    btn.prop("disabled", false).text('Add');
                }
            });
        });

        $('#attachment_filter').on('change', function () {
            table.ajax.reload(null, false);
        });

    });
</script>
@endsection
