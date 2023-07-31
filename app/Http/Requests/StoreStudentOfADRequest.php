<?php

namespace App\Http\Requests;

use App\Rules\ValidHCaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentOfADRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cpf' => 'required|cpf',
            'rg' => 'required|numeric',
            'birth' => 'required|date',
            'h_captcha_response' => ['required', new ValidHCaptcha]
        ];
    }

    public function attributes()
    {
        return [
            'cpf' => 'CPF',
            'rg' => 'R.G.',
            'birth' => 'data de nascimento',
            'card' => 'cartão',
            'h_captcha_response' => 'captcha',
        ];
    }

    public function messages()
    {
        return [
            'h_captcha_response.required' => 'O desafio deve ser respondido.'
        ];
    }
}
