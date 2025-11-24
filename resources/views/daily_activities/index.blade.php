@extends('layouts.my_app')
@section('title')
    My Activities
@endsection


@section('content')

<div>
    <H1>My Activities</H1>
<div id='daily_activities'></div>


    <div id="crud-modal" tabindex="-1" aria-hidden="true"  data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-4/5 max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                    <h3 class="text-lg font-semibold text-gray-">
                        Daily Report
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center close-modals-btn">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="calender_details_form" class="p-4 md:p-5">
                    @csrf

                    <div class="grid gap-4 mb-4 grid-cols-2">

                        <div class="col-span-2 sm:col-span-1">
                            <input type="hidden" id="daily_report_id" name="daily_report_id">
                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 " >Start Date <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" id="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="select start date" required="" >
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 ">End Date<span class="text-red-500">*</span></label>
                            <input type="date" name="end_date" id="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="select End date" required>
                        </div>
                        <div class="col-span-2">
                            <label for="task_title" class="block mb-2 text-sm font-medium text-gray-900 ">Task Title<span class="text-red-500">*</span></label>
                            <input type="text" name="task_title" id="task_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="Write Title of work done" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="tasks" class="block mb-2 text-sm font-medium text-gray-900 ">Tasks<span class="text-red-500">*</span></label>
                            <textarea id="tasks" name="tasks" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write desciption of work done here" required=""></textarea>
                        </div>
                        <div class="col-span-2">
                            <label for="skills_learned" class="block mb-2 text-sm font-medium text-gray-900 ">Skills Learned<span class="text-red-500">*</span></label>
                            <textarea id="skills_learned" name="skills_learned" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write Skills learned here" required=""></textarea>
                        </div>
                        <div class="col-span-2">
                            <label for="challenges" class="block mb-2 text-sm font-medium text-gray-900 "> Challenges Encountered</label>
                            <textarea id="challenges" name="challenges" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write Challenges encountered here here"></textarea>
                        </div>

                    </div>
                    <button type="button" id="calender_details_btn" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                       Save
                    </button>
                    <button  type="button" class="text-white inline-flex items-center bg-gray-300 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center close-modals-btn ">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                       close
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

            function minusOneDay(dateStr) {
                let d = new Date(dateStr);
                d.setDate(d.getDate() - 1);
                return d.toISOString().split('T')[0];
            }
            // Initialize Flowbite modal
            const modal = new Modal($('#crud-modal')[0], {
                backdrop: 'static',
                closable: false
            });

            /



            var calendarEl = document.getElementById('daily_activities');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                events: @json($events),
            });

            calendar.render();
            calendar.on('dateClick', function(info) {
                $("#calender_details_form")[0].reset();
                modal.show();
                $('#start_date').val(info.dateStr);
                $('#end_date').val(info.dateStr);
            });
            calendar.on('eventClick', function(info) {
                $("#calender_details_form")[0].reset();
                const props = info.event.extendedProps;
                $.each(props, function(key, value) {
                    let $el = $('#' + key);
                    if ($el.length) {
                        $el.val(value);
                    }
                });

                $("#daily_report_id").val(info.event?.id)
                $('#start_date').val(info.event.startStr);
                $('#end_date').val(minusOneDay(info.event.endStr) || info.event.startStr);
                $('#task_title').val(info.event.title);



                modal.show();

            });

            // Close modal with button
            $(document).on('click', '.close-modals-btn', function () {
                const modalElement = $(this).closest('[id$="-modal"]')[0];
                if (modalElement) {
                    modal.hide();
                }
            });

            // Submit form via AJAX
            $('#calender_details_btn').on('click', function (e) {
                e.preventDefault();

                let $form = $('#calender_details_form');
                let formData = $form.serialize();
                let hasError = false;

                // 🔹 Frontend Validation
                $form.find('input[required], textarea[required], select[required]').each(function () {
                    if ($(this).val().trim() === '') {
                        hasError = true;
                        $(this).addClass('border-red-500');
                    } else {
                        $(this).removeClass('border-red-500');
                    }
                });

                if (hasError) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Please fill in the required data',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    return;
                }

                // 🔹 Disable button to prevent double submit
                let $btn = $(this);
                $btn.prop('disabled', true).text('Saving...');

                // 🔹 Ajax request
                $.ajax({
                    url: "{{ route('student.daily_activities.store') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Tasks Saved Successfully',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // Reset form
                            $form[0].reset();
                            modal.hide();

                            // 🔹 Add new event to daily_activities dynamically
                            let event = calendar.getEventById(response.data.id);

                            if (event) {

                                event.remove();
                            }
                            calendar.addEvent(response.data);

                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Unexpected Error Occurred',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = "";

                            $.each(errors, function (key, value) {
                                errorMessages += value[0] + "\n";
                                $form.find('[name="' + key + '"]').addClass('border-red-500');
                            });

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: errorMessages,
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: "Something went wrong",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    complete: function () {
                        $btn.prop('disabled', false).text('Save');
                    }
                });
            });
        });
    </script>
@endsection
