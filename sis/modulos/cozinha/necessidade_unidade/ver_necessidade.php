<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 


?>
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
    Cozinha 
</a>
<a href="../remessa_unidade/?tela_id=114" class="navegacao_ativo">
<span></span>    Remessa Unidade
</a>
</div>
<div id="barra_info">
<? $ultima_necessidade=mysql_result(mysql_query("SELECT * FROM cozinha_necessidade ORDER BY id DESC LIMIT 1"),0,0); ?>
<form method="get">
<input type="submit" value="Nova Remessa" style="margin:3px; float:right" />
<label>
<? $unidades_q=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); ?>
	<select name="unidade_id" id='unidade_id'style="margin:3px; float:right"  >
		<option value="0">Selecione a Filial</option>
        <? while($unidade=mysql_fetch_object($unidades_q)){ ?>
        <option value="<?=$unidade->id?>"><?=$unidade->nome?></option>
   <? } ?>
	</select>
    </label>
    <input type="hidden" name="necessidade_id" value="<?=$ultima_necessidade+1?>" />
    <input type="hidden" name="tela_id" value="225" />
    
</form>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="80"><?=linkOrdem("Nº.","nome",1)?></td>
          	<td width="250">Unidade Enviada</td>
            <td width="140">Período</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
	<? 
	$registros=mysql_result(mysql_query("SELECT * FROM cozinha_necessidade WHERE vkt_id='$vkt_id'"),0,0);
	$necessidades_q=mysql_query("SELECT cn.id as id, cu.nome as unidade FROM cozinha_necessidade as cn, cozinha_unidades as cu WHERE cn.vkt_id='$vkt_id' AND cn.unidade_id=cu.id ORDER BY nome ASC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])); 
	echo mysql_error();
	while($necessidade=mysql_fetch_object($necessidades_q)){
	?>
    	<tr onclick="location='?tela_id=225&necessidade_id=<?=$necessidade->id?>'">
            <td width="80"><?=$necessidade->id?></td>
          	<td width="250"><?=$necessidade->unidade?></td>
            <td width="140" align="left">24/10/2012 - 29/10/2012</td>
            <td></td>
        </tr>
   <? } ?>     
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="80">&nbsp;</td>
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
