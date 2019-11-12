@extends('laravel-usp-theme::master')



@section('content')

<form method="POST" action="/orcamento">
    @csrf

    <div class="form-group">
      <label for="titulo">Título:</label>
      <input type="text" id="titulo" name="titulo">
    </div>
    
    <div>
      <label for="procedencia">Procedência:</label>
      <input type="text" id="procedencia" name="procedencia"> 
    </div>

    <div>
      <label for="area">Área:</label>
      <input type="text" class="col-sm-3" id="area" name="area"> 
    </div>

    <div>
      <label for="responsavel">Responsável:</label>
      <input type="text" class="col-sm-3" id="responsavel" name="responsavel"> 
    </div>

    <div>
      <label for="tiragem">Tiragem:</label>
      <input type="text" class="col-sm-3" id="tiragem" name="tiragem"> 
    </div>

    <div>
      <label for="originais">Originais:</label>
      <input type="text" class="col-sm-3" id="originais" name="orignais"> 
    </div>

    <div>
      <label for="formato">Formato:</label>
      <input type="text" class="col-sm-3" id="formato" name="formato"> 
    </div>

    <div>
      <label for="fonte">Fonte pagadora:</label>
      <input type="text" class="col-sm-3" id="fonte" name="fonte"> 
    </div>

    <div>
      <label for="observacao">Observação:</label>
      <input type="text" class="col-sm-3" id="observacao" name="observacao"> 
    </div>

    <div>
      <label for="tipo">Tipo:</label>
      <input type="text" id="tipo" name="tipo"> 
    </div>

    <div>
      <label for="ano">Ano:</label>
      <input type="text" id="ano" name="ano"> 
    </div>

    <div>
      <label for="numero_cs">Número CS:</label>
      <input type="text" id="numero_cs" name="numero_cs"> 
    </div>


    <div>
      <label for="entrada">Entrada:</label>
      <input type="text" id="entrada" name="entrada"> 
    </div>

    <div>
      <button type="submit" class="btn btn-success"> Enviar Orçamento </button> 
    </div>

</form>



@endsection