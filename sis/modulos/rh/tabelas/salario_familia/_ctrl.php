<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']== 'Salvar'){
	manipulaSalarioFamilia($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiSalarioFamilia($_POST,$vkt_id);
}

if($id>0){
	
	
	$salario_familia = mysql_fetch_object(mysql_query($t="SELECT * FROM  rh_salario_familia WHERE id='$id'"));
	
}

?>