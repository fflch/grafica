<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
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
            'tipo' => 'Diagramação + Impressão',
            'paginas' => 200,
            'centro_de_despesa' => 'Centro de Despesa da FFLCH', 
            'responsavel_centro_despesa' => 65389,
            'formato' => '14x21cm',
            'tiragem' => 200,
            'tipo_material' => 'Livro',
            'finalidade' => 'Finalidade de Teste',
            'contem_imagens' => 0,                     
        ];
        $pedido1 = Pedido::create($pedido1);
        $pedido1->setStatus('Em Elaboração');

        Pedido::factory(5)->create()->each(function ($pedido) {           
            $orcamentos = Orcamento::factory(4)->make();
            $pedido->setStatus('Em Elaboração');
            $pedido->orcamentos()->saveMany($orcamentos);
        });
        //Depois de rodar o seeder, desloga o primeiro usuário criado para que seja possível funcionar o setStatus da biblioteca de Status
        Auth::logout();
    }
}
