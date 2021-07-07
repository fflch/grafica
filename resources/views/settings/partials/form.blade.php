<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="em_analise"> Mensagem de E-mail para Autorizadores (quando é solicitado um pedido) </label>  
		<textarea rows="10" cols="70" class="form-control" name="em_analise">{{$em_analise}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %docente_nome, %candidato_nome, %titulo, %agendamento_id, %data_defesa, %agendamento_email </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="orcamento"> Mensagem de E-mail para Orçamento (quando pedido é liberado para orçamento da editora e da gráfica) </label>  
		<textarea rows="10" cols="70" class="form-control" name="orcamento">{{$orcamento}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %docente_nome,%candidato_nome, %orientador, %titulo, %data_defesa </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="autorizacao"> Mensagem de E-mail para Responsável do Centro de Despesa </label>  
		<textarea rows="10" cols="70" class="form-control" name="autorizacao">{{$autorizacao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %candidato_nome, %orientador, %titulo, %agendamento_id, %data_defesa, %status, %parecer </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="autorizado"> Mensagem de E-mail para Solicitante (Quando aprovado pelo responsável do Centro de Despesa) </label>  
		<textarea rows="10" cols="70" class="form-control" name="autorizado">{{$autorizado}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %candidato_nome, %orientador, %titulo, %agendamento_id, %data_defesa, %status, %parecer </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="diagramacao"> Mensagem de E-mail para Editora </label>  
		<textarea rows="10" cols="70" class="form-control" name="diagramacao">{{$diagramacao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %candidato_nome, %orientador, %titulo, %agendamento_id, %data_defesa, %status, %parecer </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="impressao"> Mensagem de E-mail para Gráfica </label>  
		<textarea rows="10" cols="70" class="form-control" name="impressao">{{$impressao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %docente_nome, %candidato_nome, %titulo, %agendamento_id, %data_defesa, %agendamento_email </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="finalizado"> Mensagem de E-mail informando sobre finalização do pedido </label>  
		<textarea rows="10" cols="70" class="form-control" name="finalizado">{{$finalizado}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %docente_nome, %candidato_nome, %titulo, %agendamento_id, %data_defesa, %agendamento_email </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="devolucao"> Mensagem de E-mail de Devolução (quando o pedido é rejeitado)</label>  
		<textarea rows="10" cols="70" class="form-control" name="devolucao">{{$devolucao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %docente_nome, %candidato_nome, %titulo, %agendamento_id, %data_defesa, %agendamento_email </span>
	</div>
</div>

<div class="form-group row">
	<div class="form-group col-sm">
		<label class="settings" for="chat"> Mensagem de E-mail de Novas Mensagens no Chat</label>  
		<textarea rows="10" cols="70" class="form-control" name="chat">{{$chat}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %docente_nome, %candidato_nome, %titulo, %agendamento_id, %data_defesa, %agendamento_email </span>
	</div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success float-right">Salvar</button> 
</div> 