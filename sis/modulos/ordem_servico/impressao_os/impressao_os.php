<?
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
//echo $vkt_id;	
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<style>
.readonly{ background:#F9F9F9; color:#999;}
.odd{background:#FFF;}
/* -- MODAL -- */
.modal-header-2{
	padding: 9px 15px;
  	border-bottom: 1px solid #eee;
	background-color: #F8F8F8;
	-webkit-border-top-left-radius: 6px;
	-webkit-border-top-right-radius: 6px;
	-moz-border-radius-topleft: 6px;
	-moz-border-radius-topright: 6px;
	border-top-left-radius: 6px;
	border-top-right-radius: 6px;
}
a{ text-decoration:none;}
</style>
<script>
$(document).ready(function() {
    $("tr:odd").addClass('al');
	$("#form_osCadastro input:text").attr("readonly","readonly");
	
});
$(".td").live("click",function(){
		var id = $(this).parent().attr('id');
		
		window.open('modulos/ordem_servico/impressao_os/form.php?id='+id,'carregador');
});
$("#imp_orcamento").live('click',function(){
		id=$("#id").val();	
		window.open('modulos/ordem_servico/ordem_servico/impressao_orcamento.php?id='+id,'_BLANK');
});
$("#imp_os").live('click',function(){
	
	var id              = $("#id").val();
	
	window.open('modulos/ordem_servico/ordem_servico/rel_os.php?id='+id,'_BLANK');
});
$(".executado").live('click',function(){
	var os_id = $(this).parent().parent().attr('id');
	var status;
	
	if($(this).attr('checked')){
		status='sim';		
	}else{
		status='nao';
		
	}
	
	location.href='?tela_id=452&action=altera_status&os_id='+os_id+'&status='+status;
	
	/*var dados = "os_id="+os_id+'&status='+status;
					$.ajax({
						url: 'modulos/ordem_servico/impressao_os/acao.php?acao=altera_status',
						type: 'POST',
						data: dados,
						success: function(data, textStatus) {
													
							
						},
				});*/
});
$("select#situacao").live('change',function(){
	var valor = $(this).val();
	if(valor == '1'){
		$("#AprStatus").val('');
		$("#AprStatus").hide();
		$("#orcado").show();	
	}
	else if(valor == '2'){
		$("#orcado").val('');
		$("#orcado").hide();
		$("#AprStatus").show();	
	} else{
		$("#AprStatus").val('');
		$("#orcado").val('');
		$("#orcado").hide();
		$("#AprStatus").hide();
	}
}
);
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id='some'>«</div>
<a href="" class='s1'>
  	Sistema
</a>
<a href="" class='s2'>
  	OS
</a>
<a href="" class='navegacao_ativo'>
<span></span>    Impressão OS
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">
    <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["de"];?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["ate"];?>" height="7"/>
    <label>
    	<select name="impresso_id" id="impresso_id">
        	<option value="todos" <?php if($_GET['impresso_id']=='todos'){echo "selected=selected";}?>>Todos</option>
             <option value="nao" <?php if($_GET['impresso_id']=='nao' || empty($_GET['impresso_id'])){echo "selected=selected";}?>>Não Impressos</option>
            <option value="sim" <?php if($_GET['impresso_id']=='sim'){echo "selected=selected";}?>>Impressos</option>
           
        </select>	 
    </label>
    <select name="situacao" id="situacao">
    	<option value="">Situa&ccedil;&atilde;o</option>
    	<option value="1" <?php if($_GET['situacao']==1){echo "selected=selected";}?>>Or&ccedil;amento</option>
        <option value="2" <?php if($_GET['situacao']==2){echo "selected=selected";}?>>Aprovado</option>
        <option value="3" <?php if($_GET['situacao']==3){echo "selected=selected";}?>>Cancelada</option>
    </select>
    <label id="status_os">
    <? if(!empty($_GET['orcado'])){$orDisplay='inline';}else{$orDisplay='none';} ?>
    <select name="orcado" id="orcado" style="display:<?=$orDisplay?>;">
				<option value="0">Selecione</option>
                <option value='sim' <?php if($_GET['orcado']=='sim'){echo "selected=selected";}?>> Or&ccedil;ado </option>
				<option value='nao' <?php if($_GET['orcado']=='nao'){echo "selected=selected";}?>> N&atilde;o Or&ccedil;ado </option>
	</select>
    <? if(!empty($_GET['AprStatus'])){$AprDisplay='inline';}else{$AprDisplay='none';} ?>
    <select name="AprStatus" id="AprStatus" style="display:<?=$AprDisplay?>">
    			<option value="0">Selecione</option>
    			<option value="3" <? if($_GET['AprStatus'] == '3'){echo "selected=selected";}?>>Enviado ao Financeiro</option>
                <option value="4"   <? if($_GET['AprStatus'] == '4'){echo "selected=selected";}?>>Finalizado</option>
    </select>
    </label>
    
    <input type="hidden" name="busca" id="busca" value="<?=$_GET['busca']?>" />
    <input type="submit" value="Filtrar" id="filtrar" title="Filtrar" data-placement="right" />
    <input type="hidden" name="tela_id" value="452" />
	<a href="modulos/ordem_servico/ordem_servico/form.php" target="carregador" class="mais"></a>
    </form>
 
</div>
<!-- -->
<?php
	//$string = " AND situacao = '1' ";
	$fim="";
	if(!empty($_GET['situacao'])){
		$string = "";
			if($_GET['situacao'] == '2' and $_GET['AprStatus'] == '0'){
				$fim .= " AND situacao='".$_GET['situacao']."' AND status_os = '1' ";
			} else {
				$fim.=" AND situacao='".$_GET['situacao']."'";
			}
	}else{
		$fim.=" AND situacao='2'";
	}
	if(!empty($_GET['status_os'])){
		$fim.=" AND status_os='".$_GET['status_os']."'";
	}
	if(!empty($_GET['orcado'])){
		$fim .= " AND orcado = '".$_GET['orcado']."'";
	}
	if(!empty($_GET['AprStatus'])){
			if(is_numeric($_GET['AprStatus'])){
				$fim.=" AND status_os = '".$_GET['AprStatus']."'";	
			}else{
				$fim.=" AND pago = '".$_GET['AprStatus']."'";
			}	
	}
	if(!empty($_GET['de'])&&!empty($_GET['ate'])){
		$fim.=" AND data_cadastro BETWEEN '".DataBrToUsa($_GET['de'])."' AND '".DataBrToUsa($_GET['ate'])."'";
	}
	
	if($_GET['impresso_id']=='todos'){		
	}else
	if(empty($_GET['impresso_id'])){
		$fim.=" AND impresso='nao'";
	}else{		
		$fim.=" AND impresso='".$_GET['impresso_id']."'";
	}
	if(!empty($_GET['busca'])){
		$sql = mysql_fetch_object(mysql_query($t="SELECT *, cf.id AS id_cliente, os.id AS id_os FROM os AS os, cliente_fornecedor AS cf 
													WHERE os.cliente_id = cf.id  
													AND
													(os.id = '".$_GET['busca']."' or cf.razao_social like '%".$_GET['busca']."%') limit 1"));	
		
		$fim .= " AND (id = '".$_GET['busca']."' OR cliente_id = '".$sql->id_cliente."')";
		//echo $t;
	}
?>
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
          <td width="60">N&deg; OS</td>
          <td width="340">Descri&ccedil;&atilde;o</td>
          <td width="150">Cliente</td>
          <td width="80">Cadastro</td>
          
          <td width="80">Aprovado</td>
          <td width="150">Situa&ccedil;&atilde;o</td>
          
          <td width="55">Impresso</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
			$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM os WHERE vkt_id='$vkt_id' $fim"),0,0);
			$sql=mysql_query($t="SELECT * FROM os WHERE vkt_id = '$vkt_id' $string $fim ORDER BY id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
				//echo $t;
				while($os=mysql_fetch_object($sql)){
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '".$os->cliente_id."'"));		
	?>      
    	<tr id="<?=$os->id;?>">
          <td width="60" class="td"><?=$os->numero_sequencial_empresa;?></td>
          <td width="340" class="td"><?=$os->descricao;?></td>
          <td width="150" class="td"><?=$cliente->razao_social?></td>
          <td width="80" class="td"><?=dataUsaToBr($os->data_cadastro);?></td>
          <td width="80" class="td"><?=dataUsaToBr($os->data_aprovacao);?></td>
          <td width="150" class="td">
		  <?
          	if($os->situacao == '1'){
				echo "<span style='color:#387ACB; font-weight:bold;'>Or&ccedil;amento</span>";
			} 
			else if($os->situacao == '2' and $os->status_os == '1'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Aprovado/Aguardando</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '2'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Aprovado/Em Execu&ccedil;&atilde;o</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '3' and $os->pago == 'sim'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Enviado ao Financeiro</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '4' and $os->pago == 'sim'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Finalizado</span>";
			}
			else if($os->situacao == '2'){
				echo "<span style='color:#28A42F; font-weight:bold;'>Aprovado</span>";
			} else if($os->situacao == '3'){
				echo "<span style='color:#F97C00; font-weight:bold;'>Cancelada</span>";
			} 	
		  ?>
          </td>
          
          <td width="55" align="center"><input type="checkbox" class="executado" <? if($os->impresso=='sim'){ echo "checked='checked'";}?>/></td>
          <td></td>
        </tr>
<?php
				}
?>
    	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="85">&nbsp;</td>
          <td ></td>
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
