<br><br>
<div class="card">
    <div class="card-header"><b>Histórico:</b></div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">status</th>
                <th scope="col">data</th>
                <th scope="col">usuário</th>
                <th scope="col">motivo</th>
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
