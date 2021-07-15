<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedido;
use App\Models\Chat;
use Uspdev\Replicado\Pessoa;

class ChatMail extends Mailable
{
    use Queueable, SerializesModels;
    private $pedido;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido, Chat $chat, $codpes)
    {   
        $this->pedido = $pedido;
        $this->chat = $chat;
        $this->codpes = $codpes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Nova Mensagem de {$this->chat->user->name}";
        return $this->view('mails.chat')
        ->to(Pessoa::emailusp($this->codpes))
        ->subject($subject)
        ->with([
            'pedido' => $this->pedido,
            'chat' => $this->chat,
            'codpes' => $this->codpes,
        ]);
    }
}
