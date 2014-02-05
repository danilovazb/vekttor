<?php
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
   $sqlEquipamento=mysql_query("SELECT * FROM os_equipamento WHERE vkt_id ='$vkt_id' AND (nome  like '%$_GET[busca_auto_complete]%')  LIMIT 15");
	$i=0;
	while($equipamento= mysql_fetch_object($sqlEquipamento)){
		echo urlencode("$equipamento->nome|$equipamento->id|$equipamento->modelo|$equipamento->marca|$equipamento->numero_serie|\n");
		$i++;
	}
	if($i==0){
		echo urlencode("Nao Encontrado |0|0\n");
	}
?>