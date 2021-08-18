<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Pedido;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('logado', function ($user) {
            return true;
        });

        Gate::define('admin', function ($user) {
            $admins = explode(',', trim(env('ADMINS')));
            return in_array($user->codpes, $admins);
        });

        Gate::define('autorizador', function ($user) {
            if(Gate::allows('admin')) return true;
            $autorizador = explode(',', trim(env('AUTORIZADOR')));
            return in_array($user->codpes, $autorizador);
        });

        Gate::define('editora', function ($user) {
            if(Gate::allows('admin')) return true;
            $editora = explode(',', trim(env('EDITORA')));
            return in_array($user->codpes, $editora);
        });

        Gate::define('grafica', function ($user) {
            if(Gate::allows('admin')) return true;
            $grafica = explode(',', trim(env('GRAFICA')));
            return in_array($user->codpes, $grafica);
        });

        Gate::define('servidor', function ($user) {
            if(Gate::allows('admin')) return true;
            if(Gate::allows('autorizador')) return true;
            if(Gate::allows('editora')) return true;
            if(Gate::allows('grafica')) return true;
        });

        Gate::define('owner.pedido', function ($user, $pedido) {
            if(Gate::allows('servidor')) return true;
            if($pedido->user_id == $user->id) return true;
            if($pedido->responsavel_centro_despesa == $user->codpes) return true;
            return false;
        });

        Gate::define('responsavel_centro_despesa', function ($user) {
            if(Gate::allows('admin')) return true;
            $pedidos = Pedido::currentStatus("Autorização")->where('responsavel_centro_despesa', $user->codpes)->get();
            if($pedidos->count() != 0){
                return true;
            }
            return false;
        });
    }
}
