<?php

namespace App\Http\Requests\admin\members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DocumentsRequest extends FormRequest
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
            'documents' => ['nullable', 'array'],
            'documents.*' => ['required', 'file', 'mimes:pdf', 'max:2048'],
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
            'documents.array' => 'Les documents doivent être un tableau',
            
            'documents.*.required' => 'Le document est requis',
            'documents.*.file' => 'Le document doit être un fichier',
            'documents.*.mimes' => 'Le document doit être de type pdf',
            'documents.*.max' => 'Le document doit peser au maximum 2048 Ko',
        ];
    }
}
