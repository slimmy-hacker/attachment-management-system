@extends('layouts.my_app')

@section('title')
   Locations
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
                            <a href="#" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Locations</a>
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
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All locations</h1>
        </div>
    </div>
</div>


<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden">
                <table class="table-fixed min-w-full divide-y divide-gray-200" id="locations_table">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 w-12">#</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Level</th>

                            <th class="p-4 flex space-x-2 justify-end">
                                <div class="flex space-x-2 justify-end">
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
                                    <button id="auto_fill_locations" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2">
                                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        Fill Cords
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

<!-- Upload Modal -->

<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="upload-location-modal">
    <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
        <!-- Modal content -->
        <div class="bg-white rounded-lg shadow relative">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">
                    Upload Locations
                </h3>
                <button type="button" class="close-upload-modal-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form id="uploadForm" enctype="multipart/form-data">
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

<!-- Add Modal -->
<div class="hidden fixed inset-0 z-50 overflow-y-auto" id="add-location-modal">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Add Single Location</h3>
                <button type="button" class="close-add-modal-btn text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">✕</button>
            </div>
     <form id="addLocationForm" >
@csrf
    <!-- Code -->
    <div>
        <label class="block text-sm font-medium">Code</label>
        <input type="text" name="code" value="{{ old('code') }}"
            class="mt-1 w-full border rounded p-2 @error('code') border-red-500 @enderror" required>
        @error('code')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Name -->
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input type="text" name="name" value="{{ old('name') }}"
            class="mt-1 w-full border rounded p-2 @error('name') border-red-500 @enderror" required>
        @error('name')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Level -->
    <div>
        <label class="block text-sm font-medium">Level</label>
<select name="level"
    class="mt-1 w-full border rounded p-2 @error('level') border-red-500 @enderror" required>
    <option value="">Select Level</option>
    <option value="1">County</option>
    <option value="2">Subcounty</option>
    <option value="3">Ward</option>
</select>
        @error('level')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Parent Code -->
    <div>
        <label class="block select2 text-sm font-medium">Parent Code (optional)</label>
        <select name="parent_code"
            class="mt-1 w-full border rounded p-2 @error('parent_code') border-red-500 @enderror">
            <option value="">No Parent</option>
            @foreach($locations as $location)
                <option value="{{ $location->code }}">{{ strtoupper($location->code) }} - {{ $location->name }}</option>
            @endforeach
        </select>
        @error('parent_code')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit"
            class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
            Save Location
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



    const uploadModal = new Modal($('#upload-location-modal')[0], {
        backdrop: 'static',
        closable: false
    });
    const addModal = new Modal($('#add-location-modal')[0], {
        backdrop: 'static',
        closable: false
    });

    $('#open-upload-modal-btn').click(() => uploadModal.show());
    $('.close-upload-modal-btn').click(() => uploadModal.hide());

    $('#open-add-modal-btn').click(() => addModal.show());
    $('.close-add-modal-btn').click(() => addModal.hide());

    // DataTable initialization
    var table = $("#locations_table").DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: "{{ route('admin.locations.index') }}",
        columns: [
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
                    uploadModal.hide();
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

    $("#auto_fill_locations").on('click', function (e) {
        e.preventDefault();
        let btn = $(this);

        btn.prop("disabled", true).html('updating <span class="loading-dots"></span>');



        $.ajax({
            url: "{{ route('admin.locations.auto_fill') }}",
            type: "get",
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.status === "success" ? 'success' : 'error',
                    title: response.message || 'Locations updated successfully',
                    showConfirmButton: false,
                    timer: 3000
                });

            },
            error: function (xhr) {

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Something went wrong',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
            },
            complete: function () {
                btn.prop("disabled", false).html("Update");
            }
        });
    });
});
</script>
@endsection
