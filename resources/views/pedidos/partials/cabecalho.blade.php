    <div class="row">
        <div class="col-sm">
            <div class="float-left">
                <div class="col-auto">
                    <a href="/pedidos/create" class="btn btn-primary">Novo Pedido</a>
                </div>
            </div>
            @if((auth()->user()->id == $pedido->user_id and $pedido->status == 'Em Elaboração') or Auth::user()->can('admin'))
            <div class="row float-right">
                <div class="col-auto">
                    <a href="/pedidos/{{$pedido->id}}/edit" class="btn btn-warning">Editar Pedido</a>
                </div>
                <div class="col-auto">
                    <form method="POST" action="/pedidos/{{ $pedido->id }}">
                        @csrf 
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')">Apagar</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        @if(($pedido->status == 'Em Elaboração' or $pedido->status == null) and $pedido->files()->count() != 0)
        <div class="col-sm">
            <form method="POST" action="/pedidos/enviar_analise/{{ $pedido->id }}">
                @csrf 
                <div class="col-sm form-group">
                    <label for="reason"><b>Mensagem:</b></label>
                    <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja enviar para análise?')"> Enviar para Análise </button>
                </div>
            </form>
        </div>
        @elseif($pedido->status == 'Em Análise')
            @can('autorizador')
                <div class="col-sm">
                    <form method="POST" action="/pedidos/enviar_orcamento/{{ $pedido->id }}">
                        @csrf 
                        <div class="col-sm form-group">
                            <label for="reason"><b>Mensagem:</b></label>
                            <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                        </div>
                        <div class="col-auto float-left">
                            <button type="submit" class="btn btn-success" name="button" value="orcamento" onclick="return confirm('Tem certeza que deseja enviar para orçamento?')"> Enviar para Orçamento </button>
                        </div>
                        <div class="col-auto float-left">
                            <button type="submit" class="btn btn-danger" name="button" value="devolver" onclick="return confirm('Tem certeza que deseja devolver para solicitante?')"> Devolver Pedido </button>
                        </div>
                    </form>
                </div>
            @endcan
        @elseif($pedido->status == 'Orçamento')
            @can('servidor')
                <div class="col-sm">
                    <form method="POST" action="/pedidos/autorizacao/{{ $pedido->id }}">
                        @csrf 
                        <div class="col-sm form-group">
                            <label for="reason"><b>Mensagem:</b></label>
                            <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja enviar para autorização?')"> Enviar para Autorização </button>
                        </div>
                    </form>
                </div>
            @endcan
        @elseif($pedido->status == 'Autorização' and (auth()->user()->codpes == $pedido->responsavel_centro_despesa or Auth::user()->can('admin')))
        <div class="col-sm">
            <form method="POST" action="/pedidos/enviar_autorizacao/{{ $pedido->id }}">
                @csrf
                <div class="row"> 
                    <div class="col-sm form-group">
                        <label for="reason"><b>Mensagem:</b></label>
                        <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm form-check">
                        <input type="checkbox" name="termo_responsavel_centro_despesa" class="form-check-input" id="termo_responsavel_centro_despesa">
                        <label class="form-check-label" for="termo_responsavel_centro_despesa">Declaro ciência na autorização e de que foi consultado anteriormente o setor da Contabilidade para tal ação.</label>
                    </div>
                </div>
                <div clas="row">
                    <div class="col-auto float-left">
                        <button type="submit" class="btn btn-success" name="button" value="autorizado" onclick="return confirm('Tem certeza que deseja aprovar pedido para as próximas etapas?')"> Autorizar Pedido </button>
                    </div>
                    <div class="col-auto float-left">
                        <button type="submit" class="btn btn-danger" name="button" value="negado" onclick="return confirm('Tem certeza que deseja rejeitar pedido?')"> Rejeitar Pedido </button>
                    </div>
                </div>
            </form>
        </div>
        @elseif($pedido->status == 'Diagramação' and $pedido->tipo == 'Diagramação + Impressão')
            @can('editora')
                <div class="col-sm">
                    <form method="POST" action="/pedidos/impressao/{{ $pedido->id }}">
                        @csrf 
                        <div class="col-sm form-group">
                            <label for="reason"><b>Mensagem:</b></label>
                            <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja enviar para impressao?')"> Enviar para Impressão </button>
                        </div>
                    </form>
                </div>
            @endcan
        @elseif($pedido->status == 'Impressão' or ($pedido->tipo == 'Diagramação' and $pedido->status == 'Diagramação'))
            @can('grafica')
                <div class="col-sm">
                    <form method="POST" action="/pedidos/finalizar/{{ $pedido->id }}">
                        @csrf 
                        <div class="col-sm form-group">
                            <label for="reason"><b>Mensagem:</b></label>
                            <textarea class="form-control" name="reason" id="reason" rows="5">{{ old('reason', $pedido->reason) }}</textarea>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Tem certeza que deseja finalizar o pedido?')"> Finalizar Pedido </button>
                        </div>
                    </form>
                </div>
            @endcan
        @endif
    </div>