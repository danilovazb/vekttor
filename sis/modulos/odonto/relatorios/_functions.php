<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");

	function altera_valor_convenio($dados){
		global $vkt_id;
		mysql_query($t="UPDATE odontologo_atendimento_item SET valor_convenio='$dados[valor]' WHERE id='$dados[id]' AND vkt_id='$vkt_id'");
		echo $t;
	}
?>