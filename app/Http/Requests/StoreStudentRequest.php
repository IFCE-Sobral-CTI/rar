<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'cpf' => 'required|cpf|unique:students,cpf',
            'rg' => 'required|digits_between:4,20|unique:students,rg',
            'name' => 'required|min:3',
            'birth' => 'required|date',
            'personal_email' => 'required|email',
            'institutional_email' => 'nullable|email'
        ];
    }
}
