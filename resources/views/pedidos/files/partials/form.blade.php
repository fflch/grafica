<form action="/files" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
    <div class="row">
        <div class="form-group col-sm">
            <label for="arquivo-do-trabalho" class="required"><b>Arquivo do Pedido</b></label>
            <input type="file" class="form-control-file" id="arquivo-do-trabalho" name="file">
            <span class="badge badge-warning"><b>Atenção:</b> Os arquivos a serem enviados devem ter no máximo 12mb.</span><br>
        </div>
    </div>     
    <div class="row">
        <div class="form-group col-sm">
            <button type="submit" class="btn btn-success float-right">Enviar</button> 
        </div> 
    </div>
</form>
