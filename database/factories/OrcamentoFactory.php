<?php

namespace Database\Factories;

use App\Models\Orcamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrcamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Orcamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $descricao = ['Diagramação','Papel','Capa Dura','Tinta'];
        $procedencia = ['editora','grafica'];
        return [
            'preco' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1000),
            'nome' => $descricao[array_rand($descricao)],
            'procedencia' => $procedencia[array_rand($procedencia)],
        ];
    }
}
