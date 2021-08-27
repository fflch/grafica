<div class="card" style="margin-bottom: 0.5em;">
        <div class="card-header"><b>Arquivos</b></div>
        <div class="card-body form-group">
            @if($pedido->status == 'Em Elaboração' or ($pedido->status == 'Diagramação' and Auth::user()->can('editora')))
                @include('pedidos.files.partials.form')
            @endif
            <table class="table table-striped" style="text-align: center;">
                <theader>
                    <tr>
                        <th>Nome do Arquivo</th>
                        <th>Data de Envio</th>
                        <th>Status</th>
                        @if($pedido->status == 'Em Elaboração' or ($pedido->status == 'Diagramação' and Auth::user()->can('editora')))
                            <th>Ações</th>
                        @endif
                    </tr>
                </theader>
                <tbody>
                @foreach ($pedido->files as $file)
                    <tr>
                        <td><a href="/files/{{$file->id}}">{{ $file->original_name }}</a></td>
                        <td>
                            {{ Carbon\Carbon::parse($file->created_at)->format('d/m/Y') }}
                        </td>
                        <td>{{ $pedido->status }}</td>
                        @if($pedido->status == 'Em Elaboração' or ($pedido->status == 'Diagramação' and Auth::user()->can('editora')))
                            <td>
                                <form method="POST" class="form-group" action="/files/{{$file->id}}">
                                    @csrf 
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
 
 