<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrcamentoRequest extends FormRequest
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
            'nome' => 'required',
            'preco' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'pedido_id' => 'required|exists:pedidos,id'
        ];
    }

    public function validationData()
    {
        $dado = $this->all();
        $dado['preco'] = str_replace('.', '', $dado['preco']);
        $dado['preco'] = str_replace(',', '.', $dado['preco']);
        return $dado;
    }
}
