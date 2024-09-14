<?php

namespace App\Http\Requests\admin\reductions;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class ReductionRequest extends FormRequest
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
        $reductionId = $this->route('reduction') ? $this->route('reduction')->id : null;

        return [
            'code' => [
                'required',
                'string',
                'unique:reductions,code,' . $reductionId, // Si $reductionId est null, la validation s'applique normalement
                'regex:/^[A-Z0-9]+$/',
                'max:30',
            ],
            'percentage' => 'required|integer',
            'start_date' => 'required|date|before:end_date',  
            'end_date' => 'required|date|after:start_date',
            'online' => 'required|boolean',
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
            'code.required' => 'Le code est obligatoire',
            'code.string' => 'Le code doit être une chaîne de caractères',
            'code.unique' => 'Ce code est déjà utilisé',
            'code.regex' => 'Le code doit être en majuscules et sans espace',
            'code.max' => 'Le code ne doit pas dépasser 30 caractères',

            'percentage.required' => 'Le pourcentage est obligatoire',
            'percentage.integer' => 'Le pourcentage doit être un entier',

            'start_date.required' => 'La date de début est obligatoire',
            'start_date.date' => 'La date de début doit être une date',
            'start_date.before' => 'La date de début doit être avant la date de fin',

            'end_date.required' => 'La date de fin est obligatoire',
            'end_date.date' => 'La date de fin doit être une date',
            'end_date.after' => 'La date de fin doit être après la date de début',

            'online.required' => 'Le statut en ligne est obligatoire',
            'online.boolean' => 'Le statut en ligne doit être un booléen',
        ];
    }
}
