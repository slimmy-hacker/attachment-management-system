<div id="student_attachment_details-modal" tabindex="-1" aria-hidden="true"  data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-4/5 max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-lg font-semibold text-gray-">
                   Student Attachment Details
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center close-student_attachment_details_modal-btn">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <table class="min-w-full border border-gray-300" id="student_attachment_detailsTable">
                <tbody>
                <!-- jQuery will fill here -->
                </tbody>
            </table>
            <button  type="button" class="text-white inline-flex items-center bg-gray-300 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center close-student_attachment_details_modal-btn ">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                close
            </button>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            const student_attachment_details_modal = new Modal($('#student_attachment_details-modal')[0], {
                backdrop: 'static',
                closable: false
            });

            $(document).on('click', '.close-student_attachment_details_modal-btn', function () {
                student_attachment_details_modal.hide();
            });

            $(document).on('click', '.open-student_attachment_details_modal-btn', function () {
               const student_attachment_details_id = $(this).data('id');
                openAttachmentModal(student_attachment_details_id)
            });

            function openAttachmentModal(id) {
                student_attachment_details_modal.show();
                // Clear & show loading message
                $("#student_attachment_detailsTable tbody").html(`
                <tr><td class="p-4 text-center">Loading...</td></tr>
            `);

                // Ajax request
                $.ajax({
                    url:"{{ route('attachmentDetails.show', ':id') }}".replace(':id', id),
                    method: 'GET',
                    success: function (data) {
                        fillAttachmentTable(data);
                    },
                    error: function () {
                        $("#student_attachment_detailsTable tbody").html(`
                <tr><td class="p-4 text-center text-red-600">Error loading data</td></tr>
            `);
                    }
                });
            }

            function fillAttachmentTable(data) {
                let html = '';

                html += `<tr><th class="p-3 bg-gray-100">Student Name</th><td class="p-3">${data?.student?.user?.name}</td>
                            <th class="p-3 bg-gray-100">Student Phone No</th><td class="p-3">${data?.student?.user?.phone_number}</td></tr>`;
                html += `<tr><th class="p-3 bg-gray-100">Registration No</th><td class="p-3">${data?.student?.reg_no}</td>
                               <th class="p-3 bg-gray-100">Email</th><td class="p-3">${data?.student?.user?.email}</td></tr>`;
                html += `<tr><th class="p-3 bg-gray-100">Course</th><td class="p-3">${data?.student?.program?.name}</td></tr>`;

                html += `<tr><th class="p-3 bg-gray-100">Organization</th><td class="p-3">${data?.company?.name}</td>
                            <th class="p-3 bg-gray-100">Street</th><td class="p-3">${data?.company?.street}</td></tr>`;
                html += `<tr><th class="p-3 bg-gray-100">Town</th><td class="p-3">${data?.company?.subcounty?.name}</td>
                            <th class="p-3 bg-gray-100">Building</th><td class="p-3">${data?.company?.building}</td></tr>`;

                html += `<tr><th class="p-3 bg-gray-100">Attachment Name</th><td class="p-3">${data?.attachment?.name ?? ''}</td></tr>`;
                html += `<tr><th class="p-3 bg-gray-100">Start Date</th><td class="p-3">${data?.start_date}</td>
<th class="p-3 bg-gray-100">End Date</th><td class="p-3">${data?.end_date}</td></tr>`;


                // Supervisor
                html += `<tr><th class="p-3 bg-gray-100">Industrial Supervisor</th><td class="p-3">${data?.industrial_supervisor?.user?.name ?? ''}</td>
                            <th class="p-3 bg-gray-100">Supervisor Email</th><td class="p-3">${data?.industrial_supervisor?.user?.email ?? ''}</td></tr>`;
                html += `<tr><th class="p-3 bg-gray-100">Supervisor Phone</th><td class="p-3">${data?.industrial_supervisor?.user?.phone_number ?? ''}</td></tr>`;

                // Lecturer
                html += `<tr><th class="p-3 bg-gray-100">Lecturer</th><td class="p-3">${data?.lecturer?.name ?? ''}</td>
                            <th class="p-3 bg-gray-100">Lecturer Email</th><td class="p-3">${data?.lecturer?.email ?? ''}</td></tr>`;
                html += `<tr><th class="p-3 bg-gray-100">Lecturer Phone</th><td class="p-3">${data?.lecturer?.phone_number ?? ''}</td></tr>`;


                $("#student_attachment_detailsTable tbody").html(html);
            }

        });
    </script>
@endpush
