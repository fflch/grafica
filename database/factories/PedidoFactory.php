<?php

namespace Database\Factories;

use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PedidoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tipo = Pedido::tipoOptions();
        $user = User::factory(1)->create()->toArray();
        $responsavel_centro_despesa = User::factory(1)->create()->toArray();
        return [
            'user_id' => $user[0]['id'],
            'descricao' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'tipo' => $tipo[array_rand($tipo)],
            'paginas' => $this->faker->randomNumber($nbDigits = 3, $strict = false),
            'centro_de_despesa' => $this->faker->text($maxNbChars = 200), 
            'responsavel_centro_despesa' => $responsavel_centro_despesa[0]['codpes'], 
        ];
    }
}
