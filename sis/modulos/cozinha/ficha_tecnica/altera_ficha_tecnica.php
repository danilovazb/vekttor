<?php
	// configuração inicial do sistema
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	$fichas_tecnicas = mysql_query("SELECT * FROM cozinha_fichas_tecnicas WHERE vkt_id='14'");
	
	while($ficha_tecnica=mysql_fetch_object($fichas_tecnicas)){
		
		$refeicao=$ficha_tecnica->refeicao;
		
		$encontrou_almoco="nao";
		$encontrou_ceia="nao";
		if(strstr($refeicao,'almoco')){
			$encontrou_almoco='sim';
		}
		if(strstr($refeicao,'seia')){
			$encontrou_ceia='sim';
		}
		//echo " EM: $encontrou_almoco EC: $encontrou_ceia<br>";
		if($encontrou_almoco=='sim'&&$encontrou_ceia=='nao'){
			//echo "Ficha Tecnica: $ficha_tecnica->id $refeicao<br>";
			//$refeicao.=',seia';
			//mysql_query($t="UPDATE cozinha_fichas_tecnicas SET refeicao='$refeicao' WHERE id='$ficha_tecnica->id'");
			//echo $t."<br>";
		}
	}
?>