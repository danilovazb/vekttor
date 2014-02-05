<?
if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_tipo_atividade($_POST);
	}else{
		insere_tipo_atividade($_POST);
	}
}
if($_POST['action']== 'Excluir'){
	deletar_tipo_atividade($_POST['id']);
}

if($_GET['id']>0){
	
	$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades_tipos WHERE id='$id' AND vkt_id='$vkt_id'"));
}

?>