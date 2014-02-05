<?php
function Quantidade($agenda_id,$data,$status,$filtro_campo){
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
		$filtro_campo
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
	
	//seleciona o usuário_id que vai cadastrar na fila
	//este usuario_id refere-se ao "superusuario"
	$cliente = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id='$vkt_id' ORDER BY id ASC LIMIT 1"));
	
	$s=mysql_query("SELECT * FROM odontologo WHERE vkt_id='$vkt_id'");
	//seleciona o último da fila
	$ultimo_numero_fila = mysql_fetch_object(mysql_query($t="SELECT ordem_de_atendimento FROM
			odontologo_fila_espera
		WHERE
			data_chegada =  '".date('Y-m-d')."' AND
			usuario_id='$cliente->id' AND
			vkt_id='$vkt_id'
		ORDER BY 
			ordem_de_atendimento 
		DESC LIMIT 1"));
			
	if(!empty($dados['id'])){
		$inicio = "UPDATE";$fim="WHERE id=$dados[id]";	
	}else{
		$proximo = $ultimo_numero_fila->ordem_de_atendimento+1;
		$inicio = "INSERT INTO";$fim=",ordem_de_atendimento = '$proximo',status = 'Em espera'";
	}
	
	mysql_query($t=" $inicio odontologo_fila_espera
	SET
	vkt_id               = '$vkt_id',
	usuario_id           = '$cliente->id',
	agenda_id            = '$dados[agenda_id]',
	cliente_fornecedor_id = '$dados[cliente_id]',
	observacao           = '$dados[observacao]',
	data_chegada         =  '".date('Y-m-d')."',
	hora_chegada         =  '".date('H:i')."'
	$fim");
	//echo $t." ".mysql_error();
}

function EnviaAtendimento($dados){
	global $vkt_id;
	$tempo_espera = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('".date('H:i')."',hora_chegada) tempo_espera FROM odontologo_fila_espera WHERE id='$id'"));
	mysql_query($t="UPDATE odontologo_fila_espera SET status = 'Em Atendimento', data_atendimento = '".date('Y-m-d')."', hora_atendimento =  '".date('H:i')."', tempo_espera = '$tempo_espera->tempo_espera',
	cliente_fornecedor_id = '$dados[cliente_id]'
	 WHERE id=$dados[id]");
	//echo $t."<br>";
	//$atendimento_id=mysql_result(mysql_query($t="SELECT id FROM odontologo_atendimentos WHERE cliente_fornecedor_id='$dados[cliente_id]' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"),0,0);
	//echo $t." ".mysql_error();
	//mysql_query("INSERT INTO odontologo_atendimentos SET vkt_id='$vkt_id', cliente_fornecedor_id='$dados[cliente_id]'");
	
	/*if($atendimento_id>0){
		echo "<script>window.open('modulos/odonto/atendimento/form.php?atendimento_id=".$atendimento_id."','carregador')</script>";
	}elseif($cliente_id>0){
		echo "<script>window.open('modulos/odonto/atendimento/form.php?cliente_id=".$cliente_id."','carregador')</script>";	
	}*/
	
}

function ConcluiAtendimento($id){
	$tempo_atendimento = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('".date('H:i')."',hora_atendimento) tempo_atendimento FROM odontologo_fila_espera WHERE id='$id'"));
	mysql_query($t="UPDATE  odontologo_fila_espera SET status = 'Concluido', data_conclusao = '".date('Y-m-d')."', hora_conclusao =  '".date('H:i')."',tempo_atendimento = '$tempo_atendimento->tempo_atendimento'
	
	 WHERE id=$id");
	//echo $t."<br>";
}

function CancelarAtendimento($id){
	mysql_query($t="UPDATE  odontologo_fila_espera SET status = 'Cancelado' WHERE id=$id");
	//echo $t;
}
?>