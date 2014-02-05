<?

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_colaborador($_POST);
	}
}
if($_POST['action']== 'Excluir'){
	deletar_colaborador($_POST['id']);
}

if($_GET['id']>0){
	
	$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT *,date_format(data_hora_inicio,'%H:%i' ) as hora_inicio,date_format(data_hora_fim,'%H:%i' ) as hora_fim  
	FROM projetos_atividades WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	
	$p = mysql_fetch_object(mysql_query("SELECT * FROM projetos WHERE id='".$registro->projeto_id."'"));
	
	$c = mysql_fetch_object(mysql_query("SELECT razao_social,id FROM cliente_fornecedor WHERE id='".$p->cliente_fornecedor_id."'"));



	$a_q = mysql_query("SELECT nome,id FROM projetos_atividades_tipos WHERE id='".$registro->atividade_tipo_id."'");
	
	$a=mysql_fetch_object($a_q);
	
	$u = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE id='".$registro->funcionario_id."'"));
}

	

?>