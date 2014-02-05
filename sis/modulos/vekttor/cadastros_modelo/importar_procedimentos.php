<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	$file = file("vrpo_estadopr.csv");
	$cod_grupo = "36";
	
	$cont=count($file);
	
	for($l=0;$l<$cont;$l++){
		$linha =substr($file[$l],0,strlen($file[$l])-2);
		$linha  =explode(" ",$linha);
		$ultimo_indice = sizeof($linha)-1;
		
		$codigo = $linha[0];
		
		$nome = "";
		for($i=1;$i<$ultimo_indice;$i++){
			$nome .= $linha[$i]." ";
		}
		//retira o espaço do final
		$nome = substr($nome,0,strlen($nome)-1);
		
		$nome2 = str_replace("."," ",$nome);
		$valor  = moedaBrToUsa($linha[$ultimo_indice]-1);
		
		$t="INSERT INTO servico SET vkt_id='1',codigo_interno='$codigo', nome='$nome2', valor_normal='$valor', grupo_id='$cod_grupo'"; 
		echo $t."<br>";
		mysql_query($t);
		echo mysql_error();
		//print_r($linha);
		//echo "Ultimo Indice: ".$ultimo_indice; 
		//echo " Valor: ". $valor."<br>";*/
	}
?>