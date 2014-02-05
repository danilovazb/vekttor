<?php
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;

if($_GET['img']=='cabecalho'){
	mysql_query($t="UPDATE aluguel_configuracao SET img_cabecalho='' WHERE id='$vkt_id'");
	unlink('img/'.$vkt_id."_c.".$_GET['extensao']);
	//alert($t);
}
if($_GET['img']=='rodape'){
	mysql_query($t="UPDATE aluguel_configuracao SET img_rodape='' WHERE id='$vkt_id'");
	unlink('img/'.$vkt_id."_r.".$_GET['extensao']);
	//alert($t);
}
?>
