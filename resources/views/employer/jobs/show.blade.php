<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-4">
                            <li>
                                <div class="flex items-center">
                                    <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Job Posts') }}</a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-4 text-sm font-medium text-gray-500">{{ __('Job Details') }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ __('Job Details') }}
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('jobs.edit', $job ?? '') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('Edit Job') }}
                    </a>
                    <form action="{{ route('jobs.destroy', $job ?? '') }}" method="POST" class="inline-block"
                          onsubmit="return confirm('{{ __('Are you sure you want to delete this job post? This action cannot be undone.') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            {{ __('Delete Job') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $post = $post ?? $job ?? null;
            @endphp

            @if(!$post)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No Job Found') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('The job post you\'re looking for doesn\'t exist or has been removed.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                {{ __('Back to Job Posts') }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
            <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
                <div class="p-6 lg:p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Left: Logo + Meta -->
                    <div class="md:col-span-1">
                        <div class="flex flex-col items-center pb-6 border-b border-gray-200 md:border-b-0 md:border-r">
                            <div class="w-40 h-40 rounded-xl overflow-hidden bg-white shadow-md border-2 border-gray-100">
                                @if(!empty($post->branding_image))
                                    <img src="{{ asset('storage/' . $post->branding_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 text-center">
                                <h1 class="text-xl font-bold text-gray-900">{{ $post->title }}</h1>
                                <div class="mt-2 flex items-center justify-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $post->location ?? __('Location not specified') }}
                                </div>

                                <div class="mt-2 flex items-center justify-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ ucfirst($post->work_type ?? __('Work type not specified')) }}
                                </div>

                                @if($post->category)
                                    <div class="mt-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            {{ $post->category }}
                                        </span>
                                    </div>
                                @endif

                                @if($post->salary_range)
                                    <div class="mt-4 flex items-center justify-center text-sm">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium text-gray-900">{{ $post->salary_range }}</span>
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

                                @if($post->application_deadline)
                                    <div class="mt-4 text-sm text-gray-500">
                                        <span class="font-medium">{{ __('Apply by') }}:</span>
                                        {{ \Carbon\Carbon::parse($post->application_deadline)->format('M d, Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Details -->
                    <div class="md:col-span-2 space-y-8">
                        <!-- Job Description -->
                        <div class="prose max-w-none">
                            <div class="flex items-center space-x-2">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-900">{{ __('About this position') }}</h3>
                            </div>
                            <div class="mt-4 text-gray-600 space-y-4 leading-relaxed">
                                {!! nl2br(e($post->description)) !!}
                            </div>
                        </div>

                        <!-- Responsibilities -->
                        @if($post->responsibilities)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Key Responsibilities') }}</h3>
                            <ul class="mt-4 space-y-3">
                                @foreach(explode("\n", $post->responsibilities) as $responsibility)
                                    @if(trim($responsibility))
                                        <li class="flex items-start">
                                            <span class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </span>
                                            <span class="ml-3 text-gray-600">{{ $responsibility }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Qualifications -->
                        @if($post->qualifications)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Qualifications') }}</h3>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach((array)$post->qualifications as $qualification)
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-purple-100 text-purple-800">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        {{ $qualification }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Skills -->
                        @if(!empty($post->skills))
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Required Skills') }}</h3>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($post->skills as $skill)
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Benefits -->
                        @php
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
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Benefits & Perks') }}</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($benefitsParts as $benefit)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="ml-3 text-sm text-gray-600">{{ $benefit }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                      <!-- Additional Information -->
<div class="mt-8 pt-8 border-t border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if($post->application_deadline)
            <div class="flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ __('Application Deadline') }}</p>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($post->application_deadline)->format('M d, Y') }}</p>
                </div>
            </div>
        @endif

        @if($post->created_at)
            <div class="flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ __('Posted On') }}</p>
                    <p class="text-sm text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        @endif

        @if($post->updated_at && $post->updated_at->ne($post->created_at))
            <div class="flex items-center">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ __('Last Updated') }}</p>
                    <p class="text-sm text-gray-500">{{ $post->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Comments Section -->
<div class="mt-10">
    <h3 class="text-2xl font-semibold mb-6 text-gray-900 flex items-center">
        <svg class="h-6 w-6 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 8h10M7 12h6m-6 4h10M21 12c0 4.418-4.477 8-10 8a10.37 10.37 0 01-4.472-.987L3 20l1.658-3.316A7.972 7.972 0 012 12C2 7.582 6.477 4 12 4s10 3.582 10 8z" />
        </svg>
        Comments
    </h3>

    <!-- Add Comment Form -->
    @auth
        <form action="{{ route('comments.store', $job) }}" method="POST" class="mb-6 bg-gray-50 p-4 rounded-lg shadow-sm">
            @csrf
            <textarea name="content" rows="3" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm resize-none"
                placeholder="Write a comment..."></textarea>
            <div class="flex justify-end mt-3">
                <x-primary-button class="px-5 py-2">Add Comment</x-primary-button>
            </div>
        </form>
    @else
        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
            You must <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">log in</a> to comment.
        </p>
    @endauth

    <!-- Comments List -->
  <!-- Comments List -->
{{-- <div class="space-y-6 max-h-80 overflow-auto">
    @foreach ($job->comments()->whereNull('parent_id')->latest()->get() as $comment)
        <div x-data="{ openReply: false }" class="border p-3 rounded-md">
            <div class="flex items-start space-x-3">
                <!-- User Avatar / Initials -->
                <div class="flex-shrink-0">
                    @if($comment->user->profile_photo_url)
                        <img class="h-10 w-10 rounded-full object-cover"
                             src="{{ $comment->user->profile_photo_url }}"
                             alt="{{ $comment->user->name }}">
                    @else
                        <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <!-- Name & Time -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Comment Content -->
                    <div class="text-gray-900 mt-1">{{ $comment->content }}</div>

                    <!-- Reply Button -->
                    @auth
                        <button type="button"
                            @click="openReply = !openReply"
                            class="text-blue-600 text-sm mt-2">Reply</button>

                        <form
                            x-show="openReply"
                            action="{{ route('comments.store', $job) }}"
                            method="POST"
                            class="mt-2"
                        >
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="2" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Write your reply..."></textarea>
                            <x-primary-button class="mt-2">Reply</x-primary-button>
                        </form>
                    @endauth

                   <!-- Replies -->
@if ($comment->replies->count())
    <div class="mt-3 ml-6 space-y-3 border-l pl-4">
        @foreach ($comment->replies as $reply)
            <div class="flex items-start space-x-3 text-sm">
                <!-- Reply User Avatar / Initials -->
                <div class="flex-shrink-0">
                    @if($reply->user->profile_photo_url)
                        <img class="h-8 w-8 rounded-full object-cover"
                             src="{{ $reply->user->profile_photo_url }}"
                             alt="{{ $reply->user->name }}">
                    @else
                        <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-medium text-xs">
                            {{ strtoupper(substr($reply->user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <span class="font-medium text-gray-700">{{ $reply->user->name }}</span>:<br/>
                    <span class="text-gray-900">{{ $reply->content }}</span>
                    <div class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @endforeach
    </div>
@endif

                </div>
            </div>
        </div>
    @endforeach
</div>

</div> --}}

<!-- Comments List -->
<div class="space-y-6 max-h-80 overflow-auto">
    @foreach ($job->comments()->whereNull('parent_id')->latest()->get() as $comment)
        <div x-data="{ openReply: false }" class="border p-3 rounded-md">
            <div class="flex items-start space-x-3">
                <!-- User Avatar -->
                <div class="flex-shrink-0">
                    @if($comment->user->profile_photo_url)
                        <img class="h-10 w-10 rounded-full object-cover"
                             src="{{ $comment->user->profile_photo_url }}"
                             alt="{{ $comment->user->name }}">
                    @else
                        <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-sm font-medium text-gray-700">{{ $comment->user->name }}</span>
                            <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>

                        <!-- Delete button only for comment author or job owner -->
                        @auth
                            @if(Auth::id() === $comment->user_id || Auth::id() === $job->user_id)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ml-3"
                                      onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-xs hover:underline">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <div class="mt-1 text-gray-900">{{ $comment->content }}</div>

                    {{-- Reply button --}}
                    @auth
                        <button type="button"
                                @click="openReply = !openReply"
                                class="text-blue-600 text-sm mt-2">Reply</button>

                        <form x-show="openReply" action="{{ route('comments.store', $job) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="2" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Write your reply..."></textarea>
                            <x-primary-button class="mt-2">Reply</x-primary-button>
                        </form>
                    @endauth

                    {{-- Replies --}}
                    @if ($comment->replies->count())
                        <div class="mt-3 ml-6 space-y-3 border-l pl-4">
                            @foreach ($comment->replies as $reply)
                                <div class="flex items-start space-x-3 text-sm">
                                    <div class="flex-shrink-0">
                                        @if($reply->user->profile_photo_url)
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $reply->user->profile_photo_url }}" alt="{{ $reply->user->name }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-medium text-xs">
                                                {{ strtoupper(substr($reply->user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <span class="font-medium text-gray-700">{{ $reply->user->name }}</span>
                                            @auth
                                                @if(Auth::id() === $reply->user_id || Auth::id() === $job->user_id)
                                                    <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="ml-3"
                                                          onsubmit="return confirm('Are you sure you want to delete this reply?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 text-xs hover:underline">Delete</button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                        <div class="text-gray-900">{{ $reply->content }}</div>
                                        <div class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endforeach
</div>


                    </div>
                </div>
            </div>
            @endif
        </div>
    </main>
</x-app-layout>

