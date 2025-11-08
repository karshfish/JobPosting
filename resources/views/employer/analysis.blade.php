<x-employer-layout>

 <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Analysis') }}</h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('View and analyze your job listings performance') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('Post New Job') }}
                </a>
            </div>
        </div>
    </x-slot>



</x-employer-layout>
