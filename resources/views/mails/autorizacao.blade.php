@inject('pessoa','Uspdev\Replicado\Pessoa')

{!! $pedido->configMail($pedido, $pessoa::dump($pedido->responsavel_centro_despesa)['nompes'], 'autorizacao') !!}
