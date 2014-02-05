<?php
function manipula_agenda_visita($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
		$status="pendente";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
		$status=$dados[status_visita];
	}
	
	mysql_query($t="$inicio os_agenda_visita SET
		vkt_id='$vkt_id',
		funcionario_id='$dados[tecnico_id]',
		cliente_id='$dados[cliente_id]',
		data_visita='".dataBrToUsa($dados[data_visita])."',
		hora_inicial='$dados[hora_inicial]',
		hora_final='$dados[hora_final]',
		motivo_visita='$dados[motivo_visita]',
		observacao='$dados[obs]',
		status_visita='$status'
		$fim");

	if($dados[imp]==1){
		$id=mysql_insert_id();
		echo "<script>window.open('modulos/ordem_servico/relatorios/form_visita.php?id=$id','_BLANK')</script>";
	}
}

function exclui_agenda_visita($_POST,$vkt_id){
	mysql_query("DELETE FROM os_agenda_visita WHERE id='$_POST[id]' AND vkt_id='$vkt_id'");
}

function horas_tecnico($tecnico_id,$data,$vkt_id){
	
	$horas = mysql_query($t="SELECT id,hora_inicial,hora_final FROM 
							os_agenda_visita 
						 WHERE
						 	funcionario_id = $tecnico_id 
							AND data_visita='".$data."'
							AND vkt_id='$vkt_id'");
		
	return $horas;
}
?>