<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		
		window.open('modulos/aluguel/relatorios/receitas/form.php?id='+id,'carregador');
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
$("#imprimir").live("click",function(e) {
	id=$("#id").val();
	window.open("modulos/aluguel/relatorios/receitas/impressao_receita.php?id="+id);
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id='some'>«</div>
<a href="" class='s1'>
  	Sistema
</a>
<a href="" class='s1'>
  	Aluguel
</a>
<a href="" class='s2'>
  	Relatórios
</a>
<a href="../?tela_id=<?=$_GET['tela_id']?>" class='navegacao_ativo'>
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
          <td width="200">Descricao</td>
          <td width="70">Valor</td>
          <td width="70">Custos</td>
          <td width="70">Com. Vendedor</td>
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
			$filtro = " AND data_locacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
		}else{
			$mes_atual=date("m");
			$filtro = "AND MONTH(data_locacao) = '$mes_atual'";
		}
		if(!empty($_GET['busca'])){
			$busca = "AND id='".$_GET['busca']."' OR descricao LIKE '%".$_GET['busca']."%'";
		}
		$mes_atual=date("m");
		$registros= mysql_result(mysql_query($t="SELECT count(*) FROM 
							aluguel_locacao
							WHERE
							vkt_id='$vkt_id' AND
							status_locacao!='7'
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = mysql_query($t="SELECT * FROM 
							aluguel_locacao 
							WHERE
							vkt_id='$vkt_id' AND 
							status_locacao!=7
							$filtro 
							$busca
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			
		//echo $t;
		$soma_valor = 0;
		$soma_lucro=0;
		$soma_custos=0;		
		while($r=mysql_fetch_object($sql)){
			$valores_aluguel=mysql_fetch_object(mysql_query($t="SELECT * FROM aluguel_locacao WHERE id=$r->id AND vkt_id='$vkt_id'"));
			$custos_locacao = mysql_query($t="SELECT * FROM aluguel_custos WHERE locacao_id=$r->id AND vkt_id='$vkt_id'");
			$custo_total = 0;
			while($custo=mysql_fetch_object($custos_locacao)){
				$custo_total+= $custo->valor * $custo->qtd;
			}
			//echo $t."<br>";
			//$despesas = $qtd->produto+$qtd->funcionario;
			$soma_valor+=$valores_aluguel->valor_total;
			$soma_lucro+=$valores_aluguel->valor_total-$custo_total;	
			$soma_custos+=$custo_total;
			if(!$r->comissao_vendedor>0){$comissao_vendedor="0,00";}else{$comissao_vendedor=$r->comissao_vendedor*$valores_aluguel->valor_total/100;}
			
?>      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="60"><?=$r->id?></td>
          <td width="200"><?=$r->descricao?></td>
          <td width="70"><?=moedaUsaToBr($valores_aluguel->valor_total)?></td>
          <td width="70"><?=moedaUsaToBr($custo_total)?></td>
          <td width="70"><?=moedaUsaToBr($comissao_vendedor)?></td>
          <td width="70"><?=moedaUsaToBr($valores_aluguel->valor_total-$custo_total)?></td>
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
          <td width="70"><?=moedaUsaToBr($soma_custos)?></td>
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
