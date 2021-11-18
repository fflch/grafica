<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedido;
use App\Models\Chat;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChatMail;
use Uspdev\Replicado\Pessoa;

class ChatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    public $pedido;
    public $chat;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido, Chat $chat)
    {
        $this->pedido = $pedido;
        $this->chat = $chat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->chat->user_id != $this->pedido->user_id){
            Mail::send(new ChatMail($this->pedido, $this->chat, $this->pedido->user->codpes));
        }
        else{
            if($this->pedido->status == 'Editoração' or $this->pedido->status == 'Editoração + Artes Gráficas'){
                foreach(explode(',', trim(env('EDITORA'))) as $codpes){
                    if(Pessoa::retornarEmailUsp($codpes)){  
                        Mail::send(new ChatMail($this->pedido, $this->chat, $codpes));
                    }
                }
            }
            if($this->pedido->status == 'Artes Gráficas' or $this->pedido->status == 'Editoração + Artes Gráficas'){
                foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
                    if(Pessoa::retornarEmailUsp($codpes)){
                        Mail::send(new ChatMail($this->pedido, $this->chat, $codpes));
                    }
                }
            }
        }
    }
}
