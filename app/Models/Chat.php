<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedido;
use App\Models\User;
use App\Models\File;
use App\Models\Chat;
use App\Traits\HasStatuses;
use App\Service\GeneralSettings;

class Chat extends Model
{
    protected $guarded = ['id'];

    use HasFactory;
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Função para modificar a mensagem padrão do chat
    public static function configChatMail($pedido, $usuario, $chat){
        $settings = new GeneralSettings;
        $url = "<a href='http://grafica.fflch.usp.br/pedidos/{$pedido->id}'>Link do pedido</a>'";
        $mensagem = $settings->chat;
        //Busca a última configuração
        $mensagem = str_replace(
            ["%usuario","%mensagem", "%remetente", "%url"], 
            [$usuario, $chat->message, $chat->user->name, $url], 
            $mensagem
        );
        return $mensagem;
    }
}
