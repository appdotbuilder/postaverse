<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($this->user()->id)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id)
            ],
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'birth_date' => 'nullable|date|before:today',
            'privacy' => 'required|in:public,private',
            'avatar' => 'nullable|string|max:255',
            'cover_image' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'username.unique' => 'This username is already taken.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'username.max' => 'Username cannot exceed 50 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'bio.max' => 'Bio cannot exceed 500 characters.',
            'location.max' => 'Location cannot exceed 100 characters.',
            'website.url' => 'Please provide a valid website URL.',
            'birth_date.before' => 'Birth date must be in the past.',
            'privacy.required' => 'Please select a privacy setting.',
            'privacy.in' => 'Invalid privacy setting selected.',
        ];
    }
}