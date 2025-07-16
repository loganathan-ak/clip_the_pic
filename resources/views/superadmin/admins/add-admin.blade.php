<x-layout>
    <div class="max-w-3xl mx-auto mt-5 px-6 py-12">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800">➕ Add New Admin</h2>
            <a href="{{ route('superadmin.admins') }}"
               class="text-sm font-medium text-gray-700 hover:text-blue-600 transition flex items-center">
                ← Back to List
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-xl p-8 space-y-6">

            <form action="#" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="Enter admin name" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="admin@example.com" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="••••••••" required>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-600 mb-1">Role</label>
                    <select name="role" id="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="qualitychecker" {{ old('role') == 'qualitychecker' ? 'selected' : '' }}>Quality checker</option>
                        {{-- <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option> --}}
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition duration-300 shadow-lg">
                        ✅ Create Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
