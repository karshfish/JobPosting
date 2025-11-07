<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'responsibilities' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'qualifications' => 'nullable|array',
            'qualifications.*' => 'string|max:100',
            'salary_range' => 'nullable|string|max:100',
            'benefits' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'work_type' => 'nullable|in:remote,on-site,hybrid',
            'branding_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'application_deadline' => 'nullable|date',
            'status' => 'nullable|in:draft,published,closed',
        ];
    }
}
