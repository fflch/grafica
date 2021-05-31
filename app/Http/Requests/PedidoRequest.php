<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pedido;
use Illuminate\Validation\Rule;

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
            'centro_de_despesa' => 'nullable',
            'autorizador_codpes' => 'integer|nullable', 
        ];
    }
}
