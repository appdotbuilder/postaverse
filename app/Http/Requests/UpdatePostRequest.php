<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('post'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:10000',
            'media' => 'nullable|array|max:10',
            'media.*' => 'string|max:255',
            'privacy' => 'required|in:public,friends,private',
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
            'content.required' => 'Post content is required.',
            'content.max' => 'Post content cannot exceed 10,000 characters.',
            'privacy.required' => 'Please select a privacy setting.',
            'privacy.in' => 'Invalid privacy setting selected.',
            'media.max' => 'You can upload a maximum of 10 media files.',
        ];
    }
}