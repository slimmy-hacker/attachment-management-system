
@extends('layouts.my_app')
@section('title')
    Attarchment Form
@endsection
@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold text-center mb-4">DEDAN KIMATHI UNIVERSITY OF TECHNOLOGY </h1>
        <h2 class="text-xl font-semibold text-center mb-8 underline text-blue-700">EXTERNAL ATTACHMENT INFORMATION FORM</h2>

        <form action="#" method="POST" class="space-y-6">
            @csrf
            <fieldset class="border border-gray-300 p-4 rounded">
                <legend class="font-semibold text-lg">Student Details</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <input type="text" name="student_name"  value="{{$logged_user->name}}" placeholder="Full Name" class="p-2 border rounded w-full" disabled>
                    <input type="text" name="reg_no" value="{{$my_student_details->reg_no}}" placeholder="Registration Number" class="p-2 border rounded w-full" disabled>
                    <input type="text" name="course" placeholder="Course" class="p-2 border rounded w-full" disabled>
                    <input type="tel" name="student_phone" placeholder="Phone Number" value="{{$logged_user->phone_number}}" class="p-2 border rounded w-full" disabled>
                    <input type="email" name="student_email" placeholder="Email" value="{{$logged_user->email}}" class="p-2 border rounded w-full" disabled>
                </div>
            </fieldset>

         <fieldset class="border border-gray-300 p-4 rounded">
    <legend class="font-semibold text-lg">Attachment Details</legend>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label for="organization" class="block text-sm font-medium mb-1 required">Name of Organisation</label>
            <select id="organization" name="organization" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">

                <option value=""> -- select org --</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}"
                            data-town="{{ $company->sub_county }}"
                            data-street="{{ $company->street }}"
                            data-building="{{ $company->building }}"
                    >{{$company->name}}</option>
                @endforeach

            </select>
        </div>

        <div>
            <label for="date_commenced" class="block text-sm font-medium mb-1 required">Date Commenced</label>
            <input type="date" id="date_commenced" name="date_commenced" class="p-2 border rounded w-full">
        </div>

        <div>
            <label for="date_finished" class="block text-sm font-medium mb-1 required">Expected Finishing Date</label>
            <input type="date" id="date_finished" name="date_finished" class="p-2 border rounded w-full">
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
            <label for="industrial_supervisor" class="block text-sm font-medium mb-1 required">Industrial Supervisor's Name</label>
            <select id="industrial_supervisor" name="industrial_supervisor" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                <option value=""> -- select Supervisor 1 --</option>
            </select>
         </div>
        <div>
            <label for="supervisor_phone" class="block text-sm font-medium mb-1">Supervisor's Phone Number</label>
            <input type="tel" id="supervisor_phone" name="supervisor_phone" class="p-2 border rounded w-full" placeholder="Phone Number">
        </div>

        <div>
            <label for="supervisor_email" class="block text-sm font-medium mb-1">Supervisor's Email</label>
            <input type="email" id="supervisor_email" name="supervisor_email" class="p-2 border rounded w-full" placeholder="Email">
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
            $('#organization').on('change', function () {
                let selected = $(this).find('option:selected');

                $('#town').val(selected.data('town') || '');
                $('#street').val(selected.data('street') || '');
                $('#building').val(selected.data('building') || '');
                loadCompanySupervisors(selected.val())
            });

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

                        // Re-initialize or refresh Select2
                      //  $select.select2();

                        // Ensure Select2 updates the displayed value properly
                        $select.val('').trigger('change');
                    },
                    error: function (xhr) {
                        console.error('Error fetching supervisors:', xhr.responseText);
                    }
                });
            }

// When a lecturer is selected, update phone & email
            $('#industrial_supervisor').on('change', function () {
                const selected = $(this).find(':selected');
                $('#supervisor_phone').val(selected.data('phone') || '');
                $('#supervisor_email').val(selected.data('email') || '');
            });

    });
    </script>
@endsection
