<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use Illuminate\Http\Request;
use App\Http\Requests\OrcamentoRequest;

class OrcamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(OrcamentoRequest $request)
    {
        $validated = $request->validated();
        Orcamento::create($validated);
        return back();
    }

    public function destroy(Orcamento $orcamento)
    {
        $orcamento->delete();
        return back();
    }
}
