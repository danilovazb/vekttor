<?php
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;

if($_GET['ordem']=='1'){
	//alert($_GET['extensao']);
	mysql_query($t="UPDATE sis_modulos_tutorial SET extensao1='' WHERE id='".$_GET['id']."'");
	//alert("modulos/vekttor/item_menu/tutorial/".$_GET['id'].$_GET['extensao']);
	unlink("tutorial/".$_GET['id'].$_GET['extensao']);
	//alert($t);
}
if($_GET['ordem']=='2'){
	mysql_query($t="UPDATE sis_modulos_tutorial SET extensao2='' WHERE id='".$_GET['id']."'");
	unlink("tutorial/".$_GET['id'].$_GET['extensao']);
	//alert($t);
}
?>
