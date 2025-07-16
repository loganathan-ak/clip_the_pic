<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Clip The Pic</title>
    {{-- ✅ Include Vite styles and scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Optional: Custom scrollbar for a cleaner look on some browsers */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="min-h-screen flex">
        <div class="hidden md:flex w-1/2 bg-gradient-to-r from-amber-500 to-orange-500 items-center justify-center p-8 lg:p-12 relative overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <circle cx="20" cy="20" r="15" fill="url(#grad1)" opacity="0.7"></circle>
                    <circle cx="80" cy="50" r="20" fill="url(#grad2)" opacity="0.6"></circle>
                    <rect x="10" y="70" width="30" height="10" rx="5" ry="5" fill="url(#grad3)" opacity="0.5"></rect>
                    <polygon points="60,10 70,30 50,30" fill="url(#grad4)" opacity="0.8"></polygon>
                </svg>
                <defs>
                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:rgb(255,255,255);stop-opacity:0.2" />
                        <stop offset="100%" style="stop-color:rgb(200,200,200);stop-opacity:0.05" />
                    </linearGradient>
                    <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:rgb(255,255,255);stop-opacity:0.25" />
                        <stop offset="100%" style="stop-color:rgb(200,200,200);stop-opacity:0.1" />
                    </linearGradient>
                    <linearGradient id="grad3" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:rgb(255,255,255);stop-opacity:0.15" />
                        <stop offset="100%" style="stop-color:rgb(200,200,200);stop-opacity:0.05" />
                    </linearGradient>
                    <linearGradient id="grad4" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:rgb(255,255,255);stop-opacity:0.3" />
                        <stop offset="100%" style="stop-color:rgb(200,200,200);stop-opacity:0.1" />
                    </linearGradient>
                </defs>
            </div>
            <div class="text-center text-white z-10">
                {{-- <img src="https://cdni.iconscout.com/illustration/premium/thumb/web-designer-working-on-site-layout-8349479-6681023.png?f=webp" alt="Creative Design Illustration" class="max-w-xs lg:max-w-sm h-auto mx-auto mb-6 drop-shadow-xl animate-fade-in-up"> --}}
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight">Clip The Pic</h1>
                <h3 class="text-3xl font-light mb-6 text-indigo-100">Unlock Your Creative Potential</h3>
                <p class="text-white text-lg leading-relaxed max-w-md mx-auto opacity-90">
                    Join a vibrant community where imagination meets innovation. Transform your ideas into stunning visuals effortlessly.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-12 bg-white overflow-y-auto">
            <div class="w-full max-w-md">
                <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-8">Create Your Account ✨</h2>

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm">
                        <strong class="font-bold">Heads up! There were some issues:</strong>
                        <ul class="mt-3 list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('step') === 'verify')
                    {{-- STEP 2: Enter the password sent to email --}}
                    <form method="POST" action="{{ route('register') }}" class="space-y-7">
                        @csrf
                        <input type="hidden" name="step" value="confirm">

                        <div>
                            <p class="text-base text-gray-600 mb-3 leading-relaxed">
                                A **one-time password** has been securely sent to <strong class="text-purple-600">{{ session('email') }}</strong>.
                                Please enter it below to swiftly complete your registration.
                            </p>
                            <label for="entered_password" class="block text-sm font-semibold text-gray-700 mb-1">Password from Email</label>
                            <input type="text" name="entered_password" id="entered_password" required
                                class="mt-1 block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-orange-500 focus:border-orange-500 focus:outline-none text-gray-900 text-lg">
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-6 border border-transparent rounded-lg shadow-lg text-lg font-semibold text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Complete Registration
                        </button>
                    </form>
                @else
                    {{-- STEP 1: Enter name, mobile, email --}}
                    <form method="POST" action="{{ route('register') }}" class="space-y-7">
                        @csrf
                        <input type="hidden" name="step" value="start">

                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" required autofocus
                                class="mt-1 block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-orange-500 focus:border-orange-500 focus:outline-none text-gray-900 text-lg"
                                placeholder="John Doe">
                        </div>

                        <div>
                            <label for="mobile_number" class="block text-sm font-semibold text-gray-700 mb-1">Mobile Number</label>
                            <input type="tel" name="mobile_number" id="mobile_number" required
    class="appearance-none mt-1 block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-orange-500 focus:border-orange-500 focus:outline-none text-gray-900 text-lg"
    placeholder="+91 9876543210" pattern="^\+?[0-9]{10,15}$" title="Enter a valid mobile number (e.g., +919876543210)">
                                <p class="mt-2 text-sm text-gray-500">Enter your 10-digit mobile number, including country code if applicable.</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-orange-500 focus:border-orange-500 focus:outline-none text-gray-900 text-lg"
                                placeholder="you@example.com">
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-6 border border-transparent rounded-lg shadow-lg text-lg font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 
                             focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Send Password to Email
                        </button>
                    </form>
                @endif

                <p class="text-base text-center text-gray-600 mt-8">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold text-orange-400 hover:text-orange-500 hover:underline transition duration-200">Log in here</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>