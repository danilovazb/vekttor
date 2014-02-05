<?php
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
global $vkt_id;
//$cpf_cnpj =  str_replace=
	
	$acao = $_GET['acao'];

	if($acao == 'cliente'){

	$q=@mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND (razao_social  like '%$_GET[busca_auto_complete]%' OR REPLACE(REPLACE(REPLACE(cnpj_cpf,'.','' ),'-',''),'/','') like '%$_GET[busca_auto_complete]%')  LIMIT 15");
	$i=0;
	while($r= mysql_fetch_object($q)){
		echo urlencode("$r->razao_social|$r->id|$r->cnpj_cpf\n");
		$i++;
	}
		if($i==0){
			echo urlencode("Não Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
		}

	}
	
	if($acao == 'equipamento'){

		$s_produto=mysql_query("SELECT * FROM aluguel_equipamentos WHERE vkt_id ='$vkt_id' AND (descricao  like '%$_GET[busca_auto_complete]%')  LIMIT 15");
			$i=0;
			while($equipamento= mysql_fetch_object($s_produto)){
					
					$valor_aluguel = moedaUsaToBr($equipamento->vlr_aluguel);
					
					$disponivel  = mysql_fetch_object(mysql_query("SELECT COUNT(id) as disponivel FROM aluguel_equipamentos_itens WHERE equipamento_id = '$equipamento->id' AND status = '1'"));
					$total_equipamento = mysql_fetch_object(mysql_query("SELECT COUNT(id) as total FROM aluguel_equipamentos_itens WHERE equipamento_id = '$equipamento->id' "));
					
				echo urlencode("$equipamento->descricao|$equipamento->id|$disponivel->disponivel|$total_equipamento->total|$equipamento->periodo|$equipamento->vlr_aluguel\n");
				$i++;
			}
				if($i==0){
					echo urlencode("Não Encontrado, Cadastre em Produto|0|0\n");
				}

	}
?>