@extends('layouts.my_app')
@section('title')
    Attachments
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
                                        <a href="#" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Attarchment Schedules</a>
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
                        <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Attachments</h1>
                    </div>

                </div>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden">
                            <table class="table-fixed min-w-full divide-y divide-gray-200" id="attarchment_schedules_table">
                                <thead class="bg-gray-100">
                                <tr>
                                     <th scope="col" class="p-2 w-12">
                                        <div class="flex items-center justify-center text-xs font-medium text-gray-500 uppercase">
                                            #
                                        </div>
                                    </th>
                                    <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                        Name
                                    </th>
                                    <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                       Slug
                                    </th>
                                    <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                       Start Date
                                    </th>
                                    <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                       End Date
                                    </th>
                                    <th scope="col" class="p-4">
                                        <button type="button" id="open-modal-btn" class="w-1/2 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center sm:w-auto">
                                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                            Add
                                        </button>
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


            <!-- Add User Modal -->
            <div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" data-modal-backdrop="static" id="add-schedule-modal">
                <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="bg-white rounded-lg shadow relative">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold">
                                Add New Attachment
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
                            <form id="scheduleForm">
                                @csrf()
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="name" class="text-sm font-medium text-gray-900 block mb-2">Attachment Name</label>
                                        <input type="text" name="name" id="name"
                                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                   focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                               placeholder="e.g. 2025 Attachment Intake"
                                               required>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="start_date" class="text-sm font-medium text-gray-900 block mb-2">Start Date</label>
                                        <input type="date" name="start_date" id="start_date"
                                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                   focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                               required>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="end_date" class="text-sm font-medium text-gray-900 block mb-2">End Date</label>
                                        <input type="date" name="end_date" id="end_date"
                                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                   focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                               required>
                                    </div>
                                </div>


                        <!-- Modal footer -->
                        <div class="items-center p-6 border-t border-gray-200 rounded-b">
                            <button id="uploadBtn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium
                               rounded-lg text-sm px-5 py-2.5 text-center"
                                    type="submit">
                                Add
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>






@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            const modal = new Modal($('#add-schedule-modal')[0], {
                backdrop: 'static',
                closable: false
            });

            $('#open-modal-btn').on('click', function () {
                modal.show();
            });
            $('.close-modal-btn').on('click', function () {
                modal.hide();
            });


            var table = $("#attarchment_schedules_table").DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: "{{ route('admin.attachment_schedules.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    {data: 'name', name: 'name'},
                    {data: 'slug', name: 'slug'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $("#scheduleForm").on("submit", function (e) {
                e.preventDefault();
                let btn = $("#uploadBtn");

                // Disable and show loading text
                btn.prop("disabled", true)
                    .html('Adding <span class="loading-dots"></span>');
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.attachment_schedule.store') }}", // adjust route name
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
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
                            $("#scheduleForm")[0].reset();
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
                        $("#uploadBtn").prop("disabled", false).html("Add");
                    }
                });
            });

        });
    </script>
@endsection
