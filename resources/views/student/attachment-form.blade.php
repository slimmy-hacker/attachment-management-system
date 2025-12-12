
@extends('layouts.my_app')
@section('title')
    Attachment Form
@endsection
@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold text-center mb-4">DEDAN KIMATHI UNIVERSITY OF TECHNOLOGY </h1>
        <h2 class="text-xl font-semibold text-center mb-8 underline text-blue-700">EXTERNAL ATTACHMENT INFORMATION FORM</h2>

        <form action="{{route('student.attachment-form.store')}}" method="POST" class="space-y-6">
            @csrf
            <fieldset class="border border-gray-300 p-4 rounded">
                <legend class="font-semibold text-lg">Student Details</legend>
                <div class="grid grid-cols-1 gap-4 mt-4">
                    <input type="text" name="student_name"  value="{{$logged_user->name}}" placeholder="Full Name" class="p-2 border rounded w-full" disabled>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <input type="text" name="reg_no" value="{{$my_student_details->reg_no}}" placeholder="Registration Number" class="p-2 border rounded w-full" disabled>
                    <input type="text" name="course" value="{{$my_student_details->program->name}}" placeholder="Course" class="p-2 border rounded w-full" disabled>
                    <input type="tel" name="student_phone" placeholder="Phone Number" value="{{$logged_user->phone_number}}" class="p-2 border rounded w-full" disabled>
                    <input type="email" name="student_email" placeholder="Email" value="{{$logged_user->email}}" class="p-2 border rounded w-full" disabled>
                </div>
            </fieldset>

         <fieldset class="border border-gray-300 p-4 rounded">
    <legend class="font-semibold text-lg">Attachment Details</legend>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label for="organization" class="block text-sm font-medium mb-1 required">
                Organization
            </label>

            <select
                required
                id="organization"
                name="company_id"
                class="select2 bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5
               @error('company_id') border-red-500 @enderror"
            >
                <option value=""> -- select org --</option>

                @foreach($companies as $company)
                    <option
                        value="{{ $company->id }}"
                        data-town="{{ $company->subcounty->name }}"
                        data-street="{{ $company->street }}"
                        data-building="{{ $company->building }}"
                        {{ old('company_id', $attachment_student->company_id) == $company->id ? 'selected' : '' }}
                    >
                        {{ $company->name }}
                    </option>
                @endforeach

            </select>

            @error('company_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="town" class="block text-sm font-medium mb-1">Town</label>
            <input type="text" id="town" name="town" class="p-2 border rounded w-full" placeholder="Town" disabled>
        </div>

        <div>
            <label for="street" class="block text-sm font-medium mb-1">Street</label>
            <input type="text" id="street" name="street" class="p-2 border rounded w-full" placeholder="Street" disabled>
        </div>

        <div>
            <label for="building" class="block text-sm font-medium mb-1">Building</label>
            <input type="text" id="building" name="building" class="p-2 border rounded w-full" placeholder="Building" disabled>
        </div>
        <div>
            <label for="date_commenced" class="block text-sm font-medium mb-1 required">
                Date Commenced
            </label>

            <input
                required
                type="date"
                id="date_commenced"
                name="start_date"
                value="{{ old('start_date', $attachment_student->start_date) }}"
                class="p-2 border rounded w-full @error('start_date') border-red-500 @enderror"
            >

            @error('start_date')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="date_finished" class="block text-sm font-medium mb-1 required">
                Expected Finishing Date
            </label>

            <input
                required
                type="date"
                id="date_finished"
                name="end_date"
                value="{{ old('end_date', $attachment_student->end_date) }}"
                class="p-2 border rounded w-full @error('end_date') border-red-500 @enderror"
            >

            @error('end_date')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>
             <div class="grid grid-cols-1 gap-4 mt-4">
         <div>
            <label for="industrial_supervisor" class="block text-sm font-medium mb-1 required">Industrial Supervisor's Name</label>
            <select required id="industrial_supervisor" name="industrial_supervisor_id" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                <option value=""> -- select Supervisor --</option>
            </select>
         </div>
             </div>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label for="supervisor_phone" class="block text-sm font-medium mb-1">Supervisor's Phone Number</label>
            <input type="tel" id="supervisor_phone" name="supervisor_phone" class="p-2 border rounded w-full" placeholder="Phone Number" disabled>
        </div>

        <div>
            <label for="supervisor_email" class="block text-sm font-medium mb-1">Supervisor's Email</label>
            <input type="email" id="supervisor_email" name="supervisor_email" class="p-2 border rounded w-full" placeholder="Email" disabled>
        </div>
    </div>
</fieldset>
<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
        Submit
    </button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            if ($('#organization').val()) {
                handleOrganizationChange();
            }

            function handleOrganizationChange() {
                let selected = $('#organization').find('option:selected');

                $('#town').val(selected.data('town') || '');
                $('#street').val(selected.data('street') || '');
                $('#building').val(selected.data('building') || '');

                loadCompanySupervisors(selected.val());
            }

            $("#organization").on('change', handleOrganizationChange);

            function loadCompanySupervisors(companyId) {
                const url = `/get-company-industrial-supervisors/${companyId}`;

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        let $select = $('#industrial_supervisor');
                        $select.empty().append('<option value="">-- select Supervisor --</option>');

                        $.each(response, function (i, supervisor) {
                            $select.append(`<option value="${supervisor.id}" data-phone="${supervisor.user.phone_number}" data-email="${supervisor.user.email}">
                                                ${supervisor.user.name}
                                            </option>`);
                        });
                        let oldCompanyId  = @json(old('company_id', $attachment_student->company_id));
                        let oldSupervisor = @json(old('industrial_supervisor_id', $attachment_student->industrial_supervisor_id));

                        if (companyId === oldCompanyId && oldSupervisor) {
                            $select.val(oldSupervisor).trigger('change');
                        } else {
                            $select.val('').trigger('change');
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching supervisors:', xhr.responseText);
                    }
                });
            }


            $('#industrial_supervisor').on('change', function () {
                const selected = $(this).find(':selected');
                $('#supervisor_phone').val(selected.data('phone') || '');
                $('#supervisor_email').val(selected.data('email') || '');
            });

    });
    </script>
@endsection
