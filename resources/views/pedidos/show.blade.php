@extends('laravel-usp-theme::master')

@section('content')
    @inject('pessoa','Uspdev\Replicado\Pessoa')
    @include('flash')
    @include('pedidos.partials.cabecalho')
    <br>
    {!! $stepper !!}
    <br><br>
    @include('pedidos.partials.dados_pedido')
    <br>
    @include('pedidos.partials.orcamentos')
    <br>
    @include('pedidos.partials.files')
@endsection('content')
