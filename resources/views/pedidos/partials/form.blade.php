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
            <div class="col-sm">
                <label for="paginas"><b>Número de páginas:</b></label>
                <input type="text" class="form-control numeros" name="paginas" value="{{ old('paginas', $pedido->paginas) }}">
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
        