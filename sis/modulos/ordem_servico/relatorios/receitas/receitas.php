<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		
		window.open('modulos/ordem_servico/relatorios/receitas/form.php?id='+id,'carregador');
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
$("#imprimir").live("click",function(){
	id = $("#id").val();
	//alert(id);
	window.open("modulos/ordem_servico/relatorios/receitas/impressao_receita.php?id="+id);
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="?tela_id=281" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	OS
</a>
<a href="?tela_id=<?=$_GET['tela_id']?>" class='navegacao_ativo'>
<span></span>    Receitas X Despesas
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
  <span style="float:right">
  Período: 
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "01/".date("m/Y")." a ".date("t/m/Y");
		}else{
			echo $_GET['de']." a ".$_GET['ate'];
		}?>
  </span>
  <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["de"];?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["ate"];?>" height="7"/>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
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
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="200">Cliente</td>
          <td width="70">Valor</td>
          <td width="70">Despesas</td>
          <td width="70">Desp. Peças</td>
          <td width="100">Comissao Func.</td>
          <td width="100">Comissao Vende.</td>
          <td width="70">Lucro</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro = " AND os.data_aprovacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
		}else{
			$mes_atual=date("m");
			$filtro = "AND MONTH(data_aprovacao) = '$mes_atual'";
		}
		if(!empty($_GET['busca'])){
			$busca = "AND id='".$_GET['busca']."' OR descricao LIKE '%".$_GET['busca']."%'";
		}
		$mes_atual=date("m");
		$registros= mysql_result(mysql_query("SELECT count(*) FROM 
							os 
							WHERE
							vkt_id='$vkt_id' 
							$filtro
							$busca"),0,0);
		$sql = mysql_query($t="SELECT * FROM 
							os 
							WHERE
							vkt_id='$vkt_id' 
							$filtro 
							$busca
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			
		//echo $t;
		$soma_valor = 0;
		$soma_despesa=0;
		$soma_lucro=0;
		$soma_funcionario=0;
		$soma_pecas=0;
		$soma_vendedor=0;
		
		while($r=mysql_fetch_object($sql)){
			$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id=$r->cliente_id AND cliente_vekttor_id=$vkt_id"));
			
			$valores_servicos=mysql_fetch_object(mysql_query($t="SELECT SUM(valor_servico * qtd_servico) as servico, SUM(valor_funcionario) as funcionario FROM os_item WHERE os_id=$r->id AND vkt_id='$vkt_id'"));
			//echo $t;	
			$valores_produtos=mysql_fetch_object(mysql_query($t="SELECT SUM(valor_produto * qtd_produto) as produto FROM os_item_produto WHERE os_id=$r->id AND vkt_id='$vkt_id'"));
			$produtos = mysql_query($t="SELECT DISTINCT(produto_id) as produto_id FROM os_item_produto WHERE os_id=$r->id AND vkt_id='$vkt_id'");
			//echo $t;
			$soma_vlr_produtos = 0;
			while($produto_id=mysql_fetch_object($produtos)){
				$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id=$produto_id->produto_id"));
				$soma_vlr_produtos+=$produto->preco_compra;
			}
			//$vlr_venda_produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id"));
			
			//echo $valores_produtos->produto;
			//echo $t;
			$custos_os = mysql_fetch_object(mysql_query($t="SELECT SUM(total_item) as custo FROM os_custo WHERE os_id=$r->id AND vkt_id='$vkt_id'"));
			if($os->valor_total>0){
			 	$comissao_vendedor = $os->comissao_vendedor*100/$os->valor_total;
			}else{
				$comissao_vendedor = 0.00;
			}
			//echo $t."<br>";
			//$despesas = $qtd->produto+$qtd->funcionario;
			 
			$soma_valor+=$valores_servicos->servico;
			$soma_valor+=$valores_produtos->produto;
			$soma_produto+=$valores_produtos->produto;
			$soma_despesa+=$custos_os->custo;
			$soma_pecas+=$soma_vlr_produtos;
			
			$soma_lucro+=$valores_servicos->servico+$valores_produtos->produto-$valores_servicos->funcionario-$comissao_vendedor-$custos_os->custo-$soma_vlr_produtos;	
			$soma_funcionario+=$valores_servicos->funcionario;
?>      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="60"><?=$r->id?></td>
          <td width="200"><?=$cliente->razao_social?></td>
          <td width="70"><?=moedaUsaToBr($valores_servicos->servico+$valores_produtos->produto)?></td>
          <td width="70"><?=moedaUsaToBr($custos_os->custo)?></td>
          <td width="70"><?=moedaUsaToBr($soma_vlr_produtos)?></td>
          <td width="100"><?=moedaUsaToBr($valores_servicos->funcionario)?></td>
          <?php
			if($r->comissao_vendedor>0){
				$comissao_vendedor = $r->comissao_vendedor*($valores_servicos->servico+$valores_produtos->produto)/100;
			}else{
				$comissao_vendedor = 0.00;
			}
			$soma_vendedor+=$comissao_vendedor;
?>
          <td width="100"><?=moedaUsaToBr($comissao_vendedor)?></td>
          <td width="70"><?=moedaUsaToBr($valores_servicos->servico+$valores_produtos->produto-$valores_servicos->funcionario-$comissao_vendedor-$custos_os->custo-$soma_vlr_produtos)?></td>
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
    	<tr <?=$sel?>>
          <td width="60"></td>
          <td width="200"></td>
          <td width="70"><?=moedaUsaToBr($soma_valor)?></td>
          <td width="70"><?=moedaUsaToBr($soma_despesa)?></td>
          <td width="70"><?=moedaUsaToBr($soma_pecas)?></td>
          <td width="100"><?=moedaUsaToBr($soma_funcionario)?></td>
          <td width="100"><?=moedaUsaToBr($soma_vendedor)?></td>
          <td width="70"><?=moedaUsaToBr($soma_lucro)?></td>
          <td></td>
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
