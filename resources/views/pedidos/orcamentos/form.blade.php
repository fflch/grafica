<form action="/orcamentos" method="POST">
    @csrf
    <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
    <div class="row">
        <div class="col-sm form-group">
            <label for="nome"><b>Descrição do Item:</b></label>
            <input type="text" class="form-control" name="nome" value="{{ old('nome', $pedido->nome) }}">
        </div>
        <div class="col-sm form-group">
            <label for="preco"><b>Preço:</b></label>
            <input type="text" class="form-control" name="preco" value="{{ old('preco', $pedido->preco) }}" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm">
            <button type="submit" class="btn btn-success float-right">Inserir Item</button> 
        </div>
    </div> 
</form>