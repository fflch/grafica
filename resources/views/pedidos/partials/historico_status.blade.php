<br><br>
<div id="accordion">
<div class="card">
    <div class="card-header" id="headingOne">
        <div class="float-left">
            <h5 class="mb-0" style="margin-top:0.3rem;">
                Histórico
            </h5>
        </div>
        <div class="float-right">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-angle-down"></i>
            </button>
        </div>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Data da Alteração</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Mensagem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->statuses->sortBy('id') as $status)            
                        <tr>
                            <td>{{ $status->name }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$status->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ \App\Models\User::find($status->user_id)->name }}</td>
                            <td>{{ $status->reason }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
