<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
	if(!empty($_GET['mes']) && !empty($_GET['ano'])){
		$filtro.=" AND rc.data_vencimento BETWEEN '$_GET[ano]-$_GET[mes]-01' AND '$_GET[ano]-$_GET[mes]-30'";
		$mes = $_GET['mes'];
		$ano = $_GET['ano'];
	}else{
		$filtro.=" AND rc.data_vencimento BETWEEN '".date("Y-m-01"). "' AND '".date("Y-m-t"). "'";
		$mes = date("m");
		$ano = date("Y");
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Clientes + DAC</title>
<style type="text/css">
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 42px;
	background:url(img/bgif.png);
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
td{height:120px; border-bottom:1px solid #CCC;}
thead td{ background:url(img/bgp.png); color:#FFF;}
</style>
</head>

<body >
<table width="100%" border="0" cellpadding="2" cellspacing="0">
 <thead>
  <tr>
    <td colspan="4">
    <select style="font-size:42px" onchange="location='?mes='+this.value+'&ano='+document.getElementById('ano').value" id='mes'>
    <?
    $mes_ar[$mes] = "selected='selected'";
	?>
    	<option value="01" <?=$mes_ar['01']?>>Janeiro</option>
    	<option value="02" <?=$mes_ar['02']?>>Fevereiro</option>
    	<option value="03" <?=$mes_ar['03']?>>Março</option>
    	<option value="04" <?=$mes_ar['04']?>>Abril</option>
    	<option value="05" <?=$mes_ar['05']?>>Maio</option>
    	<option value="06" <?=$mes_ar['06']?>>Junho</option>
    	<option value="07" <?=$mes_ar['07']?>>Julho</option>
    	<option value="08" <?=$mes_ar['08']?>>Agosto</option>
    	<option value="09" <?=$mes_ar['09']?>>Setembro</option>
    	<option value="10" <?=$mes_ar['10']?>>Outubro</option>
    	<option value="11" <?=$mes_ar['11']?>>Novembro</option>
    	<option value="12" <?=$mes_ar['12']?>>Dezembro</option>
    </select>
    <select style="font-size:42px" onchange="location='?ano='+this.value+'&mes='+document.getElementById('mes').value"id='ano'>
    	<?
			for($i=date("Y");$i>date("Y")-2; $i--){
				    $ano_ar[$ano] = "selected='selected'";
 
		?>
    	<option value="<?=$i?>" <?=$ano_ar[$i]?>><?=$i?></option>
        <?
			}
		?>
    </select>
    </td>
    </tr>
    
  <tr>
    <td>&nbsp;</td>
    <td><strong>Empresa</strong></td>
    <td align="right"><strong>N&atilde;o Pago</strong></td>
    <td align="right"><strong>Pago</strong></td>
  </tr>
  </thead>
<?
	
	if(!empty($_GET['situacao'])){
		$situacao.=" AND rc.situacao='".$_GET['situacao']."'";
	}else{
		$situacao = " AND rc.situacao='0'"; 
	}
	
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}

	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, rc.id as cobranca_id FROM 
		rh_cobranca_empresas rc, rh_empresas as e
		WHERE 
			rc.cliente_fornecedor_id =e.cliente_fornecedor_id 
		$busca_add 
		$filtro 
		ORDER BY e.codigo_interno LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;
		echo mysql_error();

	while($r=mysql_fetch_object($q)){
	//	$empresa = mysql_fetch_object(mysql_query("SELECT * FROM  as e WHERE c.id='$r->cliente_fornecedor_id' "));	
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>

  <tr>
    <td><input type="checkbox" style="height:50px; width:50px;" /></td>
    <td><?
    if(strlen($r->codigo_interno)<1){
		$nome = $r->rasao_social;
	}else{
		$nome = $r->codigo_interno;
	}
	echo $nome;
	?></td>
    <td align="right"><?
	if($r->situacao==0){
		echo MoedaUsaToBr($total_nao_pago[]=$r->valor);
	}
	?></td>
    <td align="right"><?
		if($r->situacao==1){
			echo	MoedaUsaToBr($total_pago[]=$r->valor);
		}
	?></td>
  </tr>
  
<?
	}
	?>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    <td align="right"><strong><?=MoedaUsaToBr(@array_sum($total_nao_pago))?></strong></td>
    <td align="right"><strong>
      <?=MoedaUsaToBr(@array_sum($total_pago))?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center"><strong>
      <?=MoedaUsaToBr(@array_sum($total_pago)+@array_sum($total_nao_pago))?>
    </strong></td>
  </tr>
</table>
</body>
</html>