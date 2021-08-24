@extends('laravel-usp-theme::master')

@section('content')
@include('flash')
<div class="card">
    <div class="card-header"><b>Login para Administradores</b></div>
    <div class="card-body">
        <form method="POST" action="/login_admin">
            @csrf
            <label><b>Número USP</b></label><br>
            <div class="row form-group">
                <div class="col-sm">
                    <input type="text" class="form-control" name="codpes">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Acessar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection('content')