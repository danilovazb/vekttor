<?php
function selecionaFuncionario($empresa_id,$funcionario_id=''){
	
	$funcionarios = mysql_query($q="SELECT * FROM rh_funcionario WHERE empresa_id='$empresa_id' AND empresa_id!='0' AND status='Admitidos'");
	
	$t="<label>	
	<select name='funcionario_id' id='funcionario_id'>
	<option value='0'>Selecione um funcionário</option>
	";
	
	
	while($funcionario = mysql_fetch_object($funcionarios)){
		if($funcionario->id==$funcionario_id){$selected="selected='selected'";}
		$t.="<option value='$funcionario->id' $selected>$funcionario->nome</option>";
		$selected='';
	}
	
	$t.="</select></label>";
	if($funcionario_id>0){
		return $t;
	}else{		
		return utf8_encode($t);
	}
}
function manipula_solicitacao_hora_extra($dados,$vkt_id){
	if($dados['id']>0){
		$sql_inicio = "UPDATE";
		$sql_fim    = "WHERE id='$dados[id]'";
	}else{
		$sql_inicio = "INSERT INTO";
		$sql_fim    ="";
	}
	
	mysql_query($t="$sql_inicio rh_solicitacao_hora_extra
	SET vkt_id='$vkt_id', empresa_id='$dados[empresa_id]',
	funcionario_id='$dados[funcionario_id]',
	data='".DataBrToUsa($dados['data'])."',
	hora_inicio='$dados[hora_inicio]',
	hora_fim='$dados[hora_fim]',
	observacao='$dados[obs]'
	 $sql_fim");
}
function exclui_hora_extra($id){
	mysql_query("DELETE FROM rh_solicitacao_hora_extra WHERE id='$id'");
}
?>