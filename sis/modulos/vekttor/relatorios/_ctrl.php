<?
//Ações do Formulário

//Recebe ID
if($_POST['cliente_id'])$cliente_vekttor_id=$_POST['cliente_id'];
if($_GET['cliente_id'])$cliente_vekttor_id=$_GET['cliente_id'];
//Cadastra Novo Cliente
if($_POST['action']=='Salvar'&&empty($cliente_vekttor_id)){
		ManipulaCliente($_POST,0,$_POST[modulo_id]);
}
//Altera Usuario
if($_POST['action']=='Salvar'&&$cliente_vekttor_id>0){
		ManipulaCliente($_POST,$cliente_vekttor_id,$_POST[modulo_id]);
		
}

if($_POST['action']=='Excluir'){
	ExcluiCliente($_POST);	
}
if(isset($cliente_vekttor_id)){
	$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE ID='$cliente_vekttor_id'"));
	$tipo_usuario = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario_tipo WHERE vkt_id='".$cliente_vekttor->id."' ORDER BY id "));
	//echo $t;
	$usuario = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id='".$cliente_vekttor->id."'"));
	//echo $t."<br>";
}
?>