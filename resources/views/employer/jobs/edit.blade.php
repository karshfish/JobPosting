<![CDATA

<x-employer-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Job Post') }}</h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Update your job posting details') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('jobs.show', $job) }}" class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">{{ __('Cancel') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('jobs.update', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="title" :value="__('Job Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $job->title)" placeholder="e.g. Senior Backend Developer" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Job Description')" />
                            <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2" placeholder="Describe the role, responsibilities and requirements">{{ old('description', $job->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="category" :value="__('Category')" />
                                <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" :value="old('category', $job->category)" placeholder="e.g. Engineering, Design, Marketing" />
                                <x-input-error class="mt-2" :messages="$errors->get('category')" />
                            </div>

                            <div>
                                <x-input-label for="responsibilities" :value="__('Responsibilities')" />
                                <textarea id="responsibilities" name="responsibilities" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2" placeholder="List key responsibilities, one per line">{{ old('responsibilities', $job->responsibilities) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('responsibilities')" />
                            </div>

                            <div>
                                <x-input-label for="benefits" :value="__('Benefits')" />
                                <textarea id="benefits" name="benefits" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2" placeholder="e.g. Health insurance, Remote allowance">{{ old('benefits', $job->benefits) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('benefits')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $job->location)" placeholder="City, Country or 'Remote'" />
                                <x-input-error class="mt-2" :messages="$errors->get('location')" />
                            </div>

                            <div>
                                <x-input-label for="work_type" :value="__('Work Type')" />
                                <select id="work_type" name="work_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach(['remote', 'on-site', 'hybrid'] as $type)
                                        <option value="{{ $type }}" {{ old('work_type', $job->work_type) === $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('work_type')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="salary_range" :value="__('Salary Range')" />
                                <x-text-input id="salary_range" name="salary_range" type="text" class="mt-1 block w-full" :value="old('salary_range', $job->salary_range)" placeholder="e.g. $50,000 - $70,000" />
                                <x-input-error class="mt-2" :messages="$errors->get('salary_range')" />
                            </div>

                            <x-text-input id="application_deadline" name="application_deadline" type="date"
                            class="mt-1 block w-full"
                            :value="old('application_deadline', \Carbon\Carbon::parse($job->application_deadline)->format('Y-m-d'))"
                            :min="date('Y-m-d')" />

                        </div>

                        <div x-data="{ skills: {{ json_encode(old('skills', $job->skills ?? [])) }} }">
                            <x-input-label :value="__('Required Skills')" />
                            <div class="mt-2 space-y-2">
                                <template x-for="(skill, index) in skills" :key="index">
                                    <div class="flex items-center gap-2">
                                        <x-text-input type="text" x-model="skills[index]" :name="'skills[]'" class="w-full" placeholder="e.g. PHP, Laravel, MySQL" />
                                        <button type="button" @click="skills.splice(index, 1)" class="p-2 text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="skills.push('')" class="mt-2 inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    Add Skill
                                </button>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                            <x-input-error class="mt-2" :messages="$errors->get('skills.*')" />
                        </div>


                        <div x-data="{ qualifications: {{ json_encode(old('qualifications', $job->qualifications ?? [])) }} }">
                            <x-input-label :value="__('Required qualifications')" />
                            <div class="mt-2 space-y-2">
                                <template x-for="(qualification, index) in qualifications" :key="index">
                                    <div class="flex items-center gap-2">
                                        <x-text-input type="text" x-model="qualifications[index]" :name="'qualifications[]'" class="w-full" placeholder="e.g. PHP, Laravel, MySQL" />
                                        <button type="button" @click="qualifications.splice(index, 1)" class="p-2 text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="qualifications.push('')" class="mt-2 inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    Add qualification
                                </button>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                            <x-input-error class="mt-2" :messages="$errors->get('skills.*')" />
                        </div>

                        <div>
                            <x-input-label for="branding_image" :value="__('Company Logo/Branding')" />
                            <div class="mt-2 flex items-center gap-4">
                                <div x-data="{ imageUrl: '{{ $job->branding_image ? asset('storage/' . $job->branding_image) : '' }}' }" class="relative">
                                    <label class="block">
                                        <span class="sr-only">Choose company logo</span>
                                        <input type="file" name="branding_image" id="branding_image" accept="image/*"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                                    </label>
                                    <div x-show="imageUrl" class="mt-2">
                                        <img :src="imageUrl" class="h-24 w-24 object-cover rounded border" />
                                    </div>
                                </div>
                                @if($job->branding_image)
                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="remove_image" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Remove current image') }}</span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('branding_image')" />
                        </div>

                        <div class="flex justify-end gap-4">
                            <x-secondary-button type="submit" name="action" value="draft">{{ __('Save as Draft') }}</x-secondary-button>
                            <x-primary-button type="submit">{{ __('Update Job Post') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>]]>
