<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimulacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'valor_emprestimo' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'valor_emprestimo.required' => 'Informe o campo valor_emprestimo'
        ];
    }
    
}
