<x-app-layout>
    <div class="container mx-auto px-6 py-10">
        <div class="max-w-3xl mx-auto bg-white shadow-lg border border-gray-100 rounded-2xl p-8 hover:shadow-2xl transition">

            {{-- Back to Jobs --}}
            <div class="mb-6">
                <a href="{{ route('candidate.jobs') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    ← Back to Job Listings
                </a>
            </div>

            {{-- Page Title --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center border-b pb-4">
                Apply for: <span class="text-blue-600">{{ $job->title }}</span>
            </h1>

            {{-- Success Message --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Job Information --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 text-gray-700">
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <p class="font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m-9-9h2m14 0h2m-16.071-7.071l1.414 1.414m12.728 12.728l1.414 1.414M4.929 19.071l1.414-1.414m12.728-12.728l1.414-1.414" />
                        </svg>
                        Salary
                    </p>
                    <p>{{ $job->salary_min ?? 'Not specified' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <p class="font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-6a2 2 0 012-2h14a2 2 0 012 2v6" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-4h6v4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L3 9h18L12 3z" />
                        </svg>
                        Work Type
                    </p>
                    <p class="capitalize">{{ $job->work_type ?? 'N/A' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <p class="font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Deadline
                    </p>
                    <p>{{ $job->application_deadline ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Job Description --}}
            <div class="mb-10">
                <h2 class="font-semibold text-gray-800 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h8m-8-4h8M4 6h16v12H4V6z" />
                    </svg>
                    Description
                </h2>
                <p class="text-gray-600 leading-relaxed">{{ $job->description }}</p>
            </div>

            {{-- Candidate Application Form --}}
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
                <div class="text-center pt-6 flex justify-center">

                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-10 py-2.5 rounded-full font-semibold shadow-md transition duration-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9" />
                        </svg>
                        Submit Application
                    </button>

                </div>
            </form>
        </div>
    </div>

    {{-- Client-side validation for PDF --}}
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
