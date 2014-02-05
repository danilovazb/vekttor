<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 


include('_functions.php');
include('_ctrl.php');
?>
<script src="<?=$caminho?>ficha_tecnica.js"></script>

<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
</script>

<style>
.mais_e_menos{margin-top:2px; margin-bottom:2px;}
.grupo{background-color:gray; color:white;}
</style>

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
<a href="?tela_id=73" class="navegacao_ativo">
<span></span>    Ficha Técnica
</a>
</div>
<div id="barra_info">
<form method="get" id="cardapio_grupo" style="float:left;">
<label>Grupo
	<select name="cardapio_grupo_id" onchange="document.getElementById('cardapio_grupo').submit()">
    	<option value="0">Todos</option>
        <? $grupos_cardapio_q=mysql_query("SELECT * FROM cozinha_cardapios_grupos WHERE vkt_id='$vkt_id'");
		while($grupo=mysql_fetch_object($grupos_cardapio_q)){
			if($_GET[cardapio_grupo_id]==$grupo->id){$sel="selected='selected'";}else{$sel='';}
			?>
            <option <?=$sel?> value="<?=$grupo->id?>"><?=$grupo->nome?></option>
            <?
		}
		 ?>
    </select>
    <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
</label>
<label>Status
	<select name="status" onchange="document.getElementById('cardapio_grupo').submit()">
    	<option value="0">Todos</option>
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
    </select>
    <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
</label>
</form>
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <input type="button" style="float:right; margin:4px 5px 0 0;" value="Imprimir" onclick="window.open('<?=$caminho?>imprimir_ficha_tecnica.php')" />
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50">No.</td>
            <td width="220">Nome</td>
            <td width="150">Refei&ccedil;&atilde;o</td>
            <td width="100">Grupo</td>
          	
            <td width="60" align="right">Custo R$</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
	<? 
	
	$status='ativo';
	if(!empty($_GET['status'])){
		$status=$_GET['status'];
	}
	
	
	if($_GET[busca]!=''){$filtro_busca=" AND cf.nome LIKE '%{$_GET[busca]}%'";}
	if($_GET[cardapio_grupo_id]>0){$filtro_grupo=" AND cf.grupo_cardapio_id='{$_GET[cardapio_grupo_id]}'";}else{$filtro_grupo='';}
	//necessario para paginacao
	$registros=mysql_result(mysql_query("SELECT COUNT(*) FROM cozinha_fichas_tecnicas as cf WHERE cf.vkt_id='$vkt_id' $filtro_grupo $filtro_busca "),0,0);
	
	$ficha_q=mysql_query($t="SELECT *,cg.nome as grupo, cf.nome as nome, cf.id as id FROM cozinha_fichas_tecnicas as cf, cozinha_cardapios_grupos as cg 
	WHERE 
	cf.vkt_id='$vkt_id' AND cf.grupo_cardapio_id=cg.id  AND cf.status='$status' $filtro_grupo $filtro_busca LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])); 
//	echo $t;
	while($ficha=mysql_fetch_object($ficha_q)){
		$soma_produtos=mysql_fetch_object(mysql_query($t="
		SELECT
			SUM(p.custo*(cp.qtd/p.conversao2/p.conversao)) as total
		FROM
			produto as p, cozinha_ficha_has_produto as cp
		WHERE
			cp.ficha_id='{$ficha->id}' AND
			p.id=cp.produto_id "));
		//echo $t;
		$refeicao = ucwords($ficha->refeicao);
		$refeicao = str_replace("seia","ceia",$refeicao); 
	?>
    
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$ficha->id?>','carregador')">
            <td width="50"><?=$ficha->id?></td>
            <td width="220"><?=$ficha->nome?></td>
            <td width="150"><?=$refeicao?></td>
            <td width="100"><?=$ficha->grupo?></td>
          	
            <td width="60" align="right"><?=number_format($soma_produtos->total,2,',','.')?></td>
            <td></td>
        </tr>
    	<? } ?>
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
