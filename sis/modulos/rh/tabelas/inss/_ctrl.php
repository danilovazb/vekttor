<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']== 'Salvar'){
	manipulaINSS($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiinss($_POST,$vkt_id);
}

if($id>0){
	
	
	$inss = mysql_fetch_object(mysql_query($t="SELECT * FROM  rh_inss WHERE id='$id'"));
	
}

?>