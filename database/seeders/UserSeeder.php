<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Uspdev\Replicado\Pessoa;
use Auth;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'codpes' => 3105829,
            'name' => Pessoa::dump(3105829)['nompes'],
            'email' => Pessoa::emailusp(3105829),
        ];
        $usuario = User::create($user);
        //Depois de rodar o seeder, loga o primeiro usuário criado para que seja possível funcionar o setStatus da biblioteca de Status
        Auth::login($usuario, true);
    }
}
