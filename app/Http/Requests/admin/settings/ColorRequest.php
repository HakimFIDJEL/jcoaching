<?php

namespace App\Http\Requests\admin\settings;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class ColorRequest extends FormRequest
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
            'primary_color' => ['nullable', 'string', 'max:255'],
            'secondary_color' => ['nullable', 'string', 'max:255'],
            'background_color' => ['nullable', 'string', 'max:255'],
            'font_color' => ['nullable', 'string', 'max:255'],
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
            'primary_color.string' => 'La couleur principale doit être une chaîne de caractères.',
            'primary_color.max' => 'La couleur principale ne doit pas dépasser 255 caractères.',

            'secondary_color.string' => 'La couleur secondaire doit être une chaîne de caractères.',
            'secondary_color.max' => 'La couleur secondaire ne doit pas dépasser 255 caractères.',

            'background_color.string' => 'La couleur de fond doit être une chaîne de caractères.',
            'background_color.max' => 'La couleur de fond ne doit pas dépasser 255 caractères.',

            'font_color.string' => 'La couleur de la police doit être une chaîne de caractères.',
            'font_color.max' => 'La couleur de la police ne doit pas dépasser 255 caractères.',
        ];
    }
}
