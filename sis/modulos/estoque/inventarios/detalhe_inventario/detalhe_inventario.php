<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho;
include('modulos/estoque/_functions_estoque.php'); 
include '_functions.php';
include '_ctrl.php';
?>
<script>
$(document).ready(function(){
	//$("#tabela_dados tr.produtos_tabela:odd").addClass('al');
	$("#tabela_dados tr td input").on('focus',function(){
		tds = $(this.parentNode.parentNode).find('td');
		$(tds).css('background-color','#8BA7C9');
		$(tds).css('color','#FFF');
	});
	
	$("#tabela_dados tr td input").on('blur',function(){
		tds = $(this.parentNode.parentNode).find('td');
		
		if($(this.parentNode.parentNode).hasClass('al')){
			$(tds).css('background-color','#F1F5FA');
		}else{
			$(tds).css('background-color','#FFF');
		}
		$(tds).css('color','#000');
		
		
	});
	
})
</script>
<script>
function calcula(t){
	estoque_qtd	= $(t.parentNode.parentNode).find('.estoque_qtd').val()*1;
	
	nova_qtd	= qtdBrToUsa($(t.parentNode.parentNode).find('.qtdn').val(),3)*1;
	
	conversao2	= $(t.parentNode.parentNode).find('.conversao2').val()*1;
	
	
	und=$(t.parentNode.parentNode).find('.und').val();
	
	preco_produto=$(t).parent().parent().find('.produto_preco').val()*1;
	
	
	if(und== 'unidade_embalagem'){
		estoque_qtd=estoque_qtd/conversao2;
	}else{
		estoque_qtd=estoque_qtd;
		preco_produto = preco_produto/conversao2;
	}
	qtd_novo=nova_qtd-estoque_qtd;
	valor_diferenca = preco_produto*qtd_novo;
	//document.title =  "estoque_qtd="+estoque_qtd+"; nova_qtd="+nova_qtd+"; conversao2="+conversao2+"; und="+und+"; preco_produto="+preco_produto+'; qtd_novo='+qtd_novo+'; valor_diferenca'+valor_diferenca;
	
	$(t.parentNode.parentNode).find('.valor_diferenca').html(qtdUsaToBr(valor_diferenca,3));
	$(t.parentNode.parentNode).find(".diferenca").html(qtdUsaToBr(qtd_novo,3));
	
}

function atualiza(t){
	id = $(t).parent().parent().find('.produto_id').val();
	
	v=$(t).parent().parent().find('.qtdn').val();
	
		
	//alert(diferenca);
	if(v!=''){
		calcula(t);	
		nova_qtd=v;
		
		estoque_inventario_item_id=$(t).parent().parent().find('.estoque_inventario_item_id').val();
		qtd_estoque=$(t).parent().parent().find('.estoque_qtd').val();
		conversao2=$(t.parentNode.parentNode).find('.conversao2').val()*1;

		ocorrencia=$(t).parent().parent().find('.ocorrencia').val();
		und=$(t.parentNode.parentNode).find('.und').val();
		qtd_diferenca=qtdBrToUsa($(t).parent().parent().find('.diferenca').text(),3);
		valor_diferenca = $(t).parent().parent().find('.valor_diferenca').text();
	  
		produto_preco=$(t).parent().parent().find('.produto_preco').val();
	
		$(t.parentNode.parentNode).find('.alterado').html('...carregando');
		infoload = "<?=$caminho?>atualiza_inventario.php?&estoque_inventario_item_id="+estoque_inventario_item_id+"&nova_qtd="+nova_qtd+"&qtd_estoque="+qtd_estoque+"&ocorrencia="+escape(ocorrencia)+"&conversao2="+conversao2+'&unidade='+und+'&qtd_diferenca='+qtd_diferenca+'&valor_diferenca='+valor_diferenca+'&valor_produto='+produto_preco;
		//document.title=infoload;
		$(t.parentNode.parentNode).find('.alterado').load(infoload);
	}
	
	
}

$('.qtdn').live('keyup',function(){
	var valor_total=0;
		
	$(this).parent().parent().parent().find('.valor_diferenca').each(function(){
		valor_total += (moedaBrToUsa($(this).html()))*1;
	})
	
	valor_total=moedaUsaToBR(valor_total.toFixed(2));
		
	$("#total_diferenca").html('');
	$("#total_diferenca").html(valor_total);
	atualiza(this);
		
});

$('.und').live('change',function(){
	var valor_total=0;
		
	$(this).parent().parent().parent().find('.valor_diferenca').each(function(){
		valor_total += (moedaBrToUsa($(this).html()))*1;
	})
	
	valor_total=moedaUsaToBR(valor_total.toFixed(2));
		
	$("#total_diferenca").html('');
	$("#total_diferenca").html(valor_total);
	atualiza(this);
});

$('.ocorrencia').live('blur',function(){
	atualiza(this)
});

$("#grupoProdutoID").live("change",function(){
	$("#form_filter").submit();
});

</script>
<style>
.qtdn{width:50px; }
.alterado{color:#B9EEAD}
.g{background:url(../fontes/img/bb.jpg); font-weight:bold; }
.qtdn{ border:1px solid #CCC}
.ocorrencia{margin-left:-8px;width:125px; height:12px;  border:1px solid #CCC}
.qtdn{ margin-right:5px;}
.und{ width:90px; text-align:right}
.und option{text-align:right}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>

<div id="some">«</div>

<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s1'>
  	Estoque
</a>
<a href="?tela_id=42" class='s2'>
    Inventário 
</a>
<a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">
<span></span>    Detalhe Inventário 
</a>
</div>
<form action="" id="form_filter" method="get" style="float:left; margin-top:3px; margin-left:8px; width:130px">
 <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
 <input type="hidden" id="inventario_id" name="inventario_id" value="<?=$id?>" />
 <?php
    	
		$select_produtos=mysql_query($t="
		SELECT SQL_CACHE p.id as produto_id, p.nome as nome,p.*, g.id as grupo_id, g.nome as grupo , eii.id as item_id, eii.qtd_inventario as qtd_inventario, eii.*, p.unidade_embalagem, p.unidade_uso
		FROM
			estoque_inventario_item eii,
			estoque_inventario ei,
			produto p,
			produto_grupo g
		WHERE
			eii.inventario_id  = ei.id AND
			eii.produto_id     = p.id  AND
			p.produto_grupo_id = g.id  AND
			eii.inventario_id  = '$inventario->id'
			GROUP BY grupo_id
			ORDER BY g.nome, p.nome   ");
	
	?>
    
    <select name="grupoProdutoID" id="grupoProdutoID" style="width:120px">
    	<option value="0">GRUPO</option>
    	<?php while($option_produto=mysql_fetch_object($select_produtos)){ 
			if( $_GET["grupoProdutoID"] ==  $option_produto->grupo_id) { $sell = 'selected="selected"';} else {$sell = '';}
		?>
    	
        <option <?=$sell?>value="<?=$option_produto->grupo_id?>"><?=$option_produto->grupo?></option>
    	
		<? } ?>
    </select>
    
</form>
<form action="" id="form_inventario" method="POST">
<div id="barra_info">
Nº. <?=$inventario->id?> - <strong><?=$almoxarifado->nome?></strong> <?=$inventario->data_hora?> 
       <? $filterGrupo =  !empty($_GET["grupoProdutoID"]) ? "&grupo_id=".$_GET["grupoProdutoID"] : NULL; ?> 
        
      <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
  <? if($inventario->status=='0'){ ?>
    <input name="action" type="submit" value="Confirmar Quantidades" style="margin:3px; float:right" />
    <? } ?>
    <input name="action" type="button" value="Imprimir Inventário" onclick="window.open('<?=$caminho?>impressao_inventario.php?inventario_id=<?=$inventario->id.$filterGrupo?>')" style="margin:3px; float:right" />
    
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50">Cod</td>
          	<td width="150">Nome</td>
          	<td width="70">Em Estoque</td>
			<td width="70">Em Estoque</td>
            <td width="160">Estoque Fisico</td>
			<td width="70">Diferen&ccedil;a</td>
            <td width="80">R$ Diferença</td>
            <td width="100">Unidade</td>
            <td width="100">Unidade Uso</td>
            <td width="120">Ocorrência</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
    <? 
	$grupo='Sem Grupo';
	
	if($_GET['busca']!=''){$filtro_busca=" nome LIKE '%{$_GET[busca]}%'";}
	if($_GET['produto_grupo_id']>0){$filtro_grupo=" 	produto_grupo_id='{$_GET[produto_grupo_id]}'";}
	
	if($_GET['grupoProdutoID']>0){$filtro_grupo=" AND p.produto_grupo_id ='{$_GET[grupoProdutoID]}'";}
	
	//if($_GET['grupoProdutoID']>0){$filtro_grupo=" 	produto_grupo_id='{$_GET[produto_grupo_id]}'";}
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT COUNT(*) FROM produto p WHERE p.vkt_id='$vkt_id' $filtro_busca $filtro_grupo ORDER BY id DESC"),0,0);
	if($inventario->status==1){
		$dis="disabled='disabled'";
		$filtro = "AND eii.qtd_inventario is not NULL";
	}
			
			$produtos_q=mysql_query($t="
		SELECT 
			SQL_CACHE p.id as produto_id, p.nome as nome,p.*, g.id as grupo_id, g.nome as grupo , eii.id as item_id, eii.qtd_inventario as qtd_inventario, eii.*, p.unidade_embalagem, p.unidade_uso
		FROM
			estoque_inventario_item eii,
			estoque_inventario ei,
			produto p,
			produto_grupo g
		WHERE
			eii.inventario_id  = ei.id AND
			eii.produto_id     = p.id  AND
			p.produto_grupo_id = g.id  AND
			eii.inventario_id  = '$inventario->id'
			$filtro_grupo
			$filtro
			ORDER BY g.nome, p.nome  
		");
		//echo $t;
	
	
	$total_diferenca = 0;
	$i=0;
	while($produto=mysql_fetch_object($produtos_q)){
		$i++;
		if($i%2==0){$al="al";}else{$al='';}
		if($produto->unidade== 'unidade_embalagem'){
			$sel['unidade_embalagem']='SELECTED="SELECTED"';	
			$sel['unidade_uso']='';	
			
			$nova_qtd 	= $produto->qtd_inventario/$produto->conversao2;  
			$diferenca	= ($produto->qtd_inventario-$produto->qtd_estoque)/$produto->conversao2;
			$valor		= ($diferenca)*($produto->custo/$produto->conversao);
			

		}else{
			$sel['unidade_embalagem']='';	
			$sel['unidade_uso']='SELECTED="SELECTED"';
	
			$nova_qtd 	= $produto->qtd_inventario;  
			$diferenca	= $produto->qtd_inventario-$produto->qtd_estoque;
			$valor		= ($diferenca)*($produto->custo/$produto->conversao/$produto->conversao2);
			
		}

		if($produto->grupo!=$grupo){
			$grupo=$produto->grupo;
	?>
	<tr>
    	<td colspan="10" class="g"><?=$produto->grupo?></td>
    </tr>
    <?
		$grupo=$produto->grupo;
		}

		
			
	?><tr class="produtos_tabela <?=$al?>">
<td width="50"><?=$produto->id?></td><td width="150"><?=$produto->nome?></td>
<td width="70" align="right"><?=qtdUsaToBr($produto->qtd_estoque/$produto->conversao2,3)?> <?=substr($produto->unidade_embalagem,0,2)?></td>
<td width="70" align="right"><?=$produto->qtd_estoque?> <?=substr($produto->unidade_uso,0,2)?></td>
<td width="160"align="right"><input type="text"<?=$dis?> name="nova_qtd[]"class='qtdn'value="<? if($produto->qtd_inventario!=NULL){	echo qtdUsaToBr($nova_qtd);}?>"sonumero="1" style="text-align:right;"/><select class='und'><option value='unidade_embalagem' <?=$sel[unidade_embalagem]?>><?=substr($produto->unidade_embalagem,0,2)." ".qtdUsaToBr($produto->conversao2).' '.substr($produto->unidade_uso,0,2)?></option><option value='unidade_uso'  <?=$sel[unidade_uso]?>><?=substr($produto->unidade_uso,0,2)?></option></select></td>
<td width="70"class="diferenca" style="text-align:right"><?=moedaUsaToBr($diferenca)?></td>
<td width="80"class="valor_diferenca" style="text-align:right"><?=moedaUsaToBr($valor)?></td>
<td width="100"><?=substr($produto->unidade_embalagem,0,2)." ".$produto->conversao2." ".substr($produto->unidade_uso,0,2)?>
<input name="estoque_qtd[]"class="estoque_qtd"type="hidden"value="<?=$produto->qtd_estoque?>">
<input name="produto_id[]"class="produto_id" type="hidden"value="<?=$produto->produto_id?>">
<input name="eii[]"class="estoque_inventario_item_id"type="hidden"value="<?=$produto->item_id?>">
<input name="produto_preco[]"type="hidden"class="produto_preco"value="<?=$produto->custo/$produto->conversao?>">
<input name="conversao2[]"type="hidden"class="conversao2"value="<?=$produto->conversao2?>">
</td>
<td width="100"><?php
        echo checaEstoque($produto->id,$inventario->status,$almoxarifado->id,$inventario->id)." ".$produto->unidade_uso;	
    ?></td>
<td width="120" ><input class="ocorrencia"name="ocorrencia[]"value="<?=$produto->ocorrencia?>"type="text" /></td><td class="alterado"></td>
</tr><?  
$total_diferenca += $produto->valor_diferenca;
} ?>
        
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50"><a>Total: <?=$total?></a></td>
            <td width="150">&nbsp;</td>
            <td width="70">&nbsp;</td>
            	
            <td width="80">&nbsp;</td>
            <td width="70">&nbsp;</td>
			<td width="100" id="total_diferenca" align="right"><?=moedaUsaToBr($total_diferenca)?></td>
			<td width="100">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="120">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>
<input type="hidden" id="inventario_id" name="inventario_id" value="<?=$id?>" />
<input type="hidden" id="almoxarifado_id" name="almoxarifado_id" value="<?=$almoxarifado->id?>" />

</form>

</div>
<div id='rodape'>
<?

if($inventario->status <=0){
?>
<input name="action" type="button" value="Cancelar" style="margin:3px;" onclick="location.href='?tela_id=<?=$_GET[tela_id]?>&inventario_id=<?=$_GET[inventario_id]?>&action=Cancelar'" />
<?
}
?>
<?=$registros?> Registros  
    <div style="float:right; margin:0px 20px 0 0">
    
    </div>
</div>
<? 

?>
<script>
// Fecha aba de menu

		$("#menu").animate({
			'marginLeft': -210,
			
		  }, 0);
		$("#conteudo").animate({
			'marginLeft': 10
		  }, 0);
		$("#rodape").animate({
			'marginLeft': 10
		  }, 0);
				   $("#some").html("&raquo;")

////

</script>