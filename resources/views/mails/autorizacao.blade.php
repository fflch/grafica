@inject('pessoa','Uspdev\Replicado\Pessoa')

{!! $pedido->configMail($pedido, $pessoa::dump($codpes)['nompes'], 'autorizacao') !!}

<h3><b>Orçamento</b></h3><br>
<table class="table table-striped" style="text-align: center;">
    <theader>
        <tr>
            <th>Descrição</th>
            <th>Setor</th>
            <th>Preço</th>
        </tr>
    </theader>
    <tbody>
        @foreach ($pedido->orcamentos as $orcamento)
            <tr>
                <td>{{ $orcamento->nome }}</td>
                <td>@if($orcamento->procedencia == 'editora') Editora @else Gráfica @endif</td>
                <td>R$ {{  number_format($orcamento->preco, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan='3'><b>Total:</b> R$ {{ number_format($pedido->orcamentos()->get()->sum("preco"), 2, ',', '.') }} </td>
        </tr>
    </tbody>
</table>
<br>
<h4><b>Sistema - Gráfica - FFLCH</b></h4>