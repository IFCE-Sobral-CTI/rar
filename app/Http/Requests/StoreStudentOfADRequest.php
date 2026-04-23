<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentOfADRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cpf' => 'required|cpf',
            'rg' => 'required|numeric',
            'birth' => 'required|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'cpf' => 'CPF',
            'rg' => 'R.G.',
            'birth' => 'data de nascimento',
        ];
    }
}
