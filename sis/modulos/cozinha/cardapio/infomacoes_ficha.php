<?
include("../../../_config.php");
include("../../../_functions_base.php");
	$ficha=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_fichas_tecnicas WHERE vkt_id='$vkt_id' AND id='$_GET[id]'"));	

?>
<table width="300" border="0" cellpadding="2" cellspacing="0" id="table_tip">
  <tr>
    <td width="120"><strong>Produto</strong></td>
    <td align="right"><strong>Est.</strong></td>
    <td align="right"><strong>Per.</strong></td>
    <td align="right"><strong>Nec.</strong></td>
    <td align="right"><strong>Valor</strong></td>
  </tr>
<?
		$grupo_atual="";
		
		$produtos_ficha_q=mysql_query("SELECT 
			p.id, 
			p.nome, 
			p.custo as custo, 
			p.conversao as conversao, 
			p.conversao2 as conversao2, 
			cp.qtd as qtd, 
			cp.obs as obs, 
			cp.grupo as grupo,
			p.unidade_uso as unidade,
			p.custo
		FROM 
			cozinha_ficha_has_produto as cp, 
			produto as p 
		WHERE 
			cp.ficha_id='{$_GET[id]}' 
		AND 
			p.id=cp.produto_id 
		ORDER BY 
			cp.grupo ASC "); 
		$qtd=mysql_num_rows($produtos_ficha_q);
		$p=1;
		$num=0;
			$percapta[leve] = $ficha->percapta_leve;
			$percapta[medio] = $ficha->percapta_medio;
			$percapta[pesado] = $ficha->percapta_pesado;
			$percapta[extra] = $ficha->percapta_extra;
			
			$contrato_pesagem = 'medio'; 
			$peso_ficha = $ficha->peso;
			$percapita_cliente =$percapta[$contrato_pesagem] ;
			$comensais = $_GET[qt] ;
			 			
	while($produto=mysql_fetch_object($produtos_ficha_q)){
			$i++;
			if($i%2){$cl='al';}else{$cl='';}
			if($grupo_atual!=$produto->grupo){
			}
			
			//$contrato_pesagem = $contrato->pesagem; 
			

			$peso_produto = $produto->qtd;
			$percapta = @($peso_produto/@($peso_ficha/$percapita_cliente));
			$total =$percapta*$_GET[qt];
		
			$valor = $total*($produto->custo/$produto->conversao);
			$valor_total[] = $valor;
			
?>
  <tr class="<?=$cl?>">
    <td><?=utf8_encode($produto->nome)?></td>
    <td align="right">&nbsp;</td>
    <td align="right"><?=qtdUsaToBr($percapta,3).' '.substr($produto->unidade,0,2)?></td>
    <td align="right"><?=qtdUsaToBr($total,3).' '.substr($produto->unidade,0,2)?></td>
    <td align="right"><?=n($valor)?></td>
  </tr>
<?
		}	
?>
  <tr>
    <td><strong>Total  (<?=$comensais?>)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?=n(@array_sum($valor_total))?></td>
  </tr>
  <tr>
    <td><strong>Por pessoa (<?=$percapita_cliente?>)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?
		echo n(@array_sum($valor_total)/$_GET[qt]);
		?></td>
  </tr>
</table>
<?
$antes = mf(mq($t="SELECT *, DATE_FORMAT(data,'%d/%m/%Y') as dt, DATE_FORMAT(data,'%w') as semana  FROM `cozinha_cardapio_dia_refeicao` WHERE `contrato_id`='$_GET[contrato_id]' AND `ficha_tecnica_id`='$_GET[id]' AND `data`<'$_GET[data_click]'  order by  data desc LIMIT 1 "));
$dais_antes=mf(mq($t1="SELECT DATEDIFF('$_GET[data_click]', '$antes->data') as dias"));
//echo $t."".$t1;

$depois = mf(mq($t="SELECT *, DATE_FORMAT(data,'%d/%m/%Y') as dt, DATE_FORMAT(data,'%w') as semana FROM `cozinha_cardapio_dia_refeicao` WHERE `contrato_id`='$_GET[contrato_id]' AND `ficha_tecnica_id`='$_GET[id]' AND `data`>'$_GET[data_click]'  order by  data desc LIMIT 1"));
$dais_depois=mf(mq($t1="SELECT DATEDIFF('$_GET[data_click]', '$antes->data') as dias"));
//echo $t."".$t1;

?>
<?
if($antes->id>0){
?>
Usado a <?=$dais_antes->dias?> dias atr&aacute;s <?=$semana_abreviado[$antes->semana]?> <?=$antes->dt?> <br>
<?
}
if($depois->id>0){

?>
Usado daqui a <?=$dais_depois->dias?> dias a frente <?=$semana_abreviado[$depois->semana]?> <?=$depois->dt?>
<?
}
?>