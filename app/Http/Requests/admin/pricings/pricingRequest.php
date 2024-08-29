<?php

namespace App\Http\Requests\admin\pricings;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class pricingRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'price' => 'required|numeric',
            'nbr_sessions' => 'required|numeric',
            'online' => 'required|boolean',
            'features' => 'required|array|min:1', 
            'features.*' => 'required|string|max:255',
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
            'title.required' => 'Le titre est requis',
            'title.string' => 'Le titre doit être une chaîne de caractères',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères',

            'subtitle.required' => 'Le sous-titre est requis',
            'subtitle.string' => 'Le sous-titre doit être une chaîne de caractères',
            'subtitle.max' => 'Le sous-titre ne doit pas dépasser 255 caractères',

            'description.required' => 'La description est requise',
            'description.string' => 'La description doit être une chaîne de caractères',
            'description.max' => 'La description ne doit pas dépasser 2000 caractères',

            'price.required' => 'Le prix est requis',
            'price.numeric' => 'Le prix doit être un nombre',
            
            'nbr_sessions.required' => 'Le nombre de sessions est requis',
            'nbr_sessions.numeric' => 'Le nombre de sessions doit être un nombre',

            'online.required' => 'La disponibilité en ligne est requise',
            'online.boolean' => 'La disponibilité en ligne doit être un booléen',

            'features.required' => 'Vous devez ajouter au moins une spécificité',
            'features.array' => 'Les spécificités doivent être envoyées sous forme de tableau',
            'features.*.required' => 'Chaque spécificité est requise',
            'features.*.string' => 'Chaque spécificité doit être une chaîne de caractères',
            'features.*.max' => 'Chaque spécificité ne doit pas dépasser 255 caractères',
        ];
    }
}
