@extends('laravel-usp-theme::master')

@section('content')
    @inject('pessoa','Uspdev\Replicado\Pessoa')
    @inject('utils','App\Utils\ReplicadoUtils')
    @include('flash')
    
    @include('pedidos.partials.header')
    
    {!! $stepper !!}
    
    @include('pedidos.partials.status')
    
    @if(($pedido->status == 'Editoração' and Auth::user()->can('editora')) or ($pedido->status == 'Artes Gráficas' and Auth::user()->can('grafica')) or (($pedido->status == 'Editoração' or $pedido->status == 'Artes Gráficas') and Auth::user()->id == $pedido->user_id))
      @include('pedidos.partials.chat')
    @endif
    
    @include('pedidos.partials.dados_pedido')

    @include('pedidos.partials.files')

    @include('pedidos.partials.orcamentos')
    
    @can('servidor')
        @if($pedido->status != 'Em Elaboração')
            <div class="row">
                <div class="col-auto">
                    <form method="POST" action="/pedidos/voltar_status/{{ $pedido->id }}">
                        @csrf 
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja voltar status?')"> Voltar para status anterior </button>
                    </form>
                </div>
            </div>
        @endif
    @endcan
@endsection('content')

@section('javascripts_bottom')
  <script src="{{asset('/js/app.js')}}"></script>
@endsection('javascripts_bottom')