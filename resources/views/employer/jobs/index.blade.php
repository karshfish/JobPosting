<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">{{ __('Job Posts') }}</h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Manage and track your job listings') }}</p>
            </div>
            <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Post a Job') }}
            </a>
        </div>
    </x-slot>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $collection = $jobPosts ?? $posts ?? collect();
                $statusCounts = $collection->groupBy('status')->map->count();
                $publishedCount = ($statusCounts['approved'] ?? 0) + ($statusCounts['published'] ?? 0);
                $draftCount = $statusCounts['draft'] ?? 0;
                $closedCount = $statusCounts['closed'] ?? 0;
                $draftCount = $statusCounts['draft'] ?? 0;
                $rejectedCount = $statusCounts['rejected'] ?? 0;
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Left: Overview & Filters -->
                <aside class="lg:col-span-1 space-y-6">
                    <!-- Stats Card -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg divide-y divide-gray-200">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Overview') }}</h3>
                            <dl class="mt-5 grid grid-cols-1 gap-5">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Total Posts') }}</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $collection->count() }}</dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Published') }}</dt>
                                    <dd class="text-lg font-semibold text-green-600">{{ $publishedCount }}</dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('draft') }}</dt>
                                    <dd class="text-lg font-semibold text-yellow-600">{{ $draftCount }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Quick Filters') }}</h3>
                        <div class="space-y-4">
                            <button class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">{{ __('All Posts') }}</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $collection->count() }}</span>
                            </button>
                            <button class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">{{ __('Published') }}</span>
                                <span class="text-sm font-semibold text-green-600">{{ $publishedCount }}</span>
                            </button>
                            <button class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">{{ __('draft Review') }}</span>
                                <span class="text-sm font-semibold text-yellow-600">{{ $draftCount }}</span>
                            </button>
                            <button class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">{{ __('Closed') }}</span>
                                <span class="text-sm font-semibold text-gray-600">{{ $closedCount }}</span>
                            </button>
                        </div>
                    </div>
                </aside>

                <!-- Right: Job Posts List -->
                <section class="lg:col-span-3 space-y-6">
                    @if($collection->isEmpty())
                    <div class="bg-white shadow-sm rounded-lg p-8">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No job posts') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new job post.') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('jobPosts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('Create Job Post') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="space-y-4">
                        @foreach($collection as $post)
                        <article class="bg-white shadow-sm rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <!-- Header: Title + Status -->
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 flex items-center gap-4">
                                        <div class="w-12 h-12 flex-shrink-0 rounded-md overflow-hidden bg-gray-100 border">
                                            @if(!empty($post->branding_image))
                                                <img src="{{ asset('storage/' . $post->branding_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3v4M8 3v4m-5 4h18" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                                {{ $post->title ?? \Illuminate\Support\Str::limit($post->description ?? '', 60) }}
                                            </h3>
                                            @if(!empty($post->category))
                                                <div class="mt-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800">{{ $post->category }}</span>
                                                </div>
                                            @endif
                                            <div class="mt-1 flex items-center gap-2 text-sm text-gray-500">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    {{ $post->location ?? '-' }}
                                                </span>
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ ucfirst($post->work_type ?? 'n/a') }}
                                                </span>
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ optional($post->created_at)->diffForHumans() ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @php $s = $post->status ?? 'draft'; @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{
                                        $s === 'published' ? 'bg-green-100 text-green-800' :
                                        ($s === 'draft' ? 'bg-yellow-100 text-yellow-800' :
                                        ($s === 'closed' ? 'bg-gray-100 text-gray-800' :
                                        'bg-yellow-500 text-yellow-800'))
                                    }}">
                                        <span class="w-2 h-2 mr-2 rounded-full {{
                                            $s === 'published' ? 'bg-green-500' :
                                            ($s === 'draft' ? 'bg-yellow-500' :
                                            ($s === 'closed' ? 'bg-gray-500' :
                                            'bg-yellow-500'))
                                        }}"></span>
                                        {{ ucfirst($s) }}
                                    </span>
                                </div>

                                <!-- Body: Description + Meta -->
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($post->description ?? '', 200) }}</p>
                                    @if(!empty($post->responsibilities))
                                        @php
                                            $firstResp = trim(explode("\n", strip_tags($post->responsibilities))[0] ?? '');
                                        @endphp
                                        @if($firstResp)
                                            <p class="mt-2 text-sm text-gray-500"><strong>{{ __('Responsibility:') }}</strong> {{ \Illuminate\Support\Str::limit($firstResp, 100) }}</p>
                                        @endif
                                    @endif
                                    @if($post->skills)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach((array)$post->skills as $skill)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $skill }}
                                        </span>
                                        @endforeach
                                    </div>
                                    @endif

                                    {{-- Benefits: show as chips (up to 3) for a cleaner, professional look --}}
                                    @if(!empty($post->benefits))
                                        @php
                                            // accept array or string storage for benefits; normalize to $parts array
                                            if(is_array($post->benefits)){
                                                $parts = array_values($post->benefits);
                                            } else {
                                                $raw = $post->benefits;
                                                $parts = preg_split('/\r\n|\r|\n|,/', $raw);
                                                $parts = array_filter(array_map('trim', $parts));
                                                $parts = array_values($parts);
                                            }
                                            $shown = array_slice($parts, 0, 3);
                                            $hasMore = count($parts) > count($shown);
                                        @endphp
                                        @if(count($shown))
                                        <div class="mt-4">
                                            <h4 class="text-sm font-medium text-gray-900">{{ __('Benefits') }}</h4>
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                @foreach($shown as $b)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        {{ $b }}
                                                    </span>
                                                @endforeach
                                                @if($hasMore)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-50 text-indigo-700">+ {{ count($parts) - count($shown) }} more</span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                </div>

                                <!-- Footer: Meta + Actions -->
                                <div class="mt-6 flex items-center justify-between border-t pt-4">
                                    <div class="flex items-center space-x-4 text-sm">
                                        @if($post->salary_range)
                                        <span class="inline-flex items-center text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $post->salary_range }}
                                        </span>
                                        @endif
                                        @if($post->application_deadline)
                                        <span class="inline-flex items-center text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($post->application_deadline)->format('M d, Y') }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('jobs.show', $post) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ __('View') }}
                                        </a>
                                        


                                    </div>
                                </div>
                                {{-- benefits moved into the main body and shown as chips above; footer left for meta/actions only --}}
                            </div>
                        </article>
                        @endforeach
                    </div>

                    @if(method_exists($collection, 'links'))
                    <div class="mt-6">
                        {{ $collection->links() }}
                    </div>
                    @endif
                    @endif
                </section>
            </div>
        </div>
    </main>
</x-app-layout>
