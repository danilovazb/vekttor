<?php
include("modulos/financeiro/_functions_financeiro.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.container_campos{
	/*color: #999999;*/
	border:1px solid #cccccc;
	padding:6px;
	-moz-border-bottom-width: 2px;
	     border-bottom-width: 2px;
	-webkit-border-radius:5px;
	   -moz-border-radius:5px;
	        border-radius:5px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){	
	
	$("tr:odd").addClass('al');
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/campo_futebol/reserva/form.php?id='+id,'carregador');
	});
	
	/* Cadastra cliente */
	$(document).on("click","#cad_cliente",function(){
		$(".modal").toggle();
	});
	
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
			  $("#tipo").removeAttr("disabled");
		  }
		  if($(this).val() == '1'){
			  $("#atl_cnpf_cpf").val('');
			  $("#atl_cnpf_cpf").attr('mascara','___.___.___-__');
		  }else{
			  $("#atl_cnpf_cpf").val('');
			  $("#atl_cnpf_cpf").attr('mascara','__.___.___/____-__'); // 05.535.221/0001-88
		  }
	});
	
	$(document).on("click","#atl_cadastrar",function(){
		var natureza = $(".atl_natureza").find(":radio");
		for(i=0; i < natureza.length; i++){
			if($(natureza[i]).is(":checked")){
				var tipo_cadastro = $(natureza[i]).val();
			}
		}
		
	  if( $.trim($("#atl_nome").val()) !== "" && $.trim($("#atl_cnpf_cpf").val()) !== ""  ){	  
		  var dados = { method:"CadastraCliente", tipo_cadastro:tipo_cadastro, tipo:$("select#tipo").val(), nome:$("#atl_nome").val(), cnpjCpf:$("#atl_cnpf_cpf").val() };
		
		  $.ajax({
			  type:"POST",
			  url:"modulos/campo_futebol/reserva/AjaxClass.php",
			  data:dados,
			  success: function(data){
				  console.log(data);
				  $("#cliente_id").val(data);
				  $("#cliente").val($("#atl_nome").val());
				  $("#atl_nome").attr("disabled","disabled");
				  $("#atl_cnpf_cpf").attr("disabled","disabled");
				  $("#atl_cadastrar").attr("disabled","disabled");
				  $(".modal").attr("disabled","disabled");
				  $(".modal").hide("slow");
			  }
		  });
		
		}
	});
	/* Fim cadastra cliente */
	
	$(document).on("click","#Salvar",function(){
		$("#form_reserva_cadastro").submit();
	});
});

</script>
<script type="text/javascript" src="modulos/campo_futebol/reserva/reserva.js"></script>
<script type="text/javascript" src="modulos/campo_futebol/reserva/jquery.utilities.min.js"></script>

<div id='conteudo'>
<div id='navegacao'>
  <div id="some">«</div>
    <a href="#" class='s1'> SISTEMA </a>
    <a href="" class='s2'> Campo Futebol </a>
    <a href="" class='navegacao_ativo'><span></span> Reserva </a>
  </div>

  <div id="barra_info">
    <form style="float:left;" method="get" autocomplete="off">
    	Data Reserva
        <label><input type="text" name="data_reserva" id="data_reserva" style="width:100px;" mascara="__/__/____"></label>
        <input type="submit" name="filter" value="Filtrar">
        <input type="hidden" name="tela_id" value="556" />
    </form>
    <a href="modulos/campo_futebol/reserva/form.php" target="carregador" class="mais"></a>
  </div>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="50">COD</td>
          <td width="200">Cliente</td>
          <td width="100">Data</td>
          <!--<td width="100">Hor&aacute;rios</td>-->
          <td width="100">Valor (R$)</td>
          <td width="100">Situa&ccedil;&atilde;o</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	  <?php 
          
		  $filterData = !empty($_GET["data_reserva"]) ? " AND DATE_FORMAT(reserva.data_cadastro_reserva, '%d/%m/%Y')  = '".trim($_GET["data_reserva"])."'  " : NULL;
		  
		  $registros= mysql_result(mysql_query("SELECT 
		  COUNT(*) 
		  FROM  ".TBL_RESERVA." AS reserva 
		  JOIN cliente_fornecedor AS cliente ON reserva.cliente_fornecedor_id = cliente.id
		  WHERE reserva.vkt_id = '$vkt_id' {$filterData}"),0,0);
		  
		  $sql = mysql_query($t="SELECT 
		  *,DATE_FORMAT(reserva.data_cadastro_reserva, '%d/%m/%Y') AS data_reserva, reserva.status AS statusReserva, reserva.id AS id_reserva 
		  FROM  ".TBL_RESERVA." AS reserva 
		  JOIN cliente_fornecedor AS cliente ON reserva.cliente_fornecedor_id = cliente.id
		  WHERE reserva.vkt_id = '$vkt_id' 
		  {$filterData} LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;
		 
		  while($reserva=mysql_fetch_object($sql)){
			$tem_pgto_finalizado 	= mf(mq($a="SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND origem_id='$reserva->id_reserva' AND origem_tipo='reserva_campo' AND status='1'"));
			if($tem_pgto_finalizado->id>0){$status="Pago";}else{
				$status='Reserva';
			}
			
      ?>      
    	<tr id="<?=$reserva->id_reserva?>">
          <td width="50"><?=$reserva->id_reserva?></td>
          <td width="200"><?=$reserva->razao_social?></td>
          <td width="100"><?=$reserva->data_reserva?></td>
          <!--<td width="100"></td>-->
          <td width="100"><?=moedaUsaToBr($reserva->valor)?></td>
          <td width="100"><?=$status?></td>
          <td></td>
        </tr>
	  <?php
		  }
      ?>
    </tbody>
</table>
<script>
/*(
function mostraConta(t){
	if($(t).is(':checked')){
		$("#conta").show();	
	}else{
		$("#conta").hide();
	}
	
}*/
$(document).on('change',"#efetivar_movimento",function(t){
	if($("#efetivar_movimento").is(':checked')){
		$("#forma_pagamento").show();
		$("#data_info_movimento_label").show();
	}else{
		$("#forma_pagamento").hide();
		$("#data_info_movimento_label").hide();
	}
})

$(document).on('change',"#efetivar_movimento2",function(t){
	if($("#efetivar_movimento2").is(':checked')){
		$("#forma_pagamento2").show();
		$("#data_info_movimento_label2").show();
	}else{
		$("#forma_pagamento2").hide();
		$("#data_info_movimento_label2").hide();
	}
})

</script>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
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