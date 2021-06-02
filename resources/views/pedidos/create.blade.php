@extends('laravel-usp-theme::master')

@section('content')
    
    @include('flash')
    <form action="/pedidos" method="POST">
        @csrf
        @include('pedidos.partials.form')
    </form>
@endsection('content')

@section('javascripts_bottom')
  <script src="{{asset('/js/app.js')}}"></script>
@endsection('javascripts_bottom')