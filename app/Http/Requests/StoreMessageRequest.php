<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'recipient_id' => 'required|exists:users,id|different:' . auth()->id(),
            'content' => 'required|string|max:5000',
            'media' => 'nullable|array|max:5',
            'media.*' => 'string|max:255',
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
            'recipient_id.required' => 'Please select a recipient.',
            'recipient_id.exists' => 'The selected recipient does not exist.',
            'recipient_id.different' => 'You cannot send a message to yourself.',
            'content.required' => 'Message content is required.',
            'content.max' => 'Message cannot exceed 5,000 characters.',
            'media.max' => 'You can attach a maximum of 5 media files.',
        ];
    }
}