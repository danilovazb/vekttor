<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php"); 
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=76" class="navegacao_ativo">
<span></span>   Finalizar Compras
</a>
</div>
<div id="barra_info">
    <form action="" method="get" style="float:left">
		<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
		<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
		<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
		<input type="hidden" name="ordem" value="<?=$_GET['ordem']?>" />
		<label for="status">Exibir:</label>
   	 	<select name="status" onchange="submit()">
			<option <? if($_GET['status']=="")echo "selected='selected'" ?> value="Todos">Todos</option>
			<option <? if($_GET['status']=="Aguardo")echo "selected='selected'" ?> value="Aguardo">Aguardo</option>
			<option <? if($_GET['status']=="Autorizado")echo "selected='selected'" ?> value="Autorizado">Autorizado</option>
			<option <? if(($_GET['status']=="Efetivado"||$_GET['status']=="")&&$_GET['ordem']=="")echo "selected='selected'" ?> value="Efetivado">Efetivado</option>
			<option <? if($_GET['status']=="Finalizado")echo "selected='selected'" ?> value="Finalizado">Finalizado</option>
			<option <? if($_GET['status']=="Cancelado")echo "selected='selected'" ?> value="Cancelado">Cancelado</option>
		</select>
</form>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="75"><?=linkOrdem("ID","id",1)?></td>
			<td width="175"><?=linkOrdem("Empreendimento","empreendimento_id",0)?></td>
          	<td width="175"><?=linkOrdem("Cliente","cliente_fornecedor_id",0)?></td>
          	<td width="100"><?=linkOrdem("Data de Início","data_inicio",0)?></td>
			<td width="100"><?=linkOrdem("Valor Total","valor_total",0)?></td>
			<td width="80"><?=linkOrdem("Status","status",0)?></td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(isset($_GET['status'])&&$_GET['status']!="Todos")$status=$_GET["status"];
	elseif($_GET['status']=="Todos")$status="";
	elseif(!$_GET['ordem'])$status="Efetivado";
		
	if(strlen($_GET[busca])>0||$status){
		$busca_add = "WHERE ";
	}
	if(strlen($_GET[busca])>0&&$status!=NULL){
		$busca_add .= "id like '%{$_GET[busca]}%'";
		$busca_add .= "AND status='".$status."'";
	}
	if(strlen($_GET[busca])>0&&$status==NULL){
		$busca_add .= "id like '%{$status}%'";
	}
	if(strlen($_GET[busca])==0&&$status!=NULL){
		$busca_add .= "status='".$status."'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM compra $busca_add ORDER BY data_inicio"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="id DESC";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("SELECT * FROM compra $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		
		$total++;
		$cliente=mysql_fetch_object(mysql_query("SELECT nome_fantasia FROM cliente_fornecedor WHERE id='".$r->cliente_fornecedor_id."' LIMIT 1"));
		$empreendimento=mysql_fetch_object(mysql_query("SELECT nome FROM empreendimento WHERE id='".$r->empreendimento_id."' LIMIT 1"));
	?>
	
    	<tr onclick="window.open('<?=$caminho?>_ctrl_form.php?id=<?=$r->id?>','carregador')">
            <td width="75"><?=$r->id?></td>
			<td width="175"><?=$empreendimento->nome?></td>
			<td width="175"><?=$cliente->nome_fantasia?></td>
          	<td width="100"><?=dataUsaToBr($r->data_inicio)?></td>
			<td width="100"><?=moedaUsaToBr($r->valor_total)?> R$</td>
			<td width="80"><?=$r->status?></td>
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
            <td width=""><a>Total: <?=$total?></a></td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&status=<?=$_GET[status]?>&limitador='+this.value">
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
