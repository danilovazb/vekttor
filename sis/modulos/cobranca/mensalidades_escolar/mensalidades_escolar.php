<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<script src="<?=$caminho?>/mensalidade_escolar.js"></script>
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
  <div id="some">«</div>
		<a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>Escolar</a><a href="./" class='s2'>
    Cobrança 
</a>
<a href="?tela_id=37" class="navegacao_ativo">
<span></span><?=$tela->nome?> 
</a>
</div>
<div id="barra_info"><a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150">Cod. Cobrança</td>
            <td width="110">Total de Boletos</td>
            <td width="120">Data gerada</td>
            <td></td>
        </tr>
    </thead>
</table>
<script type="text/javascript">
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
	<tbody>
    <? 
	$cobrancas_q=mysql_query($a="SELECT *, DATE_FORMAT(datahora_gerada,'%d/%m/%Y %H:%i:%s') as gerado_em FROM cobrancas_escolar WHERE vkt_id='$vkt_id' ORDER BY id DESC");
	echo mysql_error();
	while($cobranca=mysql_fetch_object($cobrancas_q)){
		$qtd_boletos=mysql_result(mysql_query("SELECT COUNT(*) FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND origem_id='$cobranca->id' AND origem_tipo='Mensalidade escolar' "),0);
		echo mysql_error();
	?>
    <tr>
    	<td width="150"><?=$cobranca->id?></td><td width="110"><?=$qtd_boletos?></td><td width="120"><?=$cobranca->gerado_em?></td><td></td>
    </tr>
    <? } ?>
    </tbody>
</table>
</div>
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
