<div class="row">
    <div class="col-sm">
        <a href="/pedidos/create" class="btn btn-primary">Novo Pedido</a>
    </div>
    @can('owner.pedido', $pedido)
        @if($pedido->status == 'Em Elaboração')
        <div class="col-sm">
            <form method="POST" action="/pedidos/{{ $pedido->id }}">
                @csrf 
                @method('delete')
                <button type="submit" class="btn btn-danger ml-1 float-right" onclick="return confirm('Você tem certeza que deseja apagar?')">Apagar</button>
            </form>
            <a href="/pedidos/{{$pedido->id}}/edit" class="btn btn-warning mr-1 float-right">Editar Pedido</a>
        </div>
        @endif
    @endcan
</div>