<div class="container">
    <form action="/chats" method="POST">
        @csrf
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        <input type="text" hidden class="form-control" name="user_id" value="">
        <div class="row form-group">
            <textarea class="form-control" name="message" id="message" placeholder="Mensagem...">{{ old('message') }}</textarea>
        </div>
        <div class="row form-group">
            <div class="col-sm" style="padding:0">
                <button type="submit" class="btn btn-primary rounded-circle float-right"><i class="far fa-paper-plane"></i></button>
            </div> 
        </div>
    </form>
</div>
