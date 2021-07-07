    <div class="card">
        <div class="card-header"><b>Chat</b></div>
        <div class="card-body form-group">
            <div class="container">
                @foreach($chats as $chat)
                    @if($chat->user_id == $pedido->user_id)
                        <div class="row">
                            <div class="col-auto float-right bg-light">
                                {{$chat->message}}
                                {{$chat->user->name}}
                                {{$chat->created_at}}
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-auto float-left bg-info">
                                {{$chat->message}}
                                {{$chat->user->name}}
                                {{$chat->created_at}}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            
            @if($pedido->status == 'Diagramação' or $pedido->status == 'Impressão')
                @include('pedidos.chats.form')
            @endif
        </div>
    </div>
 
 