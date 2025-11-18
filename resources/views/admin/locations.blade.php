@extends('layouts.my_app')

@section('title')
   Upload Locations
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
                        <tr>
                            <th class="p-4 w-12">#</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                            <th class="p-4">
                                <button id="open-modal-btn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2">
                                    <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Upload
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
<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 z-50 justify-center items-center h-modal sm:h-full" id="add-location-modal">
    <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
        <div class="bg-white rounded-lg shadow relative">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">Upload Locations</h3>
                <button type="button" class="close-modal-btn text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">
                    ✕
                </button>
            </div>

            <div class="p-6 space-y-6">
                <form id="locationForm" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-gray-900 block mb-2">Excel File <span class="text-red-500">*</span></label>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" class="block w-full border border-gray-300 rounded-lg p-2.5" required>
                    </div>

                    <div class="items-center p-6 border-t border-gray-200 rounded-b">
                        <button id="uploadBtn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    const modal = new Modal($('#add-location-modal')[0], { backdrop: 'static', closable: false });

    $('#open-modal-btn').click(() => modal.show());
    $('.close-modal-btn').click(() => modal.hide());

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

    $("#locationForm").submit(function (e) {
        e.preventDefault();
        let btn = $("#uploadBtn");

        // Disable and show loading text
        btn.prop("disabled", true)
            .html('Uploading <span class="loading-dots"></span>');
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

                    $("#locationForm")[0].reset();
                    modal.hide();
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
                }
                else {
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
                $("#uploadBtn").prop("disabled", false).html("Upload");
            }
        });
    });
});
</script>
@endsection
