<?php
if($_POST['salva_formulario_contrato_cliente']>0){
	
	manipulaConfiguracao($_POST);
	
}
$configuracao_relacionamento = mysql_fetch_object(mysql_query("SELECT * FROM configuracao_relacionamento WHERE vkt_id='$vkt_id'"));
?>