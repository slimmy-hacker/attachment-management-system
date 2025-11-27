<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Registration - DeKUT External Attachment System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
            Supervisor Registration
        </h2>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register.portal.store', ['portal' => $portal]) }}">
            @csrf
            <input type="hidden" name="portal" value="supervisor">

            <!-- Full Name -->
            <div class="mb-4">
                <label class="block text-gray-700">Full Name</label>
                <input type="text" name="name" required
                       class="w-full p-2 border rounded">
            </div>

            <!-- Department -->
            <div class="mb-4">
                <label class="block text-gray-700">Department</label>
                <input type="text" name="department" required
                       class="w-full p-2 border rounded">
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label class="block text-gray-700">Email Address</label>
                <input type="email" name="email" required
                       class="w-full p-2 border rounded">
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label class="block text-gray-700">Telephone</label>
                <input type="tel" name="phone" required
                       placeholder="+2547XXXXXXXX"
                       class="w-full p-2 border rounded">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="w-full p-2 border rounded">
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full p-2 border rounded">
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Register
            </button>
        </form>

        <!-- Login link -->
        <p class="mt-6 text-center text-gray-600">
            Already have an account?
            <a href="{{ route('login.portal', 'lecturer') }}"
               class="text-blue-600 hover:underline">
                Login Here
            </a>
        </p>
    </div>

</body>
</html>
