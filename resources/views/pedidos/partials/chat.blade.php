    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-header"><b>Chat</b></div>
        <div class="card-body">
            <div class="container rounded border border-dark" id="scroll" style="overflow-y: scroll; height: 200px;">
                @foreach($chats as $chat)
                    @if($chat->user_id == $pedido->user_id)
                        <div class="row">
                            <div class="col-sm">
                                <div class="col-auto float-right">
                                    <p class="bg-light rounded" style="margin:0; padding:0;text-align:right">{{$chat->message}} <i class="fas fa-user-circle"></i></p>
                                    <p style="margin:0; padding:0;color:#696969; font-size:10px">{{$chat->user->name}} - {{ Carbon\Carbon::parse($chat->created_at)->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-sm">
                                <div class="col-auto float-left">
                                    <p class="bg-info rounded" style="margin:0; padding:0; color:#fff; text-align:left"><i class="far fa-user-circle"></i> {{$chat->message}}</p>
                                    <p style="margin:0; padding:0; color:#696969; font-size:10px">{{$chat->user->name}} - {{ Carbon\Carbon::parse($chat->created_at)->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            
            @if($pedido->status == 'Editoração' or $pedido->status == 'Artes Gráficas')
                <br>
                @include('pedidos.chats.form')
            @endif
        </div>
    </div>
 
 