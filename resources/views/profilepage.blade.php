<x-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg mt-25">
        <h2 class="text-2xl font-bold mb-6">Profile Settings</h2>
    
        @if(session('success'))
            <div class="mb-4 bg-green-500 font-medium text-white p-3">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="mb-4 bg-red-500 font-medium text-white p-3">{{$error}}</div>
            @endforeach
        @endif
    
        {{-- Profile Info --}}
        <div class="flex items-center space-x-6 mb-6">
            <img src="{{ Auth::user()->profile_photo_url ?? asset('user.png') }}"
                 alt="Profile Photo"
                 class="w-20 h-20 rounded-full object-cover border">
        <div>
                <h3 class="text-xl font-semibold">{{ Auth::user()->name }}</h3>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                <span class="inline-block mt-1 px-3 py-1 text-xs font-bold rounded-full
                    @switch(Auth::user()->role)
                        @case('superadmin') bg-purple-100 text-purple-800 @break
                        @case('admin') bg-blue-100 text-blue-800 @break
                        @case('subscriber') bg-green-100 text-green-800 @break
                        @case('qualitychecker') bg-yellow-100 text-yellow-800 @break
                        @default bg-gray-100 text-gray-800
                    @endswitch">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </div>
    
        {{-- Profile Update --}}
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
    
            <div>
                <label class="block font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
            </div>

            <div>
                <label class="block font-medium mb-1">Contact Number</label>
                <input type="number" name="mobile" value="{{ Auth::user()->mobile }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
            </div>
    
            <div>
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:outline-none">
            </div>
    
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Save Changes
            </button>
        </form>
    
        {{-- Divider --}}
        <hr class="my-8">
    
        {{-- Password Change --}}
        <h3 class="text-xl font-semibold mb-4">Change Password</h3>
        <form action="{{ route('profile.password') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
    
            <div>
                <label class="block font-medium mb-1">Current Password</label>
                <input type="password" name="current_password" required
                       class="w-full border rounded px-3 py-2 focus:ring">
            </div>
    
            <div class="relative">
                <label class="block font-medium mb-1">New Password</label>
                <input type="password" name="new_password" id="new_password" required
                       class="w-full border rounded px-3 py-2 focus:ring">
                <button type="button" onclick="togglePassword('new_password')"
                        class="absolute right-3 top-9 text-sm text-gray-600 hover:text-black">
                    👁️
                </button>
            </div>
    
            <div class="relative">
                <label class="block font-medium mb-1">Confirm Password</label>
                <input type="password" name="new_password_confirmation" id="confirm_password" required
                       class="w-full border rounded px-3 py-2 focus:ring">
                <button type="button" onclick="togglePassword('confirm_password')"
                        class="absolute right-3 top-9 text-sm text-gray-600 hover:text-black">
                    👁️
                </button>
            </div>
    
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                Update Password
            </button>
        </form>
    </div>
    
    <script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</x-layout>