<?php
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
$s_servico=mysql_query("SELECT * FROM servico WHERE vkt_id ='$vkt_id' AND (nome  like '%$_GET[busca_auto_complete]%')  LIMIT 15");
			$i=0;
			while($servico= mysql_fetch_object($s_servico)){
				echo urlencode("$servico->nome|$servico->id|$servico->valor_normal|$servico->valor_colaborador|".substr($servico->und,0,2)."\n");
				$i++;
			}
				if($i==0){
					echo urlencode("Nao Encontrado, Cadastre em Produto|0|0\n");
				}
?>