<x-app-layout>
    <div class="max-w-lg mx-auto py-8">
        <h1 class="text-xl font-semibold mb-4">Edit Profile</h1>

        <form method="POST" action="{{ route('candidate.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <label class="block mb-2">Phone</label>
            <input type="text" name="phone" value="{{ $candidate->phone }}" class="border rounded w-full p-2 mb-4" />

            <label class="block mb-2">Address</label>
            <input type="text" name="address" value="{{ $candidate->address }}" class="border rounded w-full p-2 mb-4" />

            <label class="block mb-2">Resume (PDF)</label>
            <input type="file" name="resume" class="block mb-4" />

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
