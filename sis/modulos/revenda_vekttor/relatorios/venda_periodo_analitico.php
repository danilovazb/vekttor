<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
	window.open("modulos/vekttor/relatorios/form_venda_pacotes.php","carregador");
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
<span></span>    Venda de Pacotes
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
        <a href="#" onclick="window.open('http://vkt.srv.br/~nv/sis/modulos/vekttor/tutorial?id=<?php echo $_GET['tela_id'];?>');">Tutorial</a>
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
          <td width="200">Cliente</td>
          <td width="110">Vlr implantaçao</td>
          <td width="110">Vlr mensalidade</td>
          <td width="110">Vlr Desconto</td>
          <td width="110">% Vendedor</td>
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
		if(!empty($_GET['busca'])){
			$busca = "AND id='".$_GET['busca']."' OR descricao LIKE '%".$_GET['busca']."%'";
		}
		$mes_atual=date("m");
		$registros= mysql_result(mysql_query($t="SELECT count(*) FROM 
							vekttor_venda
							WHERE
							revenda_franquia_id='$vkt_id'
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = mysql_query($t="SELECT * FROM 
							vekttor_venda
							WHERE
							revenda_franquia_id='$vkt_id'
							$filtro
							$busca
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			
		//echo $t;
		$soma_implantacao= 0;
		$soma_mensalidade=0;
		$soma_desconto=0;		
		while($r=mysql_fetch_object($sql)){
			
			$soma_implantacao+=$r->valor_implantacao;
			$soma_mensalidade+=$r->valor_mensalidade;
			$soma_desconto+=$r->valor_desconto;
			
			$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$r->cliente_vekttor_id'"));
			//echo $t;
			$vendedor = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$r->vendedor_id'")); 
			$porcentagem_vendedor = ($vendedor->implantacao*$r->valor_implantacao)/100;	
?>      
    	<tr <?=$sel?> id="<?=$r->id?>" onclick="location.href='?tela_id=359&vendedor_id=<?=$vendedor->id?>&data_ini=<?=$data_ini?>&data_fim=<?=$data_fim?>'">
          <td width="50"><?=$r->id?></td>
          <td width="200"><?=$cliente->nome?></td>
          <td width="110"><?=moedaUsaToBr($r->valor_implantacao)?></td>
          <td width="110"><?=moedaUsaToBr($r->valor_mensalidade)?></td>
          <td width="110"><?=moedaUsaToBr($r->valor_desconto)?></td>
          <td width="110"><?=moedaUsatoBr($porcentagem_vendedor)?></td>
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
            <td width="50"><?=$r->id?></td>
          <td width="200"></td>
          <td width="110"><?=moedaUsaToBr($soma_implantacao)?></td>
          <td width="110"><?=moedaUsaToBr($soma_mensalidade)?></td>
          <td width="110"><?=moedaUsaToBr($soma_desconto)?></td>
          <td width="110"></td>
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
