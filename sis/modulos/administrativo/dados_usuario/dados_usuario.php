<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");

global $usuario_id;
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	var usuario_id = $("#usuario_id").val();
	window.open("modulos/administrativo/dados_usuarios/form.php?usuario_id="+usuario_id,"carregador");
});
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id='some'>«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    Administrativo 
</a>
<a href="" class="navegacao_ativo">
<span></span>    Usuário 
</a>
</div>
<div id="barra_info">
  
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
       
            <td width="100%"></td>
          	
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
       
            <td width="230"></td>
          	<td width="130"></td>
          	<td width="110"></td>
          	<td width="80"></td>
			<td width="110"></td>
            <td></td>
        </tr>
</table>
<input type="hidden" name="usuario_id" id="usuario_id" value="<?=$usuario_id?>">
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
