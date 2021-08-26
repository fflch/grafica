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
        $contem_imagens = [0,1];
        $tipo = Pedido::tipoPedidoOptions();
        $tipo_material = Pedido::tipoMaterialOptions();
        $user = User::factory(1)->create()->toArray();
        $responsavel_centro_despesa = $this->faker->unique()->servidor();
        return [
            'user_id' => $user[0]['id'],
            'titulo' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'descricao' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'tipo' => $tipo[array_rand($tipo)],
            'paginas' => $this->faker->randomNumber($nbDigits = 3, $strict = false),
            'centro_de_despesa' => $this->faker->text($maxNbChars = 200), 
            'responsavel_centro_despesa' => $responsavel_centro_despesa,
            'formato' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'tiragem' => $this->faker->randomNumber($nbDigits = 3, $strict = false),
            'tipo_material' => $tipo_material[array_rand($tipo_material)],
            'finalidade' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'contem_imagens' => $contem_imagens[array_rand($contem_imagens)], 
        ];
    }
}
