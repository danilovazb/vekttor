<?

function altera_atividade($campos){
	global $vkt_id,$usuario_id;
	
	if(mysql_query("
			UPDATE projetos_atividades SET
				vkt_id =' $vkt_id',
				projeto_id = '{$campos[projeto_id]}',
				funcionario_id    = '{$campos[funcionario_id]}',
				atividade_tipo_id = '{$campos[tipo_atividade_id]}',
				nome              = '{$campos[nome_atividade]}',
				descricao         = '{$campos[descricao_atividade]}',
				data_limite       = '".dataBrToUsa($campos[data_limite])."',
				tempo_estimado_horas ='{$campos[tempo]}',
				situacao		  = '{$campos['situacao']}',
				usuario_id_alterou='$usuario_id',
				usuario_id_cadastrou='{$campos['usuario_id_cadastrou']}',
				prioridade='{$campos['prioridade']}',
				ordenacao_funcionario='{$campos['ordenacao_funcionario']}',
				data_alteracao=now()
				
			WHERE
				id='{$campos[id]}'
	")){
	$projeto = mf(mq("SELECT * FROM projetos WHERE id='{$campos[projeto_id]}'"));
	$msg = 
"Atividade Alterada: ".$campos[nome_atividade]." em ".date("d/m/Y H:m")."
Nota: ".$campos[descricao_atividade]. "
Em: ".$projeto->nome."
Por: ".$_SESSION[usuario]->nome."
";
	registra_atividade($campos[funcionario_id],$msg,$campos[nome_atividade]);
		
	}else{
		echo mysql_error();
	}
	
}
function adiciona_atividade($campos){
	global $vkt_id,$usuario_id;
	
	if(mysql_query($t="
			INSERT INTO projetos_atividades SET
				vkt_id =' $vkt_id',
				projeto_id = '{$campos[projeto_id]}',
				funcionario_id    = '{$campos[funcionario_id]}',
				atividade_tipo_id = '{$campos[tipo_atividade_id]}',
				nome              = '{$campos[nome_atividade]}',
				descricao         = '{$campos[descricao_atividade]}',
				data_limite       = '".dataBrToUsa($campos[data_limite])."',
				tempo_estimado_horas ='{$campos[tempo]}',
				situacao		  = '{$campos['situacao']}',
				usuario_id_cadastrou='{$campos['usuario_id_cadastrou']}',
				prioridade='{$campos['prioridade']}',
				ordenacao_funcionario='{$campos['ordenacao_funcionario']}',
				data_alteracao=now(),
				data_cadastro=now()
	")){
	$projeto = mf(mq("SELECT * FROM projetos WHERE id='{$campos[projeto_id]}'"));
	$msg = 
"Nova Atividade : ".$campos[nome_atividade]." em ".date("d/m/Y H:m")."
Nota: ".$campos[descricao_atividade]. "
Em: ".$projeto->nome."
Por: ".$_SESSION[usuario]->nome."
";
	registra_atividade($campos[funcionario_id],$msg,$campos[nome_atividade]);
	}else{
		echo $t.mysql_error();
	}
	
}

function deletar_atividade($id){
	mysql_query("
			DELETE FROM 
				projetos_atividades
			WHERE
				id='$id'
	");
}


function registra_atividade($usuario_id,$msg,$assunto=NULL){
	global $vkt_id;
	$u = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario WHERE id='$usuario_id' AND cliente_vekttor_id='$vkt_id'"));

	$c = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$u->cliente_fornecedor_id'"));
//	echo "$c->razao_social,$c->email, $msg ,$msg";
	envia_emailx($c->razao_social,$c->email,$assunto,nl2br($msg));
	if(strlen($c->telefone1)>10){
		envia_sms($c->telefone1,$msg,'9292447705',$c->id);	
	}
	
	
}

?>