@extends('laravel-usp-theme::master')

@section('content')

@if(Auth::guest())
  Sistema para solicitação de serviços da Editora e Gráfica - FFLCH

  <br><br>

  <iframe width="560" height="315" src="https://www.youtube.com/embed/8VSvUe_r4dA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@else
    @include('dashboard')
@endif

@endsection('content')
