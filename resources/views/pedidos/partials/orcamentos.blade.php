<div class="card">
        <div class="card-header"><b>Itens do Pedido</b></div>
        <div class="card-body form-group">
            @include('pedidos.orcamentos.form')
            <table class="table table-striped" style="text-align: center;">
                <theader>
                    <tr>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </theader>
                <tbody>
                @foreach ($pedido->orcamentos as $orcamento)
                    <tr>
                        <td>{{ $orcamento->nome }}</td>
                        <td>{{ $orcamento->preco }}</td>
                        <td>
                            <form method="POST" class="form-group" action="/orcamentos/{{$orcamento->id}}">
                                @csrf 
                                @method('delete')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
 
 