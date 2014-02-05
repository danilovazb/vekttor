<?
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
// funçoes do modulo empreendimento

//$cpf_cnpj =  str_replace=

	
			$q=mysql_query("SELECT * FROM produto WHERE vkt_id ='$vkt_id' AND (nome  like '%$_GET[busca_auto_complete]%' )  LIMIT 15");
			$i=0;
			while($r= mysql_fetch_object($q)){
				
				echo urlencode("$r->nome $r->conversao2|$r->id|$r->unidade_embalagem|$r->conversao2|$r->unidade_uso\n");
				$i++;
			}
			if($i==0){
				echo urlencode("Nao Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
			}
	

?>