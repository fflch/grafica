<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
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
            'em_analise' => 'required',
            'orcamento' => 'required',
            'autorizacao' => 'required',
            'autorizado' => 'required',
            'diagramacao' => 'required',
            'impressao' => 'required',
            'finalizado' => 'required',
            'devolucao' => 'required',            
            'chat' => 'required',            
        ];
    }
}
