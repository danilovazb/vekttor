<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});

$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
$(".exibe_modulos").live('click',function(){
		//alert("oi");
		id = $(this).attr('r');
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
		$(".submodulos").hide();

		$("#div"+id).show();
			
	
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
          <td width="200">Nome</td>
          <td width="70">Qtd Vendida</td>
          
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
			$busca = "WHERE (id='".$_GET['busca']."' OR nome LIKE '%".$_GET['busca']."%')";
		}
		$mes_atual=date("m");
		$registros= @mysql_result(mysql_query($t="SELECT COUNT(*) FROM 
							pacotes							 
							$busca"),0,0);
							//echo $t;
		$sql = mysql_query($t="SELECT * FROM 
							pacotes
							$busca							
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			//echo $t;
		
		$c=0;
		$resultado_pacote = array();
		$soma_qtd=0;		
		while($r=@mysql_fetch_object($sql)){
			$resultado_pacote[$c]["qtd"] = @mysql_num_rows(mysql_query($t="SELECT * FROM vekttor_venda_pacote WHERE pacotes_id='$r->id'"));
			
			$soma_qtd+=$resultado_pacote[$c]["qtd"];
			
			$resultado_pacote[$c]["id"] = $r->id;
			$resultado_pacote[$c]["nome"] = $r->nome;
			$c++;
			
		}
		
		rsort($resultado_pacote);
		//var_dump($resultado_pacote);
		for($c=0;$c<sizeof($resultado_pacote);$c++){
?>      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="50"><?=$resultado_pacote[$c]["id"]?></td>
          <td width="200"><?=$resultado_pacote[$c]["nome"]?></td>
          <td width="70"><?=$resultado_pacote[$c]["qtd"]?></td>
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
          <td width="70"><?=$soma_qtd?></td>
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
