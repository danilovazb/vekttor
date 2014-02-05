<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

//filtros
if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
	
	//filtro para compras e transtrefencias
	$filtro_compras_transferencias = "AND data_inicio BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para compras itens
	$filtro_compras_itens = "AND ec.data_inicio BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para transferencias itens
	$filtro_trans_itens = "AND et.data_inicio BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para inventário
	$filtro_inventario            = "AND ei.data_criado BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para beneficiamento
	$filtro_beneficiamento        = "AND data_pedido BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para beneficiamento item
	$filtro_beneficiamento_item   = "AND ebp.data_pedido BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
}else{
	$filtro_compras_transferencias = "AND MONTH(data_inicio)=MONTH(NOW())";
	//filtro para compras itens
	$filtro_compras_itens = "AND MONTH(ec.data_inicio)=MONTH(NOW())";
	//filtro para transferencias itens
	$filtro_trans_itens = "AND MONTH(et.data_inicio)=MONTH(NOW())";
	//filtro para inventário
	$filtro_inventario  = "AND MONTH(ei.data_criado)=MONTH(NOW())";
	//filtro para beneficiamento
	$filtro_beneficiamento = "AND MONTH(data_pedido)=MONTH(NOW())";
	//filtro para beneficiamento item
	$filtro_beneficiamento_item   = "AND MONTH(ebp.data_pedido)=MONTH(NOW())";
	
}

//quantidade de ocorrencias no pedido das compras
$qtd_pedido_compra_obs  = mysql_result(mysql_query($t="SELECT COUNT(*) FROM estoque_compras WHERE vkt_id='$vkt_id' AND obs_pedido IS NOT NULL AND obs_pedido !='' $filtro_compras_transferencias"),0,0);

//quantidade de ocorrencias na chegada das compras
$qtd_chegada_compra_obs = mysql_result(mysql_query("SELECT COUNT(*) FROM estoque_compras WHERE vkt_id='$vkt_id' AND obs_chegada IS NOT NULL AND obs_chegada !='' $filtro_compras_transferencias"),0,0);

//quantidade de ocorrencias nos itens das compras
$qtd_compra_ocorrencia  = mysql_result(mysql_query("SELECT 
														COUNT(*) 
													FROM 
														estoque_compras_item eci,
														estoque_compras ec
													WHERE 
														eci.pedido_id = ec.id AND
														eci.vkt_id='$vkt_id' AND 
														eci.ocorrencia IS NOT NULL AND 
														eci.ocorrencia !=''
														$filtro_compras_itens"),0,0); 

//-------------------------------------------------------------------------------------------

//quantidade de ocorrencias no pedido dos consumos
$qtd_pedido_consumo_obs  = mysql_result(mysql_query($t="SELECT COUNT(*) FROM estoque_consumos WHERE vkt_id='$vkt_id' AND obs_pedido IS NOT NULL AND obs_pedido !='' $filtro_compras_transferencias"),0,0);

//quantidade de ocorrencias na chegada dos consumos
$qtd_chegada_consumo_obs = mysql_result(mysql_query("SELECT COUNT(*) FROM estoque_consumos WHERE vkt_id='$vkt_id' AND obs_chegada IS NOT NULL AND obs_chegada !='' $filtro_compras_transferencias"),0,0);

//quantidade de ocorrencias nos itens dos consumos
$qtd_consumo_ocorrencia  = mysql_result(mysql_query("SELECT 
														COUNT(*) 
													FROM 
														estoque_consumos_item eci,
														estoque_consumos ec
													WHERE 
														eci.pedido_id = ec.id AND
														eci.vkt_id='$vkt_id' AND 
														eci.ocorrencia IS NOT NULL AND 
														eci.ocorrencia !=''
														$filtro_compras_itens"),0,0); 

//-------------------------------------------------------------------------------------------


//quantidade de ocorrencias nos pedidos da transferencia
$qtd_transferencia_ocorrencia_pedido = mysql_result(mysql_query($t="SELECT 
																		COUNT(*) 
																	FROM 
																		estoque_transferencia 
																	WHERE 
																		vkt_id='$vkt_id' AND 
																		ocorrencia_pedido IS NOT NULL AND 
																		ocorrencia_pedido !='' 
																		$filtro_compras_transferencias"),0,0);
																		//echo $t;

$qtd_transferencia_ocorrencia_recebimento = mysql_result(mysql_query("SELECT 
																		COUNT(*) 
																	FROM 
																		estoque_transferencia 
																	WHERE 
																		vkt_id='$vkt_id' AND 
																		ocorrencia_recebimento IS NOT NULL AND 
																		ocorrencia_recebimento !='' 
																		$filtro_compras_transferencias"),0,0);
																		
$qtd_itens_transferencia_ocorrencia = mysql_result(mysql_query("SELECT 
																		COUNT(*) 
																	FROM 
																		estoque_transferencia_item eti,
																		estoque_transferencia et
																	WHERE 
																		eti.vkt_id='$vkt_id' AND
																		eti.transferencia_id = et.id AND
																		eti.ocorrencia IS NOT NULL AND 
																		eti.ocorrencia !=''																		 
																		$filtro_trans_itens"),0,0);
	
$qtd_itens_transferencia_ocorrencia_r = mysql_result(mysql_query("SELECT 
																		COUNT(*) 
																	FROM 
																		estoque_transferencia_item eti,
																		estoque_transferencia et
																	WHERE 
																		eti.vkt_id='$vkt_id' AND
																		eti.transferencia_id = et.id AND
																		eti.ocorrencia_recebimento IS NOT NULL AND 
																		eti.ocorrencia_recebimento !=''
																		$filtro_trans_itens"),0,0);
$qtd_itens_transferencia_ocorrencia += $qtd_beneficiamento_ocorrencia_r;
	

//-------------------------------------------------------------------------------------------

$qtd_itens_inventario_ocorrencia = mysql_result(mysql_query($t="SELECT 
																	COUNT(*) 
																FROM 
																	estoque_inventario ei,
																	estoque_inventario_item eii 
																WHERE 
																	eii.inventario_id = ei.id AND
																	eii.vkt_id='$vkt_id' AND 
																	eii.ocorrencia IS NOT NULL AND 
																	eii.ocorrencia !='' 
																	$filtro_inventario"),0,0);
//-------------------------------------------------------------------------------------------

//quantidade de ocorrencias no beneficiamento
$qtd_pedido_beneficiamento_obs  = mysql_result(mysql_query($t="SELECT 
														COUNT(*) 
													   FROM 
														estoque_beneficiamento_pedido 
													   WHERE 
													    vkt_id='$vkt_id' AND 
														obs IS NOT NULL AND 
														obs !='' 
														$filtro_beneficiamento"),0,0);
														//echo mysql_error();
//quantidade de ocorrencias na chegada do beneficiamento
$qtd_chegada_beneficiamento_obs = mysql_result(mysql_query("SELECT 
																COUNT(*) 
															FROM 
																estoque_beneficiamento_pedido 
															WHERE 
																vkt_id='$vkt_id' AND 
																obs_recebimento IS NOT NULL AND 
																obs_recebimento !='' 
																$filtro_beneficiamento"),0,0);

//quantidade de ocorrencias nos itens das compras
$qtd_beneficiamento_ocorrencia  = mysql_result(mysql_query("SELECT 
														COUNT(*) 
													FROM 
														estoque_beneficiamento_item ebi,
														estoque_beneficiamento_pedido ebp
														
													WHERE 
														ebi.beneficiamento_id = ebp.id AND
														ebi.vkt_id='$vkt_id' AND 
														ebi.obs_item_pedido IS NOT NULL AND 
														ebi.obs_item_pedido !=''
														$filtro_beneficiamento_item"),0,0);
$qtd_beneficiamento_ocorrencia_r = mysql_result(mysql_query("SELECT 
														COUNT(*) 
													FROM 
														estoque_beneficiamento_item ebi,
														estoque_beneficiamento_pedido ebp
														
													WHERE 
														ebi.beneficiamento_id = ebp.id AND
														ebi.vkt_id='$vkt_id' AND
														ebi.obs_recebimento IS NOT NULL AND 
														ebi.obs_recebimento !=''
														$filtro_beneficiamento_item"),0,0);
$qtd_beneficiamento_ocorrencia +=$qtd_beneficiamento_ocorrencia_r; 
														

//-------------------------------------------------------------------------------------------

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
<span></span>Ocorrencias
</a>
</div>
<div id="barra_info">
<?php
if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
	$data_inicio = $_GET['data_ini'];
	$data_fim    = $_GET['data_fim'];
}else{
	$data_inicio = "01/".date('m')."/".date('Y');
	$data_fim    = date('t')."/".date('m')."/".date('Y');
}
?> 
<form  method="get">
<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
<label style="font-weight:bold;">Filtros:</label>
<label>De 
	<input name="data_ini" id="data_ini" style="width:80px; height:12px;" mascara='__/__/____' type="text" value="<?=$data_inicio?>" calendario='1' sonumero='1' />
</label> 
<label>Até 
	<input name="data_fim" id="data_fim" type="text" style="width:80px; height:12px;" mascara='__/__/____' sonumero='1' calendario='1' value="<?=$data_fim?>" />
</label> 

<input type="submit" value="Filtrar" />

</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="130">Descrição</td>
            <td width="60" title="Quantidade" rel="tip">Pedido</td>
            <td width="60" title="Chegada" rel="tip">Chegada</td>
            <td width="60" title="Observação" rel="tip">Item</td>            
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
			
		<tr> 
            <td width="130">Compras</td>
            <td width="60" onClick="location.href='?tela_id=488&tipo=pedido_compra_obs&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_pedido_compra_obs?></td>                  
             <td width="60" onClick="location.href='?tela_id=488&tipo=chegada_compra_obs&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_chegada_compra_obs?></td>
            <td width="60" onClick="location.href='?tela_id=488&tipo=compra_ocorrencia_item&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_compra_ocorrencia?></td>
            <td></td>
        </tr>             						
	  	<tr>
        	<td width="130">Transferência</td>
            <td width="60" onClick="location.href='?tela_id=488&tipo=transferencia_ocorrencia_pedido&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_transferencia_ocorrencia_pedido?></td>
        	<td width="60" onClick="location.href='?tela_id=488&tipo=transferencia_ocorrencia_recebimento&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_transferencia_ocorrencia_recebimento?></td>
        	<td width="60" onClick="location.href='?tela_id=488&tipo=item_transferencia_ocorrencia_recebimento&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_itens_transferencia_ocorrencia?></td>
        	<td ></td>
        </tr>      
       
       <tr>
        	<td width="130">Consumo</td>
            <td width="60" onClick="location.href='?tela_id=488&tipo=consumo_ocorrencia_pedido&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_pedido_consumo_obs?></td>
        	<td width="60" onClick="location.href='?tela_id=488&tipo=consumo_ocorrencia_recebimento&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_chegada_consumo_obs?></td>
        	<td width="60" onClick="location.href='?tela_id=488&tipo=item_consumo_ocorrencia&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_consumo_ocorrencia?></td>
        	<td ></td>
        </tr>
       
                
        <tr> 
            <td width="130">Itens Inventário</td>
            <td width="60" onClick="location.href='?tela_id=488&tipo=itens_inventario&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_itens_inventario_ocorrencia?></td>                  
            <td width="60"> - </td>
            <td width="60"> - </td>
            <td ></td>
        </tr>
        
        <tr> 
            <td width="130">Beneficiamento</td>
            <td width="60" onClick="location.href='?tela_id=488&tipo=beneficiamento_ocorrencia_pedido&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_chegada_beneficiamento_obs?></td>                  
            <td width="60" onClick="location.href='?tela_id=488&tipo=beneficiamento_ocorrencia_recebimento&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_chegada_beneficiamento_obs?></td>
            <td width="60" onClick="location.href='?tela_id=488&tipo=beneficiamento_ocorrencia_itens&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'"><?=$qtd_beneficiamento_ocorrencia?></td>
            
            <td ></td>
        </tr>
		
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
