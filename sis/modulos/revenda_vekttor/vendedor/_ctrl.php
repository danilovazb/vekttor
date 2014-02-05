<?
//Ações do Formulário

//Recebe ID

if($_POST['action']=='Salvar'){
		if($_POST['id'] > 0)
			update($_POST);
		else
			cadastra($_POST);
}
//Altera Usuario
if($_POST['action']=='Excluir'){
		excluir($_POST['id']);		
}

if($_GET['id'] > 0){
	$id = $_GET['id'];
	$vendedor = mysql_fetch_object(mysql_query(" SELECT * FROM rh_funcionario WHERE id= '$id' "));
	$cliente_vendedor = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$vendedor->cliente_fornecedor_id'"));
	$usuario = mysql_fetch_object(mysql_query(" SELECT * FROM usuario WHERE id = '$cliente_vendedor->usuario_id'"));
}
?>