Prezado(a) {{ $pedido->user->name}},<br>

Seu pedido foi devolvido para status "Em Elaboração".<br>

Mensagem:<br>

{{$pedido->latestStatus()->reason}}

<h4><b>Sistema - Gráfica - FFLCH</b></h4>