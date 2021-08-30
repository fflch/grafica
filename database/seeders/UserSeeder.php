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
        User::create($user);
    }
}
