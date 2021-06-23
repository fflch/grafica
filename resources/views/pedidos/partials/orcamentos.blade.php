<div class="card">
        <div class="card-header"><b>Orçamento do Pedido</b></div>
        <div class="card-body form-group">
            @can('servidor')
                @include('pedidos.orcamentos.form')
            @endcan
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
                        <td>R$ {{  number_format($orcamento->preco, 2, ',', '') }}</td>
                        <td>
                            <form method="POST" class="form-group" action="/orcamentos/{{$orcamento->id}}">
                                @csrf 
                                @method('delete')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan='3'><b>Total:</b> R$ {{ number_format($pedido->orcamentos()->get()->sum("preco"), 2, ',', '') }} </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
 
 