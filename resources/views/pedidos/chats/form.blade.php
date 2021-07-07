<form action="/chats" method="POST">
    @csrf
    <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
    <input type="text" hidden class="form-control" name="user_id" value="">
    <div class="form-group">
        <label for="message"><b>Mensagem:</b></label>
        <textarea class="form-control" name="message" id="message" rows="5">{{ old('message') }}</textarea>
    </div>
    <div class="row">
        <div class="form-group col-sm">
            <button type="submit" class="btn btn-success float-right">Enviar</button> 
        </div> 
    </div>
</form>
