<?php

namespace App\Http\Requests\chatbox;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:1024'],
            'file' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,pdf,mp4'],
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
            'content.required' => 'Le contenu du message est requis.',
            'content.string' => 'Le contenu du message doit être une chaîne de caractères.',
            'content.max' => 'Le contenu du message ne doit pas dépasser 1024 caractères.',

            'file.file' => 'Le fichier doit être un fichier.',
            'file.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            'file.mimes' => 'Le fichier doit être une image, un PDF ou une vidéo.',
        ];
    }
}
