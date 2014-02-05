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
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
	
	$(".exibe_modulos").live('click',function(){
		id = $(this).attr('r');
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
		$(".submodulos").hide();

		$("#div"+id).show();	
	})
$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
			
		}
});
$(function(){
			$("#f_nome_contato").live('keyup',function(){
						var nome = $(this).val();
						$("#nome_usuario").val(nome);
			})
})
</script>
<div id="some">«</div>
<a href="./" class='s1' >
  	Sistema
</a>
<a href="./" class='s2'>
    Revenda Vekttor 
</a>
<a href="?tela_id=15" class="navegacao_ativo">
<span></span>    Vendedor 
</a>
</div>
<div id="barra_info">
<form method="get" autocomplete="off">
	
    
    <select name="bairro" id="bairro">
    		<option value="">Bairro</option>
    		<?php
            	$sqlFilter= mysql_query($t=" SELECT DISTINCT bairro FROM cliente_fornecedor WHERE cliente_vekttor_id = '$vkt_id' ");
					while($bairro=mysql_fetch_object($sqlFilter)){
							if($_GET['bairro'] == $bairro->bairro){$selb = "selected='selected'";} else{$selb ="";} 
			?>
            <option <?=$selb?> value="<?=$bairro->bairro?>"><?=$bairro->bairro?></option>
    		<?php
					}
			?>
    </select>

    <input type="submit" value="Filtrar" id="filtrar" />
    <input type="hidden" name="tela_id" value="344" />
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
    </form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="60"> N&ordm; </td>
            <td width="230">Vendedor</td>
          	<td width="130">Bairro</td>
            <td width="95">% Implanta&ccedil;&atilde;o</td>
            <td width="75">% Servi&ccedil;o</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	$AND = "";
	if(!empty($_GET['bairro'])){
		$AND = "AND cf.bairro like '%{$_GET[bairro]}%'";
	}
	
	
	// colocar a funcao da paginação no limite
	$sql= mysql_query($pp="SELECT *,rh.id AS id_vendedor FROM rh_funcionario AS rh, cliente_fornecedor AS cf WHERE rh.cliente_fornecedor_id = cf.id AND rh.cliente_vekttor_id = '$vkt_id' $AND ");
	while($vendedor=mysql_fetch_object($sql)){
		$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$vendedor->cliente_fornecedor_id'"));
	?>
			<tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?id=<?=$vendedor->id_vendedor?>','carregador')">
                <td width="60"><?=$vendedor->id?></td>
                <td width="230"><?=$vendedor->nome?></td>
                <td width="130"><?=$cliente->bairro?></td>
                <td width="95"><?=$vendedor->implantacao?></td>
                <td width="75"><?=$vendedor->servico?></td>
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
