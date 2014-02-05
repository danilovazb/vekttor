<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_function.php");
include("_ctrl.php");

?>

<script>

$(document).ready(function(){
	$("#dados tr.aplicavel:nth-child(2n+1)").addClass('al');
});

$("#define_sexo_m,#define_sexo_f").live("click",function(){
	var id = $(this).parent().parent().attr("id");
	var sexo = $(this).val();
	$.post("modulos/eleitoral/definir_sexo/recebe_requisicao.php",{sexo:sexo,id:id},function(data){});

});

</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <!--<input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/colaborador/busca_colaborador.php,@r0,@r1-value>busca_id,0' autocomplete="off"/>-->
     <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET[busca]?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/colaborador/busca_colaborador.php,@r0,0'/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="?tela_id=103" class="navegacao_ativo">
<span></span>  Definir Sexo </a></div>
<div id="barra_info">
    <a href="<?=$caminho?>/form_colaborador.php" target="carregador" class="mais"></a>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200"><?=linkOrdem("Nome","nome",1)?></td>
            <td width="200"><?=linkOrdem("E-mail","E-mail",0)?></td>
            <td width="100">Definir sexo</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="dados">
    <?
	//echo $vkt_id;
	$checked_m = "";
	$checked_f = "";
	$checked = "";
	
	if(isset($_GET['busca'])){ $filtro_eleitor = " AND nome LIKE '%".$_GET['busca']."%' ";} else{$filtro_eleitor='';} 
	$registros= @mysql_result(mysql_query("SELECT COUNT(*) FROM eleitoral_eleitores WHERE vkt_id='$vkt_id'"),0,0);
	
	$sql = mysql_query(" SELECT * FROM eleitoral_eleitores WHERE vkt_id = '$vkt_id' $filtro_eleitor LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));	
	while($colaborador=mysql_fetch_object($sql)){
			if($colaborador->sexo == "masculino"){
				$checked_f = '';
				$checked_m = 'checked="checked"';
			
			} else if($colaborador->sexo == "feminino"){
				$checked_m = '';
				$checked_f = 'checked="checked"';
			}
	?>
     <tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_colaborador.php?id=<?=$colaborador->id?>','carregador')" id="<?=$colaborador->id?>">
            <td width="200"><?=$colaborador->nome;?></td>
            <td width="200"><?=$colaborador->endereco?></td>
            <td width="100">
            <input type="radio" name="define_sexo_<?=$colaborador->id?>" <?=$checked_m?> id="define_sexo_m" value="masculino"> H    
            <input type="radio" name="define_sexo_<?=$colaborador->id?>" <?=$checked_f?> id="define_sexo_f" value="feminino"> F 
            </td>
            <td >&nbsp;</td>
        </tr>
     <? 
	 } 
	 ?>
    </tbody>
</table>
</div>


<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><a>Total: <?=$total?></a></td>
            <td width="400">&nbsp;</td>
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