<?
// funçoes do modulo empreendimento
//include("_functions.php");
//include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
//echo $vkt_id;	
?>
<!--<div id='form_confirma_cancelamento'></div>-->
<script>
	$(".botao_imprimir").live('click',function(){
		window.open('modulos/tela_impressao.php?url=');
	});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

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
<span></span>    <?=$tela->nome?>
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
    <?php
		if(!empty($_GET["de"])){
			$data_inicio = $_GET["de"];
			$data_fim    = $_GET["ate"];
		}else{
			$data_inicio = date("01/m/Y");
			$data_fim    = date("t/m/Y");
		}
	?>
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$data_inicio;?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$data_fim;?>" height="7"/>
    
    <!--<select name="situacao" id="situacao">
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
    <? //if(!empty($_GET['AprStatus'])){$AprDisplay='inline';}else{$AprDisplay='none';} 
		if($_GET['situacao']==2){$AprDisplay='inline';}else{$AprDisplay='none';}
	?>
    <select name="AprStatus" id="AprStatus" style="display:<?=$AprDisplay?>">
    			<option value="0">Todos</option>
    			<option value="3" <? if($_GET['AprStatus'] == '3'){echo "selected=selected";}?>>Enviado ao Financeiro</option>
                <option value="4"   <? if($_GET['AprStatus'] == '4'){echo "selected=selected";}?>>Finalizado</option>
    </select>
    </label>-->
    
    <input type="submit" value="Filtrar" id="filtrar" title="Filtrar" data-placement="right" />
    <input type="hidden" name="tela_id" value="521" />
	
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
	//$string = " AND situacao = '1' ";
	$fim="";
	if(!empty($_GET['situacao'])){
		$string = "";
			if($_GET['situacao'] == '2' and $_GET['AprStatus'] == '0'){
				$fim .= " AND situacao='".$_GET['situacao']."'";
			} else {
				$fim.=" AND situacao='".$_GET['situacao']."'";
			}
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
		$fim.=" AND data_cadastro BETWEEN '".DataBrToUsa($data_inicio)."' AND '".DataBrToUsa($data_fim)."'";
	}
	if(!empty($_GET['busca'])){
		$sql = mysql_fetch_object(mysql_query($t="SELECT *, cf.id AS id_cliente, os.id AS id_os FROM os AS os, cliente_fornecedor AS cf 
													WHERE os.cliente_id = cf.id  
													AND
													(os.id = '".$_GET['busca']."' or cf.razao_social like '%".$_GET['busca']."%') limit 1"));	
		
		$fim .= " AND (id = '".$_GET['busca']."' OR cliente_id = '".$sql->id_cliente."')";
		
	}
?>
<div class="test_impressao">
<div id='dados' >
<div id="info_filtro">
<div style="float:left">
	<img src="../modulos/vekttor/clientes/img/<?=$vkt_id?>.png" />
</div>
<div style="float:left;margin-top:20px;margin-left:20px;">
	<strong>Ordem de Serviço - Pagamentos</strong>
    <div style="clear:both"></div>
    <strong><?=$empresa[nome]?></strong>
    <div style="clear:both"></div>
    <strong>Período:</strong> <?=$data_inicio." à ".$data_fim?>
</div>
</div>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
          <td width="60">N&deg; OS</td>
          <td width="150">Cliente</td>
          <td width="340">Descri&ccedil;&atilde;o</td>
          <!--<td width="150">Situa&ccedil;&atilde;o</td>-->
          <td width="90">Data Cadastro</td>
          <td width="80">Valor</td>
          <td width="80">Pago</td>
          <td width="80">Pendente</td>
          <td></td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
			$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM os WHERE vkt_id = '$vkt_id' AND situacao='2' AND status_os='3' AND pago='sim' $fim"),0,0);
			$sql=mysql_query($t="SELECT * FROM os WHERE vkt_id = '$vkt_id' AND situacao='2' AND status_os='3' AND pago='sim' $fim ORDER BY id DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
			//echo mysql_error();
			
			$total_ordem_servico = mysql_result(mysql_query("SELECT SUM(valor_total) as valor_total FROM os WHERE vkt_id = '$vkt_id' AND situacao='2' AND status_os='3' AND pago='sim' $fim"),0,0);
				$total_pago = 0;
				$total_pendente = 0;
				while($os=mysql_fetch_object($sql)){
					$cliente     = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '".$os->cliente_id."'"));
					$os_pago     = mysql_result(mysql_query("SELECT SUM(valor_cadastro) as pago FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND (doc='$os->id' OR origem_id='$os->id') AND status='1'"),0,0);
					$total_pago +=$os_pago;
					$os_pendente = mysql_result(mysql_query("SELECT SUM(valor_cadastro) as pendente FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND (doc='$os->id' OR origem_id='$os->id') AND status='0'"),0,0);							
					$total_pendente +=$os_pendente;
	?>      
    	<tr id="<?=$os->id;?>" status="<?=$os->status_os?>">
          <td width="60"><?=$os->numero_sequencial_empresa;?></td>
          <td width="150"><?=$cliente->razao_social?></td>
          <td width="340"><?=$os->descricao;?></td>
          <!--<td width="150">
		  <?
          	/*if($os->situacao == '1'){
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
			} */	
		  ?>
          </td>-->
          <td width="90"><?=DataUsaToBr($os->data_cadastro)?></td>
          <td width="80"><?=MoedaUsaToBr($os->valor_total);?></td>
          <td width="80"><? if($os_pago>0){ echo MoedaUsaToBr($os_pago);}else{echo "0,00";}?></td>
          
          <td width="80"><? if($os_pendente>0){ echo MoedaUsaToBr($os_pendente);}else{echo "0,00";}?></td>
                     
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
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
          <td width="60">&nbsp;</td>
          <td width="150">&nbsp;</td>
          <td width="340">&nbsp;</td>
          <!--<td width="150">Situa&ccedil;&atilde;o</td>-->
          <td width="90">&nbsp;</td>
          <td width="80"><?=MoedaUsaToBr($total_ordem_servico)?></td>
          <td width="80"><?=MoedaUsaToBr($total_pago)?></td>
          <td width="80"><?=MoedaUsaToBr($total_pendente)?></td>
          <td></td>
        </tr>
    </thead>
</table>
</div>
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
