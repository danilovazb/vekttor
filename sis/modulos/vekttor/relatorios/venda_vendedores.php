<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		
		//window.open('modulos/aluguel/relatorios/receitas/form.php?id='+id,'carregador');
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<a href="#" class='s1'>
  	Vektor
</a>
<a href="#" class='s2'>
  	Relatórios
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Análise de Revendedor
</a>
</div>
<div id="barra_info">
	<input type="button" value="<<" onclick="location.href='?tela_id=341'">
	<?php
		$vendedor = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE id=".$_GET['id']));
		$revendedora = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id=".$vendedor->vkt_id));
		echo "<strong>Vendedor:</strong>$vendedor->nome&nbsp;&nbsp;&nbsp;";
		echo "<strong>Revendedora:</strong>$revendedora->nome";
	?>
    <span style="float:right">
   
  Período: 
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "01/".date("m/Y")." a ".date("t/m/Y");
		}else{
			echo $_GET['de']." a ".$_GET['ate'];
		}?>
  </span>   
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
          
          <td width="65">Vlr Implant</td>
          <td width="65">% Implant</td>
          
          <td width="65">Vlr Mensal</td>
          <td width="65">% Mensal</td>
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
		}else{
			$mes_atual=date("m");
			$filtro = "AND MONTH(data_negociacao) = '$mes_atual'";
		}
		if(!empty($_GET['busca'])){
			$busca = "AND (r.id='".$_GET['busca']."' OR r.nome LIKE '%".$_GET['busca']."%')";
		}
		$mes_atual=date("m");
		$registros= @mysql_result(mysql_query($t="SELECT DISTINCT(revenda_franquia_id) as franquia_id FROM 
							vekttor_venda
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = mysql_query($t="SELECT * FROM 
							vekttor_venda
							WHERE 
							vendedor_id = ".$_GET['id']."
							$filtro
							$busca
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;
		$valor_total_implantacao_mensalidade = @mysql_fetch_object(mysql_query($t="SELECT SUM(valor_implantacao)as implantacao,SUM(valor_mensalidade) as mensalidade FROM vekttor_venda"));//echo $t;	
		$resultado_revendedor = array();
		$c=0;
		$soma_implantacao = 0;
		$soma_mensalidade = 0;
		while($r=@mysql_fetch_object($sql)){
			//qtd_implantacao e mansalidade
			$resultado_revendedor[$c]["id"] = $r->id;	
			
			$resultado_revendedor[$c]["v_implantacao"] = $r->valor_implantacao;
			$soma_implantacao+=$r->valor_implantacao;
			if($r->subtotal>0){
				$resultado_revendedor[$c]["p_implantacao"] = ($r->valor_implantacao * 100)/ $r->subtotal;
			}
			$resultado_revendedor[$c]["v_mensalidade"] = $r->valor_mensalidade;
			$soma_mensalidade+=$r->valor_mensalidade; 
			if($r->subtotal>0){
				$resultado_revendedor[$c]["p_mensalidade"] = ($r->valor_mensalidade* 100)/ $r->subtotal;
			}
			$c++;			
		}
		
		sort($resultado_revendedor);
		
		for($c=0;$c<=sizeof($resultado_revendedor)-1;$c++){
?>      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="50"><?=$resultado_revendedor[$c]["id"]?></td>
          <td width="65"><?=moedaUsaToBr($resultado_revendedor[$c]["v_implantacao"])?></td>
          <td width="65"><?=moedaUsaToBr($resultado_revendedor[$c]["p_implantacao"])?></td>          
          <td width="65"><?=moedaUsaToBr($resultado_revendedor[$c]["v_mensalidade"])?></td>
          <td width="65"><?=moedaUsaToBr($resultado_revendedor[$c]["p_mensalidade"])?></td>
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
          <td width="65"><?=moedaUsaToBr($soma_implantacao)?></td>
          <td width="65"></td>          
          <td width="65"><?=moedaUsaToBr($soma_mensalidade)?></td>
          <td width="65"></td>
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
