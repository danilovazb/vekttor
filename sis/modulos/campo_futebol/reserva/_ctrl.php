<?php
//pr($_POST);
	if($_POST["action"] == "Salvar"){
		if( $_POST["id"] > 0 ){
			
			UpadteReserva($_POST);
		}
		else{
		//	print_r($_POST);
			CadastraReservaCampo($_POST);
		}
	}
	
	if($_POST["action"] == "Excluir"){
		DeleteReserva($_POST["id"]);
	}
	
	if($_GET["id"] > 0){
		$id = $_GET["id"];
		$reserva = mysql_fetch_object(mysql_query($t=" SELECT 
		*,DATE_FORMAT(reserva.data_cadastro_reserva, '%d/%m/%Y') AS data_reserva, reserva.valor AS valor_total,
		reserva.valor_reserva AS valor_da_reserva,
		reserva.id AS reserva_id  
		FROM ".TBL_RESERVA." AS reserva 
		JOIN cliente_fornecedor AS cliente ON reserva.cliente_fornecedor_id = cliente.id
		WHERE reserva.id = {$id} AND reserva.vkt_id = ".VKT_ID." "));
		
			//echo $configuracao->conta_id;*/
	}
	$configuracao = mysql_fetch_object(mysql_query("
			SELECT 
				* 
			FROM 
				campo_futebol_reserva_config_pagamento
			WHERE vkt_id='$vkt_id'"));

?>