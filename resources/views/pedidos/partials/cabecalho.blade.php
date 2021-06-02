<div class="row">
    <div class="col-sm">
        <div class="row float-left">
            <div class="col-auto">
                <a href="/pedidos/create" class="btn btn-primary">Novo Pedido</a>
            </div>
            @if(($pedido->status == 'Em Elaboração' and $pedido->files()->count() != 0) or $pedido->status == null)
                <div class="col-auto">
                    <form method="POST" action="/pedidos/enviar_analise/{{ $pedido->id }}">
                        @csrf 
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja enviar para análise?')"> Enviar para Análise </button>
                    </form>
                </div>
            @elseif($pedido->status == 'Em Análise')
            <div class="col-auto">
                <form method="POST" action="/pedidos/enviar_orcamento/{{ $pedido->id }}">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja enviar para orçamento?')"> Enviar para Orçamento </button>
                </form>
            </div>
            <div class="col-auto">
                <form method="POST" action="/pedidos/devolver/{{ $pedido->id }}">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja devolver para solicitante?')"> Devolver Pedido </button>
                </form>
            </div>
            @elseif($pedido->status == 'Orçamento')
                <div class="col-auto">
                    <form method="POST" action="/pedidos/autorizacao/{{ $pedido->id }}">
                        @csrf 
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja enviar para autorização?')"> Enviar para Autorização </button>
                    </form>
                </div>
            @elseif($pedido->status == 'Autorização')
            <div class="col-auto">
                <form method="POST" action="/pedidos/enviar_autorizacao/{{ $pedido->id }}/autorizado">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja aprovar pedido para as próximas etapas?')"> Autorizar Pedido </button>
                </form>
            </div>
            <div class="col-auto">
                <form method="POST" action="/pedidos/enviar_autorizacao/{{ $pedido->id }}/negado">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja rejeitar pedido?')"> Rejeitar Pedido </button>
                </form>
            </div>
            @elseif($pedido->status == 'Diagramação' and $pedido->tipo == 'Diagramação + Impressão')
            <div class="col-auto">
                <form method="POST" action="/pedidos/impressao/{{ $pedido->id }}">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja enviar para impressao?')"> Enviar para Impressão </button>
                </form>
            </div>
            @elseif($pedido->status == 'Impressão')
            <div class="col-auto">
                <form method="POST" action="/pedidos/acabamento/{{ $pedido->id }}">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja enviar para acabamento?')"> Enviar para Acabamento </button>
                </form>
            </div>
            @elseif($pedido->status == 'Acabamento' or ($pedido->tipo == 'Diagramação' and $pedido->status == 'Diagramação'))
            <div class="col-auto">
                <form method="POST" action="/pedidos/finalizar/{{ $pedido->id }}">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja finalizar o pedido?')"> Finalizar Pedido </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    <div class="col-sm ">
        <div class="row float-right">
            <div class="col-auto">
                <a href="/pedidos/{{$pedido->id}}/edit" class="btn btn-warning">Editar Pedido</a>
            </div>
            <div class="col-auto">
                <form method="POST" action="/pedidos/{{ $pedido->id }}">
                    @csrf 
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')">Apagar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>