<?
//Includes
$dentes = array("11"=>"Incisivo central",
				"12"=>"Incisivo lateral",
				"13"=>"Canino",
				"14"=>"1&ordm; Pré-molar",
				"15"=>"2&ordm; Pré-molar",
				"16"=>"1&ordm; Molar",
				"17"=>"2&ordm; Molar",
				"18"=>"3&ordm; Molar",
				"21"=>"Incisivo Central",
				"22"=>"Incisivo Lateral",
				"23"=>"Canino",
				"24"=>"1&ordm; Pré-molar",
				"25"=>"2&ordm; Pré-molar",
				"26"=>"1&ordm; Molar",
				"27"=>"2&ordm; Molar",
				"28"=>"3&ordm; Molar",
				"31"=>"Incisivo Central",
				"32"=>"Incisivo Lateral",
				"33"=>"Canino",
				"34"=>"1&ordm; Pré-molar",
				"35"=>"2&ordm; Pré-molar",
				"36"=>"1&ordm; Molar",
				"37"=>"2&ordm; Molar",
				"38"=>"3&ordm; Molar",
				"41"=>"Incisivo Central",
				"42"=>"Incisivo Lateral",
				"43"=>"Canino",
				"44"=>"1&ordm; Pré-molar",
				"45"=>"2&ordm; Pré-molar",
				"46"=>"1&ordm; Molar",
				"47"=>"2&ordm; Molar",
				"48"=>"3&ordm; Molar",
				"49"=>"Boca Inteira",
				"50"=>"Maxilar",
				"51"=>"mandíbula");
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
$atendimento_id = $_GET['atendimento_id'];
$procedimentos = mysql_query($t="SELECT * FROM odontologo_atendimento_item WHERE odontologo_atendimento_id = $atendimento_id AND aprovado='1'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Procedimentos Realizados</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
	#procedimentos{
		border-collapse:collapse;
		margin-left:auto;
		margin-right:auto;
	}
	
	#procedimentos tr td{		
		border:#000 solid 1px;
		text-align:center;
	}
</style>
</head>

<body>
<table id="procedimentos">
	
    <thead>
		<tr>
    		<td width="150">Data</td>
    		<td width="500">Evolução e Intercorrências do Tratamento</td>
    		<td>Assinatura do Paciente ou Responsável</td>
    	</tr>
	</thead>
    <tbody>
	<?php
		
		//echo $t;
		$c=0;
		while($procedimento = mysql_fetch_object($procedimentos)){
			$servico = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id='$procedimento->servico_id'"));
	?>    
		<tr>
    		<td width="150"></td>
    		<td width="500" align="left"><?=$procedimento->dente_id." ".$dentes[$procedimento->dente_id]." (".$face[$procedimento->face_id].") <strong> | </strong> ".utf8_encode($servico->nome)?></td>
    		<td></td>
    	</tr>
     <?
			$c++;
			if($c%30==0){
				echo "<br style='page-break-before:always;'>";
			}
		}
	 	
	 ?>
     
	</tbody>	
</table>
</body>
</html>