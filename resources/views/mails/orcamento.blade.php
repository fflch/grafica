@inject('pessoa','Uspdev\Replicado\Pessoa')

Prezado(a) {{ $pessoa::dump($codpes)['nompes']}},<br>

Você tem um pedido esperando por orçamento.<br>

Mensagem:<br>

{{$pedido->latestStatus()->reason}}

<h4><b>Sistema - Gráfica - FFLCH</b></h4>