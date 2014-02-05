<?php

if($_POST['salva_formulario_contrato_aluguel']== '1'){
	manipulaContrato($_POST,$vkt_id);
}

/*if($_GET['id'] > 0){
	$equipamento = mysql_fetch_object(mysql_query("SELECT *, id as equipamento_id FROM aluguel_equipamentos WHERE id='".$_GET['id']."' AND vkt_id='$vkt_id'"));

	$equipamento_itens = mysql_query("SELECT * FROM aluguel_equipamentos_itens WHERE equipamento_id='$equipamento->id' AND vkt_id='$vkt_id' ORDER BY id"); 
}*/

?>