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
                <div class="shadow overflow-hidden"> <div class="flex items-end gap-3 mt-3">
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
                                Sub County
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


@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
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
                { data: 'subcounty', name: 'subcounty' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Add student form submit (example)
        $("#assign_lecturers_form").on("submit", function(e) {
            e.preventDefault();
            let btn = $("#assign_lecturers_btn");
            btn.prop("disabled", true).text('Assigning...');

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.lecturerAssignment.generate') }}",  // Define this route to handle add student
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