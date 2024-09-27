<?php

namespace App\Http\Requests\member\payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PlanRequest extends FormRequest
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
            'lastname' => ['required', 'string', 'max:191'],
            'firstname' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'phone' => ['required', 'string', 'max:191'],
            'address' => ['required', 'string', 'max:191'],
            'city' => ['required', 'string', 'max:191'],
            'postal_code' => ['required', 'string', 'max:191'],
            'country' => ['required', 'string', 'max:191'],
            'pricing_id' => ['required', 'integer', 'exists:pricings,id'],
            'nutrition_option' => ['required', 'boolean'],
            'reduction_id' => ['nullable', 'integer', 'exists:reductions,id'],
            'total_price' => ['required', 'numeric'],
            'cgv_terms' => ['required', 'accepted'],
            'rgpd_terms' => ['required', 'accepted'],
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
            'lastname.required' => 'Le champ nom est requis.',
            'lastname.string' => 'Le champ nom doit être une chaîne de caractères.',
            'lastname.max' => 'Le champ nom ne doit pas dépasser :max caractères.',

            'firstname.required' => 'Le champ prénom est requis.',
            'firstname.string' => 'Le champ prénom doit être une chaîne de caractères.',
            'firstname.max' => 'Le champ prénom ne doit pas dépasser :max caractères.',

            'email.required' => 'Le champ email est requis.',
            'email.string' => 'Le champ email doit être une chaîne de caractères.',
            'email.email' => 'Le champ email doit être une adresse email valide.',
            'email.max' => 'Le champ email ne doit pas dépasser :max caractères.',

            'phone.required' => 'Le champ téléphone est requis.',
            'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            'phone.max' => 'Le champ téléphone ne doit pas dépasser :max caractères.',

            'address.required' => 'Le champ adresse est requis.',
            'address.string' => 'Le champ adresse doit être une chaîne de caractères.',
            'address.max' => 'Le champ adresse ne doit pas dépasser :max caractères.',

            'city.required' => 'Le champ ville est requis.',
            'city.string' => 'Le champ ville doit être une chaîne de caractères.',
            'city.max' => 'Le champ ville ne doit pas dépasser :max caractères.',

            'postal_code.required' => 'Le champ code postal est requis.',
            'postal_code.string' => 'Le champ code postal doit être une chaîne de caractères.',
            'postal_code.max' => 'Le champ code postal ne doit pas dépasser :max caractères.',

            'country.required' => 'Le champ pays est requis.',
            'country.string' => 'Le champ pays doit être une chaîne de caractères.',
            'country.max' => 'Le champ pays ne doit pas dépasser :max caractères.',

            'pricing_id.required' => 'Le tarif est requis.',
            'pricing_id.integer' => 'Le tarif doit être un entier.',
            'pricing_id.exists' => 'Le tarif sélectionné est invalide.',

            'nutrition_option.required' => 'Le champ nutrition est requis.',
            'nutrition_option.boolean' => 'Le champ nutrition doit être un booléen.',

            'reduction_id.integer' => 'Le champ réduction doit être un entier.',
            'reduction_id.exists' => 'La réduction sélectionnée est invalide.',

            'total_price.required' => 'Le champ prix total est requis.',
            'total_price.numeric' => 'Le champ prix total doit être un nombre.',

            'cgv_terms.required' => 'Vous devez accepter les conditions générales de vente.',
            'cgv_terms.accepted' => 'Vous devez accepter les conditions générales de vente.',

            'rgpd_terms.required' => 'Vous devez accepter la politique de confidentialité.',
            'rgpd_terms.accepted' => 'Vous devez accepter la politique de confidentialité.',
        ];
    }
}
