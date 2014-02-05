<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
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
<span></span>    Análise de Mensalidades
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
   
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			//echo "01/".date("m/Y")." a ".date("t/m/Y");
		}else{
			echo "Período:".$_GET['de']." a ".$_GET['ate'];
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
          <td width="200">Nome do Revendedor</td>
          <td width="100">Qtd Mensalidades</td>
          <td width="95">Vlr Mensalidades</td>
          <td width="95">% Mensalidades</td>
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
			$data_ini = $_GET['de']; $data_fim = $_GET['ate'];
		}else{
			$mes_atual=date("m");
			$filtro = "WHERE MONTH(data_negociacao) = '$mes_atual'";
			$data_ini = date("Y-m")."-01"; $data_fim = date("Y-m-t");
		}
		if(!empty($_GET['busca'])){
			$busca = "AND (rf.id='".$_GET['busca']."' OR cf.razao_social LIKE '%".$_GET['busca']."%')";
			
		}
		$mes_atual=date("m");		
		$registros= @mysql_result(mysql_query($t="SELECT DISTINCT(revenda_franquia_id) as franquia_id FROM 
							vekttor_venda
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = mysql_query($t="SELECT *, rf.id as rf_id,rf.cliente_vekttor_id as vkt_id FROM 
							revenda_franquia rf,
							cliente_fornecedor cf
							WHERE
							cf.id = rf.cliente_fornecedor_id
							$busca
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
				//echo $t;
		
		$soma_qtd = 0;
		$soma_vlr_implantacao = 0;
		$soma_vlr_mensalidade = 0;
		
		$valores_vendas = mysql_fetch_object(mysql_query("SELECT SUM(valor_mensalidade) as vm FROM vekttor_venda $filtro"));
		
		while($r=@mysql_fetch_object($sql)){
			//qtd_implantacao e mansalidade
			$qtd = @mysql_num_rows(mysql_query($t="SELECT * FROM vekttor_venda $filtro AND revenda_franquia_id = $r->vkt_id"));
			$soma_qtd += $qtd;
			//nome da revendedora
			$valores = @mysql_num_rows(mysql_query("SELECT SUM(valor_mensalidade) as vm FROM vekttor_venda $filtro AND revenda_franquia_id = $r->vkt_id"));
			
			$soma_vlr_mensalidade += $valores->vm; 
			if($valores_vendas->vm>0){
				$porcentagem_mensalidade = ($valores->vm*100)/$valores_vendas->vm;
			}
		
?>      
    	<tr <?=$sel?> id="<?=$r->id?>" onclick="location.href='?tela_id=366&revendedor_id=<?=$r->rf_id?>&data_ini=<?=$data_ini?>&data_fim=<?=$data_fim?>'">
          <td width="50"><?=$r->id?></td>
          <td width="200"><?=$r->razao_social?></td>
          <td width="100"><?=$qtd?></td>       
          <td width="95"><? if(!$valores->vm>0){echo "0";}else{ echo $valores->vm;}?></td>
          <td width="95"><? if(!$porcentagem_mensalidade>0){echo "0";}else{ echo $porcentagem_mensalidade;}?></td>
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
    	  <tr <?=$sel?> id="<?=$r->id?>">
          <td width="50"></td>
          <td width="200"></td>
          <td width="100"><?=$soma_qtd?></td>
        
          <td width="95"><?=moedaUsaToBr($soma_vlr_mensalidade)?></td>
          <td width="95"></td>
          <td></td>
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
