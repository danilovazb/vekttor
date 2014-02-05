<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
$almoxarifados = "SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id'"; 
?>
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
});
$("#almoxarifado_id").live('change',function(){
	$("#busca_cliente").focus();
});
function novaVenda(t){
	cliente=$('#busca_cliente_id').val();
	almoxarifado_id = $("#almoxarifado_id").val();
	if(cliente>0&&almoxarifado_id>0){
	location.href='?tela_id=513&pagina=<? if(empty($_GET['pagina'])){echo 1;}else{echo $_GET['pagina'];}?>&limitador=<? if(empty($_GET['pagina'])){echo 30;}else{echo $_GET['limitador'];}?>&cliente_id='+cliente+'&almoxarifado_id='+almoxarifado_id;
	
	}else{
		alert('Selecione um cliente e um Almoxarifado!');
	}
}
function funcao_bsc2(resultado,acao,origem){	
	actions_W= acao.split('|');
	//alert(actions_W);
//	document.title=resultado.innerHTML+','+resultado.getAttribute('r0')+','+resultado.getAttribute('r1')+','+resultado.getAttribute('r2')+','+acao+','+origem+','+actions_W.length;
	
	//document.getElementById(origem).value=resultado.getAttribute('r0');
	
	for(w=0;w<actions_W.length;w++){
		vlores_e_locais = actions_W[w].split("-");
		local_e_acao = vlores_e_locais[1].split('>');
		
		valor = vlores_e_locais[0].replace(/@/g,'');
		local = local_e_acao[0];
		acao_W  = local_e_acao[1];
		
		if(local=='innerHTML'){
			document.getElementById(acao_W).innerHTML=resultado.getAttribute(valor);
		}else if(local=='value'){
			document.getElementById(acao_W).setAttribute('value',resultado.getAttribute(valor));
			document.getElementById(acao_W).value=resultado.getAttribute(valor);
		}else{
			document.getElementById(acao_W).setAttribute(local,resultado.getAttribute(valor));
		}
	}
	
	$("#vender").focus();					
}

</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="post">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_POST['busca']?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" autocomplete="off"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=73" class="navegacao_ativo">
<span></span><?=$tela->nome?>
</a>
</div>
<div id="barra_info">
<form method="post">

<label style="width:20px;">Data inicial:
	<input id="data_ini" name="data_ini" type="text" style="width:67px;  margin:0; padding:0; height:11px;" calendario='1'  value="<?=$_POST['data_ini']?>" mascara="__/__/____"/>
</label>
<label style="width:20px;">Data Final:
	<input id="data_fim" name="data_fim" type="text" style="width:67px;  margin:0; padding:0; height:11px;" calendario='1'  value="<?=$_POST['data_fim']?>" mascara="__/__/____"/>
</label>

	<select id="cliente_filt_id" name="cliente_filt_id" style="width:80px;">
	  <option value="">Cliente</option>
    <? 
	$cliente_q_filt=mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND tipo='Cliente' ORDER BY razao_social ASC"); 
	while($cliente_filt=mysql_fetch_object($cliente_q_filt)){
	?>
    	<option value="<?=$cliente_filt->id?>" <? if($_POST['cliente_filt_id']==$cliente_filt->id){echo "selected=selected";}?>><?=$cliente_filt->razao_social?></option>
    <? } ?>
  </select>
 <label>
	<select id="filt_status" name="filt_status" style="width:67px;">
    <option value=''>Status</option>
    <option <? if($_POST['filt_status']=='Em aberto'){echo 'selected=selected';}?>>Em aberto</option>
    <option <? if($_POST['filt_status']=='Cancelado'){echo 'selected=selected';}?>>Cancelado</option>
    <option <? if($_POST['filt_status']=='Finalizado'){echo 'selected=selected';}?>>Finalizado</option>
    <option <? if($_POST['filt_status']=='Pago'){echo 'selected=selected';}?>>Pago</option>
    </select>
</label>
<input type="submit" name="acao" value="Filtrar" />
<input type="button" style="float:right; margin:3px 5px 0 10px;" value="Vender" onclick="novaVenda(this)" id="vender"/>
<label style="float:right;">Cliente
  <input type="text" name="busca_cliente" id="busca_cliente" style="width:120px;" onkeyup="return vkt_ac(this,event,'0','modulos/estoque/vendas/busca_cliente.php','@r0','funcao_bsc2(this,\'@r0-value>busca_cliente|@r1-value>busca_cliente_id\',\'busca_cliente\')')"/>
   <!--busca='modulos/estoque/vendas/busca_cliente.php,@r0,@r1-value>busca_cliente_id,0'-->
  <input type="hidden" name="busca_cliente_id" id="busca_cliente_id" />
</label>
<label style="float:right;">Almoxarifado:
  <select name="almoxarifado_id" id="almoxarifado_id" style="width:width:40px;">
  	<option value="">Selecione um Almoxarifado</option>
	<?php
	$almoxarifados = mysql_query($almoxarifados);
    while($almoxarifado = mysql_fetch_object($almoxarifados)){	
    	echo "<option value='$almoxarifado->id'>$almoxarifado->nome</option>";
  	}
	?>
	
  </select>
</label>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="60">Pedido</td>
          	<td width="250">Cliente</td>
            <td width="80">Data</td>
            <td width="100">Valor</td>
            <td width="100">Status</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?
	$fim='';
	if(!empty($_POST['data_ini']) && !empty($_POST['data_fim'])){
		$fim="AND ev.data_inicio BETWEEN '".dataBrToUsa($_POST['data_ini'])."' AND '".dataBrToUsa($_POST['data_fim'])."'"; 
	}
	if(!empty($_POST['cliente_filt_id'])){
		$fim.=" AND ev.fornecedor_id='".$_POST['cliente_filt_id']."'";
	}
	if(!empty($_POST['filt_status'])){
		$fim.="AND ev.status='".$_POST['filt_status']."'";
	}else{
		$fim.="AND ev.status='Em aberto'";
	}
	if(!empty($_POST['busca'])){
		$fim.=" AND cf.razao_social LIKE '%".$_POST['busca']."%' OR cf.id='".$_POST['busca']."'";
	}
		//$registros= mysql_result(mysql_query($t="SELECT count(*) FROM estoque_vendas WHERE vkt_id='$vkt_id' $fim ORDER BY id DESC"),0,0);
		//$vendas_q = mysql_query($t="SELECT * FROM estoque_vendas WHERE vkt_id='$vkt_id' $fim ORDER BY id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
		//$vendas_q = mysql_query($t="SELECT * FROM estoque_vendas WHERE id LIKE '".$_POST['busca']."'");
	
	$registros= mysql_result(mysql_query($t="
		SELECT count(*) FROM 
			estoque_vendas ev,
			cliente_fornecedor cf
		WHERE 
			ev.vkt_id='$vkt_id' AND
			ev.fornecedor_id = cf.id 
			$fim"),0,0);
	$vendas_q = mysql_query($t="SELECT 
									*, ev.id as venda_id, ev.status as status_venda, cf.id as cliente_fornecedor_id 
								FROM 
									estoque_vendas ev,
									cliente_fornecedor cf
								WHERE 
									ev.vkt_id='$vkt_id' AND
									ev.fornecedor_id = cf.id 
									$fim ORDER BY ev.id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));

	
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
		<?
			$total_valor=0;
        	while($venda=mysql_fetch_object($vendas_q)){
			if(empty($_POST['cliente_filt_id'])){
				$cliente=mysql_fetch_object(mysql_query($t="SELECT id,razao_social FROM cliente_fornecedor WHERE id='".$venda->fornecedor_id."'"));
			}else{
				$cliente=mysql_fetch_object(mysql_query($t="SELECT id,razao_social FROM cliente_fornecedor WHERE id='".$_POST['cliente_filt_id']."'"));
			}
		?>
    	<tr onclick="location='?tela_id=513&pagina=<? if(empty($_GET['pagina'])){echo 1;}else{echo $_GET['pagina'];}?>&limitador=<? if(empty($_GET['pagina'])){echo 30;}else{echo $_GET['limitador'];}?>&cliente_id=<?=$cliente->id?>&venda_id=<?=$venda->venda_id?>'">
            
            
            <td width="60"><?=$venda->venda_id?></td>
          	<td width="250"><?=$cliente->razao_social?></td>
            <td width="80"><?=DataUsatoBr($venda->data_inicio)?></td>
            <?
            $valor=mysql_fetch_object(mysql_query("SELECT sum( VALOR_INI*QTD_PEDIDA )	as valor FROM `estoque_vendas_item`	WHERE pedido_id =".$venda->venda_id));
			$total_vendas += $valor->valor;;
			?>
            <td width="100"><?=moedaUsaToBr($valor->valor,2,".",",")?></td>
            <td width="100"><?=$venda->status_venda?></td>
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
            <td width="60"></td>
          	<td width="250"></td>
            <td width="80"></td>
            <td width="100"><?=moedaUsaToBr($total_vendas)?></td>
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
