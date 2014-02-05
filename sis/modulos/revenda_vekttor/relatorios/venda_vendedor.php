<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		//var id = $(this).attr('id');
		
		//location.href='?tela_id=319';
		//window.open("modulos/vekttor/relatorios/form_venda_pacotes.php","carregador");
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="#" class='s2'>
  	Relatórios
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Venda Vendedor
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
		if(!empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "Período:".$_GET['de']." a ".$_GET['ate'];
		}else{			
			echo "01/".date("m/Y")." a ".date("t/m/Y");
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
          <td width="100">Qtd. Vendas</td>
          <td width="100">Vlr. Implantacao</td>
          <td width="100">Vlr. Mensalidade</td>
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
			$filtro = " AND data_negociacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
			$data_ini = $_GET['de'];$data_fim = $_GET['ate'];
		}else{
			$mes_atual=date("m");
			$filtro = "AND MONTH(data_negociacao) = '$mes_atual'";
			$data_ini = date("Y-m")."-01";$data_fim = date("Y-m-t");
		}
		
		$registros= @mysql_result(mysql_query($t="SELECT DISTINCT(vendedor_id) sa vendedor_id FROM 
							vekttor_venda
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = @mysql_query($t="SELECT DISTINCT(v.vendedor_id) FROM 
							vekttor_venda v,
							rh_funcionario rh
							WHERE
							rh.id=v.vendedor_id
							AND rh.cliente_vekttor_id='$vkt_id'
							$filtro
							$busca
							ORDER BY (SELECT COUNT(vendedor_id) FROM vekttor_venda) DESC
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			//echo $t;
		
		$c=0;
		$soma_implantacao=0;
		$soma_mensalidade=0;
		$resultado_vendedor = array();
			while($r=@mysql_fetch_object($sql)){
			
			 $valores = @mysql_fetch_object(mysql_query($t="SELECT SUM(valor_implantacao) as implantacao,SUM(valor_mensalidade)as mensalidade FROM vekttor_venda WHERE vendedor_id=$r->vendedor_id"));
			// echo $t;
			$qtd_venda = mysql_num_rows(mysql_query("SELECT * FROM vekttor_venda WHERE vendedor_id = $r->vendedor_id $filtro $busca"));
			$resultado_vendedor[$c]["qtd_venda"] = $qtd_venda;
			$resultado_vendedor[$c]["vlr_implantacao"] = $valores->implantacao;
			$soma_implantacao+=$resultado_vendedor[$c]["vlr_implantacao"];
			$resultado_vendedor[$c]["vlr_manesalidade"] = $valores->mensalidade;
			$soma_mensalidade+=$resultado_vendedor[$c]["vlr_manesalidade"];
			
			$vendedor = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario rh
														WHERE id=$r->vendedor_id"));
			$resultado_vendedor[$c]["id"] = $vendedor->id;
			$resultado_vendedor[$c]["nome"] = $vendedor->nome;
			
			
			
			//valor da venda de pacotes
			
			$c++;
		}
		
		sizeof($resultado_vendedor);
		
		for($c=0;$c<sizeof($resultado_vendedor);$c++){
?>      
    	<tr <?=$sel?> id="<?=$r->id?>" onclick="location.href='?tela_id=359&vendedor_id=<?=$resultado_vendedor[$c]["id"]?>&data_ini=<?=$data_ini?>&data_fim=<?=$data_fim?>'">
          <td width="50"><?=$resultado_vendedor[$c]["id"]?></td>
          <td width="200"><?=$resultado_vendedor[$c]["nome"]?></td>
          <td width="100"><?=$resultado_vendedor[$c]["qtd_venda"]?></td>
          <td width="100"><?=MoedaUsaToBr($resultado_vendedor[$c]["vlr_implantacao"])?></td>
          <td width="100"><?=MoedaUsaToBr($resultado_vendedor[$c]["vlr_manesalidade"])?></td>
                   
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
          <td width="100"><?=moedaUsaToBr($soma_implantacao)?></td>
          <td width="100"><?=moedaUsaToBr($soma_mensalidade)?></td>
                   
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
