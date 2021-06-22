@inject('pessoa','Uspdev\Replicado\Pessoa')

Prezado(a) {{ $pessoa::dump($pedido->responsavel_centro_despesa)['nompes']}},<br>

Você tem um novo pedido no sistema para ser autorizado pelo responsável do Centro de Despesa.<br>

Mensagem:<br>

{{$pedido->latestStatus()->reason}}

<h4><b>Sistema - Gráfica - FFLCH</b></h4>