<div class="card" style="margin-bottom: 0.5em;">
        <div class="card-header"><b>Orçamento do Pedido</b></div>
        <div class="card-body">
            @can('servidor')
                @if($pedido->status == 'Orçamento')
                    @include('pedidos.orcamentos.form')
                @endif
            @endcan
            <table class="table table-striped" style="text-align: center;">
                <theader>
                    <tr>
                        <th>Descrição</th>
                        <th>Setor</th>
                        <th>Preço</th>
                        @if($pedido->status == 'Orçamento' and Auth::user()->can('servidor'))
                            <th>Ações</th>
                        @endif
                    </tr>
                </theader>
                <tbody>
                @foreach ($pedido->orcamentos->sortBy('procedencia') as $orcamento)
                    <tr>
                        <td>{{ $orcamento->nome }}</td>
                        <td>@if($orcamento->procedencia == 'editora') Editora @else Gráfica @endif</td>
                        <td>R$ {{  number_format($orcamento->preco, 2, ',', '.') }}</td>
                        @if($pedido->status == 'Orçamento' and Auth::user()->can('servidor'))
                            <td>
                                <form method="POST" class="form-group" action="/orcamentos/{{$orcamento->id}}">
                                    @csrf 
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td colspan='3'><b>Total:</b> R$ {{ number_format($pedido->orcamentos()->get()->sum("preco"), 2, ',', '.') }} </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
 
 