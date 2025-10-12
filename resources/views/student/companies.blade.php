@extends('layouts.my_app')

@section('title', 'Company Details ')

@section('content')

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
                                    <a href="#" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Companies</a>
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
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Companies</h1>
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
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        #
                                    </div>
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Alias
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                   Email
                                </th>

                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Contact
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                   County
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Sub County
                                </th>

                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Latitude
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Longitude
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
        <div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="add-schedule-modal">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
                <!-- Modal content -->
                <div class="bg-white rounded-lg shadow relative">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            Add company
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
                            <!-- Company Branch -->
                            <div>
                                <label for="parent_company" class="block font-semibold">
                                    Parent Company
                                </label>
                                <input type="text" name="parent_company" id="parent_company" value="{{ old('parent_company') }}"
                                       class="w-full border rounded p-2">
                                @error('parent_company') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="name" class="block font-semibold">
                                    Company Name <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="w-full border rounded p-2" required>
                                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Company Name -->


                                <!-- Company Alias -->
                                <div>
                                    <label for="alias" class="block font-semibold">
                                        Company Alias <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="alias" id="alias" value="{{ old('alias') }}"
                                           class="w-full border rounded p-2" required>
                                    @error('alias') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>


                                <div>
                                    <label for="contact" class="block font-semibold">
                                        Contact <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="contact" id="contact" value="{{ old('contact') }}"
                                           class="w-full border rounded p-2" required>
                                    @error('contact') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="email" class="block font-semibold">
                                        Email <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                                           class="w-full border rounded p-2" required>
                                    @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>
                                <!-- Address -->
                                <div>
                                    <label for="address" class="block font-semibold">
                                        Address <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                           class="w-full border rounded p-2" required>
                                    @error('address') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>


                                <!-- County -->
                                <div>
                                    <label for="county" class="block font-semibold">
                                        County <span class="text-red-600">*</span>
                                    </label>
                                    <select name="county" id="county" class="w-full border rounded p-2 select2" required>
                                        <option value="">-- Select County --</option>
                                        @foreach($counties as $code => $county)
                                            <option value="{{ $code }}" {{ old('county') == $code ? 'selected' : '' }}>
                                                {{ $code }} - {{ $county }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('county') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <!-- Subcounty (optional) -->
                                <div>
                                    <label for="county" class="block font-semibold">
                                       Sub County <span class="text-red-600">*</span>
                                    </label>
                                    <select name="subcounty" id="subcounty" class="w-full border rounded p-2 select2" required>
                                        <option value="">-- Select Sub-County --</option>
                                        @foreach($sub_counties as $sub_county)
                                            <option value="{{ $sub_county['code'] }}"
                                                    data-county="{{ $sub_county['county_code'] }}"
                                                {{ old('subcounty') == $sub_county['code'] ? 'selected' : '' }}>
                                                {{ $sub_county['code'] }} - {{ $sub_county['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Latitude & Longitude side by side -->
                                <div class="grid grid-cols-2 gap-4 col-span-2">
                                    <div>
                                        <label for="latitude" class="block font-semibold">
                                            Latitude
                                        </label>
                                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                                               class="w-full border rounded p-2">
                                        @error('latitude') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="longitude" class="block font-semibold">
                                            Longitude
                                        </label>
                                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}"
                                               class="w-full border rounded p-2">
                                        @error('longitude') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <!-- Use Current Location button -->
                                <div class="col-span-2">
                                    <button type="button" id="get-location"
                                            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">
                                        Use Current Location
                                    </button>
                                </div>
                            </div>




                            <!-- Modal footer -->
                            <div class="items-center p-6 border-t border-gray-200 rounded-b">
                                <button class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium
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
                            ajax: "{{ route('student.companies') }}",
                            columns: [
                                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                                { data: 'name', name: 'name' },
                                { data: 'alias', name: 'alias' },
                                { data: 'email', name: 'email' },

                                { data: 'contact', name: 'contact' },
                                { data: 'county', name: 'county' },
                                { data: 'subcounty', name: 'subcounty' },
                                { data: 'latitude', name: 'latitude' },
                                { data: 'longitude', name: 'longitude' },
                                { data: 'action', name: 'action', orderable: false, searchable: false }
                            ]
                        });

                        $("#scheduleForm").on("submit", function (e) {
                            e.preventDefault();

                            let formData = new FormData(this);

                            $.ajax({
                                url: "{{ route('student.companies.store') }}", // adjust route name
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
                                }
                            });
                        });

                        $('#get-location').on('click', function () {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(function (position) {
                                    $('#latitude').val(position.coords.latitude);
                                    $('#longitude').val(position.coords.longitude);
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Location picked',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                }, function () {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Unable to Retrive location',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                });
                            } else {
                                alert('Geolocation is not supported by your browser');
                            }
                        });

                        let subCounties = @json($sub_counties);
                        let $county = $("#county");
                        let $subcounty = $("#subcounty");
                        // Fill subcounty dropdown when county changes
                        $county.on('change', function () {
                            let countyCode = $(this).val();
                            let $subcounty = $('#subcounty');

                            $subcounty.empty().append('<option value="">-- Select Subcounty --</option>');

                            if (countyCode) {
                                let filtered = subCounties.filter(sc => sc.county_code === countyCode);
                                $.each(filtered, function (i, sc) {
                                    $subcounty.append(
                                        `<option value="${sc.code}">${sc.code} - ${sc.name}</option>`
                                    );
                                });
                            }
                        });

                        $subcounty.on("change", function () {
                            let selectedCounty = $(this).find("option:selected").data("county");
                            if (selectedCounty && !$county.val()) {
                                $county.val(selectedCounty).trigger("change");
                            }
                        });

                        // Preselect county if subcounty already has value


                    });
                </script>
            @endsection
