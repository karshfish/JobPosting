<x-candidate-layout>
    <div class="container mx-auto px-6 py-10">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow-lg border border-gray-100 dark:border-gray-700 rounded-2xl p-8 hover:shadow-2xl transition">

            {{-- Back to Jobs --}}
            <div class="mb-6">
                <a href="{{ route('candidate.jobs') }}"
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                    ← Back to Job Listings
                </a>
            </div>

            {{-- Page Title --}}
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center border-b dark:border-gray-600 pb-4">
                Apply for: <span class="text-blue-600 dark:text-blue-400">{{ $job->title }}</span>
            </h1>

            {{-- Success Message --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-300 p-4 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Job Information --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 text-gray-700 dark:text-gray-300">
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl border dark:border-gray-600">
                    <p class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m-9-9h2m14 0h2m-16.071-7.071l1.414 1.414m12.728 12.728l1.414 1.414M4.929 19.071l1.414-1.414m12.728-12.728l1.414-1.414" />
                        </svg>
                        Salary
                    </p>
                    <p>{{ $job->salary_min ?? 'Not specified' }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl border dark:border-gray-600">
                    <p class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-6a2 2 0 012-2h14a2 2 0 012 2v6" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-4h6v4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L3 9h18L12 3z" />
                        </svg>
                        Work Type
                    </p>
                    <p class="capitalize">{{ $job->work_type ?? 'N/A' }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl border dark:border-gray-600">
                    <p class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
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
                <h2 class="font-semibold text-gray-800 dark:text-gray-100 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h8m-8-4h8M4 6h16v12H4V6z" />
                    </svg>
                    Description
                </h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $job->description }}</p>
            </div>
            {{-- LinkedIn Autofill Section --}}
<div class="mb-8 p-5 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl">
    <h2 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
            <path d="M4.98 3.5C3.33 3.5 2 4.83 2 6.48c0 1.64 1.32 2.97 2.98 2.97h.02c1.65 0 2.98-1.33 2.98-2.97C7.98 4.83 6.65 3.5 4.98 3.5zM2.4 21.5h5.17V8.98H2.4V21.5zM9.34 8.98V21.5h5.17v-6.48c0-3.42 4.39-3.7 4.39 0V21.5H24v-7.93c0-6.92-7.52-6.67-9.49-3.27V8.98H9.34z"/>
        </svg>
        Autofill Your Application
    </h2>

    @if(is_null(auth()->user()->linkedin_data)
)
        <p class="text-gray-700 dark:text-gray-300 mb-3">
            LinkedIn connected ✔ — You can autofill your data.
        </p>

        <button
            type="button"
            id="linkedin-autofill-btn"
            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition">
            Autofill from LinkedIn
        </button>
    @else
        <button
            type="button"
            id="linkedin-connect-btn"
            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition inline-flex items-center">
            Connect LinkedIn
        </button>
    @endif
</div>

{{-- JS to Autofill Fields --}}
@if(auth()->user()->linkedin_connected)
<script>
    document.getElementById('linkedin-autofill-btn')?.addEventListener('click', async () => {
        try {
            const res = await fetch('{{ route("linkedin.fetch") }}');
            const data = await res.json();

            if (data.success) {
                document.querySelector('input[name="name"]').value = data.name ?? '';
                document.querySelector('input[name="email"]').value = data.email ?? '';
                document.querySelector('input[name="phone"]').value = data.phone ?? '';

                alert("Your LinkedIn data has been filled in!");
            }
        } catch (e) {
            alert("Could not fetch LinkedIn data.");
        }
    });
</script>
@endif

@if(!auth()->user()->linkedin_connected)
<script>
    document.getElementById('linkedin-connect-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        const width = 600;
        const height = 700;
        const left = (window.screen.width / 2) - (width / 2);
        const top = (window.screen.height / 2) - (height / 2);
        window.open(
            '{{ route('linkedin.redirect') }}',
            'LinkedInLogin',
            `width=${width},height=${height},top=${top},left=${left},resizable,scrollbars=yes,status=1`
        );
    });
</script>
@endif

            {{-- Candidate Application Form --}}
            <form action="{{ route('candidate.jobs.submit', $job) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6" id="applicationForm">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ $linkedin['name'] ?? old('name', $user->name ?? '') }}"
                        placeholder="Enter your full name"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                    @error('name')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $linkedin['email'] ?? old('email', $user->email ?? '') }}"
                        placeholder="Enter your email"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                    @error('email')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ $linkedin['phone'] ?? old('phone', $user->phone ?? '') }}"
                        placeholder="Enter your phone number"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                    @error('phone')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Resume --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                        Upload Resume <span class="text-gray-500 dark:text-gray-400 text-xs">(PDF only)</span>
                    </label>
                    <input type="file" name="resume" accept="application/pdf" id="resumeInput"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">

                    @if(!empty($user->resume))
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        📎 Current resume:
                        <a href="{{ asset('storage/' . $user->resume) }}" target="_blank"
                            class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Download</a>
                    </p>
                    @endif

                    @error('resume')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
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
</x-candidate-layout>
