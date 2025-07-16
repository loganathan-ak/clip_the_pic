<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Clip The Pic</title>
    {{-- ✅ Include Vite styles and scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom styles for smoother transitions and modern look */
        input[type="email"] {
            transition: all 0.3s ease-in-out;
            border-color: #e2e8f0; /* default border color */
        }
        input[type="email"]:focus {
            border-color: #818cf8; /* indigo-400 equivalent */
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.4); /* focus ring */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-yellow-100 to-orange-200 min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md flex flex-col overflow-hidden transform transition-all duration-300 scale-95 md:scale-100">
        {{-- Forgot Password Form --}}
        <div class="w-full p-6 sm:p-10 lg:p-12 flex flex-col justify-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 mb-8">
                Forgot Your Password? <span class="text-indigo-600">🤔</span>
            </h2>

            <p class="text-center text-gray-600 mb-6">
                Enter your email address below and we'll send you a new password.
            </p>

            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">There were some issues:</span>
                    <ul class="mt-2 list-disc pl-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    Send New Password
                </button>
            </form>

            <p class="text-sm text-center text-gray-600 mt-8">
                Remembered your password?
                <a href="{{ route('login') }}" class="text-orange-500 hover:underline font-medium">Login here</a>
            </p>
        </div>
    </div>

</body>
</html>
