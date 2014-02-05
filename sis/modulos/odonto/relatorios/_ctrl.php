<?php
	if($_GET['acao']=='altera_valor_convenio'){
		include("_functions.php");
		altera_valor_convenio($_GET);
		exit();
	}
?>