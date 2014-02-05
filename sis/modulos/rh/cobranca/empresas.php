<?
include("../../../_config.php");
include("../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php");
	?>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
td{ 
	border-bottom:1px solid #000;
	border-left:1px solid #000;
}
table{
	border-top:1px solid #000;
	border-right:1px solid #000;
}
</style>

<table border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td><strong>Empresa</strong></td>
    <td><strong>R$ Valor</strong></td>
  </tr>
<?

	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="re.codigo_interno";
	}
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1'"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, cf.id as cliente_forencedor_id FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1' AND
		cf.valor_mensalidade>0
		 
		$busca_add 
		$filtro 
		ORDER BY ".$ordem." ".$_GET['ordem_tipo']);
	//echo $t;
	while($r=mysql_fetch_object($q)){
		
		$l++;
		if($total%2){$sel='class="al"';}else{$sel='';}

?>
  <tr>
    <td><?=$l?></td>
    <td><?
    
	if(strlen($r->codigo_interno)>1){
		$nome = $r->codigo_interno;
	}else{
		$nome = "($r->razao_social)";
	}
	echo $nome;
	?></td>
    <td align="right"><?
    $total+=$r->valor_mensalidade;
	echo     moedaUsaToBr($r->valor_mensalidade);
	?></td>
  </tr>
<?
}
?>	
  <tr>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    <td align="right"><strong>
      <?= moedaUsaToBr($total)?>
    </strong></td>
  </tr>

</table>
