@if(($pedido->status == 'Em Elaboração' or $pedido->status == null) and $pedido->files()->count() != 0)
    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-body">
            <form method="POST" action="/pedidos/enviar_analise/{{ $pedido->id }}">
                @csrf
                <div class="row form-group"> 
                    <div class="col-sm">
                        <label for="reason"><b>Mensagem:</b></label>
                        <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja enviar para análise?')"> Enviar para Análise </button>
                    </div>
                </div>
            </form>  
        </div>
    </div>
@elseif($pedido->status == 'Em Análise' and Auth::user()->can('autorizador'))
    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-body">
            <div class="row">       
                <div class="col-sm">
                    <form method="POST" action="/pedidos/enviar_orcamento/{{ $pedido->id }}">
                        @csrf 
                        <div class="row form-group">
                            <div class="col-sm">
                                <label for="reason"><b>Mensagem:</b></label>
                                <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" name="button" value="orcamento" onclick="return confirm('Tem certeza que deseja enviar para orçamento?')"> Enviar para Orçamento </button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger" name="button" value="devolver" onclick="return confirm('Tem certeza que deseja devolver para solicitante?')"> Devolver Pedido </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@elseif($pedido->status == 'Orçamento' and Auth::user()->can('servidor'))
    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <form method="POST" action="/pedidos/autorizacao/{{ $pedido->id }}">
                        @csrf
                        <div class="row form-group"> 
                            <div class="col-sm ">
                                <label for="reason"><b>Mensagem:</b></label>
                                <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm">
                                <input style="margin-left:1px" type="checkbox" name="percentual_sobre_insumos" class="form-check-input" id="percentual_sobre_insumos" @if($pedido->percentual_sobre_insumos == 1) checked @endif>
                                <label style="margin-left:19px" class="form-check-label" for="percentual_sobre_insumos">30% sobre o total de materiais</label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja enviar para autorização?')"> Enviar para Autorização </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@elseif($pedido->status == 'Autorização' and (auth()->user()->codpes == $pedido->responsavel_centro_despesa or Auth::user()->can('admin')))
    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <form method="POST" action="/pedidos/enviar_autorizacao/{{ $pedido->id }}">
                        @csrf
                        <div class="row form-group"> 
                            <div class="col-sm">
                                <label for="reason"><b>Mensagem:</b></label>
                                <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm">
                                <input style="margin-left:1px" type="checkbox" name="termo_responsavel_centro_despesa" class="form-check-input" id="termo_responsavel_centro_despesa" @if($pedido->termo_responsavel_centro_despesa == 1) checked @endif>
                                <label style="margin-left:19px" class="form-check-label" for="termo_responsavel_centro_despesa">Declaro ciência na autorização e de que foi consultado anteriormente o setor da Contabilidade para tal ação.</label>
                            </div>
                        </div>
                        <div clas="row form-group">
                            <div class="col-auto float-left">
                                <button type="submit" class="btn btn-success" name="button" value="autorizado" onclick="return confirm('Tem certeza que deseja aprovar pedido para as próximas etapas?')"> Autorizar Pedido </button>
                            </div>
                            <div class="col-auto float-left">
                                <button type="submit" class="btn btn-danger" name="button" value="negado" onclick="return confirm('Tem certeza que deseja rejeitar pedido?')"> Rejeitar Pedido </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@elseif($pedido->status == 'Editora' and $pedido->tipo == 'Diagramação + Impressão' and Auth::user()->can('editora'))
    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-body">
            <div class="row">    
                <div class="col-sm">
                    <form method="POST" action="/pedidos/grafica/{{ $pedido->id }}">
                        @csrf
                        <div class="row"> 
                            <div class="col-sm form-group">
                                <label for="reason"><b>Mensagem:</b></label>
                                <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="formato"><b>Formato:</b></label>
                                <input type="text" class="form-control" name="formato" value="{{ old('formato', $pedido->formato) }}">
                            </div>
                            <div class="col-sm form-group">
                                <label for="paginas_diagramadas"><b>Páginas Diagramadas:</b></label>
                                <input type="text" class="form-control numeros" name="paginas_diagramadas" value="{{ old('paginas_diagramadas', $pedido->paginas_diagramadas) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja enviar para gráfica?')"> Enviar para Gráfica </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@elseif(($pedido->status == 'Gráfica' and Auth::user()->can('grafica')) or (($pedido->tipo == 'Diagramação' or $pedido->tipo == 'ISBN+DOI+Ficha Catalográfica') and $pedido->status == 'Editora' and Auth::user()->can('editora')))
    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <form method="POST" action="/pedidos/finalizar/{{ $pedido->id }}">
                        @csrf
                        <div class="row"> 
                            <div class="col-sm form-group">
                                <label for="reason"><b>Mensagem:</b></label>
                                <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                            </div>
                        </div>
                        @if($pedido->status == 'Gráfica' and Auth::user()->can('grafica'))
                            <div class="row">
                                <div class="col-sm form-group">
                                    <label for="formato"><b>Formato:</b></label>
                                    <input type="text" class="form-control" name="formato" value="{{ old('formato', $pedido->formato) }}">
                                </div>
                                <div class="col-sm form-group">
                                    <label for="tiragem"><b>Tiragem:</b></label>
                                    <input type="text" class="form-control numeros" name="tiragem" value="{{ old('tiragem', $pedido->tiragem) }}">
                                </div>
                                <div class="col-sm form-group">
                                    <label for="originais"><b>Originais:</b></label>
                                    <input type="text" class="form-control numeros" name="originais" value="{{ old('originais', $pedido->originais) }}">
                                </div>
                                <div class="col-sm form-group">
                                    <label for="impressos"><b>Impressos:</b></label>
                                    <input type="text" class="form-control numeros" name="impressos" value="{{ old('impressos', $pedido->impressos) }}">
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-sm form-group">
                                    <label for="formato"><b>Formato:</b></label>
                                    <input type="text" class="form-control" name="formato" value="{{ old('formato', $pedido->formato) }}">
                                </div>
                                <div class="col-sm form-group">
                                    <label for="paginas_diagramadas"><b>Páginas Diagramadas:</b></label>
                                    <input type="text" class="form-control numeros" name="paginas_diagramadas" value="{{ old('paginas_diagramadas', $pedido->paginas_diagramadas) }}">
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja finalizar o pedido?')"> Finalizar Pedido </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@elseif($pedido->status == 'Finalizado' and Auth::user()->can('servidor'))
    <div class="card" style="margin-bottom: 0.5em;">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <form method="POST" action="/pedidos/documento_contabilidade/{{ $pedido->id }}">
                        @csrf 
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja gerar documento para contabilidade?')"> Gerar Documento para Contabilidade </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
        
