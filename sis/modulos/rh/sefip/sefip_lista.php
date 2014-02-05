<?php

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
		window.open('modulos/rh/sefip/form.php','carregador');
	$("#gera_sefip").live('click',function(){
		
		var competencia = $("#competencia").val();
		var n = competencia.split("/");
		var empresa_id      = $("#empresa_id").val();
		var mes_competencia = n[0];
		var ano_competencia = n[1]; 
		var tipo_remessa    = $("#tipo_remessa").val();
		var modalidade_arquivo = $("#modalidade_arquivo").find("option").filter(":selected").val();
		var indicador_recolhimento_ps = $("select#indicador_recolhimento_ps").val();
	
		window.open('modulos/rh/sefip/sefip.php?mes_competencia='+mes_competencia+'&ano_competencia='+ano_competencia+'&empresa_id='+empresa_id+'&tipo_remessa='+tipo_remessa+'&modalidade_arquivo='+modalidade_arquivo+'&indicador_recolhimento_ps='+indicador_recolhimento_ps);
	});
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">&laquo;</div>

<a href="#" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>SEFIP
</a>
</div>

<div id="barra_info">    
	
 
  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
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