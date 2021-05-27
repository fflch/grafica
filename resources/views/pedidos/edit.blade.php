@extends('laravel-usp-theme::master')

@section('content')

  @include('flash')
  <form action="/pedidos/{{$pedido->id}}" method="POST">
    @csrf
    @method('PATCH')
    @include('pedidos.partials.form')
  </form>

@endsection('content')