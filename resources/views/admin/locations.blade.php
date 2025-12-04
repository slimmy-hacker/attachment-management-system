@extends('layouts.my_app')

@section('title')
   Locations
@endsection

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
    <div class="mb-1 w-full">
        <div class="mb-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Locations</h1>
        </div>
    </div>
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden">
                <table class="table-fixed min-w-full divide-y divide-gray-200" id="locations_table">
                    <thead class="bg-gray-100">
<<<<<<< HEAD

  
                            <th class="p-4 w-12">#</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
              

=======
>>>>>>> ddc8c2222cbcf430ba3c1da32ac032bc16678a6e
                        <tr>
                            <th class="p-4 w-12">#</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
<<<<<<< HEAD

=======
>>>>>>> ddc8c2222cbcf430ba3c1da32ac032bc16678a6e
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                            <th class="p-4 flex space-x-2 justify-end">
                                <!-- Upload Button -->
                                <button id="open-upload-modal-btn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2">
                                    <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Upload
                                </button>
                                
                                <!-- Add Button -->
                                <button id="open-add-modal-btn" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2">
                                    <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Add
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="hidden fixed inset-0 z-50 overflow-y-auto" id="upload-location-modal">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Upload Locations</h3>
                <button type="button" class="close-upload-modal-btn text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">✕</button>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="text-sm font-medium text-gray-900 block mb-2">Excel File <span class="text-red-500">*</span></label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="block w-full border border-gray-300 rounded-lg p-2.5" required>
                </div>
                <div class="mt-4 flex justify-end">
                    <button id="uploadBtn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="hidden fixed inset-0 z-50 overflow-y-auto" id="add-location-modal">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Add Single Location</h3>
                <button type="button" class="close-add-modal-btn text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">✕</button>
            </div>
            <form id="addLocationForm">
                @csrf
                <div class="mb-4">
                    <label for="name" class="text-sm font-medium text-gray-900 block mb-2">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required class="block w-full border border-gray-300 rounded-lg p-2.5" placeholder="Enter location name">
                </div>

                <div class="mb-4">
                    <label for="code" class="text-sm font-medium text-gray-900 block mb-2">Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" required class="block w-full border border-gray-300 rounded-lg p-2.5" placeholder="Enter unique code">
                </div>

                <div class="mb-4">
                    <label for="parent_code" class="text-sm font-medium text-gray-900 block mb-2">Parent Code</label>
                    <input type="text" name="parent_code" id="parent_code" class="block w-full border border-gray-300 rounded-lg p-2.5" placeholder="Enter parent code (optional)">
                </div>

                <div class="mb-4">
                    <label for="level" class="text-sm font-medium text-gray-900 block mb-2">Level <span class="text-red-500">*</span></label>
                    <select name="level" id="level" required class="block w-full border border-gray-300 rounded-lg p-2.5">
                        <option value="">Select level</option>
                        <option value="1">County</option>
                        <option value="2">Subcounty</option>
                        <option value="3">Ward</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button id="addBtn" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5" type="submit">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // Modal toggles
    function showModal(modal) {
        modal.removeClass('hidden').addClass('flex');
    }
    function hideModal(modal) {
        modal.removeClass('flex').addClass('hidden');
    }

    const uploadModal = $('#upload-location-modal');
    const addModal = $('#add-location-modal');

    $('#open-upload-modal-btn').click(() => showModal(uploadModal));
    $('.close-upload-modal-btn').click(() => hideModal(uploadModal));

    $('#open-add-modal-btn').click(() => showModal(addModal));
    $('.close-add-modal-btn').click(() => hideModal(addModal));

    // DataTable initialization
    var table = $("#locations_table").DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: "{{ route('admin.locations.index') }}",
        columns: [
<<<<<<< HEAD



            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'code', name: 'code' },
            { data: 'parent_code', name: 'parent_code' },
            { data: 'name', name: 'name' },
            { data: 'level', name: 'level' },



=======
>>>>>>> ddc8c2222cbcf430ba3c1da32ac032bc16678a6e
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'parent_name', name: 'locations.name' },
            { data: 'level_name', name: 'level_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Upload form submit
    $("#uploadForm").submit(function (e) {
        e.preventDefault();
        let btn = $("#uploadBtn");

        btn.prop("disabled", true).html('Uploading <span class="loading-dots"></span>');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.locations.upload') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.status === "success" ? 'success' : 'error',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                if (response.status === "success") {
                    $("#uploadForm")[0].reset();
                    hideModal(uploadModal);
                    table.ajax.reload(null, false);
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
                btn.prop("disabled", false).html("Upload");
            }
        });
    });

    // Add single location form submit
    $("#addLocationForm").submit(function (e) {
        e.preventDefault();
        let btn = $("#addBtn");

        btn.prop("disabled", true).html('Adding <span class="loading-dots"></span>');

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.locations.add') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.status === "success" ? 'success' : 'error',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                if (response.status === "success") {
                    $("#addLocationForm")[0].reset();
                    hideModal(addModal);
                    table.ajax.reload(null, false);
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
                btn.prop("disabled", false).html("Add");
            }
        });
    });
});
</script>
@endsection
