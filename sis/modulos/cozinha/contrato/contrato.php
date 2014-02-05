<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");

?>
<script>

$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a><a href="./" class='s2'>
    Cozinha 
</a>
<a href="?tela_id=104" class="navegacao_ativo">
<span></span>    Contratos 
</a>
</div>
<div id="barra_info">

    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <form id="form_status">
    <? 
        $status_selecionado[$_GET[status]]="selected='selected'";
        ?>
    <label>
        <select name="status" onchange="document.getElementById('form_status').submit()">
            <option value="1">Ativos</option>
            <option <?=$status_selecionado[0]?> value="0">Inativos</option>
            <option <?=$status_selecionado[2]?> value="2">Ambos</option>
        </select>
        <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
        <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	</label>
</form>
	
    
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="100"><?=linkOrdem("Contrato","nome",1)?></td>
          	<td width="250">Cliente</td>
            <td width="80">Data</td>
            <td width="100">Valor</td>
            <td width="100">Dias Planejados</td>
            <td width="120">Último dia planejado</td>
            <td width="70">Status</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
	
    	<?php
		//filtros
		if(trim($_GET[busca])!=''){
			$filtro_busca = " AND (cf.razao_social LIKE '%{$_GET[busca]}%' OR cc.id LIKE '%{$_GET[busca]}%') ";
		}
		if($_GET['status']==1 || !isset($_GET['status'])){$filtro_status= " AND cc.status ='1'";}elseif($_GET['status']!=2){$filtro_status= " AND cc.status ='{$_GET[status]}'";}
		
		$registros=mysql_result(mysql_query("
		SELECT COUNT(cc.id)
		FROM cozinha_contratos as cc, cliente_fornecedor as cf 
		WHERE cc.vkt_id='$vkt_id' AND cc.cliente_id=cf.id $filtro_busca $filtro_status ORDER BY cc.id DESC 
		"),0,0);
		//echo mysql_error();
		$query = mysql_query($x="
		SELECT cc.id as id, cf.razao_social as cliente, cc.data as data, cc.valor as valor, cc.status as status
		FROM cozinha_contratos as cc, cliente_fornecedor as cf
		WHERE cc.vkt_id='$vkt_id' AND cc.cliente_id=cf.id  $filtro_busca $filtro_status GROUP BY cc.id ORDER BY cc.id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			
			while($contrato=mysql_fetch_object($query)){
				$ultima_data = @mysql_result(mysql_query("SELECT DATE_FORMAT(data,'%d/%m/%Y') as data FROM cozinha_cardapio_dia_refeicao WHERE contrato_id='$contrato->id' AND vkt_id='$vkt_id' ORDER BY data DESC"),0,0);
				$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='{$contrato->cliente_id}'"));
				$dias_planejados=mysql_result(mysql_query($a="SELECT COUNT(DISTINCT(data)) FROM cozinha_cardapio_dia_refeicao WHERE vkt_id='$vkt_id' AND contrato_id='$contrato->id' AND data>=DATE(NOW())" ),0,0);
		?>
			<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$contrato->id?>','carregador')">
            	<td width="100"><?=$contrato->id?></td>
          		<td width="250"><?=$contrato->cliente?></td>
            	<td width="80"><?=dataUsaToBr($contrato->data)?></td>
            	<td width="100"><?=moedaUsaToBr($contrato->valor)?></td>
            	<td width="100"><?=$dias_planejados?></td>
            	<td width="120"><?=$ultima_data?></td>
            	<td width="70"><? if($contrato->status==0){	echo "Inativo";}else{ echo "Ativo";};?></td>
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
            <td width="150"><a>Total: <?=$total?></a></td>
            <td width="400">&nbsp;</td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
    <option <?=$qtd_selecionado[1]?> >1</option>
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$limitador)?>
    </div>
</div>
