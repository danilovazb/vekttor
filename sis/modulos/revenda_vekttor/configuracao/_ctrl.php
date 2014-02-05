<?
//Ações do Formulário

//Recebe ID

if($_POST['action']=='Salvar'){
		if($_POST['id'] > 0)
			update($_POST['id']);
		else
			cadastra($_POST);
}
//Altera Usuario
if($_POST['action']=='Excluir'){
		excluir($_POST['id']);		
}

if(isset($cliente_vekttor_id)){
	$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE ID='$cliente_vekttor_id'"));
	$tipo_usuario = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario_tipo WHERE vkt_id='".$cliente_vekttor->id."' ORDER BY id "));
	//echo $t;
	$usuario = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id='".$cliente_vekttor->id."'"));
	//echo $t."<br>";
}
?>