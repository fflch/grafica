@extends('laravel-usp-theme::master')

@section('content')
    @include('flash')

    <div class="row">
        
    </div>
    <br>

    <div class="card">
        <div class="card-header"><b>Configurações de sistema</b></div>
        <div class="card-body">
            <div class="row form-group">
                <div class="col-sm">
                    <b>Instruções de estilo:</b><br>
                    <b>{{ "<br>" }}</b>: quebra de linha<br>
                    <b>{{"<b>"}}</b> e <b>{{"</b>"}}</b>: determina qual parte do texto ficará em negrito<br>
                    <b>{{"<center>"}}</b> e <b>{{"</center>"}}</b>: determina qual parte do texto ficará centralizada<br>
                    <b>{{"<hr>"}}</b>: cria linha horizontal<br>
                    <b>{{"<i>"}}</b> e <b>{{"</i>"}}</b>: determina qual parte do texto ficará em itálico<br>
                    <b>{{"<u>"}}</b> e <b>{{"</u>"}}</b>: determina qual parte do texto ficará sublinhado<br>
                    <b>{{"<p>"}}</b> e <b>{{"</p>"}}</b>: cria uma parágrafo<br>
                </div>
            </div>
            <form action="/settings" method="POST">
                @csrf
                @include('settings.partials.form')
            </form>
        </div>
    </div>
@endsection('content')