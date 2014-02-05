<?
include("../../../../_config.php");
include '_functions.php';
include '_ctrl.php';

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão de Inventário</title>
<style>
#tabela{ margin-left:20px; margin-top:5px; font-size:12px; border-top:1px solid #000; border-left:1px solid #000}
#tabela thead{ border:dashed 1px black;}
#tabela thead tr td{ height:15px; line-height:15px; color:black; text-transform:uppercase; background-color:#CCC; font-weight:bold  }
#tabela td{ border-right:1px solid #000;border-bottom:1px solid #000;}
#tabela tbody tr.p:nth-child(2n+1){}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
}
.g{padding-left:5px; text-transform:uppercase; background:#CCCCCC}
</style>

</head>
<body> 
<span style="margin-left:20px; font-weight:bold;">Unidade: <?=$almoxarifado->nome?> | Inventário nº <?=$inventario->id?> | Criado em <?=$inventario->data_hora?>  </span>
<table cellpadding="1" cellspacing="0" border="0"  id="tabela">
<thead>
	<tr>
    	<td width="60">COD.</td>
      <td width="200">Produto</td>
        <td width="50">Unidade</td>
        <td width="80"> Físico</td>
    </tr>
</thead>
<tbody>
<?
	$filterGrupo =  !empty($_GET["grupo_id"]) ? " AND p.produto_grupo_id = '".$_GET["grupo_id"]."' " : NULL;
	
	$grupo='Sem Grupo';
	$produtos_q=mysql_query("SELECT p.*, g.nome as grupo FROM produto as p, produto_grupo as g WHERE p.vkt_id='$vkt_id' AND p.produto_grupo_id=g.id $filterGrupo  ORDER BY g.nome ASC,p.nome ASC");
	while($produto=mysql_fetch_object($produtos_q)){
		if($grupo!=$produto->grupo){
			
		?>
	<tr>
    	<tr>
        <td colspan="4" class="g"><strong><?=$produto->grupo?></strong></td>
        </tr>
    
    <? 
		$grupo=$produto->grupo;
	} 
	$inventario_item=mysql_fetch_object(mysql_query("SELECT * FROM estoque_inventario_item WHERE inventario_id='$id' AND produto_id='{$produto->id}'"));
	$estoque_inventario_item_id = $inventario_item->id;
	?>
	<tr class="p">
   	  <td ><?=$produto->id?></td>
      <td ><?=$produto->nome?></td>
        <td align="right"><?=$produto->unidade_embalagem?></td>
        <td ><?=$inventario_item->qtd_inventario?></td>
    </tr>
<? } ?>
</tbody>
</table>

</body>
</html>