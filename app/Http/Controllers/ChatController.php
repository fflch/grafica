<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;

class ChatController extends Controller
{
    
    public function store(ChatRequest $request)
    {
        $this->authorize('logado');
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        Chat::create($validated);
        return back();
    }

}
