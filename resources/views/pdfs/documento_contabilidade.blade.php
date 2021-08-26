@extends('pdfs.fflch')
@inject('pessoa','Uspdev\Replicado\Pessoa')

@section('styles_head')
<style>
  /**
  @page { margin: 100px 100px 25px 25px; }
  header { position: fixed; top: -60px; left: 0px; right: 0px; height: 100px; }
  footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
  .page-break {
      page-break-after: always;
      margin-top:160px;
  }
  p:last-child { page-break-after: never; }
  .content {
      margin-top:160px;
  }
  **/
    body{
        margin-left: 1.2em; font-family: DejaVu Sans, sans-serif; font-size: 12px;
    }   
    .dados {
        border:1px solid; margin-top:0.3cm; margin-bottom:0.3cm; width: 15cm; font-size:14px; margin-left:1.5cm;
    }
    #footer {
      position: fixed;
      bottom: -1cm;
      left: 0px;
      right: 0px;
      text-align: center;
      border-top: 1px solid gray;
      width: 18.5cm;
      height: 100px;
    }
    .page-break {
      page-break-after: always;
      margin-top:160px;
    }
    p:last-child {
      page-break-after: never; 
    }
    .content {
      margin-top:0px;
    }
    table{
        border-collapse: collapse;
    }
    tr, td {
        word-wrap:break-word;
    }
</style>
@endsection('styles_head')

@section('header')
  <table style='width:100%'>
    <tr>
      <td style='width:20%' style='text-align:left;'>
        <img src='images/logo-fflch.png' width='100px'/>
      </td>
      <td style='width:80%; text-align:center; font-size:18px; color: #042e6f'>
        <b>FACULDADE DE FILOSOFIA, LETRAS E CIÊNCIAS HUMANAS</b>
        <p style="color:#000; margin: 0; padding: 0;">Universidade de São Paulo</p>
        <i>Serviço de Editoração e Artes Gráficas</i>
      </td>
    </tr>
  </table>
  <hr>
@endsection('header')

@section('content')
    <h2 align="center">Orçamento do Pedido - nº {{ $pedido->id }} </h2>
    <table style="text-align:left; border: 1px solid;" width="18cm" cellspacing="0" cellpadding="0">
        <tr style="border: 1px solid #000;">
            <td style="font-size:14px; border: 1px solid #000; text-align:center;" colspan='2'><b>Dados do Pedido</b></td>
        </tr>
        <tr style="border: 1px solid #000;">    
            <td colspan='2' style="border: 1px solid #000;"><b>Solicitante:</b> {{$pedido->user->name ?? ''}}</td>
        </tr>
        <tr style="border: 1px solid #000;">    
            <td style="border: 1px solid #000;"><b>Tipo de Pedido:</b> {{$pedido->tipo ?? ''}}</td>
            <td style="border: 1px solid #000;"><b>Tipo de Material:</b> {{$pedido->tipo_material ?? ''}}</td>
        </tr>
        <tr style="border: 1px solid #000;">    
            <td style="border: 1px solid #000;"><b>Data da Solicitação:</b> {{ strftime('%d/%m/%Y', strtotime($pedido->created_at)) }}</td>
            <td style="border: 1px solid #000;"><b>Data da Finalização:</b> {{ strftime('%d/%m/%Y', strtotime($pedido->updated_at)) }}</td>
        </tr>
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000;"><b>Centro de Despesa:</b> {{$pedido->centro_de_despesa ?? ''}}</td>
            <td style="border: 1px solid #000;"><b>Responsável Centro de Despesa:</b>@if($pedido->responsavel_centro_despesa != null) {{$pessoa::dump($pedido->responsavel_centro_despesa)['nompes'] }}@endif</td>
        </tr>
    </table>
    <br>
    <table style="text-align:left; table-layout:fixed; border:1px solid; white-space: normal;" width="18cm" cellspacing="0" cellpadding="0">
        <tr style="border: 1px solid #000;">
            <td colspan='3' style="font-size:14px; border: 1px solid #000; text-align:center;"><b>Outras informações</b></td>
        </tr>
        <tr style="border: 1px solid #000;">    
            <td colspan='3' style="border: 1px solid #000;">
                <b>Título: </b>
                {{$pedido->titulo ?? ''}}
            </td>
        </tr>
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000;"><b>Número de páginas:</b> {{$pedido->paginas ?? ''}}</td>
            <td style="border: 1px solid #000;"><b>Páginas diagramadas:</b> {{$pedido->paginas_diagramadas ?? ''}}</td>
            <td style="border: 1px solid #000;"><b>Formato:</b> {{$pedido->formato ?? ''}}</td>
        </tr>
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000;"><b>Contém Imagens?</b> @if($pedido->contem_imagens == 1) Sim @else Não @endif</td>
            <td style="border: 1px solid #000;"><b>Tipo das Imagens:</b> {{$pedido->tipo_imagens ?? ''}}</td>
            <td style="border: 1px solid #000;"><b>Quantidade de Imagens:</b> {{$pedido->quantidade_imagens ?? ''}}</td>
        </tr>
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000;"><b>Tiragem:</b> {{$pedido->tiragem ?? ''}}</td>
            <td style="border: 1px solid #000;"><b>Originais:</b> {{$pedido->originais ?? ''}}</td>
            <td style="border: 1px solid #000;"><b>Total de impressos:</b> {{$pedido->impressos ?? ''}}</td>
        </tr>
        <tr style="border: 1px solid #000;">    
            <td colspan='3' style="border: 1px solid #000;">
                <b>Descrição: </b>
                {{$pedido->descricao ?? ''}}
            </td>
        </tr>
        <tr style="border: 1px solid #000;">
            <td colspan='3' style="border: 1px solid #000;">
                <b>Finalidade: </b>
                {{$pedido->finalidade ?? ''}}
            </td>
        </tr>
    </table>
    <br>
    <table style="border: 1px solid #000;" width="18cm" cellspacing="0" cellpadding="0">
        <tr style="border: 1px solid #000;">
            <th height="0.4cm" style="background-color:gray; padding:0px; font-size:14px; border: 1px solid #000; text-align: center;" colspan='3'>Orçamento</th>
        </tr>
        <tr style="border: 1px solid #000; text-align: center;">
            <th height="0.4cm" style="background-color:gray; padding:0px; border: 1px solid #000;">Item</th>
            <th height="0.4cm" style="background-color:gray; padding:0px; border: 1px solid #000;">Setor</th>
            <th height="0.4cm" style="background-color:gray; padding:0px; border: 1px solid #000;">Preço</th>
        </tr>
        @foreach ($pedido->orcamentos->sortBy('procedencia') as $orcamento)
            <tr style="border: 1px solid #000;">
                <td height="0.4cm" style="background-color:white; padding:0px; border: 1px solid #000; text-align: left;">{{ $orcamento->nome }}</td>
                <td height="0.4cm" style="background-color:white; padding:0px; border: 1px solid #000; text-align: center;">@if($orcamento->procedencia == 'editora') Editora @else Gráfica @endif</td>
                <td height="0.4cm" style="background-color:white; padding:0px; border: 1px solid #000; text-align: right;">R$ {{  number_format($orcamento->preco, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="border: 1px solid #000; text-align: center;">
            <td height="0.4cm" style="background-color:#B9B1B1; padding:0px; border: 1px solid #000; text-align: left;"></td>
            <td height="0.4cm" style="background-color:#B9B1B1; padding:0px; border: 1px solid #000; text-align: center;"><b>Total: </b></td>
            <td height="0.4cm" style="background-color:#B9B1B1; padding:0px; border: 1px solid #000; text-align: right;"> R$ {{ number_format($pedido->orcamentos()->get()->sum("preco"), 2, ',', '.') }} </td>
        </tr>
    </table>
    <br>
    <div style="text-align:right; margin-right:22px;">
        ______________________________________________
        <br>
        {{ $pedido->user->name }}<br><br>
        @php(setlocale(LC_TIME, 'pt_BR','pt_BR.utf-8','portuguese'))
        São Paulo, {{ strftime('%d de %B de %Y', strtotime('today')) }}
    </div>
    <p>
        @if($observacao)
            <b>Observação:</b><br>
            {{$observacao}}
        @endif
    </p>
    <div id="footer">
        <table style="text-align:center; color: #042e6f">
            <tr>
                <td style="border-right: 1px solid gray">
                    <b>Serviço de Editoração da FFLCH</b><br> 
                    <b>E-mail:</b> editorafflch@usp.br | <b>Tel e fax:</b> 3091-4593 <br>
                    Rua do Lago, 717 CEP: 05508-080 - Cidade Universitária São Paulo - SP / Brasil <br>
                </td>
                <td>
                    <b>Serviço de Artes Gráficas da FFLCH</b> <br> 
                    <b>E-mail:</b> sagr@usp.br | <b>Tel e fax:</b> 3091-4591 <br>
                    Rua do Lago, 717 CEP: 05508-080 - Cidade Universitária São Paulo - SP / Brasil <br>
                </td>    
            </tr>
        </table>
    </div>
@endsection('content')