<?php

	//Includes
	include("../../../_config.php");
include("../../../_functions_base.php");
	global $vkt_id;

	$hora_entrada        = $_POST['hora_entrada'];
	$hora_saida_almoco   = $_POST['hora_saida_almoco'];
	$hora_retorno_almoco = $_POST['hora_retorno_almoco'];
	$empresa_id			 = $_POST['empresa_id'];
	$funcionario_id		 = $_POST['funcionario_id'];
	$data_hora_extra	 = DataBrToUsa($_POST['data_hora_extra']);
	$hora_saida          = $_POST['hora_saida'];
	$faltas              = $_POST['faltas'];
	//verifica se já há algum cadastro no tabela rh_hora_extra com 
	//esta empresa, funcionario e data
	$hora_extra = mysql_query($t="SELECT * FROM rh_hora_extra WHERE empresa_id='$empresa_id' AND funcionario_id='$funcionario_id' AND data='$data_hora_extra' AND vkt_id='$vkt_id'");
	
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
	
		$saldo_tarde->saldo_tarde*=(-1);
	
	}
	
	$adicional_noturno = 0;
	if($saldo_tarde->saldo_tarde>0&&$hora_saida>=22&&$hora_saida<24){
		
		$adicional_noturno = $hora_saida-22;
		
	}else if($saldo_tarde->saldo_tarde>0&&$hora_saida>=0&&$hora_saida<=5){
		$adicional_noturno = $hora_saida+2;
	}
		
	$total_dia   = $saldo_manha->saldo_manha+$saldo_tarde->saldo_tarde; 	
	
		
	$diasemana = mysql_fetch_object(mysql_query("SELECT DAYNAME('$data_hora_extra') as dia_semana"));
	$diasemana = $diasemana->dia_semana;
	
	$data_feriado = explode("-",$data_hora_extra);
	$feriado   = mysql_fetch_object(mysql_query("SELECT  * FROM rh_feriado WHERE vkt_id = $vkt_id AND dia='".$data_feriado[2]."' AND mes='".$data_feriado[1]."'"));
	//echo $data_hora_extra;
	//calcula o saldo baseado nas horas trabalhadas e no dia
	
	$hora_extra_100 = '0';
	
	//verifica se a falta é igual a 1 ou 0
	if($faltas == '0'){
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
	
	mysql_query($t="
	$inicio
		rh_hora_extra
	SET
		vkt_id              = '$vkt_id',
		hora_entrada        = '$hora_entrada',
		hora_saida_almoco   = '$hora_saida_almoco',
		hora_retorno_almoco = '$hora_retorno_almoco',
		hora_saida          = '$hora_saida',
		empresa_id          = '$empresa_id',
		funcionario_id      = '$funcionario_id',
		data                = '$data_hora_extra',
		total               = '$total_dia',
		saldo_horas         = '$saldo_dia',
		falta_integral      = '$faltas',
		adicional_noturno   = '$adicional_noturno',
		hora_extra_100      = '$hora_extra_100'
	$fim");
	//echo $t;
	$retorno = json_encode(
		array("total_dia"=>MoedaUsaToBr($total_dia),
			  "saldo_dia"=>MoedaUsaToBr($saldo_dia),
			  "adicional_noturno"=>MoedaUsaToBr($adicional_noturno))
	
	);
	
	echo $retorno;
	
	
	//	echo $total_dia.'|'.$saldo_dia;

		
?>