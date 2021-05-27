@extends('laravel-usp-theme::master')

@section('content')
    
    @include('flash')
    <form action="/pedidos" method="POST">
        @csrf
        @include('pedidos.partials.form')
    </form>
@endsection('content')
