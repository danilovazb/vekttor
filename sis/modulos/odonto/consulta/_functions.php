<?php
function Quantidade($agenda_id,$data,$status){
		global $vkt_id;
		global $usuario_id;
		if($agenda_id>0){
			$agenda = " AND agenda_id = '$agenda_id'";
		}
		//if($status!='Toda a Fila'){
			$status_fila = " AND status = '$status'";
		//}
		$quantidade = @mysql_num_rows(mysql_query($t="SELECT * FROM 
		odontologo_fila_espera 
		WHERE
		 
		data_chegada = '".dataBrToUsa($data)."' AND
		vkt_id='$vkt_id' AND 
		usuario_id=$usuario_id
		$agenda
		$status_fila
		"));
		//echo $t."<br>";
		if($quantidade>0){
			return $quantidade;
		}else{
			return 0;
		}
}

function manipulaFila($dados){
	global $vkt_id;
	global $usuario_id;
	
	//seleciona o último da fila
	$ultimo_numero_fila = mysql_fetch_object(mysql_query($t="SELECT ordem_de_atendimento FROM 
		odontologo_fila_espera 
		WHERE
		data_chegada =  '".date('Y-m-d')."' AND
		usuario_id='$usuario_id' AND
		vkt_id='$vkt_id' ORDER BY ordem_de_atendimento DESC LIMIT 1"));
		//echo $t;
	
	
	if(!empty($dados['id'])){
		$inicio = "UPDATE";$fim="WHERE id=$dados[id]";	
		
	//echo $proximo;
	}else{
		$proximo = $ultimo_numero_fila->ordem_de_atendimento+1;
		$inicio = "INSERT INTO";$fim=",ordem_de_atendimento = '$proximo',status = 'Em espera'";
	}
	
	mysql_query($t=" $inicio odontologo_fila_espera
	SET
	vkt_id               = '$vkt_id',
	usuario_id           = '$usuario_id',
	agenda_id            = '$dados[agenda_id]',
	cliente_fornecedor_id = '$dados[cliente_id]',
	observacao           = '$dados[observacao]',
	data_chegada         =  '".date('Y-m-d')."',
	hora_chegada         =  '".date('H:i')."'
	$fim");
	//echo $t." ".mysql_error();
}

function EnviaAtendimento($id){
	$tempo_espera = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('".date('H:i')."',hora_chegada) tempo_espera FROM odontologo_fila_espera WHERE id='$id'"));
	mysql_query($t="UPDATE  odontologo_fila_espera SET status = 'Em Atendimento', data_atendimento = '".date('Y-m-d')."', hora_atendimento =  '".date('H:i')."', tempo_espera = '$tempo_espera->tempo_espera' WHERE id=$id");
	//echo $t;
}

function ConcluiAtendimento($id){
	$tempo_atendimento = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('".date('H:i')."',hora_atendimento) tempo_atendimento FROM odontologo_fila_espera WHERE id='$id'"));
	mysql_query($t="UPDATE  odontologo_fila_espera SET status = 'Concluido', data_conclusao = '".date('Y-m-d')."', hora_conclusao =  '".date('H:i')."',tempo_atendimento = '$tempo_atendimento->tempo_atendimento' WHERE id=$id");
	//echo $t;
}

function CancelarAtendimento($id){
	mysql_query($t="UPDATE  odontologo_fila_espera SET status = 'Cancelado' WHERE id=$id");
	//echo $t;
}
?>