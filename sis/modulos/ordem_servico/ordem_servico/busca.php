<?
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=
	$acao = $_GET['acao'];

	if($acao == 'cliente'){

	$q=mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND (razao_social  like '%$_GET[busca_auto_complete]%' OR REPLACE(REPLACE(REPLACE(cnpj_cpf,'.','' ),'-',''),'/','') like '%$_GET[busca_auto_complete]%')  LIMIT 15");
	$i=0;
	while($r= mysql_fetch_object($q)){
		echo urlencode("$r->razao_social|$r->id|$r->cnpj_cpf\n");
		$i++;
	}
		if($i==0){
			echo urlencode("Não Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
		}

	}
	
	if($acao == 'produto'){

		$s_produto=mysql_query("SELECT * FROM produto WHERE vkt_id ='$vkt_id' AND (nome  like '%$_GET[busca_auto_complete]%')  LIMIT 15");
			$i=0;
			while($produto= mysql_fetch_object($s_produto)){
					$preco_venda = moedaUsaToBr($produto->preco_venda);
				echo urlencode("$produto->nome|$produto->id|$preco_venda\n");
				$i++;
			}
				if($i==0){
					echo urlencode("Não Encontrado, Cadastre em Produto|0|0\n");
				}

	}
	
	if($acao == 'servico'){

		$s_servico=mysql_query("SELECT * FROM servico WHERE vkt_id ='$vkt_id' AND (nome  like '%$_GET[busca_auto_complete]%')  LIMIT 15");
			$i=0;
			while($servico= mysql_fetch_object($s_servico)){
				echo urlencode("$servico->nome|$servico->id|$servico->valor_normal|$servico->valor_colaborador\n");
				$i++;
			}
				if($i==0){
					echo urlencode("Não Encontrado, Cadastre em Produto|0|0\n");
				}

	}
	
	if($acao == 'funcionario'){

		$s_funcionario=mysql_query("SELECT * FROM rh_funcionario WHERE vkt_id ='$vkt_id' AND (nome  like '%$_GET[busca_auto_complete]%')  LIMIT 15");
			$i=0;
			while($funcionario= mysql_fetch_object($s_funcionario)){
				echo urlencode("$funcionario->nome|$funcionario->id\n");
				$i++;
			}
				if($i==0){
					echo urlencode("Não Encontrado, Cadastre em Funcionario|0|0\n");
				}

	}


?>