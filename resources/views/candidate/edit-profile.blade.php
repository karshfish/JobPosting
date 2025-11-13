<x-candidate-layout>
    <div class="container mx-auto px-6 py-10">
        {{-- Page Title --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center border-b pb-4">
            👤 Edit Profile
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

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">👤 Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        placeholder="Enter your full name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">📧 Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="Enter your email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">📞 Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="Enter your phone number"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">🏠 Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        placeholder="Enter your address"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('address')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Resume Upload --}}
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
                </div>

                {{-- Buttons --}}
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('candidate.dashboard') }}"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full shadow-sm transition">
                        ← Back
                    </a>

                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-full shadow-md transition duration-200">
                        💾 Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-candidate-layout>
