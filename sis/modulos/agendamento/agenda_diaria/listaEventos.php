<?php
include("../../../_config.php");
	$and = "";
	if(!empty($_GET['agenda_id'])){
		$agenda_id = $_GET['agenda_id'];
		$and .= " WHERE agenda_id = '$agenda_id'  ";
	} else{
		$and .= " WHERE agenda_id = '0'  ";
	}

$sql = mysql_query($t=" SELECT * FROM agenda_agendamento $and ");
		
		$events = array();
		while($evento=mysql_fetch_object($sql)){
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '".$evento->cliente_id."'"));
					if(strlen($evento->nota_adicional)>0){
						$separador= ' - ';
					}else{
						$separador= '';
					}
					
					$eventsArray['id'] = $evento->id;
					$eventsArray['title'] = utf8_encode($cliente-> nome_fantasia .$separador.$evento->nota_adicional);
					$eventsArray['start'] = $evento->data_hora_inicio;
					$eventsArray['end']   = $evento->data_hora_fim;
					$eventsArray['allDay'] = false;
					$eventsArray['cliente'] = $cliente-> nome_fantasia ;
					$events[] = $eventsArray;
		}
		echo json_encode($events);
?>