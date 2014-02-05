<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Lista de Produtos</title>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
td{ border-top:1px solid #000; border-left:1px solid #000; padding-left:5px;}
table{ border-bottom:1px solid #000; border-right:1px solid #000;}
.grupo{background:#000; color:#999}
tr td:nth-child(3),tr td:nth-child(4),tr td:nth-child(5),tr td:nth-child(6){ text-align:right;}
</style>
</head>

<body>
<table cellpadding="0" cellspacing="0" width="800" id="tabela_dados">
    <thead>
    	<tr>
            <td ><strong>Codigo</strong></td>
          	<td ><strong>Nome</strong></td>
          	<td ><strong><a>Unidade</a></strong></td>
			<td ><strong><a>R$/Compra</a></strong></td>
			<td ><strong>R$/Embalagem</strong></td>
			<td ><strong>R$/Uso</strong></td>
            <td ><strong>Estoque em Valor</strong></td>
          	<td></td>
        </tr>
    </thead>
  <tbody >
    <? 
	$grupo='Sem Grupo';
	if($_GET['produto_grupo_id']>0){$filtro_grupo=" AND p.produto_grupo_id='{$_GET[produto_grupo_id]}'";}
	if($_GET['busca']!=''){$filtro_busca =" AND p.nome LIKE '%{$_GET[busca]}%' ";}
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT COUNT(*) FROM produto as p WHERE vkt_id='$vkt_id' $filtro_grupo $filtro_busca $filtro_grupo ORDER BY id DESC"),0,0);
	
	$produtos_q=mysql_query("
	SELECT *, p.id as id, p.nome as nome 
	FROM produto as p, produto_grupo as pg 
	WHERE p.vkt_id='$vkt_id' AND p.produto_grupo_id = pg.id $filtro_grupo $filtro_busca ORDER BY  pg.nome, p.nome ");
	echo mysql_error();
	while($produto=mysql_fetch_object($produtos_q)){
		$custo=0;
	if($produto->produto_grupo_id!=$grupo){
		$grupo_nome=mysql_fetch_object(mysql_query("SELECT * FROM produto_grupo WHERE id=".$produto->produto_grupo_id));
		
		$saldo = mysql_fetch_object(mysql_query($o="SELECT saldo FROM estoque_mov WHERE produto_id='".$produto->id."' AND vkt_id='$vkt_id' ORDER BY id DESC"));
		
		$conversao = mysql_fetch_object(mysql_query($r=" SELECT * FROM produto WHERE id = '$produto->id'"));
		
		
		//protudo.conversao * produto.conversao2 * estoque_mov.saldo(onde produto_id = id do produto, ultimo saldo) * custo
		if(empty($saldo)){
			$saldo = '0';
		}else{
			$saldo=$saldo->saldo;
		}
		//echo "saldo=$saldo custo={$conversao->custo} conversao={$conversao->conversao} conversao2={$conversao->conversao2}<br>";
		$custo = @(@($saldo * $conversao->custo)/@($conversao->conversao*$conversao->conversao2));
	?>
    <tr>
      <td colspan="9" class='grupo'><?=$grupo_nome->nome;?></td>
    </tr>
    <?
		$grupo=$grupo_nome->id;
	}
    	
	?>
    <tr onclick="window.open('<?=$caminho?>form.php?id=<?=$produto->id?>','carregador')">
      <td><?=$produto->id?></td>
      <td><?=$produto->nome?></td>
      <td><?=substr($produto->unidade,0,2).'  '.($produto->conversao*1).' '.substr($produto->unidade_embalagem,0,2).'  '.($produto->conversao2*1).' '.substr($produto->unidade_uso,0,2)?></td>
      <td><?=number_format($produto->custo,2,',','.')?></td>
      <td><?=number_format($custo_embalagem=@($produto->custo/$produto->conversao),2,',','.')?></td>
      <td><?=number_format(@($custo_embalagem/$produto->conversao2),2,',','.')?></td>
      <td><?=$custo?></td>
      <td></td>
    </tr>
    <?
	}
	?>
  </tbody>
</table>
</body>
</html>
