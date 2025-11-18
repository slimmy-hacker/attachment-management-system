
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-700">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">
            Login
        </h2>
        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-600">Email Address</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"  value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                <span class="text-gray-600">Remember Me</span>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                Login
            </button>

            <p class="text-center text-sm text-gray-600 mt-4">
    Don’t have an account?
    <a href="{{ route('register.select.portal') }}" class="text-blue-600 hover:underline">
        Register here
    </a>
</p>
        </form>
    </div>
</body>
</html>
