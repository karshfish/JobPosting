<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">My Applications</h1>

        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Job</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Applied</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr class="border-b">
                    <td class="py-2">{{ $app->job->title }}</td>
                    <td class="py-2">{{ ucfirst($app->status) }}</td>
                    <td class="py-2">{{ $app->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-4 text-center">No applications yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <a href="/jobs" class="inline-block mt-6 text-blue-600 underline">Browse Jobs</a>
    </div>
</x-app-layout>
