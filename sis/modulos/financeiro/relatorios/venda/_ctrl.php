<?php

if($_POST['acao']=='movimentacoes'){
	
	include("_functions.php");
	// fun��es base do sistema
	echo consultaMovimentacoes($_POST);
	
}
?>