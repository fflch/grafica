@extends('laravel-usp-theme::master')

@section('content')
    @inject('pessoa','Uspdev\Replicado\Pessoa')
    @include('flash')
    @include('pedidos.partials.cabecalho')
    <br>
    {!! $stepper !!}
    @if(($pedido->status == 'Diagramação' and Auth::user()->can('editora')) or ($pedido->status == 'Impressão' and Auth::user()->can('grafica')))
      <br><br>
      @include('pedidos.partials.chat')
    @endif
    <br><br>
    @include('pedidos.partials.dados_pedido')
    <br>
    @include('pedidos.partials.files')
    <br>
    @include('pedidos.partials.orcamentos')
@endsection('content')

@section('javascripts_bottom')
  <script src="{{asset('/js/app.js')}}"></script>
@endsection('javascripts_bottom')