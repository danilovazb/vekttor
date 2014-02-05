<?php

function cadastraAgenda($campos){
				global $vkt_id;
				global $usuario_id;
				$sql=" INSERT INTO agenda SET nome = '$campos[nome_agenda]',vkt_id = '$vkt_id' ,usuario_id = '$usuario_id'";
				mysql_query($sql);
}

function updateAgenda($campos){
				$sql = " UPDATE agenda SET nome = '$campos[nome_agenda]' WHERE id = '$campos[id]'";
				mysql_query($sql);
}


function cadastraEvento($campos){
			global $vkt_id;
				//$sqlAgenda = mysql_query(" INSERT INTO agenda SET vkt_id = '$vkt_id', nome = '$campos[nome_cliente]' ");
				//$agenda_id = mysql_insert_id();
				if(empty($campos['cliente_id'])){
						$campos['cliente_id'] = cadastraCliente($campos);
				}
				/* Insere na Tabela agenda_agendamento */
				$sql_agendamento = mysql_query($t=" INSERT INTO agenda_agendamento SET
													vkt_id         = '$vkt_id',
													agenda_id      = '$campos[agenda_id]',
													cliente_id     = '$campos[cliente_id]',
													nota_adicional = '$campos[evento]',
													data_hora_inicio = '".dataBrToUsa($campos['data_inicio'])." ".$campos['hora_inicio']."',
													data_hora_fim    = '".dataBrToUsa($campos['data_fim'])." ".$campos['hora_fim']."'
													");
													
					
}

function updateEvento($campos){
			global $vkt_id;
			$sql_agendamento = mysql_query($t=" UPDATE agenda_agendamento SET
													vkt_id         = '$vkt_id',
													agenda_id      = '$campos[agenda_id]',
													cliente_id     = '$campos[cliente_id]',
													nota_adicional = '$campos[evento]'
												WHERE 
													id = '$campos[id]'
											");
}

function cadastraCliente($campos){
			global $vkt_id;
			$sql = " INSERT INTO cliente_fornecedor SET razao_social = '$campos[nome_cliente]', nome_fantasia = '$campos[nome_cliente]'";
			mysql_query($sql);
			$cliente_id = mysql_insert_id();
			return $cliente_id;
}
function ExcluiEvento($id){
			global $vkt_id;
			mysql_query(" DELETE FROM agenda_agendamento WHERE id = '$id' AND vkt_id = '$vkt_id'");
}
?>