<?php
session_start();

//include("_functions.php");
//include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="?tela_id=281" class='s1'> SISTEMA </a>
<a href="?" class='s2'> OS </a>
<a href="?tela_id=549" class='navegacao_ativo'>
<span></span>    Produtos em Garantia
</a>
<form class='form_busca' action="" method="get">
   	 <a id="clickbusca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
  <form method="get" autocomplete="off">
	
  <input type="hidden" name="tela_id" value="548" />
  </form>
</div>

<script>
$(document).ready(function(){
	$("tr:odd").addClass('al');
});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="90">Nº Série</td>
          <td width="150">Cliente</td>
          <td width="80">Data entrada</td>
          <td width="80">Garantia até</td>
          <td width="90">Valor serviço</td>
          <td width="90">Valor produto</td>
          <td width="70">Sub-total</td>
          <td width="70">Valor total</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
  <tbody>
      <?php 
     		
			$filter = !empty($_GET["busca"]) ? "AND oe.numero_serie = '".trim($_GET["busca"])."' " : NULL;
			
			$sql = mysql_query($t=" SELECT *, 
			oe.nome AS nomeEquipamento, os.data_cadastro AS dataEntrada, oe.numero_serie AS Nserie, os.id AS ID_os 
			FROM os  
				JOIN os_has_equipamento AS oep ON oep.os_id = os.id
				JOIN os_equipamento AS oe ON oe.id = oep.equipamento_id  
				JOIN cliente_fornecedor AS cliente ON cliente.id = os.cliente_id
				WHERE os.vkt_id = '$vkt_id'  
				AND os.garantia in(2,3)
				$filter ");
			
			while($reg=mysql_fetch_object($sql)){
				
				$totalProduto = mysql_fetch_object(mysql_query(" SELECT  count(id),sum(valor_produto * qtd_produto) as total_produto FROM os_item_produto WHERE os_id = '$reg->ID_os' AND vkt_id = '$vkt_id' "));
				$totalServico = mysql_fetch_object(mysql_query(" SELECT  count(id), sum(valor_servico * qtd_servico) as total_servico FROM os_item WHERE os_id = '$reg->ID_os' AND vkt_id = '$vkt_id' "));
			
      ?>      
      <tr>
          <td width="90"><?=$reg->Nserie?></td>
          <td width="150"><?=$reg->nomeEquipamento?></td>
          <td width="80"><?=dataUsaToBr($reg->data_cadastro)?></td>
          <td width="80"><?=dataUsaToBr($reg->data_final_garantia)?></td>
          <td width="90"><?=moedaUsaToBr($totalServico->total_servico)?></td>
          <td width="90"><?=moedaUsaToBr($totalProduto->total_produto)?></td>
          <td width="70"><?=moedaUsaToBr($reg->valor_total)?></td>
          <td width="70"><?=moedaUsaToBr($reg->valor_total_geral)?></td>
          <td></td>
      </tr>
    <?php
			}
    ?>
  </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
