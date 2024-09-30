<?php

namespace App\Http\Requests\admin\medias;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class MediaRequest extends FormRequest
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
            'label' => ['required', 'string', 'max:191'],
            'file' => ['required', 'file', 'mimes:jpeg,png,jpg,mp4,webm', 'max:2048'],
            'online' => ['required', 'boolean'],
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
            'label.required' => 'Le label est requis',
            'label.string' => 'Le label doit être une chaîne de caractères',
            'label.max' => 'Le label doit contenir au maximum 191 caractères',

            'file.required' => 'Le fichier est requis',
            'file.file' => 'Le fichier doit être un fichier',
            'file.mimes' => 'Le fichier doit être de type jpeg, png, jpg, gif, svg, mp4 ou webm',
            'file.max' => 'Le fichier doit peser au maximum 2048 Ko',

            'online.required' => 'Le statut en ligne est requis',
            'online.boolean' => 'Le statut en ligne doit être un booléen',
        ];
    }
}
