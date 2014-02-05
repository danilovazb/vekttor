<?php
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
global $vkt_id;

$almoxarifados = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' AND id='".$_GET['almoxarifado_id']."'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Teste</title>

<style>
body{ 
	margin:0;
	font-family:Verdana;
	font-size:8px;
}
table{
	border-collapse:collapse;
}
table tr td{
	border:solid 1px #000000;
}
thead{ text-align:center; font-weight:bold;}

.quebra_pagina{
	page-break-after:always;
	margin-top:3.6mm;
}
</style>
<script src="../../fontes/js/jquery.min.js"></script>
</head>
<body>
<h3><?=$almoxarifados->nome?></h3>
<h3>Posição de Estoque - <?=date('d')."/".date('m')."/".date('Y')." ".date("H").":".date("i")?> </h3>
<div id="conteudo">
<div id="dados">
<table cellpadding="4" cellspacing="0" border="1">
	<thead>
    	<tr>
            <td width="220">Produto</td>
          	<td width="100" align="right">Qtd Embalagem</td>
            <td width="100" align="right">Qtd Uso</td>
			<td width="100" align="right">Valor Un</td>                        
            <td width="100" align="right">Valor Total</td>
           
        </tr>
    <?php
    $produtos = mysql_query($t=
			
			"		SELECT 
			 p.*, g.id as grupo_id, g.nome as grupo 
		FROM
			produto p,
			produto_grupo g
		WHERE
			p.vkt_id='$vkt_id' AND
			p.produto_grupo_id = g.id 
		
			ORDER BY g.nome, p.nome  
");
		

								
			$saldo_total = 0;			
			while($produto = mysql_fetch_object($produtos)){
				
				$produto_saldo = mysql_fetch_object(mysql_query($t="
					SELECT 
						(SELECT saldo FROM estoque_mov WHERE almoxarifado_id='".$_GET['almoxarifado_id']."' AND produto_id=p.id AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1) as saldo
					FROM 
						produto p, 
						estoque_mov em 
					WHERE 
						em.produto_id = p.id AND 
						em.almoxarifado_id='".$_GET['almoxarifado_id']."' AND 
						em.produto_id='$produto->id' AND 
						em.vkt_id='$vkt_id' 
					ORDER BY 
						em.id DESC LIMIT 1"));
					//echo $t;
					$qtd_embalagem = $produto_saldo->saldo / $produto->conversao2;
					$valor   = ($produto_saldo->saldo/$produto->conversao2) * ( $produto->custo/$produto->conversao);
					//echo $produto_saldo->saldo." ";
					$valor_total    += $valor;						
		if($produto->grupo!=$grupo){
			$grupo=$produto->grupo;
	?>
	<tr>
    	<td colspan="6" class="g" bgcolor="#CCCCCC"><?=$produto->grupo?></td>
    </tr>
    <?
		$grupo=$produto->grupo;
		}

		
			
?><tr class='ps'>
<td width="220" align="left"><?=$produto->nome?></td>
<td width="100" align="right"><? if($produto_saldo->saldo>0){ echo qtdUsaToBr($qtd_embalagem)." ".substr($produto->unidade_embalagem,0,2);}else{ echo "0 ".substr($produto->unidade_embalagem,0,2);}?></td>
<td width="100" align="right"><? if($produto_saldo->saldo>0){ echo qtdUsaToBr($produto_saldo->saldo)." ".substr($produto->unidade_uso,0,2);}else{ echo "0 ".substr($produto->unidade_uso,0,2);}?></td>
<td width="100" align="right"><?=moedaUsaToBr($produto->custo/$produto->conversao)?></td>                        
<td width="100" align="right"><?=MoedaUsaToBr($valor)?></td>
</tr>
<?
		}
	?>
    </tbody>
    
</table>
</div>
</div>
</body>
</html>