<x-candidate-layout>
    <div class="container mx-auto p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Available Job Posts</h2>
                <p class="mt-1 text-sm text-gray-600">Browse and apply to all available job opportunities</p>
            </div>
        </div>

        @php
        $collection = $jobs ?? collect();

        $statusCounts = $collection->groupBy('status')->map->count();

        $publishedCount = ($statusCounts['accepted'] ?? 0) + ($statusCounts['published'] ?? 0);
        $draftCount = $statusCounts['draft'] ?? 0;
        $closedCount = $statusCounts['closed'] ?? 0;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- LEFT SIDEBAR -->
            <aside class="lg:col-span-1 space-y-6">

                {{-- Quick Filters --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Filters</h3>
                    <div class="space-y-3">
                        <a href="{{ route('candidate.jobs') }}"
                            class="w-full block px-4 py-2 rounded-lg flex items-center justify-between hover:bg-gray-50 transition
                           {{ request('status') == '' ? 'bg-indigo-50 border border-indigo-100' : '' }}">
                            <span class="text-sm font-medium text-gray-700">All Posts</span>
                            <!-- <span class="text-sm font-semibold text-gray-900">{{ $collection->count() }}</span> -->
                        </a>
                        <a href="{{ route('candidate.jobs', ['status' => 'published']) }}"
                            class="w-full block px-4 py-2 rounded-lg flex items-center justify-between hover:bg-gray-50 transition
                           {{ request('status') == 'published' ? 'bg-green-50 border border-green-100' : '' }}">
                            <span class="text-sm font-medium text-gray-700">Published</span>
                            <!-- <span class="text-sm font-semibold text-green-600">{{ $publishedCount }}</span> -->
                        </a>
                        <a href="{{ route('candidate.jobs', ['status' => 'draft']) }}"
                            class="w-full block px-4 py-2 rounded-lg flex items-center justify-between hover:bg-gray-50 transition
                           {{ request('status') == 'draft' ? 'bg-yellow-50 border border-yellow-100' : '' }}">
                            <span class="text-sm font-medium text-gray-700">Draft</span>
                            <!-- <span class="text-sm font-semibold text-yellow-600">{{ $draftCount }}</span> -->
                        </a>
                        <a href="{{ route('candidate.jobs', ['status' => 'closed']) }}"
                            class="w-full block px-4 py-2 rounded-lg flex items-center justify-between hover:bg-gray-50 transition
                           {{ request('status') == 'closed' ? 'bg-gray-50 border border-gray-200' : '' }}">
                            <span class="text-sm font-medium text-gray-700">Closed</span>
                            <!-- <span class="text-sm font-semibold text-gray-600">{{ $closedCount }}</span> -->
                        </a>
                    </div>
                </div>

                {{-- Advanced Filters --}}
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Advanced Filter</h3>
                    <form method="GET" action="{{ route('candidate.jobs') }}" class="space-y-4">
                        <div>
                            <label class="text-sm font-medium">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="mt-1 block w-full px-3 py-2 border rounded-md" placeholder="Job title...">
                        </div>
                        <div>
                            <label class="text-sm font-medium">Location</label>
                            <input type="text" name="location" value="{{ request('location') }}"
                                class="mt-1 block w-full px-3 py-2 border rounded-md" placeholder="e.g. Cairo">
                        </div>
                        <div>
                            <label class="text-sm font-medium">Work Type</label>
                            <select name="work_type" class="mt-1 block w-full px-3 py-2 border rounded-md">
                                <option value="">Any</option>
                                <option value="remote" {{ request('work_type')=='remote'?'selected':'' }}>Remote</option>
                                <option value="onsite" {{ request('work_type')=='onsite'?'selected':'' }}>On-site</option>
                                <option value="hybrid" {{ request('work_type')=='hybrid'?'selected':'' }}>Hybrid</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium">Date Posted</label>
                            <select name="date" class="mt-1 block w-full px-3 py-2 border rounded-md">
                                <option value="">Any</option>
                                <option value="today" {{ request('date')=='today'?'selected':'' }}>Today</option>
                                <option value="week" {{ request('date')=='week'?'selected':'' }}>This Week</option>
                                <option value="month" {{ request('date')=='month'?'selected':'' }}>This Month</option>
                            </select>
                        </div>
                        <button class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">
                            Apply Filter
                        </button>
                    </form>
                </div>

            </aside>

            <!-- JOB CARDS -->
            <section class="lg:col-span-3 space-y-6">

                @if($collection->isEmpty())
                <div class="bg-white shadow-sm rounded-lg p-8 text-center">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No job posts found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your filters.</p>
                </div>
                @else

                <div class="space-y-4">
                    @foreach($collection as $post)
                    <article class="bg-white shadow-sm rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">

                            <!-- Left: Logo + Info -->
                            <div class="flex-1 flex gap-4">
                                <div class="w-16 h-16 flex-shrink-0 rounded-md overflow-hidden bg-gray-100 border">
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

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-medium text-gray-900 truncate">{{ $post->title ?? \Illuminate\Support\Str::limit($post->description ?? '', 60) }}</h3>

                                    @if(!empty($post->category))
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800">{{ $post->category->name ?? $post->category }}</span>
                                    </div>
                                    @endif

                                    <div class="mt-2 flex flex-wrap gap-2 text-sm text-gray-500">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $post->location ?? '-' }}
                                        </span>

                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ ucfirst($post->work_type ?? 'n/a') }}
                                        </span>

                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ optional($post->created_at)->diffForHumans() ?? '-' }}
                                        </span>
                                    </div>

                                    {{-- Skills --}}
                                    @if($post->skills)
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        @foreach((array)$post->skills as $skill)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                    @endif

                                    {{-- Benefits --}}
                                    @if(!empty($post->benefits))
                                    @php
                                    $parts = is_array($post->benefits) ? array_values($post->benefits) : preg_split('/\r\n|\r|\n|,/', $post->benefits);
                                    $parts = array_filter(array_map('trim', $parts));
                                    $parts = array_values($parts);
                                    $shown = array_slice($parts, 0, 3);
                                    $hasMore = count($parts) > count($shown);
                                    @endphp
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach($shown as $b)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800 gap-1">
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ $b }}
                                        </span>
                                        @endforeach
                                        @if($hasMore)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-50 text-indigo-700">+ {{ count($parts) - count($shown) }} more</span>
                                        @endif
                                    </div>
                                    @endif

                                </div>

                                <!-- Right: Status + Actions -->
                                <div class="flex flex-col justify-between items-start sm:items-end gap-3 mt-4 sm:mt-0">
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

                                    <div class="flex gap-2 flex-wrap">
                                        <a href="{{ route('candidate.jobs.show', $post) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                            View
                                        </a>
                                        @if($post->status == 'published')
                                        <a href="{{ route('candidate.jobs.apply', $post) }}" class="px-3 py-1.5 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-700">
                                            Apply
                                        </a>
                                        @else
                                        <button disabled class="px-3 py-1.5 text-sm rounded bg-gray-300 text-gray-600 cursor-not-allowed">
                                            Not Available
                                        </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $collection->links() }}
                </div>

                @endif

            </section>

        </div>
    </div>
</x-candidate-layout>
