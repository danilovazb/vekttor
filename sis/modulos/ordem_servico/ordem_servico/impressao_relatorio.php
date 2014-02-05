<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Vekttor - OS</title>

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
<h3><?=$empresa['nome']?></h3>
<h3>Relatório Ordem De Serviço - Período: <?=$_GET['de']?> à <?=$_GET['ate']?></h3>
<div id="conteudo">
<div id="dados">
<table cellpadding="4" cellspacing="0" border="1">
	<thead>
    	<tr>
        	
          <td width="20">N&deg; OS</td>
          <td width="250">Descri&ccedil;&atilde;o</td>
          <td width="150">Cliente</td>
          <td width="80">Cadastro</td>          
          <td width="80">Aprovado</td>
          <td width="130">Situa&ccedil;&atilde;o</td>
          <td width="80">Valor Total</td>
    	
    	</tr>
    </thead>
	<tbody>
    	<?php 
			$fim="";
			$cancel =" AND situacao != 3 ";
	$fim="";
	if( empty($_GET["aprovacao"]) )
		$filter = !empty($_GET['situacao']) ? " AND orcado = '".trim($_GET['status'])."' AND situacao = '".trim($_GET["situacao"])."'" : NULL;
	
	if( !empty($_GET["aprovacao"]) )
		$filter = !empty($_GET['situacao']) ? " AND status_os = '".trim($_GET['status'])."' AND situacao = '".trim($_GET["situacao"])."'" : NULL;
	
	if( !empty($_GET["cancelada"]) ){
		$filter = !empty($_GET['situacao']) ? " AND situacao = '".trim($_GET['situacao'])."'" : NULL;
		$cancel = "";
	}
	if(!empty($_GET['de'])&&!empty($_GET['ate'])){
		$fim.=" AND data_cadastro BETWEEN '".DataBrToUsa($_GET['de'])."' AND '".DataBrToUsa($_GET['ate'])."'";
	}
	if(!empty($_GET['busca'])){
		$sql = mysql_fetch_object(mysql_query($t="SELECT *, cf.id AS id_cliente, os.id AS id_os FROM os AS os, cliente_fornecedor AS cf 
													WHERE os.cliente_id = cf.id  AND (os.id = '".$_GET['busca']."' or cf.razao_social like '%".$_GET['busca']."%') limit 1"));	
		
		$fim .= " AND (id = '".$_GET['busca']."' OR cliente_id = '".$sql->id_cliente."')";
		
	}
			$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM os WHERE vkt_id='$vkt_id' $fim"),0,0);
			$sql=mysql_query($t="SELECT * FROM os WHERE vkt_id = '$vkt_id' $cancel $string $filter $fim ORDER BY id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			//$sql=mysql_query($t="SELECT * FROM os WHERE vkt_id = '$vkt_id' $string $fim ORDER BY id DESC");
				//echo $t;
			$total_ordem_servico = mysql_result(mysql_query("SELECT SUM(valor_total_geral) as valor_total FROM os WHERE vkt_id = '$vkt_id'  $cancel $string $filter $fim ORDER BY id DESC"),0,0);
				$c=1;
			$total=0;
			while($os=mysql_fetch_object($sql)){
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '".$os->cliente_id."'"));		
	?>      
    	<tr id="<?=$os->id;?>">
          <td width="20"><?=$os->numero_sequencial_empresa;?></td>
          <td width="250"><?=$os->descricao;?></td>
          <td width="130"><?=$cliente->razao_social?></td>
          <td width="80"><?=dataUsaToBr($os->data_cadastro);?></td>
          <td width="80"><?=dataUsaToBr($os->data_aprovacao);?></td>
          <td width="150">
		  <?
          	if($os->situacao == '1'){
				echo "<span style='color:#387ACB; font-weight:bold;'>Or&ccedil;amento</span>";
			} 
			else if($os->situacao == '2' and $os->status_os == '1'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Aprovado/Aguardando</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '2'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Aprovado/Em Execu&ccedil;&atilde;o</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '3' and $os->pago == 'sim'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Enviado ao Financeiro</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '4' and $os->pago == 'sim'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Finalizado</span>";
			}
			else if($os->situacao == '2'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Aprovado</span>";
			} else if($os->situacao == '3'){
				echo "<span style='color:#F97C00; font-weight:bold;'>Cancelada</span>";
			} 	
		  ?>
          </td>
          <td width="80"><?=moedaUsaToBr($os->valor_total_geral);?></td>
         
        </tr>
<?php
			if($c%40==0 && $c>1){
				echo "<div class='quebra_pagina'></div>";								
			}
			$c++;
		}
?>	
		<tr>
		 <td colspan="6" style="text-align:right;font-weight:bold">Total: </td>
          <td width="80"><?=moedaUsaToBr($total_ordem_servico);?></td>
    	</tr>
    </tbody>
    
</table>
</div>
</div>
</body>
</html>