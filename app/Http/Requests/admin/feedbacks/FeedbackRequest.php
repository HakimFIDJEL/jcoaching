<?php

namespace App\Http\Requests\admin\feedbacks;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class FeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'job' => 'required|string|max:191',
            'message' => 'required|string|max:1500',
            'online' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis',
            'name.string' => 'Le nom doit être une chaîne de caractères',
            'name.max' => 'Le nom ne doit pas dépasser 191 caractères',

            'job.required' => 'Le métier est requis',
            'job.string' => 'Le métier doit être une chaîne de caractères',
            'job.max' => 'Le métier ne doit pas dépasser 191 caractères',

            'message.required' => 'Le message est requis',
            'message.string' => 'Le message doit être une chaîne de caractères',
            'message.max' => 'Le message ne doit pas dépasser 1500 caractères',

            'online.string' => 'Le statut en ligne doit être une chaîne de caractères',
        ];
    }
}
