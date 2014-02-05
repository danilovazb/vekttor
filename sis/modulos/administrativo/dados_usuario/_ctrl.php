<?
//Ações do Formulário

//Recebe ID
if($_POST['usuario_id'])$usuario_id=$_POST['usuario_id'];
if($_GET['usuario_id'])$usuario_id=$_GET['usuario_id'];
//Cadastra Novo Cliente
//Altera Usuario
if($_POST['action']=='Salvar'){
	
	ManipulaUsuario($_POST);
		
}

if(isset($usuario_id)){
	$usuario = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE id='$usuario_id'"));
}
?>