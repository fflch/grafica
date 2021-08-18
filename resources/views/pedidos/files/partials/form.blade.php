<form action="/files" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
    <div class="row form-group">
        <div class="col-auto" style="margin-top:0.6em;">
            <label for="arquivo-do-trabalho" class="required"><b>Arquivo do Pedido:</b></label>
        </div>
        <div class="col-sm">
            <input type="file" class="form-control-file" id="arquivo-do-trabalho" name="file">
            <span class="badge badge-warning"><b>Atenção:</b> Os arquivos a serem enviados devem ter no máximo 12mb.</span><br>
        </div>
        <div class="col-auto" style="margin-top:0.2em;">
            <button type="submit" class="btn btn-success float-right">Enviar</button> 
        </div> 
    </div>     
</form>
