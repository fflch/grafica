    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-header"><b>Dados do Pedido</b></div>
        <div class="card-body">
            <b>N° do Pedido:</b> {{$pedido->id ?? 'Não informado'}}</br>
            <b>Solicitante:</b> {{$pedido->user->name ?? 'Não informado'}}</br>
            <b>E-mail:</b> {{$pessoa->retornarEmailUsp($pedido->user->codpes) ?? 'Não informado'}}</br>
            <b>Vínculo:</b> {{$pessoa->cracha($pedido->user->codpes)['nomorg'] ?? 'Não informado'}}</br>
            <b>Tipo de Pedido:</b> {{$pedido->tipo ?? 'Não informado'}}</br>
            <b>Tipo do Material:</b> {{$pedido->tipo_material ?? 'Não informado'}}</br>
            <b>Título:</b> {{$pedido->titulo ?? 'Não informado'}}</br>
            <b>Descrição:</b> {{$pedido->descricao ?? 'Não informado'}}</br>
            <b>Finalidade:</b> {{$pedido->finalidade ?? 'Não informado'}}</br>
            <b>Número de páginas:</b> {{$pedido->paginas ?? 'Não informado'}}</br>
            <b>Formato:</b> {{$pedido->formato ?? 'Não informado'}}</br>
            <b>Tiragem:</b> {{$pedido->tiragem ?? 'Não informado'}}</br>
            <b>Contém Imagens?</b> @if($pedido->contem_imagens == 1) Sim @else Não @endif
            @if($pedido->contem_imagens == 1)
                |
                <b>Tipo das Imagens:</b> {{$pedido->tipo_imagens ?? 'Não informado'}} |
                <b>Quantidade de Imagens:</b> {{$pedido->quantidade_imagens ?? 'Não informado'}}
            @endif
            </br>
            <b>Centro de Despesa:</b> {{$pedido->centro_de_despesa ?? 'Não informado'}} |
            <b>Responsável Centro de Despesa:</b>@if($pedido->responsavel_centro_despesa != null) {{$pessoa::dump($pedido->responsavel_centro_despesa)['nompes'] }}@endif</br>
        </div>
    </div>