<?
require "../../../_config.php";
require "../../../_functions_base.php";
require "_functions.php";
if($_GET['unidade_id_origem']>0){$unidade_id_origem=$_GET['unidade_id_origem'];}
if($_GET['unidade_id_destino']>0){$unidade_id_destino=$_GET['unidade_id_destino'];}
if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
	$filtro_inicio 	= date("Y-m-").'01';
	$filtro_fim		= date("Y-m-t");
}else{
	$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
	$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
}

$total_dias	= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);

$contratos_q=mysql_query("SELECT * FROM cozinha_contratos WHERE vkt_id='$vkt_id' AND unidade_id='$unidade_id_destino' ");
while($contrato=mysql_fetch_object($contratos_q)){
	//selecionar fichas do contrato e seus respectivos pessoas, e a soma da quantidade de pessoas q vao comer
	$fichas_contrato_q=mysql_query($q="
	SELECT
		DISTINCT(cf.id) as ficha_id, cf.peso as peso_receita, cf.nome as ficha_nome,
		cf.percapta_leve as peso_leve, cf.percapta_medio as peso_medio, cf.percapta_pesado as peso_pesado, cf.percapta_extra as peso_extra,
		SUM(ccr.pessoas) as pessoas, cc.pesagem as pesagem_contrato, cc.unidade_id as unidade_id
	FROM
		cozinha_cardapio_dia_refeicao as ccr,
		cozinha_fichas_tecnicas as cf,
		cozinha_contratos as cc
	WHERE
		ccr.ficha_tecnica_id=cf.id
		AND ccr.contrato_id = cc.id
		AND cc.id='{$contrato->id}'
		AND ccr.data >= '$filtro_inicio' AND ccr.data <= '$filtro_fim'	
	GROUP BY cf.id
	");

echo mysql_error();
$produtos=array();
//listar fichas e calcular o fator multiplicador para qtd de ingredientes
	while($fichas_contrato=mysql_fetch_object($fichas_contrato_q)){	
		//echo '<b>Ficha ID</b>: '.$fichas_contrato->ficha_id.' <b>Pessoas que vão comer</b> : '.$fichas_contrato->pessoas;
		//echo " <b>peso da receita:</b> ".$fichas_contrato->peso_receita.' ';
		//echo " <b>pesagem contrato:</b> ".$fichas_contrato->pesagem_contrato.' ';
		if($fichas_contrato->pesagem_contrato=='leve'){
			$fator_multiplicador = @($fichas_contrato->peso_leve/$fichas_contrato->peso_receita);
		}
		if($fichas_contrato->pesagem_contrato=='medio'){
			$fator_multiplicador = @($fichas_contrato->peso_medio/$fichas_contrato->peso_receita);
		}
		if($fichas_contrato->pesagem_contrato=='pesado'){
			$fator_multiplicador = @($fichas_contrato->peso_pesado/$fichas_contrato->peso_receita);
		}
		if($fichas_contrato->pesagem_contrato=='muito pesado'){
			$fator_multiplicador = @($fichas_contrato->peso_extra/$fichas_contrato->peso_receita);
		}
		//echo "<b>Fator Multiplicador</b>: ".$fator_multiplicador.'<br>';
		//pegar os produtos de cada ficha
		if($_GET['grupo_id']>0){$filtro_grupo=" AND p.produto_grupo_id='{$_GET['grupo_id']}' ";}
		$ingredientes_q=mysql_query($xi="
		SELECT 
			p.id as produto_id, p.nome as nome, cfp.qtd as qtd, p.estoque_min as estoque_min, p.unidade_uso as unidade_uso, p.unidade_embalagem as unidade_embalagem, p.conversao2 as conversao2, pg.nome as grupo
		FROM
			cozinha_ficha_has_produto as cfp, produto as p, produto_grupo as pg
		WHERE 
			cfp.ficha_id='{$fichas_contrato->ficha_id}' AND p.id=cfp.produto_id AND pg.id =p.produto_grupo_id
			$filtro_grupo ");
			
		//listar os produtos e fazer o calculo de qtd de ingredientes de cada produto
		while($ingrediente=mysql_fetch_object($ingredientes_q)){
			
			$produtos[$ingrediente->grupo][$ingrediente->nome]['produto_id'] = $ingrediente->produto_id;	
			$produtos[$ingrediente->grupo][$ingrediente->nome]['estoque_min'] = $ingrediente->estoque_min;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['unidade_id'] = $fichas_contrato->unidade_id;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['unidade_uso'] = $ingrediente->unidade_uso;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['unidade_embalagem'] = $ingrediente->unidade_embalagem;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['conversao2'] = $ingrediente->conversao2;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['em_estoque'] = checaEstoque($ingrediente->produto_id,0,$fichas_contrato->unidade_id);
			$produtos[$ingrediente->grupo][$ingrediente->nome]['qtd']+=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas'][]=$fichas_contrato->ficha_nome;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas_qtd'][]=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
		}
		
	}
}

ksort($produtos);
$grupo_atual="";
foreach($produtos as $grupo=>$produto){
	if($grupo_atual!=$grupo){
		echo "<h1>$grupo</h1>";
	}
	ksort($produto);
	foreach($produto as $nome=>$campo){
		
		echo "$nome {$campo['qtd']}-----<br/>";
		foreach($campo['fichas'] as $i=>$v){
			echo $v.' - '.$campo['fichas_qtd'][$i].'<br/>';
		}
		echo "-------------------------<br/>";
		
	}
}
