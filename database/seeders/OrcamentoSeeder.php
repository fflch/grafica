<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orcamento;

class OrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orcamento1 = [
            'preco' => 500.00,
            'nome' => 'Diagramação',
            'pedido_id' => 1,
        ];
        $orcamento2 = [
            'preco' => 200.00,
            'nome' => 'Papel',
            'pedido_id' => 1,
        ];
        $orcamento3 = [
            'preco' => 300.00,
            'nome' => 'Capa Dura',
            'pedido_id' => 1,
        ];
        $orcamento4 = [
            'preco' => 150.00,
            'nome' => 'Tinta',
            'pedido_id' => 1,
        ];

        Orcamento::create($orcamento1);
        Orcamento::create($orcamento2);
        Orcamento::create($orcamento3);
        Orcamento::create($orcamento4);
    }
}
