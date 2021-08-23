<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Orcamento;
use App\Models\File;
use App\Models\Chat;
use App\Traits\HasStatuses;
use App\Service\GeneralSettings;
use Illuminate\Support\Facades\URL;

class Pedido extends Model
{
    protected $guarded = ['id'];

    use HasFactory;
    use HasStatuses;

    const status = [
        'Em Elaboração',
        'Em Análise',
        'Orçamento',
        'Autorização',
        'Editora',
        'Gráfica',
        'Finalizado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public static function tipoOptions(){
        return [
            'Diagramação',
            'Impressão',
            'Diagramação + Impressão',
            'ISBN+DOI+Ficha Catalográfica',
            'Blocagem',
            'Refile',
        ];
    }

    public static function tipoImagensOptions(){
        return [
            'Preto e Branco',
            'Colorida',
        ];
    }

    public function setUserIdAttribute($value)
    {
        if(auth()->check()) {
            if($this->user_id != null){
                $this->attributes['user_id'] = $this->user->id;
            }
            else if(auth()->user()){
                    $this->attributes['user_id'] = auth()->user()->id;
            }
        } else {
            # para rodar o seeder
            $this->attributes['user_id'] = $value;
        }
        
    }

    //Função para modificar a mensagem padrão dos emails
    public static function configMail($pedido, $usuario, $tipo){
        $settings = new GeneralSettings;
        $url = "<a href='http://grafica.fflch.usp.br/pedidos/{$pedido->id}'>Link do pedido</a>'";
        $temporaryUrl = URL::temporarySignedRoute('acesso_autorizado', now()->addMinutes(2880), [
            'file_id'   => $pedido->files()->first()->id,
            'pedido_id' => $pedido->id
        ]);
        $url2 = "<a href={$temporaryUrl}>Link do arquivo</a>'";
        if($tipo == 'em_analise'){
            $mensagem = $settings->em_analise;
        }
        elseif($tipo == 'orcamento'){
            $mensagem = $settings->orcamento;
        }
        elseif($tipo == 'autorizacao'){
            $mensagem = $settings->autorizacao;
        }
        elseif($tipo == 'diagramacao'){
            $mensagem = $settings->diagramacao;
        }
        elseif($tipo == 'impressao'){
            $mensagem = $settings->impressao;
        }
        elseif($tipo == 'autorizado'){
            $mensagem = $settings->autorizado;
        }
        elseif($tipo == 'finalizado'){
            $mensagem = $settings->finalizado;
        }
        else{
            $mensagem = $settings->devolucao;
        }

        //Busca a última configuração
        $mensagem = str_replace(
            ["%usuario","%mensagem", "%url", "%link_arquivo"], 
            [$usuario, $pedido->latestStatus()->reason, $url, $url2], 
            $mensagem
        );
        return $mensagem;
    }

}
