<?php

if($_POST['acao']=='movimentacoes'){
	
	include("_functions.php");
	// funções base do sistema
	echo consultaMovimentacoes($_POST);
	
}
?>