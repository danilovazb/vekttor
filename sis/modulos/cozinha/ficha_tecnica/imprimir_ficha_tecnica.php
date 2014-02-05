<?
require('../../../_config.php');
require('../../../_functions_base.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão Ficha Técnica</title>
<style>
table tr td{ font-size:11px; font-family:Arial, Helvetica, sans-serif}
</style>
</head>
<body>

<table cellpadding="1" cellspacing="0" border="1">
<thead>
	<tr style=""><td width="40">Nº</td><td width="250">Nome</td><td width="200">Refeição</td><td>Ingredientes</td><td width="130">Quantidade (Kg)</td></tr>
</thead>
<tbody>
<?
$grupo="Sem Grupo";
$ficha_q=mysql_query("SELECT *,cg.nome as grupo, cf.nome as nome, cf.id as id FROM cozinha_fichas_tecnicas as cf, cozinha_cardapios_grupos as cg 
	WHERE 
	cf.vkt_id='$vkt_id' AND cf.grupo_cardapio_id=cg.id  ORDER BY cg.id, cf.nome"); 
	echo mysql_error();
	
	while($ficha=mysql_fetch_object($ficha_q)){
		if($ficha->grupo!=$grupo){
			echo "<tr style='background:#CCC'><td colspan='5'><b>Grupo da ficha técnica:</b> $ficha->grupo</td></tr>";
			$grupo=$ficha->grupo;
		}
		?>
		<tr style=" font-weight:bold;">
        	<td><?=$ficha->id?></td>
            <td><?=$ficha->nome?></td>
            <td><?=ucwords($ficha->refeicao)?></td>
            <td></td>
            <td align="right">Peso da Receita: <?=$ficha->peso?> Kg</td>
        </tr>
        <tr>
        	<td></td>
            <td colspan="4">
				<b>Leve:</b> <?=$ficha->percapta_leve?> Kg / <?=@(number_format($ficha->peso/$ficha->percapta_leve,0,',','.'))?>p
			 <b>Médio:</b> <?=$ficha->percapta_medio?> Kg / <?=@(number_format($ficha->peso/$ficha->percapta_medio,0,',','.'))?>p
			 <b>Pesado:</b> <?=$ficha->percapta_pesado?> Kg /  <?=@(number_format($ficha->peso/$ficha->percapta_pesado,0,',','.'))?>p
			 <b>Muito pesado:</b> <?=$ficha->percapta_extra?> Kg / <?=@(number_format($ficha->peso/$ficha->percapta_extra,0,',','.'))?>p </td>
        </tr>
		<?
		$produtos_ficha_q=mysql_query("
		SELECT
			p.nome as produto, (p.custo*(cp.qtd/p.conversao2/p.conversao)) as total, cp.qtd as qtd, cp.grupo as grupo
		FROM
			produto as p, cozinha_ficha_has_produto as cp
		WHERE
			cp.ficha_id='{$ficha->id}' AND
			p.id=cp.produto_id
		");
		while($produto_ficha=mysql_fetch_object($produtos_ficha_q)){
			
			?>
            <tr>
            	<td colspan="3"></td>
                <td><?=$produto_ficha->produto?></td>
                <td align="right"><?=moedaUsaToBr($produto_ficha->qtd)?></td>
            </tr>
            <?
		}
		
	}
?>
</tbody> 
</table>


</body>
</html>