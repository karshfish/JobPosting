<x-app-layout>
    <div class="container mx-auto px-6 py-10">
        <div class="max-w-3xl mx-auto bg-white shadow-lg border border-gray-100 rounded-2xl p-8 hover:shadow-2xl transition">

            {{-- 🔙 Back to Jobs --}}
            <div class="mb-6">
                <a href="{{ route('candidate.jobs') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    ← Back to Job Listings
                </a>
            </div>

            {{-- 🧾 Page Title --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center border-b pb-4">
                Apply for: <span class="text-blue-600">{{ $job->title }}</span>
            </h1>

            {{-- ✅ Success Message --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- 💼 Job Information --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 text-gray-700">
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <p class="font-semibold text-gray-900">💰 Salary</p>
                    <p>{{ $job->salary_range ?? 'Not specified' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <p class="font-semibold text-gray-900">🏠 Work Type</p>
                    <p class="capitalize">{{ $job->work_type ?? 'N/A' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <p class="font-semibold text-gray-900">📅 Deadline</p>
                    <p>{{ $job->application_deadline ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- 📍 Job Description --}}
            <div class="mb-10">
                <h2 class="font-semibold text-gray-800 mb-2">📝 Description</h2>
                <p class="text-gray-600 leading-relaxed">{{ $job->description }}</p>
            </div>

            {{-- 🧍 Candidate Application Form --}}
            <form action="{{ route('candidate.jobs.submit', $job) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6" id="applicationForm">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                        placeholder="Enter your full name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                        placeholder="Enter your email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                        placeholder="Enter your phone number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Resume --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Upload Resume <span class="text-gray-500 text-xs">(PDF only)</span>
                    </label>
                    <input type="file" name="resume" accept="application/pdf" id="resumeInput"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition">

                    @if(!empty($user->resume))
                    <p class="text-sm text-gray-500 mt-2">
                        📎 Current resume:
                        <a href="{{ asset('storage/' . $user->resume) }}" target="_blank"
                            class="text-blue-600 hover:underline font-medium">Download</a>
                    </p>
                    @endif

                    @error('resume')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="text-center pt-6">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-10 py-2.5 rounded-full font-semibold shadow-md transition duration-200">
                        🚀 Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ⚠️ Client-side validation for PDF --}}
    <script>
        document.getElementById('applicationForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('resumeInput');
            const file = fileInput.files[0];
            if (file && file.type !== 'application/pdf') {
                e.preventDefault();
                alert('Please upload a valid PDF file.');
            }
        });
    </script>
</x-app-layout>
