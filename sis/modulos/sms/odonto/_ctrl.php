<?

//Altera Usuario
if($_POST['action'] == 'Salvar'){
	
}


if($_POST['action']=='Excluir'){
		excluir($_POST['id']);		
}

if($_POST['action'] == 'Anexar'){
	
}

if($_GET['id'] > 0){
	$id = $_GET['id'];
	$sms_edit = mysql_fetch_object(mysql_query(" SELECT * FROM  rel_sms WHERE id = '$id' "));
	$clientes = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$sms_edit->cliente_id' "));
	$mes_aniversario = explode("-",$clientes->nascimento);
	
}

if($_GET['contato_id']>0){
	
}
?>