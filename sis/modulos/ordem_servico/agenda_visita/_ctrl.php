<?php

if($_POST['action']== 'Salvar'){
	manipula_agenda_visita($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	exclui_agenda_visita($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$agenda = mysql_fetch_object(mysql_query("SELECT * FROM os_agenda_visita WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	$tecnico_id = $agenda->funcionario_id;
	$data = $agenda->data_visita;

}

if($_GET['tecnico_id']>0){
	$tecnico_id = $_GET['tecnico_id'];
	if($_GET['data']){
		$data = dataBrToUsa($_GET['data']);
	}
}
	
if($tecnico_id>0){
	//alert($data);	
	$horas_tecnico  = horas_tecnico($tecnico_id,$data,$vkt_id);
	$horas = array();
	$c=0;
	while($h=mysql_fetch_object($horas_tecnico)){
		$horas[$c]['id'] = $h->id;
		$horas[$c]['hi'] = $h->hora_inicial;
		$horas[$c]['hf'] = $h->hora_final;
		$c++;
	}
	//print_r($horas);
}
?>