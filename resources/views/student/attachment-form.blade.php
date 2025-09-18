
@extends('layouts.my_app')
@section('title')
    Student LogBook
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
                    <input type="text" name="student_name" placeholder="Full Name" class="p-2 border rounded w-full">
                    <input type="text" name="reg_no" placeholder="Registration Number" class="p-2 border rounded w-full">
                    <input type="text" name="course" placeholder="Course" class="p-2 border rounded w-full">
                    <input type="tel" name="student_phone" placeholder="Phone Number" class="p-2 border rounded w-full">
                    <input type="email" name="student_email" placeholder="Email" class="p-2 border rounded w-full">
                </div>
            </fieldset>

         <fieldset class="border border-gray-300 p-4 rounded">
    <legend class="font-semibold text-lg">Attachment Details</legend>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label for="organization" class="block text-sm font-medium mb-1">Name of Organisation</label>
            <input type="text" id="organization" name="organization" class="p-2 border rounded w-full" placeholder="Name of Organisation">
        </div>

        <div>
            <label for="date_commenced" class="block text-sm font-medium mb-1">Date Commenced</label>
            <input type="date" id="date_commenced" name="date_commenced" class="p-2 border rounded w-full">
        </div>

        <div>
            <label for="date_finished" class="block text-sm font-medium mb-1">Expected Finishing Date</label>
            <input type="date" id="date_finished" name="date_finished" class="p-2 border rounded w-full">
        </div>

        <div>
            <label for="town" class="block text-sm font-medium mb-1">Town</label>
            <input type="text" id="town" name="town" class="p-2 border rounded w-full" placeholder="Town">
        </div>

        <div>
            <label for="street" class="block text-sm font-medium mb-1">Street</label>
            <input type="text" id="street" name="street" class="p-2 border rounded w-full" placeholder="Street">
        </div>

        <div>
            <label for="building" class="block text-sm font-medium mb-1">Building</label>
            <input type="text" id="building" name="building" class="p-2 border rounded w-full" placeholder="Building">
        </div>

        <div>
            <label for="supervisor_name" class="block text-sm font-medium mb-1">Industry Supervisor's Name</label>
            <input type="text" id="supervisor_name" name="supervisor_name" class="p-2 border rounded w-full" placeholder="Supervisor's Name">
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
