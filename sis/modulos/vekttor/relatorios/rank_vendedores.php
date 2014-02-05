<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		
		var id = $(this).attr('id');
		
		var data_ini = $(this).attr('data_ini');
		var data_fim = $(this).attr('data_fim');
		
		location.href='?tela_id=356&id='+id+'&data_ini='+data_ini+'&data_fim='+	data_fim;
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some"></div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="#" class='s1'>
  	Vektor
</a>
<a href="#" class='s2'>
  	Relatórios
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Rank Vendedores
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
          <td width="50">Codigo</td>
          <td width="200">Nome do Vendedor</td>
          <td width="200">Revendedora</td>
          <td width="70">Qtd Vendas</td>
          <td width="70">Vlr. Vendas</td>
        
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
			$filtro = " WHERE data_negociacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
		}else{
			$mes_atual=date("m");
			$filtro = "WHERE MONTH(data_negociacao) = '$mes_atual'";
		}
		if(!empty($_GET['busca'])){
			$busca = "AND (r.id='".$_GET['busca']."' OR r.nome LIKE '%".$_GET['busca']."%')";
		}
		$mes_atual=date("m");
		$registros= @mysql_result(mysql_query($t="SELECT DISTINCT(vendedor_id) as vendedor_id FROM 
							vekttor_venda
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = @mysql_query($t="SELECT * FROM 
							rh_funcionario
							WHERE 
							vendedor = 's'
							$busca
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			//echo $t;
		$valor_total = 0;
		$soma_qtd=0;
		$c=0;
		$resultado_vendedor = array();
		while($r=@mysql_fetch_object($sql)){
			
			//echo $t;
			$resultado_vendedor[$c]["id"] = $r->id;
			$resultado_vendedor[$c]["nome"] = $r->nome;
			
			$revendedora = @mysql_fetch_object(mysql_query($t="SELECT *,cv.id as cv_id FROM 
																	revenda_franquia rf,
																	clientes_vekttor cv
																	WHERE
																	cv.id = rf.cliente_vekttor_id AND
																	cliente_vekttor_id=$r->vkt_id"));
			//echo $t;
			$resultado_vendedor[$c]["revendedora"] = $revendedora->nome; 
			//qtd_implantacao e mansalidade
			$resultado_vendedor[$c]["qtd"] = @mysql_num_rows(mysql_query("SELECT * FROM vekttor_venda WHERE vendedor_id=$r->id"));
			$soma_qtd+=$resultado_vendedor[$c]["qtd"];
			//valor da venda de pacotes
			$vlr_venda = mysql_fetch_object(mysql_query($t="SELECT SUM(subtotal) as venda FROM vekttor_venda WHERE vendedor_id='$r->id'"));
			$resultado_vendedor[$c]["valor"]=$vlr_venda->venda;
			//echo $t;		
			$valor_total+=$vlr_venda->venda;
			$c++;
		}
		
		sizeof($resultado_vendedor);
		
		for($c=0;$c<sizeof($resultado_vendedor);$c++){
?>      
    	<tr <?=$sel?> id="<?=$resultado_vendedor[$c]["id"]?>" data_ini="<?=$data_ini?>" data_fim="<?=$data_fim?>">
          <td width="50"><?=$resultado_vendedor[$c]["id"]?></td>
          <td width="200"><?=$resultado_vendedor[$c]["nome"]?></td>
          <td width="200"><?=$resultado_vendedor[$c]["revendedora"]?></td>
          <td width="70"><?=moedaUsaToBr($resultado_vendedor[$c]["qtd"])?></td>
          <td width="70"><? if(!$resultado_vendedor[$c]["valor"]>0){ echo "0,00";}else{ echo moedaUsaToBr($resultado_vendedor[$c]["valor"]);}?></td>
          
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
          <td width="50"></td>
          <td width="200"></td>
          <td width="200"></td>
          <td width="70"><?=moedaUsaToBr($soma_qtd)?></td>
          <td width="70"><?=moedaUsaToBr($valor_total)?></td>
          
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
