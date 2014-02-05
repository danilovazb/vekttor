<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
$almoxarifado_id = $_GET['almoxarifado_id'];

?>

<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})

$("#filtrar").live("click",function(){
	var unidade_id = $("#unidade_id").val();
	var produto_id    = $("#produto_id").val();
	var de            = $("#de").val();
	var ate          = $("#ate").val();
	if(unidade_id > 0 && produto_id>0){
		location.href='?tela_id=<?=$_GET['tela_id']?>&produto_id='+produto_id+'&unidade_id='+unidade_id+'&de='+de+'&ate='+ate;
	}else{
		alert('Selecione uma unidade e um produto');
	}
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
	<input type="button" value="<<" onclick="location.href='?tela_id=480'" style="margin-top:3px;"/>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="220">Produto</td>
             <td width="120">Movimentação</td>
             <td width="80">Data</td>
            <td width="100">Qtd Embalagem</td>
            <td width="100">Qtd Uso</td>
			<td width="100">Valor Total</td>                        
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
	<?php
			//$produtos = mysql_query($t="SELECT * FROM produto WHERE vkt_id='$vkt_id'");
			if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
				$filtro = "AND em.data_hora BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
			}else{
				$filtro = "AND MONTH(em.data_hora)=MONTH(NOW())";
			}
			if($_GET['mov']=='consumo'){
				$filtro.=" AND doc_tipo!='inventario'
						   AND em.saida IS NOT NULL";
				$mov="saida";
				
			}
			if($_GET['mov']=='saida_inv'){
				$filtro.=" AND doc_tipo='inventario' 
						   AND em.saida IS NOT NULL
							";
				$mov="saida";
			}
			if($_GET['mov']=='saida_ent'){
				$filtro.=" AND doc_tipo='inventario' 
						   AND em.entrada IS NOT NULL
							";
				$mov="entrada";
			}
						
			$produto_saidas = mysql_query($t="
					SELECT 
						*
					FROM 
						estoque_mov em,
						produto p						 
					WHERE 
						em.vkt_id='$vkt_id' AND
						em.almoxarifado_id='$almoxarifado_id' AND
						em.produto_id = p.id	 
												 
						$filtro
					ORDER BY 
						p.nome ASC");
						//echo $t." ".mysql_error();
			while($produto_saida = mysql_fetch_object($produto_saidas)){				
					
					//quantidade em embalagem
															
					$qtd_embalagem = $produto_saida->$mov / $produto_saida->conversao2;
					
					$valor   = $produto_saida->$mov * ( $produto_saida->custo / $produto_saida->conversao2 );
					$valor_total    += $valor;						
	?>
    <tr>
              
            <td width="220"><?=$produto_saida->nome?></td>
            <td width="120"><?=$produto_saida->doc_tipo." (".$produto_saida->doc_id.")"?></td>
             <td width="80"><?=DataUsaToBr(substr($produto_saida->data_hora,0,10))?></td>
          	<td width="100" align="right"><?=MoedaUsaToBr($qtd_embalagem)?></td>
            <td width="100" align="right"><? if($produto_saida->$mov>0){ echo MoedaUsaToBr($produto_saida->$mov);}else{ echo "0,00";}?></td>
			<td width="100" align="right"><?=MoedaUsaToBr($valor)?></td>                        
            <td></td>
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
            <td width="120"></td>
             <td width="80"></td>
          	<td width="100"></td>
            <td width="100"></td>
			<td width="100" align="right"><?=MoedaUsaToBr($valor_total)?></td>                        
            <td></td>
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
