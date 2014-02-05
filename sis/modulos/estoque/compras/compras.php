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

function novoPedido(t){
	fornecedor=$('#fornecedor_id').val();
	estoque_id=$('#estoque_id').val();
	if(fornecedor!=''&&estoque_id!=''){
	location='?tela_id=124&pagina=<? if(empty($_GET['pagina'])){echo 1;}else{echo $_GET['pagina'];}?>&limitador=<? if(empty($_GET['pagina'])){echo 30;}else{echo $_GET['limitador'];}?>&fornecedor_id='+document.getElementById('fornecedor_id').value+'&estoque_id='+estoque_id;
	}else {
		alert('Selecione um fornecedor e uma unidade!');
	}
}


</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="post" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" id='busca' name="busca" maxlength="44" value="" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/estoque/compras/busca_pedido.php,@r0,0' sonumero='1' autocomplete="off"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=110" class="navegacao_ativo">
<span></span>Compras
</a>
</div>
<div id="barra_info">
<form method="get">
<label>Data inicial:
	<input id="data_ini" name="data_ini" type="text" style="width:67px;  margin:0; padding:0; height:11px;" calendario='1' value="<?=$_GET['data_ini']?>" mascara="__/__/____"/>
</label>
<label>Data Final:
	<input id="data_fim" name="data_fim" type="text" style="width:67px;  margin:0; padding:0; height:11px;" calendario='1' value="<?=$_GET['data_fim']?>" mascara="__/__/____"/>
</label>
<label>
	
    <select id="fornecedor_id_filt" name="fornecedor_id_filt" style="width:80px;">
    <option value="">Fornecedor</option>
    <? 
	$fornecedores_q=mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND tipo='Fornecedor' ORDER BY razao_social ASC"); 
	while($fornecedor=mysql_fetch_object($fornecedores_q)){
	?>
    	<option value="<?=$fornecedor->id?>" <? if(isset($_GET['fornecedor_id_filt'])&&$_GET['fornecedor_id_filt']==$fornecedor->id){echo "selected=selected";}?>><?=$fornecedor->razao_social?></option>
    <? } ?>
    </select>
</label>

<label>
	<select id="almoxarifado_id_filt" name="almoxarifado_id_filt" style="width:60px;">
    <option value="">Selecione uma Unidade</option>
   
    <? 
	$almoxarifados_q=mysql_query($t="SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY id ASC"); 
	while($almoxarifado=mysql_fetch_object($almoxarifados_q)){
	?>
    	<option value="<?=$almoxarifado->id?>" <? if(isset($_GET['almoxarifado_id_filt'])&&$_GET['almoxarifado_id_filt']==$almoxarifado->id){echo "selected=selected";}?>><?=$almoxarifado->nome?></option>
    <? } ?>
    </select>
</label>
<label>
	<select id="filt_status" name="filt_status" style="width:50px;">
    <option value=''>Status</option>
    <option <? if($_POST['filt_status']=='Em aberto'){echo 'selected=selected';}?>>Em aberto</option>
    <option <? if($_POST['filt_status']=='cancelado'){echo 'selected=selected';}?>>Cancelado</option>
    <option <? if($_POST['filt_status']=='Finalizado'){echo 'selected=selected';}?>>Finalizado</option>
    </select>
</label>
<input type="submit" name="acao" value="Filtrar" />

<input type="button" style="float:right; margin:3px 5px 0 10px;" value="Novo Pedido" onclick="novoPedido(this)" />
<label style="float:right;margin-top:4px;">
    <select name="estoque_id" id="estoque_id">
	<option value="">Unidade</option>
	<?
		$unidades_q=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
				
		while($unidade=mysql_fetch_object($unidades_q)){
			if($pedido->unidade_id==$unidade->id){$select1='selected=selected';}else{$select1='';}
			echo "<option value='".$unidade->id."' $select1>".$unidade->nome."</option>";
		}
	?>
</select>
</label>
<label style="float:right;">
	<select id="fornecedor_id" name="fornecedor_id" style="width:80px;margin-top:4px;">
    <option value="">Fornecedor</option>
	<? 
	$fornecedores_q=mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND tipo='Fornecedor' ORDER BY razao_social ASC"); 
	
	while($fornecedor=mysql_fetch_object($fornecedores_q)){
	?>
    	<option value="<?=$fornecedor->id?>"><?=$fornecedor->razao_social?></option>
    <? } ?>
    </select>
</label>
<input type="hidden" name="tela_id" id="tela_id" value="<?=$_GET['tela_id']?>" />
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="60">Pedido</td>
          	<td width="200">Fornecedor</td>
            <td width="100">Almoxarifado</td>
            <td width="80">Data</td>
            <td width="100">Valor</td>
            <td width="100">Status</td>
            <td width="120" title="Data da Chegada Prevista">Data Cheg. Prevista</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	<?
	$fim='';
	if(!empty($_GET['data_ini']) && !empty($_GET['data_fim'])){
		$fim="AND data_inicio BETWEEN '".dataBrToUsa($_GET['data_ini'])."' AND '".dataBrToUsa($_GET['data_fim'])."'"; 
	}
	if(!empty($_GET['fornecedor_id_filt'])){
		$fim.="AND fornecedor_id='".$_GET['fornecedor_id_filt']."'";
	}
	if(!empty($_GET['almoxarifado_id_filt'])){
		
		$fim.="AND unidade_id='".$_GET['almoxarifado_id_filt']."'";
	}
	if(!empty($_GET['filt_status'])){
		$fim.="AND status='".$_GET['filt_status']."'";
	}else{
		$fim.=" AND status!='Cancelado'";
	}
	
	
	if(!empty($_POST['busca'])){
		$compras_q = mysql_query($t="SELECT * FROM estoque_compras WHERE id LIKE '".$_POST['busca']."'");
		//echo $t;
	}else{
		$registros= mysql_result(mysql_query($t="SELECT count(*) FROM estoque_compras WHERE vkt_id='$vkt_id' $fim ORDER BY id DESC"),0,0);
		$compras_q = mysql_query($t="SELECT * FROM estoque_compras WHERE vkt_id='$vkt_id' $fim ORDER BY id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		echo mysql_error();
		//echo $t;
		// necessario para paginacao
    	
	}
	
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
		<?
			
        	while($compra=mysql_fetch_object($compras_q)){
			if($compra->status=='Em aberto'){
				$color = '#B94A48';
				$weight = 'bold';
			}else{
				$color = '';
				$weight = '';
			}
			if(empty($_POST['fornecedor_id_filt'])){
				$fornecedor=mysql_fetch_object(mysql_query($t="SELECT id,razao_social FROM cliente_fornecedor WHERE id='".$compra->fornecedor_id."'"));
			}else{
				$fornecedor=mysql_fetch_object(mysql_query($t="SELECT id,razao_social FROM cliente_fornecedor WHERE id='".$_POST['fornecedor_id_filt']."'"));
			}
			
			if(empty($_POST['almoxarifado_id_filt'])){
				$almoxarifado=mysql_fetch_object(mysql_query($t="SELECT id,nome FROM cozinha_unidades WHERE id='".$compra->unidade_id."'"));
			}else{
				$almoxarifado=mysql_fetch_object(mysql_query($t="SELECT id,nome FROM cozinha_unidades WHERE id='".$_POST['almoxarifado_id_filt']."'"));
			}
			
		?>
    	<tr onclick="location='?tela_id=124&pagina=<? if(empty($_GET['pagina'])){echo 1;}else{echo $_GET['pagina'];}?>&limitador=<? if(empty($_GET['pagina'])){echo 30;}else{echo $_GET['limitador'];}?>&fornecedor_id=<?=$fornecedor->id?>&compra_id=<?=$compra->id?>&estoque_id=<?=$almoxarifado->id?>'">
            
            
            <td width="60"><?=$compra->id?></td>
          	<td width="200"><?=$fornecedor->razao_social?></td>
            <td width="100"><?=$almoxarifado->nome?></td>
            <td width="80"><?=DataUsatoBr($compra->data_inicio)?></td>
            <?
            $valor=mysql_fetch_object(mysql_query("SELECT sum( VALOR_INI*QTD_PEDIDA ) as valor FROM `estoque_compras_item` WHERE pedido_id=".$compra->id))?>
            <td width="100" align="right"><?=moedaUsaToBr($total_compras[]=$valor->valor,2,".",",")?></td>
            <td width="100" style="color:<?=$color?>;font-weight:<?=$weight?>"><?=$compra->status?></td>
            <td width="120" title="Data da Chegada Prevista"><?=DataUsaToBr($compra->data_chegada_prevista)?></td>
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
            <td width="80"></td>
          	<td width="200"></td>
            <td width="100"></td>
            <td width="80"></td>
            
            <td width="100" align="right"><?=moedaUsaToBr(@array_sum($total_compras))?></td>
            <td width="100" ></td>
            <td width="120" ></td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=1&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('fornecedor_id_filt'=>$_GET['fornecedor_id_filt'],'almoxarifado_id_filt'=>$_GET['almoxarifado_id_filt'],'filt_status'=>$_GET['filt_status'],'data_ini'=>$_GET['data_ini'],'data_fim'=>$_GET['data_fim']))?>
    </div>
</div>
