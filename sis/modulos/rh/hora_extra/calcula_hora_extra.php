<?php
	//Includes
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	global $vkt_id;

	$hora_entrada        = $_POST['hora_entrada'];
	$hora_saida_almoco   = $_POST['hora_saida_almoco'];
	$hora_retorno_almoco = $_POST['hora_retorno_almoco'];
	$empresa_id			 = $_POST['empresa_id'];
	$funcionario_id		 = $_POST['funcionario_id'];
	$data_hora_extra	 = DataBrToUsa($_POST['data_hora_extra']);
	$hora_saida          = $_POST['hora_saida'];
		
	$falta_justificada   = $_POST['falta_justificada'];
	$faltas              = $_POST['faltas'];
	//verifica se já há algum cadastro no tabela rh_hora_extra com 
	//esta empresa, funcionario e data
	$hora_extra = mysql_query($t="SELECT * FROM rh_hora_extra WHERE empresa_id='$empresa_id' AND funcionario_id='$funcionario_id' AND data='$data_hora_extra' AND vkt_id='$vkt_id'");
	//echo $t;
	//calcula horas_trabalhadas	
	//$horas_total = mysql_fetch_object(mysql_query("SELECT TIME_TO_SEC(TIMEDIFF('12:25:01','07:01:01'))/60/60"));
	
	
	//caso encontre não encontre registro, adiciona na tabela
	if(!mysql_num_rows($hora_extra)>0){
		$inicio = "INSERT INTO";
		$fim    ="";
	//caso encontre,
	}else{
		
		$inicio = "UPDATE";
		$fim    ="WHERE empresa_id='$empresa_id' AND funcionario_id='$funcionario_id' AND data='$data_hora_extra'";
	}
	
	//calcula o saldo no formato decimal
	$saldo_manha = mysql_fetch_object(mysql_query($t="SELECT TIME_TO_SEC(TIMEDIFF('$hora_saida_almoco','$hora_entrada'))/60/60 as saldo_manha"));
	//echo $t;
	$saldo_tarde = mysql_fetch_object(mysql_query("SELECT TIME_TO_SEC(TIMEDIFF('$hora_saida','$hora_retorno_almoco'))/60/60 as saldo_tarde"));
	
		
	if($saldo_tarde->saldo_tarde < 0){
	
		//$saldo_tarde->saldo_tarde*=(-1);
		$saldo_tarde = mysql_fetch_object(mysql_query("SELECT TIME_FORMAT(TIMEDIFF('24:00','$hora_retorno_almoco'),'%H:%i') as saldo_tarde"));
		$saldo_tarde = $saldo_tarde->saldo_tarde;
		$saldo_tarde = mysql_fetch_object(mysql_query($t="SELECT TIME_TO_SEC(ADDTIME('$saldo_tarde','$hora_saida'))/60/60 as saldo_tarde"));
		
	}
	$adicional_noturno = 0;
	if($saldo_tarde->saldo_tarde>0&&$hora_saida>=22&&$hora_saida<24){
		$hora_saida = explode(":",$hora_saida);
		$hora_saida = $hora_saida[0]+$hora_saida[1]/60;   
		$adicional_noturno = $hora_saida-22;
		//echo "$adicional_noturno = $hora_saida-22";
	}else if($saldo_tarde->saldo_tarde>0&&$hora_saida>=0&&$hora_saida<=5){
		$hora_saida = explode(":",$hora_saida);
		$hora_saida = $hora_saida[0]+$hora_saida[1]/60;
		$adicional_noturno = $hora_saida+2;
		//echo "$adicional_noturno = $hora_saida+2";
	}
	
		
	$total_dia   = $saldo_manha->saldo_manha+$saldo_tarde->saldo_tarde; 	
			
	$diasemana = mysql_fetch_object(mysql_query($t="SELECT DAYNAME('$data_hora_extra') as dia_semana, DAYOFWEEK('$data_hora_extra') as numero_dia_semana"));
	
	$numero_diasemana = $diasemana->numero_dia_semana;
	
	$diasemana = $diasemana->dia_semana;
	
	$data_feriado = explode("-",$data_hora_extra);
	$feriado   = mysql_fetch_object(mysql_query($t="SELECT  * FROM rh_feriado WHERE vkt_id = $vkt_id AND dia='".$data_feriado[2]."' AND mes='".$data_feriado[1]."'"));
	
	//echo $data_hora_extra;
	//calcula o saldo baseado nas horas trabalhadas e no dia
	
	$hora_extra_100 = '0';
	
	//verifica se a falta é igual a 1 ou 0
	if($faltas == '0' || $falta_justificada == '0'){
	//verifica se o dia ad semana é domingo ou feriado
		if($diasemana == 'Sunday'||$feriado->id >0 ){
			//caso verdadeiro, o saldo é igual ao total de horas trabalhadas.
			$saldo_dia = $total_dia;
			$hora_extra_100 = '1';
	
		//caso o dia da semana não seja sábado nem domingo, verifica se o número de horas trabalhadas é maior ou igual a 8
		}
		//verifica se as horas trabalhadas é maior ou igual a quatro e se o dia da semana é sabado
		else if($total_dia>=4&&$diasemana=='Saturday'){
	
			//caso verdadeiro, subtrai a hora total de 4.
			$saldo_dia = $total_dia - 4;
			//$saldo_dia = 4-$total_dia;
		//verifica se as horas trabalhadas é menor ou igual a quatro e se o dia da semana é sabado
		}else if($total_dia<4&&$diasemana=='Saturday'){
		//caso verdadeiro, subtrai a hora total de 4.
			if($total_dia>0){
				$saldo_dia = 4-$total_dia;			
			}else{
				$saldo_dia = 0;
			}
		//$saldo_dia = $total_dia - 4;
	
		}else if($total_dia > 8){
		
			//caso verdadeiro, subtrai as horas trabalhadas de 8
			$saldo_dia = $total_dia - 8;
	
		}else{
		
			$saldo_dia = $total_dia - 8 ;
			
		}
	}else{
		$total_dia =0;
		$saldo_dia =0;
		$adicional_noturno=0;
		$hora_extra_100=0;
	}
	
	$horas_100=$horas_50="00:00";
	
	if($saldo_dia>0&&(!$feriado->id>0)&&$numero_diasemana!=1){
			
			$horas_50 = $saldo_dia;
			
			$horas_50 = $horas_50*60*60;
											
			$horas_50 = mysql_result(mysql_query("SELECT TIME_FORMAT(SEC_TO_TIME('$horas_50'),'%H:%i')"),0,0);
	}
	if($saldo_dia>0&&($feriado->id>0||$numero_diasemana==1)){
			
			$horas_100 = $saldo_dia;
			
			$horas_100 = $horas_100*60*60;
												
			$horas_100 = mysql_result(mysql_query("SELECT TIME_FORMAT(SEC_TO_TIME('$horas_100'),'%H:%i')"),0,0);
	}
		
	
	$adicional_noturno2 = explode(",",$adicional_noturno);
	
	$horas_adicional_noturno = $adicional_noturno-$adicional_noturno2[1];
	
	$minutos_adicional_noturno = $adicional_noturno-$adicional_noturno2[0];	
	$minutos_adicional_noturno = ceil($minutos_adicional_noturno);
	
	$adicional_noturno = ($horas_adicional_noturno*60*60)+($minutos_adicional_noturno*60);
		
	mysql_query($t="
	$inicio
		rh_hora_extra
	SET
		vkt_id              = '$vkt_id',
		hora_entrada        = '$hora_entrada',
		hora_saida_almoco   = '$hora_saida_almoco',
		hora_retorno_almoco = '$hora_retorno_almoco',
		hora_saida          = '".$_POST['hora_saida']."',
		empresa_id          = '$empresa_id',
		funcionario_id      = '$funcionario_id',
		data                = '$data_hora_extra',
		total               = '$total_dia',
		saldo_horas         = '$saldo_dia',
		falta_integral      = '$faltas',
		falta_justificada   = '$falta_justificada',
		adicional_noturno   = '$adicional_noturno',
		hora_extra50        = '$horas_50',
		hora_extra_100      = '$horas_100'
	$fim");
	//echo $t." ".mysql_error();
	
	$horas_adicional_noturno = (int)($adicional_noturno/60/60);
	if($horas_adicional_noturno<10){
		$horas_adicional_noturno = "0".$horas_adicional_noturno;
	}
	$minutos_adicional_noturno = ($adicional_noturno/60%60);
	if($minutos_adicional_noturno<10){
		$minutos_adicional_noturno = "0".$minutos_adicional_noturno;
	}
	$adicional_noturno = $horas_adicional_noturno.":".$minutos_adicional_noturno;
	
	
	
	$retorno = 
		array("total_dia"=>decimal_hora($total_dia),
			  "horas50"=>$horas_50,
			  "horas100"=>$horas_100,
			  "saldo_dia"=>decimal_hora($saldo_dia),
			  "feriado"=>$feriado->id,
			  "dia_semana"=>$numero_diasemana,
			  "adicional_noturno"=>$adicional_noturno
	
	);
	
	echo json_encode($retorno);
	
	
	//	echo $total_dia.'|'.$saldo_dia;

		
?>