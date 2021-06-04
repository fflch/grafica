@extends('laravel-usp-theme::master')

@section('content')
    @include('flash')
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