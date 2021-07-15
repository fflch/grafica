<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;
use App\Jobs\ChatJob;

class ChatController extends Controller
{
    
    public function store(ChatRequest $request)
    {
        $this->authorize('logado');
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $chat = Chat::create($validated);
        $pedido = Pedido::where('id',$chat->pedido_id)->first();
        ChatJob::dispatch($pedido, $chat);
        return back();
    }

}
