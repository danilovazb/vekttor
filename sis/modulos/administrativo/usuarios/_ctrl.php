<?
if($_POST['usuario_id']>0){$usuario_id=$_POST['usuario_id'];}else{$usuario_id=0;}
if($_GET['usuario_id']>0&&$usuario_id==0){$usuario_id=$_GET['usuario_id'];}
//Cadastra Novo Usuario
if($_POST['action']=='Salvar'&& $usuario_id<1){
	cadastraUsuario($_POST['nome'],$_POST['usuario_tipo'],$_POST['obra'],$_POST['login'],$_POST['senha']);
	salvaUsuarioHistorico("Formulário - Usuário","Salvou um Novo","usuario",$usuario_id);
}
//Altera Usuario
if($_POST['action']=='Salvar' && $usuario_id>0){
	alteraUsuario($usuario_id,$_POST['nome'],$_POST['usuario_tipo'],$_POST['obra'],$_POST['login'],$_POST['senha']);
	salvaUsuarioHistorico("Formulário - Usuário","Alterou o ID $usuario_id","usuario",$usuario_id);
}
//Exclui Usuario
if($_POST['action']=='Excluir' && $usuario_id>0){
	excluiUsuario($usuario_id);
	salvaUsuarioHistorico("Formulário - Usuário","Excluiu o ID $usuario_id","usuario",$usuario_id);
}
//Pega informações
if($usuario_id>0){
	$usuario=mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE id='".$usuario_id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Usuário","Abriu o ID $usuario_id","usuario",$usuario_id);
}
?>