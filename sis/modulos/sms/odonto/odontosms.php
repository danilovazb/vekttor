<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

//include("_functions.php");
//include("_ctrl.php");
$mes = date("m"); $ano = date("Y");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>

</style>
<script>
$(function(){
	
	/*- SMS unico -*/
	var EnviarUnico = function(){
		var telefone = $("#celular_unico").val();
		var mensagem = $("#msg_unica").val();
		var cliente = $("#cliente_id").val();
			$("#result_loading").show();
			$.post('modulos/sms/odonto/enviasms.php',{tel_unico:telefone,msg:mensagem,cliente_id:cliente},
			function(data){
				$("#result_loading").hide();
				$("#result").html(data);
				location.href="?tela_id=386";
			})
	}
	/*- SMS grupo -*/
	var EnviarGrupo = function(){
			$("#result_loading").show();
			var button = $("<input  type='button' id='botao_fechar' value='Fechar' style='float:right'  />");
			$.post("modulos/sms/odonto/enviasms.php",$("#form_odonto_sms").serialize(),
			function(data){
				$("#result_loading").hide();
				$("#result").html(data);	
				$("#botao_salvar").hide();
				location.href="?tela_id=386";
				$("#btn_info").html(button);
			});
	}
	
	$("#enviar_und_sms").live('click',function(){
			EnviarUnico();
	});
	/*botao*/
	$("#abrir_form_und").live('click',function(){
		window.open('modulos/sms/odonto/form_unico.php','carregador');
	});
	
	$("#botao_fechar").live('click',function(){
			location.href="?tela_id=386";
	});
	/*--*/
	$("#botao_salvar").live('click',function(){
		if($.trim($("#celular_unico").val()) != ""){
			EnviarUnico();
		} else{
			EnviarGrupo();
		}	
	});
	$("tr:odd").addClass('al');
})
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Ondontologo 
</a>
<a href="#" class="navegacao_ativo">
<span></span>  SMS
</a>
</div>
<div id="barra_info">
<form method="get" autocomplete="off">
	 <input type="hidden" name="tela_id" value="386">
     Data: <input type="text" name="data_incio" id="data_incio" calendario='1' style="width:80px; height:11px"> : <input type="text" name="data_fim" id="data_fim" calendario='1' style="width:80px;height:11px">
     <input type="submit" value="Filtrar">
     <!--<button type="button" id="abrir_form_und">Enviar &Uacute;nico</button>-->
     <a href="modulos/sms/odonto/form.php" target="carregador" class="mais"></a>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="230"><?=linkOrdem("Nome","nome",1)?></td>
            <td width="60">Enviado</td>
            <td width="75">Data Envio</td>
            <td width="50">Hora</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?php
	$and = "";
	if((!empty($_GET['data_incio'])) and (!empty($_GET['data_fim']))){
		$and .= " AND data_envio BETWEEN '".dataBrToUsa($_GET['data_incio'])."' AND '".dataBrToUsa($_GET['data_fim'])."' ";	
	} else{
		$and = " AND MONTH(data_envio) = '$mes' AND YEAR(data_envio) = '$ano'";	
	}
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT COUNT(*) FROM rel_sms WHERE vkt_id = '$vkt_id' $and"),0,0);
	
	$sql= mysql_query(" SELECT * FROM rel_sms WHERE vkt_id = '$vkt_id' $and");
	while($msg=mysql_fetch_object($sql)){
		$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$msg->cliente_id'"));
		if($msg->status==0){$status='nao';}else{$status='sim';}
	?>
<tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$msg->id?>','carregador')">
    <td width="50" align="center"><?=str_pad($cliente->id,5,"0",STR_PAD_LEFT)?></td>
    <td width="230"><?=$cliente->nome_fantasia?></td>
    <td width="60"><?=$status?></td>
    <td width="75"><?php if($status=='sim'){ echo DataUsaToBr(substr($msg->data_envio,0,10));}else{ echo "-";}?></td>
    <td width="50"><?php if($status=='sim'){ echo substr($msg->data_envio,11,5);}else{ echo "-";}?></td>
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
