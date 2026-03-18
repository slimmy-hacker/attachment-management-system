@extends('layouts.my_app')

@section('title')
    Attachment Import
@endsection

@section('content')

<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
    <div class="mb-1 w-full">
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.portal') }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium">Attachments</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Bulk Import</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Student Attachment Info</h1>
        </div>
    </div>
</div>

<div class="flex flex-col mt-6 px-4">
    <div class="max-w-4xl bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Bulk Data Management</h3>
                <p class="text-sm text-gray-500">Upload CSV to auto-fill student attachment forms</p>
            </div>
            
            <div class="flex space-x-2">
                <button id="open-upload-modal-btn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-4 py-2.5">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Upload Student Records
                </button>
            </div>
        </div>
        
        <div class="border-t border-gray-200 pt-4 mt-4 text-sm text-gray-600">
            <strong>Note:</strong> Your CSV should contain columns for <code>reg_no</code>, <code>name_of_organization</code>, <code>date_started</code>, <code>expected_date_finish</code>, and <code>town</code>.
        </div>
    </div>
</div>

<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="upload-attachment-modal">
    <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
        <div class="bg-white rounded-lg shadow relative border border-gray-200">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Import Student Records
                </h3>
                <button type="button" class="close-upload-modal-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-6">
                <form id="uploadAttachmentForm" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label for="file" class="text-sm font-medium text-gray-900 block mb-2">Select CSV File <span class="text-red-500">*</span></label>
                            <input type="file" name="file" accept="*"
       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
       required>
                        </div>
                    </div>

                    <div class="flex items-center pt-6 border-t border-gray-200 rounded-b mt-6">
                        <button id="uploadBtn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
                            Process Records
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
    // Standard CSRF setup for all AJAX calls on this page
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    const uploadModal = new Modal($('#upload-attachment-modal')[0], {
        backdrop: 'static',
        closable: false
    });

    $('#open-upload-modal-btn').click(() => uploadModal.show());
    $('.close-upload-modal-btn').click(() => uploadModal.hide());

    $("#uploadAttachmentForm").submit(function (e) {
        e.preventDefault();
        let btn = $("#uploadBtn");

        // UI Feedback
        btn.prop("disabled", true).html('<svg class="animate-spin h-5 w-5 mr-3 inline" viewBox="0 0 24 24">...</svg> Processing...');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.attachmentsimport.process') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Import Complete',
                    text: response.message,
                    confirmButtonColor: '#0891b2'
                });
                $("#uploadAttachmentForm")[0].reset();
                uploadModal.hide();
            },
            error: function (xhr) {
                // Handle session expiration (419) specifically
                if (xhr.status === 419) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Session Expired',
                        text: 'Please refresh the page to renew your security token.'
                    });
                } else {
                    let res = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: res && res.message ? res.message : 'An error occurred while processing the file.'
                    });
                }
            },
            complete: function () {
                btn.prop("disabled", false).html("Process Records");
            }
        });
    });
});
</script>
@endsection