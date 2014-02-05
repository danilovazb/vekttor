<?php
include("../../../_config.php");
include("../../../_functions_base.php");

		if($_POST['acao'] == "update"){
			$id = $_POST['id'];
			//data hora inicio
				$DataHoraInicio = $_POST['dataInicio']." ".$_POST['horaInicio'];
			//data hora fim
				$DataHoraFim = $_POST['dataFim']." ".$_POST['horaFim']; 
				
				mysql_query(" UPDATE agenda_agendamento SET data_hora_inicio = '$DataHoraInicio', data_hora_fim = '$DataHoraFim' WHERE id = '$id'");
		
		}
		else if($_POST['acao'] == "updateResize"){
				$id = $_POST['id'];
				$dara_hora_fim = $_POST['dataFim']." ".$_POST['horaFim'];
				$sql = " UPDATE agenda_agendamento SET data_hora_fim = '$dara_hora_fim' WHERE id = '$id'"; 	
				mysql_query($sql);
		}
		else if($_POST['acao'] == "busca_cliente"){
			    global $vkt_id;
				$lista = array();
				$cliente = $_POST['cliente_id'];
				$sql = mysql_query($t=" SELECT * FROM agenda_agendamento WHERE vkt_id = '$vkt_id' AND cliente_id = '$cliente'");
				while($item=mysql_fetch_object($sql)){
						$cliente_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '".$item->cliente_id."' AND cliente_vekttor_id = '$vkt_id'"));
						$agenda = mysql_fetch_object(mysql_query(" SELECT * FROM agenda WHERE id = '".$item->agenda_id."'"));
						
						$dataHoraInicio = explode(" ",$item->data_hora_inicio);
						$dataHoraFim = explode(" ",$item->data_hora_fim);
						
						$eventsArray['id'] = $item->id;
						$eventsArray['titulo'] = utf8_encode(substr($item->nota_adicional,0,30));
						$eventsArray['hora_inicio'] = dataUsaToBr($dataHoraInicio[0])." - ".$dataHoraInicio[1];
						$eventsArray['hora_fim']   = dataUsaToBr($dataHoraFim[0])." - ".$dataHoraFim[1];
						$eventsArray['agenda'] =  substr($agenda->nome,0,25);
						$eventsArray['cliente'] = utf8_encode(substr($cliente_nome->nome_fantasia,0,30));
						$eventsArray['agenda_id'] = ($item->agenda_id);
						$lista[] = $eventsArray;
				}
				echo json_encode($lista);
				//print_r($lista);
				//echo $t;
		}
?>