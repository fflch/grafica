<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedido;
use Uspdev\Replicado\Pessoa;

class EditoraMail extends Mailable
{
    use Queueable, SerializesModels;
    private $pedido;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido, $codpes)
    {   
        $this->pedido = $pedido;
        $this->codpes = $codpes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Novo pedido de {$this->pedido->user->name} para ser diagramado";
        return $this->view('mails.editora')
        ->to(Pessoa::retornarEmailUsp($this->codpes))
        ->subject($subject)
        ->with([
            'pedido' => $this->pedido,
            'codpes' => $this->codpes,
        ]);
    }
}
