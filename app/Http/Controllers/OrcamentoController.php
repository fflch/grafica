<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use Illuminate\Http\Request;
use App\Http\Requests\OrcamentoRequest;

class OrcamentoController extends Controller
{
    public function store(OrcamentoRequest $request)
    {
        $this->authorize('servidor');
        $validated = $request->validated();
        Orcamento::create($validated);
        return back();
    }

    public function destroy(Orcamento $orcamento)
    {
        $this->authorize('servidor');
        $orcamento->delete();
        return back();
    }
}
