    <div class="card">
        <div class="card-header"><b>Dados do Pedido</b></div>
        <div class="card-body">
            <b>Solicitante:</b> {{$pedido->user->name ?? 'Não informado'}}</br>
            <b>Descrição:</b> {{$pedido->descricao ?? 'Não informado'}}</br>
            <b>Tipo:</b> {{$pedido->tipo ?? 'Não informado'}}</br>
            <b>Número de páginas:</b> {{$pedido->paginas ?? 'Não informado'}}</br>
            <b>Centro de Despesa:</b> {{$pedido->centro_de_despesa ?? 'Não informado'}}</br>
            <b>Autorizador:</b>@if($pedido->autorizador != null) {{$pessoa::dump($pedido->autorizador)['nompes'] }}@endif</br>
            <b>Status:</b> {{$pedido->status}}</br>
        </div>
    </div>