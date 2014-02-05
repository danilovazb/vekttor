<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
if(!empty($_GET['status'])){
	mysql_query($t="UPDATE estoque_compras SET status='".$_GET['status']."' WHERE id='".$_GET['compra_id']."'");
}

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
<a href="../consumo_estoque/?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>Consumo Mensal
</a>
</div>
<div id="barra_info">
<?php
if(!empty($_GET['data_ini'])){
	$data_ini=$_GET['data_ini'];
}
else{
	$data_ini="01/".date('m')."/".date('Y');
}
if(!empty($_GET['data_fim'])){
	$data_fim=$_GET['data_fim'];
}
else{
	$data_fim=date("t")."/".date('m')."/".date('Y');
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
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="180">Unidade</td>
          	<td width="150">Consumo + Transferência</td>
			<td width="110" title="Diferença Negativa" rel="tip">Dif. Negativa</td>
			<td width="110" title="Diferença Positiva" rel="tip">Dif. Positiva</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
	<?php
		$almoxarifados = mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id'");	
		
		if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
			$filtro = "AND em.data_hora BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
		}else{
			$filtro = "AND MONTH(em.data_hora)=MONTH(NOW())";
		}
		
		while($almoxarifado = mysql_fetch_object($almoxarifados)){
				
			
			$resultado = mysql_fetch_object(mysql_query($t=
				"SELECT 
						SUM(em.saida*(p.custo/p.conversao2)) as total
					FROM 
						estoque_mov em,
						produto p						 
					WHERE 
						em.vkt_id='$vkt_id' AND
						em.almoxarifado_id='$almoxarifado->id' AND 
						em.produto_id = p.id AND 
						em.saida IS NOT NULL AND
						em.doc_tipo != 'inventario'
						$filtro
				"
			));	
		//	echo $t."<br>";
			$entrada = mysql_fetch_object(mysql_query($t=
				"SELECT 
						SUM(em.entrada*(p.custo/p.conversao2)) as total
					FROM 
						estoque_mov em,
						produto p						 
					WHERE 
						em.vkt_id='$vkt_id' AND
						em.almoxarifado_id='$almoxarifado->id' AND 
						em.produto_id = p.id AND 
						em.entrada > 0 AND
						em.doc_tipo = 'inventario'
						$filtro
				"
			));	
		//	echo $t."<br>";
			$saida = mysql_fetch_object(mysql_query($t=
				"SELECT 
						SUM(em.saida*(p.custo/p.conversao2)) as total
					FROM 
						estoque_mov em,
						produto p						 
					WHERE 
						em.vkt_id='$vkt_id' AND
						em.almoxarifado_id='$almoxarifado->id' AND 
						em.produto_id = p.id AND 
						em.saida > 0 AND
						em.doc_tipo = 'inventario'
						$filtro
				"
			));	
	//		echo $t;
			
										
	?>
    <tr>
              
           <td width="180"><?=$almoxarifado->nome?></td>
           <td width="150" align="right" onclick="location.href='?tela_id=487&almoxarifado_id=<?=$almoxarifado->id?>&mov=consumo'">
				<? if($resultado->total>0){ echo moedaUsaToBr($resultado->total);}else{ echo "0,00";}?>
           </td>
           <td width="110" align="right" onclick="location.href='?tela_id=487&almoxarifado_id=<?=$almoxarifado->id?>&mov=saida_inv'">
				<? if($saida->total>0){ echo moedaUsaToBr($saida->total);}else{ echo "0,00";}?>
           </td>
          	<td width="110" align="right" onclick="location.href='?tela_id=487&almoxarifado_id=<?=$almoxarifado->id?>&mov=saida_ent'">
				<? if($entrada->total>0){ echo moedaUsaToBr($entrada->total);}else{ echo "0,00";}?>
            </td>
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
