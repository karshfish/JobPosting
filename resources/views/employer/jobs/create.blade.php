@extends('employer.layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white dark:bg-slate-800 shadow sm:rounded-lg p-6 space-y-6">
            @csrf

            <header class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Job Post</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Fill the details below to publish a new job.</p>
                </div>
            </header>

            {{-- validation summary --}}
            @if ($errors->any())
                <div class="rounded-md bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 p-3 text-sm text-red-700 dark:text-red-300">
                    <strong class="font-medium">There are some problems with your input.</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Job Title</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 shadow-sm px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="e.g. Senior Backend Developer" required aria-required="true">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Job Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Role summary, responsibilities, expectations..." required
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 shadow-sm px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Responsibilities --}}
            <div>
                <label for="responsibilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Responsibilities</label>
                <textarea id="responsibilities" name="responsibilities" rows="3" placeholder="List key responsibilities, one per line"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 shadow-sm px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('responsibilities') }}</textarea>
                @error('responsibilities') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Category --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>


                <!-- Location Dropdown with Search -->
                <div x-data="dropdownAutocomplete()" class="relative w-full">
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>

                    <!-- Input field -->
                    <input
                        id="location"
                        name="location"
                        type="text"
                        x-model="query"
                        @focus="open = true"
                        @click.outside="open = false"
                        placeholder="Select or type a location..."
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 shadow-sm px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        autocomplete="off"
                    >

                    <!-- Dropdown list -->
                    <ul
                        x-show="open && filteredLocations.length > 0"
                        class="absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-md shadow-lg max-h-48 overflow-auto"
                    >
                        <template x-for="loc in filteredLocations" :key="loc">
                            <li
                                @click="select(loc)"
                                class="px-4 py-2 cursor-pointer hover:bg-indigo-100 dark:hover:bg-slate-700 text-gray-900 dark:text-gray-100"
                                x-text="loc"
                            ></li>
                        </template>
                    </ul>

                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Work type --}}
                <div>
                    <label for="work_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Work Type</label>
                    <select id="work_type" name="work_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="on-site" {{ old('work_type') == 'on-site' ? 'selected' : '' }}>On-site</option>
                        <option value="hybrid" {{ old('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('work_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Application deadline --}}
                <div>
                    <label for="application_deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Application Deadline</label>
                    <input id="application_deadline" name="application_deadline" type="date" value="{{ old('application_deadline') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('application_deadline') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Skills / Qualifications / Technologies (Alpine.js dynamic lists & tags) --}}
            <div x-data="tagInputs(@json(old('skills', [])), @json(old('qualifications', [])), @json(old('technologies', [])))" class="space-y-4">

               <div x-data="dropdownTagsSkills({{ json_encode(old('skills', [])) }})" class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Required Skills</label>

    {{-- Dropdown --}}
    <div class="relative" x-cloak>
        <button type="button"
                @click="open = !open"
                class="w-full flex justify-between items-center rounded-md border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
            <span x-text="selected.length ? selected.join(', ') : 'Select a skill'"></span>
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open" @click.away="open = false"
             x-transition
             class="absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-md shadow-lg max-h-48 overflow-auto">
            <template x-for="skill in allSkills" :key="skill">
                <button type="button"
                        @click="addSkill(skill)"
                        class="w-full text-left px-3 py-2 text-sm hover:bg-indigo-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200">
                    <span x-text="skill"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Selected Tags --}}
    <div class="flex flex-wrap gap-2 mt-2">
        <template x-for="(tag, index) in selected" :key="index">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-sm">
                <span x-text="tag"></span>
                <button type="button" @click="removeSkill(index)" class="text-indigo-500 hover:text-indigo-700">&times;</button>
                <input type="hidden" :name="'skills[]'" :value="tag">
            </span>
        </template>
    </div>
</div>

                {{-- Qualifications Dropdown Tag Selector --}}
<div x-data="dropdownTagsQualifications({{ json_encode(old('qualifications', [])) }})" class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qualifications</label>

    {{-- Dropdown --}}
    <div class="relative">
        <button type="button"
                @click="open = !open"
                class="w-full flex justify-between items-center rounded-md border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
            <span x-text="selected.length ? selected.join(', ') : 'Select qualifications'"></span>
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open" @click.away="open = false"
             class="absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-md shadow-lg max-h-48 overflow-auto">
            <template x-for="qual in allOptions" :key="qual">
                <button type="button"
                        @click="addTag(qual)"
                        class="w-full text-left px-3 py-2 text-sm hover:bg-indigo-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200">
                    <span x-text="qual"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Selected Tags --}}
    <div class="flex flex-wrap gap-2 mt-2">
        <template x-for="(tag, index) in selected" :key="index">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-sm">
                <span x-text="tag"></span>
                <button type="button" @click="removeTag(index)" class="text-green-500 hover:text-green-700">&times;</button>
                <input type="hidden" :name="'qualifications[]'" :value="tag">
            </span>
        </template>
    </div>

    @error('qualifications')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

                {{-- Technologies Dropdown Tag Selector --}}
<div x-data="dropdownTagsTech({{ json_encode(old('technologies', [])) }})" class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Technologies (tags)</label>

    {{-- Dropdown --}}
    <div class="relative">
        <button type="button"
                @click="open = !open"
                class="w-full flex justify-between items-center rounded-md border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
            <span x-text="selected.length ? selected.join(', ') : 'Select technologies'"></span>
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open" @click.away="open = false"
             class="absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-md shadow-lg max-h-48 overflow-auto">
            <template x-for="tech in allOptions" :key="tech">
                <button type="button"
                        @click="addTag(tech)"
                        class="w-full text-left px-3 py-2 text-sm hover:bg-sky-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200">
                    <span x-text="tech"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Selected Tags --}}
    <div class="flex flex-wrap gap-2 mt-2">
        <template x-for="(tag, index) in selected" :key="index">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-sky-50 dark:bg-sky-900 text-sky-700 dark:text-sky-300 rounded-full text-sm">
                <span x-text="tag"></span>
                <button type="button" @click="removeTag(index)" class="text-sky-500 hover:text-sky-700">&times;</button>
                <input type="hidden" :name="'technologies[]'" :value="tag">
            </span>
        </template>
    </div>

    @error('technologies')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

            </div>

            {{-- Salary and Benefits --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="salary_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salary Min</label>
                    <input id="salary_min" name="salary_min" type="number" step="0.01" value="{{ old('salary_min') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 px-3 py-2" placeholder="e.g. 30000">
                    @error('salary_min') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="salary_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salary Max</label>
                    <input id="salary_max" name="salary_max" type="number" step="0.01" value="{{ old('salary_max') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 px-3 py-2" placeholder="e.g. 60000">
                    @error('salary_max') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div x-data="dropdownTagsBenefits(@json(old('benefits', [])))" class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Benefits</label>

    {{-- Dropdown --}}
    <div class="relative" x-cloak>
        <button type="button"
                @click="open = !open"
                class="w-full flex justify-between items-center rounded-md border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
            <span x-text="selected.length ? selected.join(', ') : 'Select benefits'"></span>
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open" @click.away="open = false"
             x-transition
             class="absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-md shadow-lg max-h-48 overflow-auto">
            <template x-for="benefit in allOptions" :key="benefit">
                <button type="button"
                        @click="addTag(benefit)"
                        class="w-full text-left px-3 py-2 text-sm hover:bg-purple-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200">
                    <span x-text="benefit"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Selected Tags --}}
    <div class="flex flex-wrap gap-2 mt-2">
        <template x-for="(tag, index) in selected" :key="index">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                <span x-text="tag"></span>
                <button type="button" @click="removeTag(index)" class="text-purple-500 hover:text-purple-700">&times;</button>
                <input type="hidden" :name="'benefits[]'" :value="tag">
            </span>
        </template>
    </div>

    @error('benefits')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

            </div>

            {{-- Branding Image upload with preview --}}
            <div x-data="imagePreview()" class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Logo / Branding (optional)</label>

                <div class="flex items-center gap-4">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-slate-700 rounded-md border flex items-center justify-center overflow-hidden">
                        <template x-if="preview">
                            <img :src="preview" alt="Preview" class="object-cover w-full h-full">
                        </template>
                        <template x-if="!preview">
                            <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m10 12V8M7 20h10" />
                            </svg>
                        </template>
                    </div>

                    <div class="flex-1">
                        <input id="branding_image" name="branding_image" type="file" accept="image/*" @change="onFileChange($event)" class="block w-full text-sm text-gray-700">
                        <p class="text-xs text-gray-400 mt-1">Recommended: PNG/JPG up to 2MB.</p>
                        <div class="mt-2 flex gap-2">
                            <button type="button" @click="remove()" class="px-3 py-1 bg-red-50 text-red-700 rounded text-sm hidden" x-ref="removeBtn">Remove</button>
                        </div>
                        @error('branding_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm transition">Create Job</button>
            </div>
        </form>
    </div>
</div>

{{-- Alpine.js helper scripts (for tags & image preview) --}}
<script>
    // Tag inputs: skills, qualifications, technologies
    function tagInputs(initialSkills = [], initialQualifications = [], initialTechnologies = []) {
        return {
            skills: Array.isArray(initialSkills) ? initialSkills.filter(Boolean) : [],
            qualifications: Array.isArray(initialQualifications) ? initialQualifications.filter(Boolean) : [],
            technologies: Array.isArray(initialTechnologies) ? initialTechnologies.filter(Boolean) : [],
            skillInput: '',
            qualificationInput: '',
            techInput: '',
            addSkill() {
                const v = this.skillInput && this.skillInput.trim();
                if (v && !this.skills.includes(v)) this.skills.push(v);
                this.skillInput = '';
            },
            removeSkill(i) { this.skills.splice(i, 1); },
            addQualification() {
                const v = this.qualificationInput && this.qualificationInput.trim();
                if (v && !this.qualifications.includes(v)) this.qualifications.push(v);
                this.qualificationInput = '';
            },
            removeQualification(i) { this.qualifications.splice(i, 1); },
            addTech() {
                const v = this.techInput && this.techInput.trim();
                if (v && !this.technologies.includes(v)) this.technologies.push(v);
                this.techInput = '';
            },
            removeTech(i) { this.technologies.splice(i, 1); }
        }
    }

    // Image preview helper
    function imagePreview() {
        return {
            preview: null,
            file: null,
            onFileChange(e) {
                const f = e.target.files[0];
                if (!f) return;
                if (!f.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = (ev) => {
                    this.preview = ev.target.result;
                    this.file = f;
                    if (this.$refs.removeBtn) this.$refs.removeBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(f);
            },
            remove() {
                this.preview = null;
                this.file = null;
                const inp = document.getElementById('branding_image');
                if (inp) inp.value = null;
                if (this.$refs.removeBtn) this.$refs.removeBtn.classList.add('hidden');
            }
        }
    }

    //skills
function dropdownTagsSkills(initial = []) {
    return {
        open: false,
        selected: Array.isArray(initial) ? initial : [],
        allSkills: [
            'Teamwork',
            'Leadership',
            'Problem Solving',
            'Communication',
            'Time Management',
            'Adaptability',
            'Critical Thinking',
            'Creativity',
            'Conflict Resolution',
            'Collaboration',
            'Decision Making',
            'Emotional Intelligence',
            'Organization',
            'Presentation Skills',
            'Negotiation',
            'Motivation',
            'Flexibility',
            'Work Ethic'
        ],
        addSkill(skill) {
            if (!this.selected.includes(skill)) {
                this.selected.push(skill);
            }
            this.open = false; // أغلق القائمة بعد الاختيار
        },
        removeSkill(index) {
            this.selected.splice(index, 1);
        }
    }
}

 //location
function dropdownAutocomplete() {
    return {
        query: '',
        open: false,
        locations: [
            'Cairo, Egypt',
            'Giza, Egypt',
            'Alexandria, Egypt',
            'Dubai, UAE',
            'Riyadh, Saudi Arabia',
            'Jeddah, Saudi Arabia',
            'Amman, Jordan',
            'London, UK',
            'New York, USA',
            'Berlin, Germany',
            'Remote',
            'Hybrid'
        ],
        get filteredLocations() {
            if (this.query === '') return this.locations;
            return this.locations.filter(loc =>
                loc.toLowerCase().includes(this.query.toLowerCase())
            );
        },
        select(item) {
            this.query = item;
            this.open = false;
        }
    };
}
// qualifications
function dropdownTagsQualifications(initial = []) {
    return {
            open: false,
            selected: initial,
            allOptions: ['High School', 'Bachelor', 'Master', '1 year', '3 years', '5 years'],
            addTag(tag) {
                if (!this.selected.includes(tag)) {
                    this.selected.push(tag);
                }
                this.open = false;
            },
            removeTag(index) {
                this.selected.splice(index, 1);
            }
    }
}

//tech
function dropdownTagsTech(initial = []) {
        return {
            open: false,
            selected: initial,
            allOptions: [ 'Laravel', 'PHP', 'MySQL', 'React', 'Vue.js', 'Angular',
            'JavaScript', 'TypeScript', 'HTML', 'CSS', 'Bootstrap',
            'TailwindCSS', 'REST API', 'Git', 'Docker', 'AWS', 'Node.js'],
            addTag(tag) {
                if (!this.selected.includes(tag)) {
                    this.selected.push(tag);
                }
                this.open = false;
            },
            removeTag(index) {
                this.selected.splice(index, 1);
            }
        }
    }
//benfits
function dropdownTagsBenefits(initial = []) {
    return {
        open: false,
        selected: Array.isArray(initial) ? initial : [],
        allOptions: [
            'Health Insurance',
            'Remote Allowance',
            'Paid Time Off',
            'Flexible Hours',
            'Performance Bonus',
            'Retirement Plan',
            'Training & Development',
            'Company Laptop',
            'Team Outings',
            'Gym Membership'
        ],
        addTag(tag) {
            if (!this.selected.includes(tag)) {
                this.selected.push(tag);
            }
            this.open = false;
        },
        removeTag(index) {
            this.selected.splice(index, 1);
        }
    }
}

</script>
@endsection
