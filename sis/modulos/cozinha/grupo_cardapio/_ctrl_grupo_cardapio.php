<?
if(isset($_GET['id'])){$id=$_GET['id'];}

if(isset($_POST['id'])){$id=$_POST['id'];}

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_grupo_cardapio($id,$_POST );
	}else{
		cadastra_grupo_cardapio($_POST['nome'],$_POST );	
	}
}
if($_POST['action']== 'Excluir'){
	deleta_grupo_cardapio($_POST['id']);
}

if($id>0){
	$grupo_cardapio = mysql_fetch_object(mysql_query($trace="SELECT * FROM cozinha_cardapios_grupos WHERE id='$id'"));	
	//echo $trace;
}
//if($_GET['id']>0){
	
	/*$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT *,date_format(data_hora_inicio,'%H:%i' ) as hora_inicio,date_format(data_hora_fim,'%H:%i' ) as hora_fim  
	FROM projetos_atividades WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	
	$p = mysql_fetch_object(mysql_query("SELECT * FROM projetos WHERE id='".$registro->projeto_id."'"));
	
	$c = mysql_fetch_object(mysql_query("SELECT razao_social,id FROM cliente_fornecedor WHERE id='".$p->cliente_fornecedor_id."'"));



	$a_q = mysql_query("SELECT nome,id FROM projetos_atividades_tipos WHERE id='".$registro->atividade_tipo_id."'");
	
	$a=mysql_fetch_object($a_q);
	
	$u = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE id='".$registro->funcionario_id."'"));*/
//}

	

?>