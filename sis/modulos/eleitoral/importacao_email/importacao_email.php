<?php

$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 
include("_functions.php");
include("_ctrl.php");

?>

<script>

$(document).ready(function(){
	$("#tabela_dados tr.aplicavel:nth-child(2n+1)").addClass('al');
})

var tabAtual = 1
 
mudarTab = function(numeroTab) {
	$("#tab_"+tabAtual).toggle()
	$("#tab_"+numeroTab).toggle()
	tabAtual = numeroTab
}
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <!--<input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>-->
    <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET[busca]?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/politicos/busca_politico.php,@r0,0'/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="" class="navegacao_ativo">
<span></span>  Importaçao Email</a></div>
<div id="barra_info">
<form method="get">
	
 <input type="hidden" name="tela_id" value="398" />
 
<input type="button" name="importar" id="importar" value="Importar" style="float:right;margin-top:3px;" onClick="window.open('<?=$caminho?>/form.php','carregador')">
<!--<input type="button" name="exportar" id="exportar" value="Exportar" style="float:right;margin-top:3px;" onClick="window.open('modulos/eleitoral/sms_importado/exportar_mensagem.php?de=<?=$_GET['de']?>&ate=<?=$_GET['ate']?>&quantidade=<?=$_GET['quantidade']?>','carregador')">-->



</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td >Email</td>
             
             
          
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<!--<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
    		
					}
			
		?>        						
	
    </tbody>
</table>-->
</div>
</div>
<div id='rodape'>
	<!--Registros 
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
    </div>-->
</div>