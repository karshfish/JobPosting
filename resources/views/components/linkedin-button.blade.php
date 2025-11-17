@if(auth()->user()->linkedin_id)
    <div class="flex items-center gap-3">
        <img src="{{ auth()->user()->linkedin_data['avatar'] ?? '' }}" alt="avatar" class="w-10 h-10 rounded-full">
        <div>
            <div class="text-sm font-medium">{{ auth()->user()->linkedin_data['name'] ?? auth()->user()->name }}</div>
            <form action="{{ route('linkedin.disconnect') }}" method="POST" class="mt-1">
                @csrf
                <button class="text-xs text-red-600 hover:underline">Disconnect LinkedIn</button>
            </form>
        </div>
    </div>
@else
    <a href="{{ route('linkedin.redirect') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        Connect with LinkedIn
    </a>
@endif
