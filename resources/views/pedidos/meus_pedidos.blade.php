@extends('laravel-usp-theme::master')

@section('content')
    @include('flash')
    <div class="card">
        <div class="card-header"><h5><b>Filtros</b></h5></div>
        <div class="card-body">
            <form method="GET" action="/pedidos/meus_pedidos">
                <div class="row form-group">
                    <div class="col-auto form-group"> 
                        <select class="form-control" name="busca_tipo">
                            <option value="" selected="">- Tipo -</option>
                            @foreach (App\Models\Pedido::tipoOptions() as $option)
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
                    <div class="col-auto form-group"> 
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
                </div>
                <div class="row form-group float-right">
                    <div class="col-auto form-group">
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h3>Meus pedidos</h3></div>
        <div class="card-body">
            <table class="table table-striped">
                <theader>
                    <tr>
                        <th>Nº USP</th>
                        <th>Nome</th>
                        <th>Data da Solicitação</th>
                        <th>Status</th>
                    </tr>
                </theader>
                <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->user->codpes }}</td>
                        <td><a href="/pedidos/{{$pedido->id}}">{{ $pedido->user->name }}</a></td>
                        <td>{{ Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $pedido->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $pedidos->appends(request()->query())->links() }}
@endsection('content')