@extends('employer.layouts.app')

@section('content')


    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 bg-white dark:bg-slate-900 dark:border-slate-700 text-slate-900 dark:text-slate-100">

                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
<div>
    <x-input-label for="title" :value="__('Job Title')" class="dark:text-gray-200" />
    <x-text-input
        id="title"
        name="title"
        type="text"
        class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
        :value="old('title')"
        placeholder="e.g. Senior Backend Developer"
    />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>

<div>
    <x-input-label for="description" :value="__('Job Description')" class="dark:text-gray-200" />
    <textarea
        id="description"
        name="description"
        rows="5"
        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 dark:bg-gray-700 dark:text-gray-100"
        placeholder="Describe the role, responsibilities and requirements"
    >{{ old('description') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>

<div class="grid grid-cols-1 gap-4">
    <div>
        <x-input-label for="category" :value="__('Category')" class="dark:text-gray-200" />
        <x-text-input
            id="category"
            name="category"
            type="text"
            class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
            :value="old('category')"
            placeholder="e.g. Engineering, Design, Marketing"
        />
        <x-input-error class="mt-2" :messages="$errors->get('category')" />
    </div>

    <div>
        <x-input-label for="responsibilities" :value="__('Responsibilities')" class="dark:text-gray-200" />
        <textarea
            id="responsibilities"
            name="responsibilities"
            rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 dark:bg-gray-700 dark:text-gray-100"
            placeholder="List key responsibilities, one per line"
        >{{ old('responsibilities') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('responsibilities')" />
    </div>
</div>


                            <div>
    <x-input-label for="benefits" :value="__('Benefits')" class="dark:text-gray-200" />
    <textarea
        id="benefits"
        name="benefits"
        rows="3"
        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 dark:bg-gray-700 dark:text-gray-100"
        placeholder="e.g. Health insurance, Remote allowance"
    >{{ old('benefits') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('benefits')" />
</div>

<div>
    <x-input-label for="location" :value="__('Location')" class="dark:text-gray-200" />
    <x-text-input
        id="location"
        name="location"
        type="text"
        class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
        :value="old('location')"
        placeholder="City, Country or 'Remote'"
    />
    <x-input-error class="mt-2" :messages="$errors->get('location')" />
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="status" :value="__('Status')" class="dark:text-gray-200" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
            <option value="" disabled {{ is_null(old('status')) || old('status') == '' ? 'selected' : '' }}>Select status</option>
            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')" />
    </div>

    <div>
        <x-input-label for="work_type" :value="__('Work Type')" class="dark:text-gray-200" />
        <select id="work_type" name="work_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-100">
            <option value="" disabled {{ is_null(old('work_type')) || old('work_type') == '' ? 'selected' : '' }}>Select work type</option>
            <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
            <option value="on-site" {{ old('work_type') == 'on-site' ? 'selected' : '' }}>On Site</option>
            <option value="hybrid" {{ old('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('work_type')" />
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="salary_range" :value="__('Salary Range')" class="dark:text-gray-200" />
        <x-text-input
            id="salary_range"
            name="salary_range"
            type="text"
            class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
            :value="old('salary_range')"
            placeholder="e.g. 40,000 - 60,000 or Negotiable"
        />
        <x-input-error class="mt-2" :messages="$errors->get('salary_range')" />
    </div>

    <div>
        <x-input-label for="application_deadline" :value="__('Application Deadline')" class="dark:text-gray-200" />
        <x-text-input
            id="application_deadline"
            name="application_deadline"
            type="date"
            class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
            :value="old('application_deadline')"
            placeholder="YYYY-MM-DD"
        />
        <x-input-error class="mt-2" :messages="$errors->get('application_deadline')" />
    </div>
</div>


                        <div x-data="arrayInputs(@json(old('skills', [])))"
     x-init="if(!items || items.length === 0) items.push('')"
     class="space-y-3">

    <x-input-label for="skills" :value="__('Skills')" class="dark:text-gray-200" />

    <template x-for="(item, index) in items" :key="index">
        <div class="relative">
            <input :id="`skill-${index}`"
                   type="text"
                   name="skills[]"
                   x-model="items[index]"
                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 pr-8 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500"
                   placeholder="{{ __('e.g. JavaScript') }}" />

            <button type="button"
                    @click="remove(index)"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400 text-lg leading-none">
                ×
            </button>
        </div>
    </template>

    <div>
        <button type="button"
                @click="add()"
                class="mt-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
            {{ __('Add Skill') }}
        </button>
    </div>

    <x-input-error class="mt-2" :messages="$errors->get('skills')" />
</div>

<div x-data="arrayInputs(@json(old('qualifications', [])))"
     x-init="if(!items || items.length === 0) items.push('')"
     class="space-y-3 mt-6">

    <x-input-label for="qualifications" :value="__('Qualifications')" class="dark:text-gray-200" />

    <template x-for="(item, index) in items" :key="index">
        <div class="relative">
            <input :id="`qualification-${index}`"
                   type="text"
                   name="qualifications[]"
                   x-model="items[index]"
                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 pr-8 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500"
                   placeholder="{{ __('e.g. Bachelor Degree') }}" />

            <button type="button"
                    @click="remove(index)"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400 text-lg leading-none">
                ×
            </button>
        </div>
    </template>

    <div>
        <button type="button"
                @click="add()"
                class="mt-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition">
            {{ __('Add Qualification') }}
        </button>
    </div>

    <x-input-error class="mt-2" :messages="$errors->get('qualifications')" />
</div>

<div x-data="singleImageUpload()" class="space-y-2 mt-4">
    <x-input-label for="branding_image" :value="__('Branding Image')" class="dark:text-gray-200" />

    <div class="mt-2 flex items-center gap-4">
        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-md border dark:border-gray-600 flex items-center justify-center overflow-hidden">
            <template x-if="preview">
                <img :src="preview" alt="Preview" class="object-cover w-full h-full">
            </template>
            <template x-if="!preview">
                <div class="text-center text-gray-400 dark:text-gray-300">
                    <svg class="mx-auto h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v12" />
                    </svg>
                </div>
            </template>
        </div>

        <div class="flex-1">
            <input id="branding_image" name="branding_image" type="file" accept="image/*" @change="onFileChange($event)" class="block w-full text-sm text-gray-700 dark:text-gray-200" />
            <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">{{ __('Recommended: JPG or PNG — up to 2MB') }}</p>
        </div>
    </div>

    <x-input-error class="mt-2" :messages="$errors->get('branding_image')" />
</div>

<div class="flex items-center justify-end mt-4">
    <a href="{{ route('jobs.index') }}" class="mr-3 inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-100 rounded hover:bg-gray-400 dark:hover:bg-gray-500">
        {{ __('Cancel') }}
    </a>
    <x-primary-button>{{ __('Create') }}</x-primary-button>
</div>

    </div>
@endsection

<script>
    function arrayInputs(initial) {
        return {
            items: Array.isArray(initial) ? initial : (initial ? [initial] : []),
            add() { this.items.push(''); },
            remove(i) { this.items.splice(i, 1); }
        }
    }
</script>

<script>
    function singleImageUpload() {
        return {
            file: null,
            preview: null,
            onFileChange(e) {
                const f = e.target.files[0];
                if (!f) return;
                if (!f.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = (ev) => {
                    this.file = f;
                    this.preview = ev.target.result;
                };
                reader.readAsDataURL(f);
            },
            remove() {
                this.file = null;
                this.preview = null;
                // clear the file input element value
                const inp = document.getElementById('branding_image');
                if (inp) inp.value = null;
            }
        }
    }
</script>
