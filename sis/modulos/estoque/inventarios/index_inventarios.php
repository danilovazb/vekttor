<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));

?>
<script>
$(document).ready(function(){
	$("#tabela_dados tr.produtos_tabela:odd").addClass('al');
})
</script>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>

<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=42" class="navegacao_ativo">
<span></span>Inventário - <?=$id?>
</a>
</div>

<div id="barra_info">
<form  method="get">
<input type="hidden" name="tela_id" value="42" />
<label style="font-weight:bold;">Filtros:</label>
Por Data 
<label>De: 
	<input name="data_ini" id="data_ini" style="width:80px; height:12px;" mascara='__/__/____' type="text" value="<?=$_GET['data_ini']?>" calendario='1' sonumero='1' />
</label> 
<label>Até: 
	<input name="data_fim" id="data_fim" type="text" style="width:80px; height:12px;" mascara='__/__/____' sonumero='1' calendario='1' value="<?=$_GET['data_fim']?>" />
</label> 
<label> Unidade
	<select name="almoxarifado_id">
    <option value="0">- Todos -</option>
    <? $almoxarifados_q=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
	while($almoxarifado=mysql_fetch_object($almoxarifados_q)){
		if($_GET['almoxarifado_id']==$almoxarifado->id){$sel='selected="selected"';}else{$sel='';}
	?>
    <option <?=$sel?> value="<?=$almoxarifado->id?>"><?=$almoxarifado->nome?></option>
    <? } ?>
    </select>
</label>

<label>
	<select name="status">
    	<option value="">Status</option>
    	<option value="0" <? if($_GET['status']=='0'){echo "selected='selected'";}?>>Salvo</option>
        <option value="1" <? if($_GET['status']=='1'){echo "selected='selected'";}?>>Fechado</option>
        <option value="2" <? if($_GET['status']=='2'){echo "selected='selected'";}?>>Cancelado</option>
    </select>
</label>
 
<input type="submit" value="Filtrar" />
    <input type="button" value="Novo Inventário" onclick="if(document.getElementById('almoxarifado').value=='0'){alert('Escolha uma unidade')}else{location.href='?tela_id=194&almoxarifado_id='+document.getElementById('almoxarifado').value}" style="margin:3px; float:right" />	
   <label style="float:right; padding:3px 5px 0 0 ">
	<select name="almoxarifado" id='almoxarifado' >
    <option value="0">Selecione Filial</option>
    <? 
	$almoxarifados_q=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id'");
	while($almoxarifado=mysql_fetch_object($almoxarifados_q)){
		
	?>	
		<option value="<?=$almoxarifado->id?>"><?=$almoxarifado->nome?></option>
    <?
	}
	?>
	</select>
    </label>
    </form>
    
</div>


<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50">ID</td>
          	<td width="150">Unidade</td>
          	<td width="100">Data Criado</td>
			<td width="100">Status</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
    <? 
	/**** filtros ****/
	//data
	if($_GET['data_ini']!='' && $_GET['data_fim']!=''){
		$filtro_data=" AND data_criado > '".dataBrToUsa($_GET['data_ini'])." 00:00:00' AND data_criado < '".dataBrToUsa($_GET['data_fim'])." 23:59:59'";
	}elseif($_GET['data_ini']!='' || $_GET['data_fim']!=''){
		if($_GET['data_ini']){$filtro_data=" AND data_criado > '".dataBrToUsa($_GET['data_ini'])." 00:00:00'";}
		if($_GET['data_fim']){$filtro_data=" AND data_criado < '".dataBrToUsa($_GET['data_fim'])." 23:59:59'";}
	}
	//por almoxarifado
	if($_GET['almoxarifado_id']>0){
		$filtro_almoxarifado=" AND almoxarifado_id= {$_GET[almoxarifado_id]}";
	}
	//por id do inventário
	if($_GET['busca']>0){
		$filtro_inventario= " AND ei.id LIKE'%{$_GET[busca]}%'";
	}
	
	if(!empty($_GET['status'])){
		$filtro_status = "AND ei.status='".$_GET['status']."'";
	}else{
		$filtro_status = "AND ei.status != '2'";
	}
	
	/********************/
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT COUNT(*) FROM estoque_inventario as ei WHERE vkt_id='$vkt_id' $filtro_almoxarifado $filtro_data $filtro_inventario ORDER BY id DESC"),0,0);
	echo mysql_error();
	$grupo='Sem Grupo';
	$inventarios_q=mysql_query($a="
	SELECT 
		ei.id as id, cu.nome as unidade, ei.data_criado as criado, ei.status as status
	FROM 
		estoque_inventario as ei, cozinha_unidades as cu
	WHERE 
		ei.vkt_id='$vkt_id' 
		AND ei.almoxarifado_id=cu.id 
		$filtro_status 
		$filtro_data
		$filtro_almoxarifado
		$filtro_inventario
		$filtro_inventario
		ORDER BY ei.id DESC
		LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($inventario=mysql_fetch_object($inventarios_q)){
		if($inventario->status=='0'){$status='Salvo';}
		if($inventario->status=='1'){$status='Fechado';}
		if($inventario->status=='2'){$status='Cancelado';}
	?>
	   	<tr onclick="location.href='?tela_id=194&inventario_id=<?=$inventario->id?>'" class="produtos_tabela">
            <td width="50" ><?=$inventario->id?></td>
          	<td width="150" ><?=$inventario->unidade?></td>
			<td width="100" ><?=dataUsaToBr($inventario->criado)?></td>
            <td width="100" ><?=$status?></td>
            <td></td>
        </tr>
        <? } ?>
        
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50"><a>Total: <?=$total?></a></td>
            <td width="150">&nbsp;</td>
			<td width="165">&nbsp;</td>
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
