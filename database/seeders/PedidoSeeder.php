<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Orcamento;
use Auth;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pedido1 = [
            'user_id' => 1,
            'titulo' => 'A educação universitária',
            'descricao' => 'Livro',
            'tipo' => 'Editoração + Artes Gráficas',
            'paginas' => 200,
            'centro_de_despesa' => 'Centro de Despesa da FFLCH', 
            'responsavel_centro_despesa' => 65389,
            'formato' => '14x21cm',
            'tiragem' => 200,
            'tipo_material' => 'Livro',
            'finalidade' => 'Finalidade de Teste',
            'contem_imagens' => 0,                     
        ];
        Pedido::create($pedido1);

        Pedido::factory(5)->create()->each(function ($pedido) {           
            $orcamentos = Orcamento::factory(4)->make();
            $pedido->orcamentos()->saveMany($orcamentos);
        });

        //Para setar status dos dados fakes
        $pedidos = Pedido::all();
        foreach($pedidos as $pedido){
            $user = User::where('id', $pedido->user_id)->first();
            Auth::login($user);
            $pedido->setStatus('Em Elaboração');
            Auth::logout();
        }
    }
}
