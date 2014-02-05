<?

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_projeto($_POST);
	}else{
		insere_projeto($_POST);
	}
}
if($_POST['action']== 'Excluir'){
	deletar_projeto($_POST['id']);
}

if($_GET['id']>0){
	
	$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT *, TIME_FORMAT(tempo,'%H:%i') as tempo FROM projetos WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	$c = mysql_fetch_object(mysql_query("SELECT razao_social,id FROM cliente_fornecedor WHERE id='".$registro->cliente_fornecedor_id."'"));
}


?>