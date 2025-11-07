<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Job Details') }}</h2>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('jobPosts.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">{{ __('Back') }}</a>
                <a href="{{ route('jobPosts.edit', $post ?? $JobPost ?? $jobPost ?? '') }}" class="inline-flex items-center px-3 py-2 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">{{ __('Edit') }}</a>
                <form action="{{ route('jobPosts.destroy', $post ?? $JobPost ?? $jobPost ?? '') }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </x-slot>

    <main class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @php
                // Accept any of the common variable names controller may pass
                $post = $post ?? $JobPost ?? $jobPost ?? null;
            @endphp

            @if(!$post)
                <div class="bg-white shadow rounded p-6 text-center text-gray-600">{{ __('Job post not found.') }}</div>
            @else
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left: Logo + Meta -->
                    <div class="md:col-span-1 flex flex-col items-center text-center">
                        <div class="w-28 h-28 rounded-md overflow-hidden bg-gray-100 border">
                            @if(!empty($post->branding_image))
                                <img src="{{ asset('storage/' . $post->branding_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3v4M8 3v4m-5 4h18" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <h3 class="mt-4 text-lg font-semibold text-gray-900 truncate">{{ $post->title }}</h3>
                                <div class="mt-2 text-sm text-gray-600">
                            {{ $post->location ?? '-' }} · {{ ucfirst($post->work_type ?? 'n/a') }}
                        </div>

                        @if($post->category)
                            <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                {{ $post->category }}
                            </span>
                        @endif

                        @if($post->salary_range)
                            <div class="mt-3 text-sm font-medium text-gray-900">
                                {{ $post->salary_range }}
                            </div>
                        @endif

                        <div class="mt-4">
                            @php $s = $post->status ?? 'draft'; @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{
                                $s === 'approved' ? 'bg-green-100 text-green-800' :
                                ($s === 'rejected' ? 'bg-red-100 text-red-800' :
                                ($s === 'closed' ? 'bg-gray-100 text-gray-800' :
                                'bg-yellow-100 text-yellow-800'))
                            }}">
                                <span class="w-2 h-2 mr-2 rounded-full {{
                                    $s === 'approved' ? 'bg-green-500' :
                                    ($s === 'rejected' ? 'bg-red-500' :
                                    ($s === 'closed' ? 'bg-gray-500' :
                                    'bg-yellow-500'))
                                }}"></span>
                                {{ ucfirst($s) }}
                            </span>
                        </div>

                        <div class="mt-4 text-sm text-gray-500">{{ optional($post->created_at)->format('M d, Y') }}</div>
                    </div>

                    <!-- Right: Details -->
                    <div class="md:col-span-2">
                    <div class="md:col-span-2 space-y-8">
                        <!-- Job Description -->
                        <div class="prose max-w-none">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('About this position') }}</h3>
                            <div class="mt-4 text-gray-600">
                                {!! nl2br(e($post->description)) !!}
                            </div>
                        </div>

                        <!-- Responsibilities -->
                        @if($post->responsibilities)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Key Responsibilities') }}</h3>
                            <ul class="mt-4 space-y-2 text-gray-600">
                                @foreach(explode("\n", $post->responsibilities) as $responsibility)
                                    @if(trim($responsibility))
                                        <li class="flex items-start">
                                            <span class="flex-shrink-0 mt-1">
                                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                            <span class="ml-3">{{ $responsibility }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Skills -->
                        @if(!empty($post->skills))
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Required Skills') }}</h3>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($post->skills as $skill)
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Benefits (render as chips like Skills/Qualifications) -->
                        @php
                            // normalize benefits to array (support JSON/array or legacy string)
                            if(!empty($post->benefits)){
                                if(is_array($post->benefits)){
                                    $benefitsParts = array_values($post->benefits);
                                } else {
                                    $benefitsParts = preg_split('/\r\n|\r|\n|,/', $post->benefits);
                                    $benefitsParts = array_filter(array_map('trim', $benefitsParts));
                                    $benefitsParts = array_values($benefitsParts);
                                }
                            } else {
                                $benefitsParts = [];
                            }
                        @endphp

                        @if(count($benefitsParts))
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Benefits') }}</h3>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($benefitsParts as $b)
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $b }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                            @if($post->responsibilities)
                                <h5 class="mt-4 font-medium text-gray-900">{{ __('Responsibilities') }}</h5>
                                <ul class="list-disc pl-5 text-gray-700">
                                    @foreach(explode("\n", $post->responsibilities) as $line)
                                        @if(trim($line) != '')
                                            <li>{{ trim($line) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif

                            @if($post->skills)
                                <h5 class="mt-4 font-medium text-gray-900">{{ __('Skills') }}</h5>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach((array)$post->skills as $skill)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if($post->qualifications)
                                <h5 class="mt-4 font-medium text-gray-900">{{ __('Qualifications') }}</h5>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach((array)$post->qualifications as $q)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">{{ $q }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if($post->salary_range || $post->application_deadline || $post->benefits)
                                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @if($post->salary_range)
                                        <div>
                                            <h6 class="text-sm font-medium text-gray-900">{{ __('Salary') }}</h6>
                                            <div class="text-gray-700 text-sm mt-1">{{ $post->salary_range }}</div>
                                        </div>
                                    @endif
                                    @if($post->application_deadline)
                                        <div>
                                            <h6 class="text-sm font-medium text-gray-900">{{ __('Apply By') }}</h6>
                                            <div class="text-gray-700 text-sm mt-1">{{ \Carbon\Carbon::parse($post->application_deadline)->format('M d, Y') }}</div>
                                        </div>
                                    @endif
                                    @if($post->benefits)
                                        <div>
                                            <h6 class="text-sm font-medium text-gray-900">{{ __('Benefits') }}</h6>
                                            <div class="text-gray-700 text-sm mt-1">{{ $post->benefits }}</div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </main>
</x-app-layout>
