<?php
include("../../../_config.php");

 /* === 
	Criado por Jaime Neves, antes de alterar qualquer linha de código deste arquivo entre em contato com o autor 
 ===*/	
	
	function aprovar_item(){
		$id = $_POST["id"];
		mysql_query($t=" UPDATE odontologo_atendimento_item SET aprovado = '1' WHERE id = '$id' ");
	}
	
	function item_pendente(){
		$id = $_POST["id"];
		mysql_query($t=" UPDATE odontologo_atendimento_item SET aprovado = '2' WHERE id = '$id' ");
	}
	
	$acao = $_POST["acao"];
	
		switch($acao){
			case "aprovar":
				aprovar_item();
			break;
			case "pendente":
				item_pendente();
			break; 
		}

?>