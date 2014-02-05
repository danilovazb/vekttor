<?
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
//echo $vkt_id;	
?>
<!--<div id='form_confirma_cancelamento'></div>-->
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
table#table-equipamento{border-collapse:collapse; margin-bottom:15px;border:1px solid #CCC;border-bottom-width: 2px;}
table#table-equipamento thead tr:first-child { background:#DDD; padding:3px 12px;}
table#table-equipamento thead th.equipamento { font-weight:700;padding:3px 13px; text-transform:uppercase;}
table#table-equipamento thead th.equipamento span{ font-weight:bold; padding-right:-5px;}
table#table-equipamento thead { background:#F6F6F6; }
table#table-equipamento thead th { padding:3px; font-size:12px; border:1px solid #CCC; font-weight:200; }
table#table-equipamento tbody tr { background:#E2E2E2; }
table#table-equipamento tbody tr td:first-child { text-align:center; padding-left:0; }
form#form_equipamento_cadastro input[readonly="readonly"]{ background:#CCC; } 
.textM{ text-transform:uppercase;}
.pane-item-pago{ 
	background-color: #dff0d8;border: 1px solid #ddd;padding: 8px; display:table; width:63%; color:#666; text-align:center; clear:both; margin-bottom:7px;
	-webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
}
.pane-item-pago p{
	margin:0;
}
</style>
<script>
$(function(){
	$("table#table-equipamento tr:odd").addClass('al');
});
$("#data_entrega").live('blur',function(){

	var data1 = $("#data_cadastro").val();
	var data2 = $("#data_entrega").val();
	
	data1 = data1.split("/");
	var data1 = new Date(data1[2],data1[1],data1[0]);
	
	data2 = data2.split("/");
	var data2 = new Date(data2[2],data2[1],data2[0]);
	
	var diferenca = data2.getTime() - data1.getTime();
	var diferenca = Math.floor(diferenca / (1000 * 60 * 60 * 24));
	$('#dias').val(diferenca);
});


$("#dias").live('blur',function(){
		
		var QtdDias = parseInt($(this).val());
		if(QtdDias > '0'){
				var DateLocacao = $("#data_cadastro").val();
				var dmy = DateLocacao.split("/"); 
				var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
				joindate.setDate(joindate.getDate() + QtdDias);
				 $("#data_entrega").val(("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear());
		}
})
$("#imprimir_relatorio").live('click',function(){
	
	var valor = $("#situacao").val();
	var de = $("#de").val();
	var ate = $("#ate").val();
	//alert('oi');
	if( $.trim(valor) != "all" ){
	var situacao = ($("#situacao").find("option:selected").attr("id"));
	if(situacao == 1)
		window.open("modulos/ordem_servico/ordem_servico/impressao_relatorio.php?tela_id=276&status="+valor+"&situacao="+situacao+"&de="+de+"&ate="+ate);
	else if(situacao == 2)
		window.open("modulos/ordem_servico/ordem_servico/impressao_relatorio.php?&status="+valor+"&situacao="+situacao+"&aprovacao=1"+"&de="+de+"&ate="+ate);
	else if(situacao == 3)
		window.open("modulos/ordem_servico/ordem_servico/impressao_relatorio.php?situacao="+situacao+"&cancelada=1"+"&de="+de+"&ate="+ate);
	} else {
		window.open("modulos/ordem_servico/ordem_servico/impressao_relatorio.php?de="+de+"&ate="+ate);
	}
	
	//window.open('modulos/ordem_servico/ordem_servico/impressao_relatorio.php?de='+de+'&ate='+ate+'&situacao='+situacao+'&AprStatus='+AprStatus+'&orcado='+orcado+'&busca='+busca);
});

$("#cancelar_os").live('click',function(){
	
	var os_id   =$("#id").val();
	//alert(empresa_id);
	window.open('modulos/ordem_servico/ordem_servico/form_confrima_cancelamento.php','carregador');
});
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
<span></span>    Ordem de Servi&ccedil;o
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca"  id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">
    <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["de"];?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["ate"];?>" height="7"/>
    
    <select name="situacao" id="situacao" style="width:170px;">
    	<option value="all">Todas</option>
        <optgroup label="Orçamento"  >
			<option value='nao' id="1" <?php if($_GET['status']=='nao'){echo "selected=selected";}?>> A serem orçados </option>
            <option value='sim' id="1" <?php if($_GET['status']=='sim'){echo "selected=selected";}?>> Orçados e ainda não aprovados </option>
        </optgroup>
        <optgroup label="Aprovados">
            <option value="1" id="2" <? if($_GET['status'] == '1'){echo "selected=selected";}?>>Não executado</option>
        </optgroup>
        <optgroup label="Executado/Enviado Financeiro">
            <option value="3" id="2" <? if($_GET['status'] == '3'){echo "selected=selected";}?>>Não entregue</option>
            <option value="4" id="2" <? if($_GET['status'] == '4'){echo "selected=selected";}?>>Finalizado/Entregue</option>
        </optgroup>
        <optgroup label="Cancelada">
        	<option value="0" id="3" <?php if($_GET['situacao']==3){echo "selected=selected";}?>>Cancelada</option>
        </optgroup>
    </select>
    
    <!--<input type="submit" value="Filtrar" id="filtrar" title="Filtrar" data-placement="right" />-->
    <input type="hidden" name="tela_id" value="276" />
	<a href="modulos/ordem_servico/ordem_servico/form.php" target="carregador" class="mais"></a>
    <input type="hidden" name="busca" id="busca" value="<?=$_GET['busca']?>" />
   <button type="button" id="imprimir_relatorio" class="botao_imprimir"  style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
	</button>

<!--<button type="button" onclick="window.open('modulos/tela_impressao.php?url=<? //$url?>')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
</button>-->
    </form>
 	
</div>
<script>
$(document).ready(function(){$("tr:odd").addClass('al');});
//$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/ordem_servico/ordem_servico/form.php?id='+id,'carregador');
	});
//});

$("#envia_email").live('click',function(){
			//alert('sdsdfs');
		window.open('modulos/ordem_servico/ordem_servico/orcamento_email.php','carregador');
});

$("#imp_orcamento").live('click',function(){
		id=$("#id").val();	
		window.open('modulos/ordem_servico/ordem_servico/impressao_orcamento.php?id='+id,'_BLANK');
});

/*-script para window cliente-*/
$(".atl_natureza input:radio").live('click',function(){
	$("#atl_nome").val("");
	$("#atl_cnpf_cpf").val("");
	$("#atl_nome").attr("disabled","disabled");
	$("#atl_cnpf_cpf").attr("disabled","disabled");
	$("#atl_cadastrar").attr("disabled","disabled");
	
	for( i=0; i < $(this).length; i++ ){
			if($(this).is(":checked")){
				var liberado = true;
			}
	}
	if(liberado == true){
		$("#atl_nome").removeAttr("disabled");
		$("#atl_cnpf_cpf").removeAttr("disabled");
		$("#atl_cadastrar").removeAttr("disabled");
	}
	if($(this).val() == '1'){
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','___.___.___-__');
	}else{
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','__.___.___/____-__'); // 05.535.221/0001-88
	}
});

$("div").on("click","#cad_cliente",function(){
	$(".modal").toggle();
});

$("div").on('click','#atl_cadastrar',function(){
		//Físico - Jurídico
		var natureza = $(".atl_natureza").find(":radio");
			for(i=0; i < natureza.length; i++){
				if($(natureza[i]).is(":checked")){
					var tipo = $(natureza[i]).val();
				}
			}
	 
		  var nome = $("#atl_nome").val();
		  var cnpj_cpf = $("#atl_cnpf_cpf").val();
		//alert(tipo_cliente);
		$.post('modulos/ordem_servico/ordem_servico/tabela_item.php?acao=atl_cliente',{tipo_cadastro:tipo,nome:nome,cnpjCpf:cnpj_cpf},function(data){
				$("#cliente_id").val(data);
				$("#cliente").val(nome);
				$("#atl_nome").attr("disabled","disabled");
				$("#atl_cnpf_cpf").attr("disabled","disabled");
				$("#atl_cadastrar").attr("disabled","disabled");
				$(".modal").hide("slow");	
		})
		
});
/*-fim script para window cliente-*/

</script>
<!-- JS PARA PRODUTOS -->
<script type="text/javascript" src="modulos/ordem_servico/ordem_servico/OrdemServicoJS.js"></script>
<!-- -->
<?php
	$cancel =" AND situacao != 3 ";
	$fim="";
	if( empty($_GET["aprovacao"]) )
		$filter = !empty($_GET['situacao']) ? " AND orcado = '".trim($_GET['status'])."' AND situacao = '".trim($_GET["situacao"])."'" : NULL;
	
	if( !empty($_GET["aprovacao"]) )
		$filter = !empty($_GET['situacao']) ? " AND status_os = '".trim($_GET['status'])."' AND situacao = '".trim($_GET["situacao"])."'" : NULL;
	
	if( !empty($_GET["cancelada"]) ){
		$filter = !empty($_GET['situacao']) ? " AND situacao = '".trim($_GET['situacao'])."'" : NULL;
		$cancel = "";
	}
	if(!empty($_GET['de'])&&!empty($_GET['ate'])){
		$fim.=" AND data_cadastro BETWEEN '".DataBrToUsa($_GET['de'])."' AND '".DataBrToUsa($_GET['ate'])."'";
	}
	if(!empty($_GET['busca'])){
		$sql = mysql_fetch_object(mysql_query($t="SELECT *, cf.id AS id_cliente, os.id AS id_os FROM os AS os, cliente_fornecedor AS cf 
													WHERE os.cliente_id = cf.id  AND (os.id = '".$_GET['busca']."' or cf.razao_social like '%".$_GET['busca']."%') limit 1"));	
		
		$fim .= " AND (id = '".$_GET['busca']."' OR cliente_id = '".$sql->id_cliente."')";
		
	}
?>
<div class="test_impressao">
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
          <td width="40">N&deg;</td>
          <td width="230">Descri&ccedil;&atilde;o</td>
          <td width="150">Cliente</td>
          <td width="80">Cadastro</td>
          
          <!--<td width="80">Aprovado</td>-->
          <td width="150">Situa&ccedil;&atilde;o</td>
          <td width="80">Total</td>
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
			$sql=mysql_query($t="SELECT * FROM os WHERE vkt_id = '$vkt_id' $cancel $string $filter $fim ORDER BY id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			
			$total_ordem_servico = mysql_result(mysql_query("SELECT SUM(valor_total_geral) as valor_total FROM os WHERE vkt_id = '$vkt_id'  $cancel $string $filter $fim ORDER BY id DESC"),0,0);
				while($os=mysql_fetch_object($sql)){
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '".$os->cliente_id."'"));		
	?>      
    	<tr id="<?=$os->id;?>" status="<?=$os->status_os?>">
          <td width="40"><?=$os->numero_sequencial_empresa;?></td>
          <td width="230" class="textM"><div style="padding-left:5px; margin-left:-10px;" rel="tip" title="<?=$os->descricao;?>" ><?=getString($os->descricao,35);?></div></td>
          <td width="150"><?=$cliente->razao_social?></td>
          <td width="80"><?=dataUsaToBr($os->data_cadastro);?></td>
          <!--<td width="80"><?=dataUsaToBr($os->data_aprovacao);?></td>-->
          <td width="150">
		  <?
          	if($os->situacao == '1'){
				echo "<span style='color:#387ACB;'>Or&ccedil;amento</span>";
			} 
			else if($os->situacao == '2' and $os->status_os == '1'){
				echo "<span style='color:#28A42F;'>Aprovado/Aguardando</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '2'){
				echo "<span style='color:#28A42F;'>Aprovado/Em Execu&ccedil;&atilde;o</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '3' and $os->pago == 'sim'){
				echo "<span style='color:#28A42F;'>Executado / Não entregue</span>";
			}
			else if($os->situacao == '2' and $os->status_os == '4' and $os->pago == 'sim'){
				echo "<span style='color:#28A42F;'>Finalizado/Entregue</span>";
			}
			else if($os->situacao == '2'){
				echo "<span style='color:#28A42F;'>Aprovado</span>";
			} else if($os->situacao == '3'){
				echo "<span style='color:#F97C00;'>Cancelada</span>";
			} 	
		  ?>
          </td>
          <td width="80"><?=moedaUsaToBr($os->valor_total_geral);?></td>
                     
          <td></td>
        </tr>
<?php
				}
?>
    	
    </tbody>
</table>
</div>
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
          <td width="85"><?=moedaUsaToBr($total_ordem_servico)?></td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&de=<?=$_GET['de']?>&ate=<?=$_GET['ate']?>&situacao=<?=$_GET['situacao']?>&orcado=<?=$_GET['orcado']?>&AprStatus=<?=$_GET['AprStatus']?>'">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array("de"=>$_GET['de'],"ate"=>$_GET['ate'],"situacao"=>$_GET['situacao'],"orcado"=>$_GET['orcado'],"AprStatus"=>$_GET['AprStatus']))?>
    </div>
</div>
