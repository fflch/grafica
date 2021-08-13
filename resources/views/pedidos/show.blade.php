@extends('laravel-usp-theme::master')

@section('content')
    @inject('pessoa','Uspdev\Replicado\Pessoa')
    @include('flash')
    @include('pedidos.partials.cabecalho')
    <br>
    {!! $stepper !!}
    @if(($pedido->status == 'Diagramação' and Auth::user()->can('editora')) or ($pedido->status == 'Impressão' and Auth::user()->can('grafica')) or (($pedido->status == 'Diagramação' or $pedido->status == 'Impressão') and Auth::user()->id == $pedido->user_id))
      <br><br>
      @include('pedidos.partials.chat')
    @endif
    <br><br>
    @include('pedidos.partials.dados_pedido')
    <br>
    @include('pedidos.partials.files')
    <br>
    @include('pedidos.partials.orcamentos')
    
    @can('admin')
        @if($pedido->status != 'Em Elaboração')
            <br>
            <div class="col-auto">
                <form method="POST" action="/pedidos/voltar_status/{{ $pedido->id }}">
                    @csrf 
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja voltar status?')"> Voltar para status anterior </button>
                </form>
            </div>
        @endif
    @endcan
@endsection('content')

@section('javascripts_bottom')
  <script src="{{asset('/js/app.js')}}"></script>
@endsection('javascripts_bottom')