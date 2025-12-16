@extends('layouts.my_app')

@section('title')
    Opportunities
@endsection

@section('content')

<!-- Page Header -->
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
    <div class="mb-1 w-full">
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium">
                                Opportunities
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
                Available Opportunities
            </h1>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden">
                <table class="table-fixed min-w-full divide-y divide-gray-200" id="opportunities_table">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 w-12 text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                         <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                        <th class="p-4">
                            @if($isCompany)
                                <button id="open-opportunity-modal-btn"
                                        class="text-white bg-cyan-600 hover:bg-cyan-700
                                               focus:ring-4 focus:ring-cyan-200
                                               font-medium rounded-lg text-sm px-3 py-2 inline-flex items-center">
                                    <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    Add
                                </button>
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ADD OPPORTUNITY MODAL -->
<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0
            z-50 justify-center items-center h-modal sm:h-full"
     data-modal-backdrop="static"
     id="add-opportunity-modal">

    <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

        <div class="bg-white rounded-lg shadow relative">

            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold">
                    Post New Opportunity
                </h3>

                <button type="button"
                        class="close-opportunity-modal-btn text-gray-400 bg-transparent
                               hover:bg-gray-200 hover:text-gray-900 rounded-lg
                               text-sm p-1.5 ml-auto inline-flex items-center">
                    ✕
                </button>
            </div>

            <div class="p-6 space-y-6">
                <form id="opportunityForm">
                    @csrf

                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            <label class="text-sm font-medium text-gray-900 block mb-2">Title</label>
                            <input type="text" name="title"
                                   class="shadow-sm bg-gray-50 border border-gray-300
                                          rounded-lg block w-full p-2.5"
                                   required>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2">Location</label>
                            <input type="text" name="location"
                                   class="shadow-sm bg-gray-50 border border-gray-300
                                          rounded-lg block w-full p-2.5"
                                   required>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                Expiry (days)
                            </label>
                            <input type="number" name="expiry_days" min="1" max="90"
                                   class="shadow-sm bg-gray-50 border border-gray-300
                                          rounded-lg block w-full p-2.5"
                                   required>
                        </div>

                        <div class="col-span-6">
                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                Description
                            </label>
                            <textarea name="description" rows="3"
                                      class="shadow-sm bg-gray-50 border border-gray-300
                                             rounded-lg block w-full p-2.5"
                                      required></textarea>
                        </div>
                    </div>

                    <div class="items-center p-6 border-t border-gray-200 rounded-b mt-6">
                        <button id="saveOpportunityBtn"
                                class="text-white bg-cyan-600 hover:bg-cyan-700
                                       focus:ring-4 focus:ring-cyan-200
                                       font-medium rounded-lg text-sm px-5 py-2.5"
                                type="submit">
                            Save
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

    const modal = new Modal(
        document.getElementById('add-opportunity-modal'),
        { backdrop: 'static', closable: false }
    );

    $('#open-opportunity-modal-btn').on('click', function () {
        modal.show();
    });

    $('.close-opportunity-modal-btn').on('click', function () {
        modal.hide();
    });

    let table = $('#opportunities_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: "{{ route('opportunities.index') }}",
        columns: [
            { data: 'DT_RowIndex', searchable: false },
            { data: 'title' },
            { data: 'location' },
            { data: 'expiry_date' },
             { data: 'description' },
            { data: 'company' },
            
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    $("#opportunityForm").on("submit", function (e) {
        e.preventDefault();

        let btn = $("#saveOpportunityBtn");
        btn.prop("disabled", true).text("Saving...");

        $.ajax({
            url: "{{ route('opportunities.store') }}",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,

            success: function (res) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Opportunity posted successfully',
                    showConfirmButton: false,
                    timer: 3000
                });

                $("#opportunityForm")[0].reset();
                modal.hide();
                table.ajax.reload(null, false);
            },

            error: function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Failed to save opportunity',
                    showConfirmButton: false,
                    timer: 3000
                });
            },

            complete: function () {
                btn.prop("disabled", false).text("Save");
            }
        });
    });

});
</script>
@endsection
