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
<a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>Posição de Estoque
</a>
</div>
<div id="barra_info">
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="220">Unidade</td>
          	<td width="100">Valor de Estoque</td>
                        
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
		
		while($almoxarifado = mysql_fetch_object($almoxarifados)){
			
			/*
				SELECT DISTINCT(produto_id),
				(SELECT saldo FROM estoque_mov WHERE produto_id=319 AND almoxarifado_id='1' ORDER BY id DESC LIMIT 1) as saldo
				FROM estoque_mov
				WHERE almoxarifado_id='1' AND vkt_id='14' AND produto_id=319 ORDER BY id DESC 
			*/
			
			/*$produtos_almoxarifados = mysql_query($t=
				"SELECT 
					DISTINCT(produto_id) 
				FROM 
					estoque_mov
				WHERE 
					almoxarifado_id='$almoxarifado->id' AND
					data_hora >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND
					vkt_id='$vkt_id'
					ORDER BY id DESC
				"
			);*/
			
			$saldo_total = mysql_result(mysql_query("
				SELECT 
					SUM( (m.saldo/p.conversao2) * ( p.custo / p.conversao ) ) AS valor
				FROM 
					produto p, estoque_mov m
				WHERE 
					p.id = m.produto_id AND
					m.id = (SELECT id FROM estoque_mov WHERE produto_id=p.id AND almoxarifado_id = '$almoxarifado->id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1) AND
					m.almoxarifado_id = $almoxarifado->id AND 
					p.vkt_id          = '$vkt_id'
"),0,0);
										
	?>
    <tr onclick="location.href='?tela_id=486&almoxarifado_id=<?=$almoxarifado->id?>'">
              
           <td width="220"><?=$almoxarifado->nome?></td>
          	<td width="100" align="right"><? if($saldo_total>0){ echo moedaUsaToBr($saldo_total);}else{ echo "0,00";}?></td>
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
