<?
include("_functions.php");
include("_ctrl.php"); 
$statusVenda = array( 1 => '', 2 => '<p style="" class="badge badge-list badge-important"> Cancelada </p>');
?>
<script type="text/javascript" src="modulos/rh/venda_funcionario/venda_empresa.js"></script>
<script type="text/javascript">
$(function(){
	$("tr:odd").addClass('al');
	$("#tabela_dados tr.funcionario").live("click",function(){
		var funcionario_id = $(this).attr('id');
		var empresa_id = $("#empresa_id").val();
		window.open('modulos/rh/venda_funcionario/form.php?funcionario_id='+funcionario_id+'&empresa_id='+empresa_id,'carregador');
	});
	
	$("#tabela_dados tr.venda").live("click",function(){
		var funcionario_id = $(this).attr("funcionario");
		var venda_id = $(this).attr('id');
		var empresa_id = $("#empresa_id").val();
		window.open('modulos/rh/venda_funcionario/form.php?venda_id='+venda_id+'&empresa_id='+empresa_id+'&funcionario_id='+funcionario_id,'carregador');
	});
	
	$(".cancelarItem").live("click",function(){
		var $tr = $(this).closest("tr");
		var parcelaID = $tr.attr("id");
		var dados = {funcao:"CancelarItemParcela",id:parcelaID};
		$tr.find("td").eq(2).html("<b class='text-warning'> Cancelada </b");
		$tr.find("td").eq(3).html("");
		$.ajax({
			type:"POST",
			url:"modulos/rh/venda_funcionario/ajax.php",
			data:dados,
			success: function(dados){}
		});
	});
	
	$("#form-filtro").live("change",function(){
		$(this).submit();
	});
});
</script>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
a.restaurarItem{ text-decoration:none}
a.restaurarItem:hover{ text-decoration:underline; }
a.cancelarItem{ text-decoration:none}
a.cancelarItem:hover{ text-decoration:underline; }
.text-warning{ color:#900;}
.badge-list{-webkit-border-radius: 3px;-moz-border-radius:3px;border-radius: 3px; padding:2px; margin:2px;font-size:9px;float:right; background:inherit; color:#d9534f; text-shadow:inherit;}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
  <a href="?" class='s1'> Sistema </a>
  <a href="?" class='s1'> RH </a>
  <a href="?" class='s2'> Venda Empresa/Funcionário </a>
  <a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'> <span></span> Funcionário   </a>
  <form class='form_busca' action="" method="get">
       <a></a>
      <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
      <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
      <input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
      <input type="hidden" name="empresa_id" id="empresa_id" value="<?=$_GET["empresa_id"]?>">
      <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
  </form>
  <input type="hidden" name="empresa_id" id="empresa_id" value="<?=$_GET["empresa_id"]?>">
</div>
<div id="barra_info">
    <button type="button" style="float:left;margin-top:2px;" onclick="location.href='?tela_id=582'" > Voltar </button> 
	<form method="get" autocomplete="off" id="form-filtro">
    &nbsp;
    <select name="tipo_venda" style="">
      <optgroup label="Tipo de Vendas">
      	<option value="0" <? if($_GET["tipo_venda"] == 1) echo ' selected="selected"'; ?> selected="selected">Todas</option>
        <option value="1" <? if($_GET["tipo_venda"] == 1) echo ' selected="selected"'; ?>>Ativos</option>
        <option value="2" <? if($_GET["tipo_venda"] == 2) echo ' selected="selected"'; ?>>Canceladas</option>
      </optgroup>
    </select>
    
    <input type="hidden" name="empresa_id" value="<?=$_GET["empresa_id"]?>" />
    <input type="hidden" name="tela_id" value="583" />
    </form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
          <td width="70">COD</td>
          <td width="230">Funcionário</td>
          <td width="130">Total</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody><?
	$filterBusca = !empty($_GET["busca"]) ? " AND nome LIKE '%".trim($_GET["busca"])."%' " : NULL;
	$sql = mysql_query($ty=" SELECT * FROM rh_funcionario WHERE empresa_id = '".trim($_GET["empresa_id"])."' AND vkt_id = '$vkt_id' {$filterBusca}  ");
	
	while($r=mysql_fetch_object($sql)){		
		
		$filter = !empty($_GET["tipo_venda"]) ? " AND status = ".trim($_GET["tipo_venda"])."  " : NULL;
		
		$Sqlvenda = mysql_query($g=" SELECT * FROM ".VENDA." WHERE funcionario_id = '".$r->id."' {$filter} ");
	?>
      <tr id="<?=$r->id?>" class="funcionario">
        <td width="70" ><?=$r->id?></td>
        <td width="230"><?=$r->nome?></td>
        <td width="130"></td>
        <td></td>
      </tr>
      
	  <? while($venda=mysql_fetch_object($Sqlvenda)){ ?>
      
      <tr class="venda" id="<?=$venda->id?>" funcionario="<?=$r->id?>">
        <td width="70"><div style="padding-left:13px;"><?=$venda->id?></div></td>
        <td width="230"><div style="padding-left:13px;"><b><?=get_nome($venda->descricao,25)?></b> <?=$statusVenda[$venda->status]?></div></td>
        <td width="130"><?=moedaUsaToBr($venda->valor_total)?></td>
        <td></td>
      </tr> 
	  <? 
	  	} 
	  } ?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
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