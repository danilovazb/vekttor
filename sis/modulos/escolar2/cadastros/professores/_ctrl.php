<?
if($_POST['funcionario_id']>0){$funcionario_id=$_POST['funcionario_id'];}
if($_GET['funcionario_id']>0){$funcionario_id=$_GET['funcionario_id'];}

if($_POST['action']=="Salvar"){
	cadastraFuncionario($_POST);
}


if($_POST['action']=="Excluir"){
	deletaFuncionario($_POST['professor_id'],$_POST['usuario_id'],$_POST['funcionario_id']);
}

if($funcionario_id>0){
	
	$funcionario=mysql_fetch_object(mysql_query($f="SELECT * FROM rh_funcionario WHERE vkt_id='$vkt_id' AND id='$funcionario_id' "));
	
	$professor=mysql_fetch_object(mysql_query($p="SELECT * FROM escolar2_professores WHERE vkt_id='$vkt_id' AND funcionario_id='$funcionario->id' "));
	
	
	
	$usuario=mysql_fetch_object(mysql_query($lululu="SELECT * FROM usuario WHERE cliente_vekttor_id='$vkt_id' AND id='$professor->usuario_id' "));
}