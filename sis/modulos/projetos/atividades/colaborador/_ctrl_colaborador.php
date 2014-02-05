<?


if($_GET['id']>0){
	
	$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT *,
	date_format(data_hora_inicio,'%H:%i' ) as hora_inicio,
	date_format(data_hora_fim,'%H:%i' ) as hora_fim  ,
	date_format(data_cadastro,'%d/%m/%Y às %H:%i' ) as cadastro,
	DATEDIFF(data_cadastro,NOW() ) as dias , 
	TIMEDIFF(NOW(),data_cadastro ) as horas ,
	DATEDIFF(data_cadastro,data_hora_fim ) as dias_concluidas,
	TIMEDIFF(data_hora_fim,data_cadastro ) as horas_concluidas
	
	
	FROM projetos_atividades WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	
	$p = mysql_fetch_object(mysql_query("SELECT * FROM projetos WHERE id='".$registro->projeto_id."'"));
	
	$c = mysql_fetch_object(mysql_query("SELECT razao_social,id FROM cliente_fornecedor WHERE id='".$p->cliente_fornecedor_id."'"));



	$a_q = mysql_query("SELECT nome,id FROM projetos_atividades_tipos WHERE id='".$registro->atividade_tipo_id."'");
	
	$a=mysql_fetch_object($a_q);
	
	$u = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE id='".$registro->funcionario_id."'"));
	$criador = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE id='".$registro->usuario_id_cadastrou."'"));

}


if($_POST[comentario_executor]||$_POST[aguardando_resposta]){
	editaexecutor($_POST);
}
	

?>