<x-app-layout>

    {{-- ===========================
      HERO SECTION
=========================== --}}
    <section class="relative bg-gray-50 border-b border-gray-100 dark:border-slate-700 dark:bg-gray-900">
        <div
            class="max-w-7xl mx-auto px-6 min-h-[90vh] lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- TEXT SIDE -->
            <div class="space-y-6">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white leading-tight">
                    Careers at Hireup
                </h1>

                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-300">
                    Join us in delivering disability support as it should be.
                </h2>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-base">
                    We’re Hireup and we’re on a mission to ensure that people living with disability can access
                    the right support for the moments that matter to them.
                </p>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-base">
                    You’ll become a critical part of a purpose-driven team, delivering our mission for people
                    with a disability. Wherever you fit best within our organisation, our mission will ignite you
                    and our authentic, united and diverse workplace will help you grow.
                </p>

                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-base">
                    So be a part of our story and let us help you develop the next chapter of your own.
                </p>

                <a href="#"
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold hover:underline transition">
                    Learn about the application process →
                </a>
            </div>

            <!-- IMAGE SIDE -->
            <div class="relative">
                <div class="overflow-hidden shadow-lg rounded-bl-[200px] rounded-[20px] w-[30rem]">
                    <img src="{{ asset('assets/hero.jpg') }}" class="w-full h-[420px] object-cover" alt="Hero Image">
                </div>

                <!-- Curved Decoration -->
                <div
                    class="absolute -bottom-6 -left-6 w-32 h-32
                            bg-indigo-200 dark:bg-indigo-800 opacity-50
                            rounded-tl-[60px] rounded-br-[60px] backdrop-blur-md">
                </div>
            </div>

        </div>
    </section>






    {{-- ===========================
      CATEGORY SECTION
=========================== --}}
    <section class="py-16 bg-gray-50 border-b border-gray-100 dark:border-slate-700 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-6 ">

            <!-- Section Header -->
            <h2 class="text-4xl md:text-5xl text-center font-extrabold mb-4 text-gray-900 dark:text-white">
                Browse Job Categories
            </h2>

            <!-- Section Description -->
            <p
                class="text-gray-700 text-center dark:text-gray-300 mb-12 max-w-3xl mx-auto text-md md:text-sm leading-relaxed">
                Explore a variety of job categories to find the perfect opportunities that match your skills and career
                aspirations. Each category connects you to roles that help you grow, learn, and make an impact.
            </p>

            <!-- Categories Grid -->
            @if ($categories->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach ($categories as $category)
                        <div
                            class="bg-gray-50 dark:bg-slate-800 p-6 rounded-xl shadow hover:shadow-lg transition flex flex-col justify-between">
                            <!-- Category Name -->
                            <h4 class="text-xl font-semibold dark:text-white mb-3">{{ $category->name }}</h4>

                            <!-- Category Description -->
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-6">
                                {{ $category->description ?? 'Explore a wide range of job opportunities in this category and find the perfect match for your skills and career goals.' }}
                            </p>

                            <!-- Action Button (link style) -->
                            <a href="{{ route('jobs', ['category' => $category->id]) }}"
                                class="mt-auto inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold hover:underline transition">
                                View Jobs →
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- See More Button -->
            <div class="mt-12 text-center">
                <a href="{{ route('jobs') }}"
                   class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition font-medium">
                    See More Categories
                </a>
            </div>
            @else
                <p class="dark:text-gray-300">No categories found.</p>
            @endif

        </div>
    </section>






    {{-- ===========================
      TREND JOBS SECTION
=========================== --}}
  <section class="py-20 bg-gray-50 dark:bg-slate-900 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <h2 class="text-4xl md:text-5xl text-center font-extrabold mb-4 text-gray-900 dark:text-white">
            Trending Jobs
        </h2>

        <p class="text-gray-700 dark:text-gray-300 text-center mb-14 max-w-3xl mx-auto text-base sm:text-lg md:text-xl leading-relaxed">
            Explore the most in-demand job opportunities. These listings have received the highest number of applications and are trending among job seekers right now.
        </p>

        @if ($trendJobs->count() > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
                @foreach ($trendJobs as $job)

                    <div class="bg-white dark:bg-slate-800 p-7 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 hover:shadow-xl transition">

                        <!-- Applications Badge -->
                        <div class="flex justify-between items-center mb-4">
                            <span class="px-3 py-1 bg-indigo-600/10 dark:bg-indigo-400/20 text-indigo-700 dark:text-indigo-300 text-sm font-semibold rounded-full">
                                 {{ $job->applications_count }} Applications
                            </span>

                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Job Title -->
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $job->title }}
                        </h3>

                        <!-- Company -->
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            {{ $job->company_name }}
                        </p>

                        <!-- Short Description -->
                        <p class="text-gray-700 dark:text-gray-400 mb-6">
                            {{ Str::limit($job->description, 110) }}
                        </p>

                        <!-- View Button -->
                        <a href="{{ route('jobs.show', $job->id) }}"
                           class="inline-flex items-center font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                            View Job →
                        </a>
                    </div>

                @endforeach
            </div>
            <!-- See More Button -->
            <div class="mt-12 text-center">
                <a href="{{ route('jobs') }}"
                   class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition font-medium">
                    See More Jobs
                </a>
            </div>
        @else
            <p class="text-center text-gray-500 dark:text-gray-300">No trending jobs available.</p>
        @endif

    </div>
</section>





    {{-- ===========================
      EXTRA
=========================== --}}
    <section class="py-16 bg-gray-50 border-b border-gray-100 dark:border-slate-700 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-6 text-center">

            <!-- Section Heading -->
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Our benefits</h2>
            <p class="text-gray-500 dark:text-gray-300 mt-2">We want to help you live your good life.</p>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">

                <!-- Card 1 -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-3xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="text-blue-600 text-4xl mb-4">
                        🌐
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">Work and flexibility</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-3 text-sm leading-relaxed">
                        We are a hybrid organisation, offering flexibility in how and where
                        you do your best work. With an annual ‘Work Well’ allowance to
                        support your hybrid work set-up and beautiful offices.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-3xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="text-blue-600 text-4xl mb-4">
                        💰
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">Financial wellbeing</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-3 text-sm leading-relaxed">
                        Salary-sacrificing options, superannuation support, financial
                        coaching sessions and staff discounts to help you grow financially.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-3xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="text-blue-600 text-4xl mb-4">
                        🛒
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">Life and leave</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-3 text-sm leading-relaxed">
                        Access to Good Life days, family leave, paid learning leave and
                        opportunities to connect with the community.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-gray-50 dark:bg-slate-800 rounded-3xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="text-blue-600 text-4xl mb-4">
                        📘
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">Learning</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-3 text-sm leading-relaxed">
                        On-demand tools, paid learning leave and individual budgets to
                        support your growth and development.
                    </p>
                </div>

            </div>
        </div>
    </section>


    {{-- ===========================
      Footer
=============================== --}}

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
