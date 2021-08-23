@inject('financeiro','Uspdev\Replicado\Financeiro')
@inject('utils','App\Utils\ReplicadoUtils')
<div class="card">
    <div class="card-header"><b>Novo Pedido</b></div>
    <div class="card-body">
        <div class="row form-group">
            <div class="col-sm">
                <label for="titulo"><b>Título:</b></label>
                <input type="text" class="form-control" name="titulo" value="{{ old('titulo', $pedido->titulo) }}">
            </div>
        </div>
                      
        <div class="row form-group">
            <div class="col-sm">
                <label for="tipo" class="required"><b>Tipo:</b></label>
                <select class="form-control" name="tipo">
                    <option value="" selected="">- Selecione -</option>
                    @foreach ($pedido->tipoOptions() as $option)
                        {{-- 1. Situação em que não houve tentativa de submissão e é uma edição --}}
                        @if (old('tipo') == '' and isset($pedido->tipo))
                        <option value="{{$option}}" {{ ( $pedido->tipo == $option) ? 'selected' : ''}}>
                            {{$option}}
                        </option>
                        {{-- 2. Situação em que houve tentativa de submissão, o valor de old prevalece --}}
                        @else
                        <option value="{{$option}}" {{ ( old('tipo') == $option) ? 'selected' : ''}}>
                            {{$option}}
                        </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label for="paginas"><b>Número de páginas:</b></label>
                <input type="text" class="form-control numeros" name="paginas" value="{{ old('paginas', $pedido->paginas) }}">
            </div>
            <div class="col-auto">
                <label class="form-group"><b>Contém Imagens?</b></label><br>
                <div class="form-check form-check-inline">
                    @if (old('contem_imagens') == '' and isset($pedido->contem_imagens))
                        <input class="form-check-input" type="radio" name="contem_imagens" id="contem_imagens1" value="1" {{ ( $pedido->contem_imagens == 1) ? 'checked' : ''}} />
                    @else
                        <input class="form-check-input" type="radio" name="contem_imagens" id="contem_imagens1" value="1" {{ ( old('contem_imagens') == 1) ? 'checked' : ''}} />
                    @endif
                    <label class="form-check-label" for="contem_imagens1">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    @if (old('contem_imagens') == '' and isset($pedido->contem_imagens))
                        <input class="form-check-input" type="radio" name="contem_imagens" id="contem_imagens2" value="0" {{ ( $pedido->contem_imagens == 0) ? 'checked' : ''}} />
                    @else
                        <input class="form-check-input" type="radio" name="contem_imagens" id="contem_imagens2" value="0" {{ ( old('contem_imagens') == 0) ? 'checked' : ''}} />
                    @endif
                    <label class="form-check-label" for="contem_imagens2">Não</label>
                </div>                
            </div>
            <div class="col-sm">
                <label for="tipo_imagens"><b>Tipo das Imagens:</b></label>
                <select class="form-control" name="tipo_imagens">
                    <option value="" selected="">- Selecione -</option>
                    @foreach ($pedido->tipoImagensOptions() as $option)
                        {{-- 1. Situação em que não houve tentativa de submissão e é uma edição --}}
                        @if (old('tipo_imagens') == '' and isset($pedido->tipo_imagens))
                        <option value="{{$option}}" {{ ( $pedido->tipo_imagens == $option) ? 'selected' : ''}}>
                            {{$option}}
                        </option>
                        {{-- 2. Situação em que houve tentativa de submissão, o valor de old prevalece --}}
                        @else
                        <option value="{{$option}}" {{ ( old('tipo_imagens') == $option) ? 'selected' : ''}}>
                            {{$option}}
                        </option>
                        @endif
                    @endforeach
                </select>            
            </div>
            <div class="col-auto">
                <label for="quantidade_imagens"><b>Quantidade de Imagens:</b></label>
                <input type="text" class="form-control numeros" name="quantidade_imagens" value="{{ old('quantidade_imagens', $pedido->quantidade_imagens) }}">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm">
                <input type="text" hidden name="user_id" value="">
                <label for="descricao"><b>Descrição:</b></label>
                <textarea class="form-control" name="descricao" id="descricao" rows="5">{{ old('descricao', $pedido->descricao) }}</textarea>
            </div>
            <div class="col-sm">
                <label for="finalidade"><b>Finalidade:</b></label>
                <textarea class="form-control" name="finalidade" id="finalidade" rows="5">{{ old('finalidade', $pedido->finalidade) }}</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm">
                <label for="centro_de_despesa" class="required"><b>Centro de Despesa:</b></label>
                <select class="form-control" name="centro_de_despesa">
                    <option value="" selected="">- Selecione -</option>
                    @foreach ($financeiro->listarCentrosDespesas() as $option)
                        {{-- 1. Situação em que não houve tentativa de submissão e é uma edição --}}
                        @if (old('centro_de_despesa') == '' and isset($pedido->centro_de_despesa))
                        <option value="{{$option['etrhie']}}" {{ ( $pedido->centro_de_despesa == $option['etrhie']) ? 'selected' : ''}}>
                            {{$option['etrhie']}}
                        </option>
                        {{-- 2. Situação em que houve tentativa de submissão, o valor de old prevalece --}}
                        @else
                        <option value="{{$option['etrhie']}}" {{ ( old('centro_de_despesa') == $option['etrhie']) ? 'selected' : ''}}>
                            {{$option['etrhie']}}
                        </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm">
                <label for="responsavel_centro_despesa"><b>Responsável pelo Centro de Despesa:</b></label>
                <select class="form-control" name="responsavel_centro_despesa" @if($pedido->status == 'Aprovado')readonly @endif>
                    <option value="" selected="">- Selecione -</option>
                    @foreach ($utils->listarDocentesServidores() as $option)
                        {{-- 1. Situação em que não houve tentativa de submissão e é uma edição --}}
                        @if (old('responsavel_centro_despesa') == '' and isset($pedido->responsavel_centro_despesa))
                        <option value="{{$option['codpes'] ?? ''}}" {{ ( $pedido->responsavel_centro_despesa == $option['codpes']) ? 'selected' : ''}}>
                            {{$option['nompes'] ?? ''}}
                        </option>
                        {{-- 2. Situação em que houve tentativa de submissão, o valor de old prevalece --}}
                        @else
                        <option value="{{$option['codpes'] ?? ''}}" {{ ( old('responsavel_centro_despesa') == $option['codpes']) ? 'selected' : ''}}>
                            {{$option['nompes'] ?? ''}}
                        </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row form-group">
            
        </div>
        <div class="row form-group">
            <div class="col-sm">
                <button type="submit" class="btn btn-success float-right">Enviar</button> 
            </div>
        </div>
    </div>
</div>
        