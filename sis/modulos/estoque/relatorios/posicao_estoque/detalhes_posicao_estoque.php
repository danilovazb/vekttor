<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
$almoxarifado_id = $_GET['almoxarifado_id'];
?>
<style>
.g{background:url(../fontes/img/bb.jpg); font-weight:bold; }
.ps a{ text-decoration:none; color:#000;}
</style>

<script>
$(document).ready(function(){
	$("#dados tr.ps:odd").addClass('al');
})

$("#imprimir_relatorio").live('click',function(){
	var almoxarifado_id = $("#almoxarifado_id").val();
	window.open('modulos/estoque/relatorios/posicao_estoque/impressao_relatorio.php?almoxarifado_id='+almoxarifado_id);
});

</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<!--<form class='form_busca' action="" method="post" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" id='busca' name="busca" maxlength="44" value="" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/estoque/compras/busca_pedido.php,@r0,0' sonumero='1' autocomplete="off"/>
</form>-->
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s1'>
    Estoque 
</a>
<a href="./" class='s1'>
    Relatórios
</a>
<a href="./" class='s2'>
    Posição de Estoque
</a>
<a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>Detalhes Posição de Estoque
</a>
</div>
<div id="barra_info">
	<input type="button" value="<<" onclick="location.href='?tela_id=481'" style="margin-top:3px;"/>
    
    <button type="button" id="imprimir_relatorio" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
</button>
	<input type="hidden" name="almoxarifado_id" id="almoxarifado_id" value="<?=$almoxarifado_id?>" />
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="220">Produto</td>
          	<td width="100" align="right">Qtd Embalagem</td>
            <td width="100" align="right">Qtd Uso</td>
			<td width="100" align="right">Valor Un</td>                        
            <td width="100" align="right">Valor Total</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
	<?php
			
			/*
				SELECT DISTINCT(produto_id),
				(SELECT saldo FROM estoque_mov WHERE produto_id=319 AND almoxarifado_id='1' ORDER BY id DESC LIMIT 1) as saldo
				FROM estoque_mov
				WHERE almoxarifado_id='1' AND vkt_id='14' AND produto_id=319 ORDER BY id DESC 
			*/
			
			$produtos = mysql_query(
			
			"		SELECT 
			 p.*, g.id as grupo_id, g.nome as grupo 
		FROM
			produto p,
			produto_grupo g
		WHERE
			p.vkt_id='$vkt_id' AND
			p.produto_grupo_id = g.id 
		
			ORDER BY g.nome, p.nome  
");

								
			$saldo_total = 0;			
			while($produto = mysql_fetch_object($produtos)){
				
				$produto_saldo = mysql_fetch_object(mysql_query($t="
					SELECT 
						(SELECT saldo FROM estoque_mov WHERE almoxarifado_id='$almoxarifado_id' AND produto_id=p.id AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1) as saldo
					FROM 
						produto p, 
						estoque_mov em 
					WHERE 
						em.produto_id = p.id AND 
						em.almoxarifado_id='$almoxarifado_id' AND 
						em.produto_id='$produto->id' AND 
						em.vkt_id='$vkt_id' 
					ORDER BY 
						em.id DESC LIMIT 1"));
					
					$qtd_embalagem = $produto_saldo->saldo / $produto->conversao2;
					$valor   = ($produto_saldo->saldo/$produto->conversao2) * ( $produto->custo/$produto->conversao);
					$valor_total    += $valor;						
		if($produto->grupo!=$grupo){
			$grupo=$produto->grupo;
	?>
	<tr>
    	<td colspan="6" class="g"><?=$produto->grupo?></td>
    </tr>
    <?
		$grupo=$produto->grupo;
		}

		if($produto_saldo->saldo<$produto->estoque_min){
			$color="#B94A48";
		}else{
			$color="";
		}
			
?><tr class='ps' style="color:<?=$color?>">
<td width="220"><a target="_blank" href="?tela_id=397&produto_id=<?=$produto->id?>&unidade_id=<?=$_GET[almoxarifado_id]?>&de=&ate="><?=$produto->nome?></a></td>
<td width="100" align="right"><? if($produto_saldo->saldo>0){ echo qtdUsaToBr($qtd_embalagem)." ".substr($produto->unidade_embalagem,0,2);}else{ echo "0 ".substr($produto->unidade_embalagem,0,2);}?></td>
<td width="100" align="right"><? if($produto_saldo->saldo>0){ echo qtdUsaToBr($produto_saldo->saldo)." ".substr($produto->unidade_uso,0,2);}else{ echo "0 ".substr($produto->unidade_uso,0,2);}?></td>
<td width="100" align="right"><?=moedaUsaToBr($produto->custo/$produto->conversao)?></td>                        
<td width="100" align="right"><?=MoedaUsaToBr($valor)?></td>
<td></td>
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
              
            <td width="220"></td>
          	<td width="100"></td>
            <td width="100"></td>
			<td width="100" align="right"></td>                        
            <td width="100" align="right"><?=MoedaUsaToBr($valor_total)?></td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=1&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&produto_id=<?=$_GET['produto_id']?>&unidade_id=<?=$_GET['unidade_id']?>&de=<?=$_GET['de']?>&ate=<?=$_GET['ate']?>'">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('produto_id'=>$_GET['produto_id'],'unidade_id'=>$_GET['unidade_id'],'de'=>$_GET['de'],'ate'=>$_GET['ate'],'data_fim'=>$_GET['data_fim']))?>
    </div>
</div>
<script>
$('#sub3').show();
$('#sub396').show()
</script>
