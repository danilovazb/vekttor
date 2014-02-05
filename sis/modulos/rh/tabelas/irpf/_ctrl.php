<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']== 'Salvar'){
	manipulaIrpf($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiIrpf($_POST,$vkt_id);
}

if($id>0){
	
	
	$irpf = mysql_fetch_object(mysql_query($t="SELECT * FROM  rh_irpf WHERE id='$id'"));
	//echo $t;
	
}

?>