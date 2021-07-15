<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pedido;
use Illuminate\Validation\Rule;
use Uspdev\Replicado\Financeiro;

class PedidoRequest extends FormRequest
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
        $pedido = new Pedido;
        
        return [
            'user_id' => '',
            'descricao' => 'required',
            'tipo' => ['required',Rule::in($pedido->tipoOptions())],
            'paginas' => 'integer|nullable',
            'finalidade' => ['required'],
            'centro_de_despesa' => ['required'],
            'responsavel_centro_despesa' => 'integer|codpes', 
        ];
    }
}
