@inject('pessoa','Uspdev\Replicado\Pessoa')

{!! $chat->configChatMail($pedido, $pessoa::dump($codpes)['nompes'], $chat) !!}
