<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include '_functions.php';
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
<a href="./" class='s2'>
    Relatórios
</a>
<a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span><?=$tela->nome?></a>
</a>
</div>
<div id="barra_info">
<?php
if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
	$data_ini = $_GET['data_ini'];
	$data_fim = $_GET['data_fim'];
}else{
	$data_ini = "01/".date('m')."/".date('Y');
	$data_fim = date('t')."/".date('m')."/".date('Y');
}
?>

<form  method="get">
<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
<label style="font-weight:bold;">Filtros:</label>
<label>De: 
	<input name="data_ini" id="data_ini" style="width:80px; height:12px;" mascara='__/__/____' type="text" value="<?=$data_ini?>" calendario='1' sonumero='1' />
</label> 
<label>Até: 
	<input name="data_fim" id="data_fim" type="text" style="width:80px; height:12px;" mascara='__/__/____' sonumero='1' calendario='1' value="<?=$data_fim?>" />
</label> 

<input type="submit" value="Filtrar" />
</form> 
</div>
<?php
	$almoxarifados = "SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id'";
	$grupo_produtos = mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id'");
	
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr align="left">
            <td width="140"></td>
			<?
				$almo = mysql_query($almoxarifados);
				while($almoxarifado = mysql_fetch_object($almo)){
					echo "<td width='100' style='font-size:10px;'>".substr($almoxarifado->nome,0,16)."</td>";
				}
			?>                        
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
		<tr align="left">
            <td width="140"></td>
			<?
				$almo = mysql_query($almoxarifados);
				while($almoxarifado = mysql_fetch_object($almo)){
			?>
            		<td width='45' align="left">Compra</td>
					<td width='44' align="left">Consumo</td>
			<?
				}
			?>                        
            <td></td>
        </tr>
		<?php
			if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
				$filtro = "AND ec.data_chegada_prevista BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
			}else{
				$filtro = "AND MONTH(ec.data_chegada_prevista)=MONTH(NOW())";
			}
			while($grupo = mysql_fetch_object($grupo_produtos)){		
		?>
        	<tr>
            	<td width="140"><?=$grupo->nome?></td>
                <?php
					$almo = mysql_query($almoxarifados);
                	while($almoxarifado = mysql_fetch_object($almo)){
                		
						$total_compra_grupo = total_compras($almoxarifado->id,$grupo->id,$filtro);		
						$total_consumo_grupo= total_consumo($almoxarifado->id,$grupo->id,$filtro);
						
				?>		
                	<td width='45'  rel="tip" title="Valor de Compras de <?=$grupo->nome?> do Estoque <?=$almoxarifado->nome?> entre <?=$data_ini?> e <?=$data_fim?>" align='right' onclick="location.href='?tela_id=510&tipo=compra&grupo_id=<?=$grupo->id?>&almoxarifado_id=<?=$almoxarifado->id?>&de=<?=$data_ini?>&ate=<?=$data_fim?>'">
						<? if($total_compra_grupo>0){ echo MoedaUsaToBr($total_compra_grupo);}else{ echo "-";}?>
                    </td>
					<td width='44' rel="tip" title="Valor de Consumo de <?=$grupo->nome?> do Estoque <?=$almoxarifado->nome?> entre <?=$data_ini?> e <?=$data_fim?>" align='right' onclick="location.href='?tela_id=510&tipo=consumo&grupo_id=<?=$grupo->id?>&almoxarifado_id=<?=$almoxarifado->id?>&de=<?=$data_ini?>&ate=<?=$data_fim?>'">
						<? if($total_consumo_grupo>0){ echo MoedaUsaToBr($total_consumo_grupo);}else{ echo "-";}?>
                     </td>
                <?php
					}
				?>
                <td></td>
            </tr>
		<?php
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