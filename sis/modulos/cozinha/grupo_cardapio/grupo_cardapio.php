<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_functions.php");
include("_ctrl_grupo_cardapio.php");

?>
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
		</a><a href="./" class='s2'>
    Cozinha 
</a>
<a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>  <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
    	  <td width="90">Refei&ccedil;&atilde;o</td>
    	  <td width="50">Ordem</td>
            <td width="150"><?=linkOrdem("Nome","nome",1)?></td>
            <td width="50">Fichas </td>
          	<td >Descricao</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
  <?
$refeicoes = array(
"cafe"=>"Café",
"almoco"=>"Almoço",
"lanche"=>"Lanche",
"janta"=>"Janta",
"ceia"=>"Ceia",
);
foreach($refeicoes as $refeicao => $apelido){
	$linhas++;
?>
  <tr class="aplicavel">
      <td><strong>
        <?=$apelido?>
      </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <?
    $mq = mq($t="SELECT * FROM cozinha_cardapios_grupos WHERE vkt_id='$vkt_id' AND $refeicao='1' ORDER BY ".$refeicao."_ordem,ordem, nome ASC");
	while($r=mysql_fetch_array($mq)){
		$fichas_tecnicas_grupos = mysql_fetch_object(mysql_query("SELECT COUNT(*) as qtd FROM cozinha_fichas_tecnicas WHERE grupo_cardapio_id='$r[id]'"));
	$linhas++;
	?>
    <tr class="aplicavel"  onclick="window.open('<?=$caminho?>/form.php?id=<?=$r[id]?>','carregador')">
      <td width="90" >&nbsp;</td>
      <td width="50" ><?=$r[$refeicao."_ordem"]?></td>
      <td width="150" ><?=$r[nome]?></td>
      <td width="50" ><?=$fichas_tecnicas_grupos->qtd?></td>
      <td width="" >&nbsp;</td>
    </tr>
    <?
	}
}
	?>
    <tr class="aplicavel">
      <td><strong>Sem refei&ccedil;&atilde;o</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <?
    $mq = mq($t="SELECT * FROM cozinha_cardapios_grupos WHERE vkt_id='$vkt_id' AND cafe='0' AND almoco='0'AND janta='0'AND lanche='0'AND ceia='0' ORDER BY ordem, nome ASC");
	while($r=mf($mq)){
	$linhas++;
	?>
    <tr class="aplicavel"  onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->id?>','carregador')">
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td ><?=$r->nome?></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <?
	}
	?>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td><a>Total: <?=$total?></a></td>
      </tr>
    </thead>
</table>
<script>

	$("#dados tr.aplicavel:nth-child(2n+1)").addClass('al');
</script>

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
</div>
