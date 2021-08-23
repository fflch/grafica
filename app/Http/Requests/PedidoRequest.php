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
            'titulo' => 'required',
            'descricao' => 'required',
            'tipo' => ['required',Rule::in($pedido->tipoOptions())],
            'paginas' => 'required|integer',
            'finalidade' => ['required'],
            'centro_de_despesa' => ['required'],
            'responsavel_centro_despesa' => 'integer|codpes', 
            'contem_imagens' => 'integer|required', 
            'tipo_imagens' => ['nullable','required_if:contem_imagens,1',Rule::in($pedido->tipoImagensOptions())], 
            'quantidade_imagens' => 'nullable|integer|required_if:contem_imagens,1', 
        ];
    }
}
