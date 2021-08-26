@extends('laravel-usp-theme::master')

@section('content')
    <div class="row" style="margin-bottom: 0.5em">
        <div class="col-sm">
            <a href="/pedidos/create" class="btn btn-primary">Novo Pedido</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><b>Pedidos</b></div>
        <div class="card-body">
            <form method="GET" action="/pedidos">
                <div class="row form-group">
                    <div class="btn-group btn-group-toggle col-auto" data-toggle="buttons">
                        <label class="btn btn-light">
                            <input type="radio" name="filtro_busca" id="numero_nome" value="numero_nome" autocomplete="off" @if(Request()->filtro_busca == 'numero_nome' or Request()->filtro_busca == '') checked @endif> Número USP/Nome
                        </label>
                        <label class="btn btn-light">
                            <input type="radio" name="filtro_busca" id="data" value="data" autocomplete="off" @if(Request()->filtro_busca == 'data') checked @endif> Data
                        </label>
                    </div>
                    <div class="col-2"> 
                        <select class="form-control" name="busca_tipo">
                            <option value="" selected="">- Tipo -</option>
                            @foreach (App\Models\Pedido::tipoPedidoOptions() as $option)
                                {{-- 1. Situação em que não houve tentativa de submissão e é uma edição --}}
                                @if (old('busca_tipo') == '' and isset(Request()->busca_tipo))
                                <option value="{{$option}}" {{ ( Request()->busca_tipo == $option) ? 'selected' : ''}}>
                                    {{$option}}
                                </option>
                                {{-- 2. Situação em que houve tentativa de submissão, o valor de old prevalece --}}
                                @else
                                <option value="{{$option}}" {{ ( old('busca_tipo') == $option) ? 'selected' : ''}}>
                                    {{$option}}
                                </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto"> 
                        <select class="form-control" name="busca_status">
                            <option value="" selected="">- Status -</option>
                            @foreach (App\Models\Pedido::status as $option)
                                {{-- 1. Situação em que não houve tentativa de submissão e é uma edição --}}
                                @if (old('busca_status') == '' and isset(Request()->busca_status))
                                <option value="{{$option}}" {{ ( Request()->busca_status == $option) ? 'selected' : ''}}>
                                    {{$option}}
                                </option>
                                {{-- 2. Situação em que houve tentativa de submissão, o valor de old prevalece --}}
                                @else
                                <option value="{{$option}}" {{ ( old('busca_status') == $option) ? 'selected' : ''}}>
                                    {{$option}}
                                </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm" id="busca"  @if(Request()->filtro_busca == 'data') style="display:none;" @endif>
                        <input type="text" class="form-control busca" autocomplete="off" name="busca" value="{{ Request()->busca }}" placeholder="Digite a descrição do pedido, o número USP, o nome do(a) solicitante">
                    </div>
                    <div class="col-sm" id="busca_data" @if(Request()->filtro_busca == 'numero_nome' or Request()->filtro_busca == '') style="display:none;" @endif>
                        <input class="form-control data datepicker" autocomplete="off" name="busca_data" value="{{ Request()->busca_data }}" placeholder="Selecione a data">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <theader>
            <tr>
                <th>Nº USP</th>
                <th>Nome</th>
                <th>Título</th>
                <th>Data da Solicitação</th>
                <th>Tipo de Pedido</th>
                <th>Tipo de Material</th>
                <th>Status</th>
                <th colspan="2">Ações</th>
            </tr>
        </theader>
        <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->user->codpes }}</td>
                <td><a href="/pedidos/{{$pedido->id}}">{{ $pedido->user->name }}</a></td>
                <td>{{ $pedido->titulo }}</td>
                <td>{{ Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</td>
                <td>{{ $pedido->tipo}}</td>
                <td>{{ $pedido->tipo_material}}</td>
                <td>{{ $pedido->status}}</td>
                <td>
                    <a href="/pedidos/{{$pedido->id}}/edit" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                </td>
                <td>
                    <form method="POST" action="/pedidos/{{ $pedido->id }}">
                        @csrf 
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $pedidos->appends(request()->query())->links() }}
@endsection('content')

@section('javascripts_bottom')
  <script src="{{asset('/js/app.js')}}"></script>
@endsection('javascripts_bottom')