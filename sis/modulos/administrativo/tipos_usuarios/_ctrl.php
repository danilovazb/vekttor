<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$usuario_tipo_id=$_POST['id'];
if($_GET['id'])$usuario_tipo_id=$_GET['id'];
if($_POST['usuario_tipo_id'])$usuario_tipo_id=$_POST['usuario_tipo_id'];
if($_GET['usuario_tipo_id'])$usuario_tipo_id=$_GET['usuario_tipo_id'];


//Cadastra Novo Usuario
if($_POST['action']=='Salvar'&&empty($usuario_tipo_id)){
	$cadastra=cadastraUsuarioTipo($_POST['nome'],$_POST[modulo_id]);
	salvaUsuarioHistorico("Formulário - Tipo de Usuário","Salvou um Novo",'','');
}
//Altera Usuario
if($_POST['action']=='Salvar'&&isset($usuario_tipo_id)){
	$altera=alteraUsuarioTipo($usuario_tipo_id,$_POST['nome'],$_POST[modulo_id]);
	salvaUsuarioHistorico("Formulário - Tipo de Usuário","Alterou o ID $usuario_tipo_id",'','');
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($usuario_tipo_id)){
	$exclui=excluiUsuarioTipo($usuario_tipo_id);
	salvaUsuarioHistorico("Formulário - Tipo de Usuário","Excluiu o ID $usuario_tipo_id",'','');
}
//Pega informações
if($usuario_tipo_id>0){
	$usuario_tipo=mysql_fetch_object(mysql_query("SELECT * FROM usuario_tipo WHERE id='".$usuario_tipo_id."' and vkt_id='$vkt_id' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Tipo de Usuário","Abriu o ID $usuario_tipo_id",'','');
}

?>