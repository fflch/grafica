<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="em_analise"> <b>Mensagem de E-mail para Autorizadores (quando é solicitado um pedido)</b> </label>  
		<textarea rows="10" cols="70" class="form-control" name="em_analise">{{$em_analise}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="orcamento"> <b>Mensagem de E-mail para Orçamento (quando pedido é liberado para orçamento da editora e da gráfica)</b> </label>  
		<textarea rows="10" cols="70" class="form-control" name="orcamento">{{$orcamento}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="autorizacao"> <b>Mensagem de E-mail para Responsável do Centro de Despesa</b> </label>  
		<textarea rows="10" cols="70" class="form-control" name="autorizacao">{{$autorizacao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="autorizado"> <b>Mensagem de E-mail para Solicitante (Quando aprovado pelo responsável do Centro de Despesa)</b> </label>  
		<textarea rows="10" cols="70" class="form-control" name="autorizado">{{$autorizado}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="diagramacao"> <b>Mensagem de E-mail para Editora</b> </label>  
		<textarea rows="10" cols="70" class="form-control" name="diagramacao">{{$diagramacao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="impressao"> <b>Mensagem de E-mail para Gráfica</b> </label>  
		<textarea rows="10" cols="70" class="form-control" name="impressao">{{$impressao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="finalizado"> <b>Mensagem de E-mail informando sobre finalização do pedido</b> </label>  
		<textarea rows="10" cols="70" class="form-control" name="finalizado">{{$finalizado}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="devolucao"> <b>Mensagem de E-mail de Devolução (quando o pedido é rejeitado)</b></label>  
		<textarea rows="10" cols="70" class="form-control" name="devolucao">{{$devolucao}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %mensagem, %url</span>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm">
		<label class="settings" for="chat"> <b>Mensagem de E-mail de Novas Mensagens no Chat</b></label>  
		<textarea rows="10" cols="70" class="form-control" name="chat">{{$chat}}</textarea> 
		<span class="badge badge-warning">Token de substituição: %usuario, %remetente, %mensagem, %url </span>
	</div>
</div>

<div class="row form-group">
	<div class="col-sm">
    	<button type="submit" class="btn btn-success float-right">Salvar</button>
	</div> 
</div> 