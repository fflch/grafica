<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pedido;
use Illuminate\Validation\Rule;
use Uspdev\Replicado\Financeiro;
use App\Utils\ReplicadoUtils;

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
        $centros = Financeiro::listarCentrosDespesas();
        foreach($centros as $centro){
            $centros_despesas[] = $centro['etrhie'];
        }
        $docentes = ReplicadoUtils::listarDocentesServidores();
        foreach($docentes as $docente){
            $docentes_servidores[] = $docente['codpes'];
        }
        return [
            'user_id' => '',
            'titulo' => 'required',
            'descricao' => 'required',
            'tipo' => ['required',Rule::in($pedido->tipoOptions())],
            'paginas' => 'required|integer',
            'finalidade' => ['required'],
            'centro_de_despesa' => ['required',Rule::in($centros_despesas)],
            'responsavel_centro_despesa' => ['integer','required',Rule::in($docentes_servidores)], 
            'contem_imagens' => 'integer|required', 
            'tipo_imagens' => ['nullable','required_if:contem_imagens,1',Rule::in($pedido->tipoImagensOptions())], 
            'quantidade_imagens' => 'nullable|integer|required_if:contem_imagens,1', 
        ];
    }
}
