<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
	#dados_fornecedores tbody tr:hover{
		background-color:#FFF;
	}
</style>
<script src="modulos/estoque/produtos/scripts.js">
</script>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>

<form class='form_busca' action="" method="get">
   	 <a></a>
	
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
    <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
    <input type="hidden" name="produto_grupo_id" value="<?=$_GET['produto_grupo_id']?>" />
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>    Produtos 
</a>
</div>
<div id="barra_info">
	<form style="float:left;" id="form_produtos">
    	<label>
        	<select id="produto_grupo_id" name="produto_grupo_id" onchange="document.getElementById('form_produtos').submit();">
            	<option value="0">Grupo de Produto</option>
                <? $grupos_q=mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
				while($grupo=mysql_fetch_object($grupos_q)){
					if($_GET['produto_grupo_id']==$grupo->id){$sel='selected="selected"';}else{$sel='';}
				?>
                <option <?=$sel?> value="<?=$grupo->id?>"><?=$grupo->nome?></option>
            	<? } ?>
            </select>
        </label>
        <label>
        	<select name="almoxarifado_id" onchange="document.getElementById('form_produtos').submit();">
            <option value="0">Almoxarifado</option>
            	<? 
				$unidades_q= mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
				while($unidade=mysql_fetch_object($unidades_q)){
					if($_GET['almoxarifado_id']==$unidade->id){$sel='selected="selected"';}else{$sel='';}
				?>
            	<option <?=$sel?> value="<?=$unidade->id?>"><?=$unidade->nome?></option>
                <? } ?>
            </select>
        </label>
        <? if($_GET['almoxarifado_id']>0){ 
			$estoque_min['true']="checked='checked'";
		?>
        <label>Em estoque mínimo
        	<input type="checkbox" name="estoque_minimo" value='true' <?=$estoque_min[$_GET['estoque_minimo']]?> onchange="document.getElementById('form_produtos').submit();" />
        </label>
        <? } ?>
        
        <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
		<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
        <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
        <input type="hidden" name="busca" value="<?=$_GET[busca]?>" />
    </form>
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <input type="button"  style="float:right; margin:2px 2px 0 0 " name='Imprimir Lista de Produtos' value="Imprimir Lista de Produtos" onclick="window.open('<?=$caminho?>lista_de_produtos_impressao.php','_blank')" />
    <? if($_GET['estoque_minimo']=='true'&&$_GET['almoxarifado_id']>0){ ?>
	<input type="button"  style="float:right; margin:2px 2px 0 0 " name='Imprimir Lista de Produtos' value="Cotar Produtos Selecionados" onclick="enviarParaCotacao()" />
    <? } ?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="100"><?=linkOrdem("ID","id",1)?></td>
          	<td width="200"><?=linkOrdem("Nome","nome",0)?></td>
			<td width="100"><a>Unidade</a></td>
            <td width="90">Em estoque</td>
            <td width="100">Estoque mínimo</td>
            <? if($_GET['estoque_minimo']=='true'&&$_GET['almoxarifado_id']>0){ ?>
            <td width="100">Cotar <input id="cotar_todos" type="checkbox" checked="checked" /></td>
            <? } ?>
          	<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<form id="produtos_para_cotacao" method="post" action="?tela_id=117">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody >
	
	<? 
	$grupo='Sem Grupo';
	if($_GET['produto_grupo_id']>0){$filtro_grupo=" AND p.produto_grupo_id='{$_GET[produto_grupo_id]}'";}
	if($_GET['almoxarifado_id']>0){$filtro_almoxarifado=" AND almoxarifado_id='{$_GET[almoxarifado_id]}'";}
	if($_GET['busca']!=''){$filtro_busca =" AND p.nome LIKE '%{$_GET[busca]}%' ";}
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT COUNT(*) FROM produto as p WHERE vkt_id='$vkt_id' $filtro_grupo $filtro_busca $filtro_grupo ORDER BY id DESC"),0,0);
	
	$produtos_q=mysql_query($a="
	SELECT 
		p.id as p_id, p.nome as nome, p.produto_grupo_id as produto_grupo_id, p.conversao2 as conversao2, p.unidade_embalagem as unidade_embalagem, p.estoque_min as estoque_min
	FROM 
		produto as p, produto_grupo as pg
	WHERE 
		p.vkt_id='$vkt_id' 
	AND 
		p.produto_grupo_id = pg.id 
		$filtro_grupo 
		
		$filtro_busca 
	GROUP BY
		p.id
	ORDER BY 
		pg.nome, p.nome
	LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $a;
	echo mysql_error();
	while($produto=mysql_fetch_object($produtos_q)){
		
		$total_estoque=0;
		$custo=0;
		$saldo_q = mysql_query($o="
		SELECT DISTINCT(almoxarifado_id) as a_id, produto_id as p_id, 
				(SELECT saldo FROM estoque_mov WHERE almoxarifado_id=a_id AND produto_id=p_id $filtro_almoxarifado ORDER BY id DESC LIMIT 1) 
				as ultimo_saldo 
			FROM 
				estoque_mov as e 
			WHERE 
				produto_id='$produto->p_id' $filtro_almoxarifado AND vkt_id='$vkt_id'  ");
		//echo $o;
		while($saldo=mysql_fetch_object($saldo_q)){
				//echo $produto->p_id." ".$saldo->ultimo_saldo."<br>";
				$total_estoque+=$saldo->ultimo_saldo;
		}
		if(($_GET['estoque_minimo']=='true'&&$_GET['almoxarifado_id']>0&&$produto->estoque_min>=($total_estoque/$produto->conversao2))||!$_GET['estoque_minimo']){
			if($produto->produto_grupo_id!=$grupo){
				$grupo_nome=mysql_fetch_object(mysql_query("SELECT * FROM produto_grupo WHERE id=".$produto->produto_grupo_id));
				$conversao = mysql_fetch_object(mysql_query($r=" SELECT * FROM produto WHERE id = '$produto->id'"));
		
		
		//protudo.conversao * produto.conversao2 * estoque_mov.saldo(onde produto_id = id do produto, ultimo saldo) * custo
		/*if($produto->ultimo_saldo){
			$saldo = '0';
		}else{
			$saldo=$saldo->saldo;
		}*/
		//echo "saldo=$saldo custo={$conversao->custo} conversao={$conversao->conversao} conversao2={$conversao->conversao2}<br>";
			$custo = @(@($saldo * $conversao->custo)/@($conversao->conversao*$conversao->conversao2));
	?>
    <tr>
    		<td colspan="7" style="background:url(../fontes/img/bb.jpg) repeat scroll 0 0; font-weight:bold;  color:#202020;"><?=$grupo_nome->nome;?></td>
    </tr>	
	<?
			$grupo=$grupo_nome->id;
		}
		$emestoque=@($total_estoque/$produto->conversao2);
		if($emestoque<=$produto->estoque_min){
			$color="#B94A48";
			
		}else{
			$color="";
		}
	?>
		<tr id="<?=$produto->p_id?>" style="color:<?=$color?>">
            <td class="abre_form" width="100"><?=$produto->p_id?></td>
          	<td class="abre_form" width="200"><?=$produto->nome?></td>
            <td width="100" align="right"><?=$produto->unidade_embalagem?></td>
			<td width="90" align="right"><?=qtdUsaToBr($emestoque)?></td>
            <td width="100" align="right">
			<?=qtdUsaToBr($produto->estoque_min)?></td>
            <? if($_GET['estoque_minimo']=='true'&&$_GET['almoxarifado_id']>0){ 
			?>
            <td width="100">
            	<input name="qtd_digitada[]" type="text" style=" width:50px; height:9px;" value="<?=$qtd_para_cotar?>" />
                <input name="qtd_sistema[]" type="hidden" style=" width:50px; height:9px;" value="<?=$qtd_para_cotar?>" />
                <input name="produto_id[]" class="cotar" type="checkbox" checked="checked"  value="<?=$produto->p_id?>"/>
            	<input type="hidden" name="necessidade_inicio"  value="<?=date('Y-m-d')?>" />
                <input type="hidden" name="necessidade_fim" value="<?=date('Y-m-d')?>" />    
            </td>
            <? } ?>
            <td></td>
        </tr>
	<?
	}
		}
	?>
    </tbody>
</table>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="100"><a>Total: <?=$total?></a></td>
            <td width="200">&nbsp;</td>
            <td width="100">&nbsp;</td>
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
	if(!isset($_GET['estoque_minimo'])){
		$estoque_minimo='false';
	}else{
		$estoque_minimo=$_GET['estoque_minimo'];
	}
	
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&produto_grupo_id=<?=$_GET['produto_grupo_id']?>&almoxarifado_id='+<?=$_GET['almoxarifado_id']?>+'&estoque_minimo='+<?=$estoque_minimo?>">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina.  <?=ceil($registros/$limitador)?> Total Páginas
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('produto_grupo_id'=>$_GET['produto_grupo_id'],'almoxarifado_id'=>$_GET['almoxarifado_id'],'estoque_minimo'=>$_GET['estoque_minimo']))?>
    </div>
</div>
