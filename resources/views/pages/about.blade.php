<x-app-layout>

    {{-- Hero Section --}}
    <section class=" border-b border-gray-100 dark:border-slate-700 relative py-24 bg-gray-50 dark:bg-slate-900">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('assets/hero.avif') }}" class="w-full h-full object-cover opacity-30 dark:opacity-50"
                alt="Background">
            <div class="absolute inset-0 bg-gray-900/35 dark:bg-black/40"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                Our Mission & Vision
            </h2>
            <p class="text-lg md:text-xl text-gray-200 mb-6 max-w-2xl mx-auto">
                Discover what drives us to create meaningful connections and life-changing opportunities.
            </p>
            <a href="#team"
                class="inline-block px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition">
                Meet Our Team
            </a>
        </div>
    </section>

    {{-- Team Section --}}
    <section id="team" class="border-b border-gray-100 dark:border-slate-700  py-24 bg-gray-50 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl md:text-4xl font-bold text-center dark:text-white">Meet Our Team</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mt-2">
                A group of passionate individuals working to build the future of hiring.
            </p>

            <div class="grid md:grid-cols-4 gap-10 mt-16">

                @foreach ([
        [
            'name' => 'Fady Samire',
            'role' => 'Security Lead',
            'img' => 'D1.jpg',
            'description' => 'Responsible for maintaining the security of the platform, ensuring data privacy and system integrity.',
        ],
        [
            'name' => 'Eslam Ahmed',
            'role' => 'Admin Manager',
            'img' => 'D2.jpg',
            'description' => 'Handles all administrative functions, manages internal workflows, and ensures smooth operation of the admin panel.',
        ],
        [
            'name' => 'Ahmed Elnagar',
            'role' => 'Candidate Manager',
            'img' => 'D3.jpg',
            'description' => 'Manages the candidate experience, oversees applications, and ensures a seamless hiring process for job seekers.',
        ],
        [
            'name' => 'Moaz Yasser',
            'role' => 'Employer Manager',
            'img' => 'D4.jpg',
            'description' => 'Responsible for handling employer accounts, job postings, and ensuring businesses find the right talent efficiently.',
        ],
    ] as $member)
                    <div
                        class="bg-gray-50 dark:bg-slate-900 rounded-3xl shadow border border-gray-200 dark:border-gray-700 p-6 text-center">
                        <img src="{{ asset('assets/' . $member['img']) }}"
                            class="w-28 h-28 mx-auto rounded-full object-cover shadow mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $member['name'] }}</h3>
                        <p class="text-indigo-600 dark:text-indigo-400 font-medium mb-2">{{ $member['role'] }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $member['description'] }}</p>
                    </div>
                @endforeach

            </div>


        </div>
    </section>


    {{-- Values --}}
    <section
        class="py-20 bg-gray-50 border-b border-gray-100 dark:border-slate-700 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl md:text-4xl font-bold text-center dark:text-white">Our Values</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mt-2 max-w-2xl mx-auto">
                The core principles that guide everything we do.
            </p>

            <div class="grid md:grid-cols-3 gap-10 mt-14">

                <div
                    class="bg-gray-50 dark:bg-slate-900 p-8 rounded-3xl shadow border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">Integrity</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                        We uphold honesty and transparency, building trust with every interaction.
                    </p>
                </div>

                <div
                    class="bg-gray-50 dark:bg-slate-900 p-8 rounded-3xl shadow border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">Innovation</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                        We challenge norms and create smarter, faster ways for people to connect.
                    </p>
                </div>

                <div
                    class="bg-gray-50 dark:bg-slate-900 p-8 rounded-3xl shadow border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">Empowerment</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                        We provide tools and support that help individuals and companies grow.
                    </p>
                </div>

            </div>
        </div>
    </section>

      <footer class="bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-300 py-16">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Logo -->
            <div class="mb-10 text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start space-x-2">
                    <img src="{{ asset('assets/logo.jpg') }}" class="h-8 rounded w-auto" alt="Logo">
                    <span class="text-gray-900 dark:text-white text-2xl font-semibold">Hireup</span>
                </div>
            </div>

            <!-- Footer Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-10">

                <!-- Column 1 -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-semibold mb-4">How Hireup Works</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Home</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-blue-600 dark:hover:text-blue-400 transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Safety</a>
                        </li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Events</a>
                        </li>
                    </ul>
                </div>

                <!-- Column 2 -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-semibold mb-4">Find Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">For
                                Individuals</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">For
                                Support Coordinators</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">For
                                Service Providers</a></li>
                        <li><a href="#"
                                class="hover:text-blue-600 dark:hover:text-blue-400 transition">Individualised Living
                                Options</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-semibold mb-4">Support Near You</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Adelaide,
                                SA</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Brisbane,
                                QLD</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Melbourne,
                                VIC</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Perth,
                                WA</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Sydney,
                                NSW</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Across
                                Australia</a></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-semibold mb-4">Provide Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Become a
                                Support Worker</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">The
                                Hireup Difference</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Pay and
                                Benefits</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Paid
                                Training</a></li>
                    </ul>
                </div>

                <!-- Column 5 -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-semibold mb-4">About Us</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Our
                                Story</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Our
                                Impact</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Annual
                                Reports</a></li>
                        <li><a href="#"
                                class="hover:text-blue-600 dark:hover:text-blue-400 transition">Careers</a></li>
                        <li><a href="#"
                                class="hover:text-blue-600 dark:hover:text-blue-400 transition">Press</a></li>
                    </ul>
                </div>

                <!-- Column 6 -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-semibold mb-4">Your Account</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="hover:text-blue-600 dark:hover:text-blue-400 transition">Login</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Sign
                                Up</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Hireup
                                App</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Give
                                feedback</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </footer>




</x-app-layout>
