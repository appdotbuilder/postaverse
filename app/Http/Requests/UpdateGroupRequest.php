<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('group'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $group = $this->route('group');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('groups', 'name')->ignore($group->id)
            ],
            'description' => 'required|string|max:2000',
            'cover_image' => 'nullable|string|max:255',
            'privacy' => 'required|in:public,private,secret',
            'rules' => 'nullable|array|max:10',
            'rules.*' => 'string|max:500',
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
            'name.required' => 'Group name is required.',
            'name.unique' => 'A group with this name already exists.',
            'name.max' => 'Group name cannot exceed 255 characters.',
            'description.required' => 'Group description is required.',
            'description.max' => 'Description cannot exceed 2,000 characters.',
            'privacy.required' => 'Please select a privacy setting.',
            'privacy.in' => 'Invalid privacy setting selected.',
            'rules.max' => 'You can add a maximum of 10 rules.',
            'rules.*.max' => 'Each rule cannot exceed 500 characters.',
        ];
    }
}