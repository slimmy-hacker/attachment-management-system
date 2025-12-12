@extends('layouts.my_app')

@section('title')
    administrative units
@endsection

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
    <div class="mb-1 w-full">
        <div class="mb-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Administrative units</h1>
        </div>
    </div>
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden">
                <table class="table-fixed min-w-full divide-y divide-gray-200" id="administrative_units_table">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 w-12">#</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                            <th class="p-4">
                                <div class="flex space-x-2 justify-end">
                                    <!-- Upload button unchanged -->
                                    <button id="open-upload-modal-btn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2">
                                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        Upload
                                    </button>

                                    <!-- New Add button -->
                                    <button id="open-add-modal-btn" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2">
                                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.414 9l-3.707 3.707-1.414-1.414L10.586 7.5 6.879 3.793 8.293 2.379 13 7.086l-1.414 1.414z" clip-rule="evenodd"/></svg>
                                        Add
                                    </button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal unchanged -->
<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 z-50 justify-center items-center h-modal sm:h-full" id="add-location-modal">
    <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
        <div class="bg-white rounded-lg shadow relative">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">Upload Administrative units</h3>
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
                        <button class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal (new) -->
<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 z-50 justify-center items-center h-modal sm:h-full" id="add-administrative-unit-modal">
    <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
        <div class="bg-white rounded-lg shadow relative">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">Add Administrative Unit</h3>
                <button type="button" class="close-add-modal-btn text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">
                    ✕
                </button>
            </div>

            <div class="p-6 space-y-6">
                <form id="addAdminUnitForm">
                    @csrf               
    
    <div class="mb-4">
        <label class=" required block text-sm font-medium text-gray-700 mb-1">
            Code
        </label>
        <input type="text" name="code" value="{{ old('code') }}"
            class="block w-full p-2 border rounded focus:ring focus:border-blue-300 @error('code') border-red-500 @enderror" required>
        @error('code')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Name -->
    <div class="mb-4">
        <label class=" required block  text-sm font-medium text-gray-700 mb-1">
            Name
        </label>
        <input type="text" name="name" value="{{ old('name') }}"
            class="block w-full p-2 border rounded focus:ring focus:border-blue-300 @error('name') border-red-500 @enderror" required>
        @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

   <!-- Level -->
<div class="mb-4">
    <label class="required block select2 text-sm font-medium text-gray-700 mb-1">
        Select Level
    </label>
    <select name="level" id="level"
        class="select2 block w-full p-2 border rounded focus:ring focus:border-blue-300 @error('level') border-red-500 @enderror" required>
        <option value="">-- Select Level --</option>
        <option value="1" {{ old('level') == '1' ? 'selected' : '' }}>School</option>
        <option value="2" {{ old('level') == '2' ? 'selected' : '' }}>Department</option>
        <option value="3" {{ old('level') == '3' ? 'selected' : '' }}>Course</option>
    </select>
    @error('level')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<!-- Parent -->
<div class="mb-4">
    <label class="block select2 text-sm font-medium text-gray-700 mb-1">
        Select Parent
    </label>
    <select name="parent" id="parent"
        class="select2 block w-full p-2 border rounded focus:ring focus:border-blue-300 @error('parent') border-red-500 @enderror">
        <option value="">-- Select Parent --</option>
        @foreach($admin_units as $admin_unit)
            <option value="{{ $admin_unit->id }}" {{ old('parent') == $admin_unit->id ? 'selected' : '' }}>
                {{ $admin_unit->name }}
            </option>
        @endforeach
    </select>
    @error('parent')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


    <!-- Submit button -->
    <button type="submit" id="addAdministrativeUnitBtn"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
        Add Administrative Unit
    </button>
</form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
 let allUnits = @json($admin_units);
   
    const uploadModal = new Modal($('#add-location-modal')[0], { backdrop: 'static', closable: false });
    const addModal = new Modal($('#add-administrative-unit-modal')[0], { backdrop: 'static', closable: false });

    // Buttons to open modals
    $('#open-upload-modal-btn').click(() => uploadModal.show());
    $('#open-add-modal-btn').click(() => addModal.show());

    // Buttons to close modals
    $('.close-modal-btn').click(() => uploadModal.hide());
    $('.close-add-modal-btn').click(() => addModal.hide());

    // DataTable initialization (unchanged)
    var table = $("#administrative_units_table").DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: "{{ route('admin.administrative-units.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'parent_name', name: 'administrative_units.name' },
            { data: 'level_name', name: 'level_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Upload form submission - keep your existing code here unchanged
    $("#locationForm").submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.administrative-units.upload') }}",
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
            }
        });
    });
    // Add form submission
    $("#addAdminUnitForm").submit(function(e) {
        e.preventDefault();
        let form = $(this);
        let data = form.serialize();

        $.ajax({
            url: "{{ route('admin.administrative-units.add') }}", // Make sure you have this route
            method: "POST",
            data: data,
            success: function(response) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.status === 'success' ? 'success' : 'error',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                if (response.status === 'success') {
                    form[0].reset();
                    addModal.hide();
                    table.ajax.reload(null, false);
                }
            },
            error: function(xhr) {
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
            }
        });

    });
    $("#level").on('change', function () {
    let level = parseInt($(this).val());
    let $parent = $("#parent");

    if (level === 1) {
        // No parent for level 1
        $parent.val(null).trigger('change');
        $parent.prop('disabled', true);
    } else {
        // Enable parent select
        $parent.prop('disabled', false);

        // Filter parent options by level = level - 1
        // Assuming you have all admin units in JS with their levels, e.g.:
        // let allUnits = @json($admin_units);

        let parentLevel = level - 1;
        let filteredParents = allUnits.filter(u => u.level === parentLevel);

        // Clear current options and add filtered ones
        $parent.empty().append('<option value="">-- Select Parent --</option>');
        $.each(filteredParents, function (i, unit) {
            $parent.append(`<option value="${unit.id}">${unit.name}</option>`);
        });
        $parent.val(null).trigger('change');
    }
});

});
</script>
@endsection
