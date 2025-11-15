<x-candidate-layout>
    <div class="container mx-auto px-6 py-10">
        {{-- Page Title --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center border-b pb-4">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            Edit Profile
        </h1>


        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        {{-- Profile Form Card --}}
        <div class="max-w-3xl mx-auto bg-white shadow-lg border border-gray-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300">

            <form action="{{ route('candidate.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                {{-- Profile Photo --}}
                <div class="flex flex-col items-center mb-6">
                    {{-- Current Photo --}}
                    @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                        class="w-32 h-32 rounded-full object-cover border shadow mb-3">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128"
                        class="w-32 h-32 rounded-full object-cover border shadow mb-3">
                    @endif

                    <!-- <label class="block text-sm font-semibold text-gray-800 mb-2">🖼 Profile Photo</label> -->
                    <input type="file"
                        name="profile_photo"
                        accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg
                focus:ring-2 focus:ring-blue-400 focus:outline-none transition">

                    @error('profile_photo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.121 17.804z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Full Name
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        placeholder="Enter your full name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 mr-2 0"
                            fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V8a2
              2 0 00-2-2H3a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="Enter your email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- {{-- Phone --}} -->
                <!-- <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">📞 Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="Enter your phone number"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> -->

                <!-- {{-- Address --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">🏠 Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        placeholder="Enter your address"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('address')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> -->

                <!-- {{-- Resume Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">📄 Resume (PDF)</label>
                    <input type="file" name="resume" accept="application/pdf"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @if($user->resume)
                    <p class="text-sm text-gray-500 mt-2">
                        Current Resume:
                        <a href="{{ asset('storage/' . $user->resume) }}" target="_blank"
                            class="text-blue-600 hover:underline font-medium">Download</a>
                    </p>
                    @endif
                    @error('resume')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> -->

                {{-- Buttons --}}
                <div class="flex justify-center items-center mt-8">
                    <!-- <a href="{{ route('candidate.dashboard') }}"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full shadow-sm transition">
                        ← Back
                    </a> -->

                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-full shadow-md transition duration-200 flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 4.5H7.5a1.5 1.5 0 00-1.5 1.5v12a1.5 1.5 0 001.5 1.5h9a1.5 1.5 0 001.5-1.5v-12a1.5 1.5 0 00-1.5-1.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v3h6v-3" />
                        </svg>

                        Update Profile
                    </button>

                </div>
            </form>
        </div>
    </div>
</x-candidate-layout>
