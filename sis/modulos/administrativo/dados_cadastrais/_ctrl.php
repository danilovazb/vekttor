<?
//Ações do Formulário

//Recebe ID
if($_POST['cliente_id'])$cliente_vekttor_id=$_POST['cliente_id'];
if($_GET['cliente_id'])$cliente_vekttor_id=$_GET['cliente_id'];
//Cadastra Novo Cliente
//Altera Usuario
if($_POST['action']=='Salvar'){
	
	ManipulaCliente($_POST,$cliente_vekttor_id,$_POST[modulo_id]);
		
}

if(isset($cliente_vekttor_id)){
	$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$cliente_vekttor_id'"));
}
?>