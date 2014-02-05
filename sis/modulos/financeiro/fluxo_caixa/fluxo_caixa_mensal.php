<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
include("_functions.php");
include("_ctl.php");
?>
<script src="modulos/financeiro/financeiro.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#rodape_t td, #mjy td{text-align:right}

#mjy .al td.cl{width:75px;text-align:right;}
#mjy  td.cl{width:75px;text-align:right;}
.cl{width:75px;text-align:right;}
#mjy .al td.clv{color:#F00}
#mjy td.clv{color:#F00}

#mjy .al td.cla{color:#999}
#mjy td.cla{color:#999}

#mjy tr:hover .clh{background:#8BA7C9; color:#FFF;}
#mjy tr:hover .clf{background:#8BA7C9; color:#FFF;}

#mjy tr.al:hover .clh{background:#8BA7C9; color:#FFF;}
#mjy tr.al:hover .clf{background:#8BA7C9; color:#FFF;}

#mjy .al td.clh{width:75px;text-align:right; background:#E8D9D9;}
#mjy td.clh{width:75px;text-align:right; background:#FFF0F0;}

#mjy .al td.clf{width:75px;text-align:right; background:#E4E4E4}
#mjy td.clf{width:75px;text-align:right; background:#F5F5F5;}
.ui-tooltip{ white-space: pre-wrap; opacity:1;}
</style>
<script>
 $(function() {
	$( document ).tooltip({
		track: true
	});
});
//
$("#forma_pagamento").live('change',function(){
	if($(this).val()=="4"){
		$("#imprimir_boleto").show();
	}else{
		$("#imprimir_boleto").hide();
	}
})

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
$("div").on("click","#cad_cliente",function(){
	$(".modal").toggle();
});
$("div").on('click','#atl_cadastrar',function(){
		//Físico - Jurídico
		var natureza = $(".atl_natureza").find(":radio");
			for(i=0; i < natureza.length; i++){
				if($(natureza[i]).is(":checked")){
					var tipo_cadastro = $(natureza[i]).val();
				}
			}
	 
		  var nome = $("#atl_nome").val();
		  var cnpj_cpf = $("#atl_cnpf_cpf").val();
		  var tipo = $("select#tipo").val();
		//alert(tipo_cliente);
		$.post('modulos/ordem_servico/ordem_servico/tabela_item.php?acao=atl_cliente',{tipo_cadastro:tipo_cadastro,tipo:tipo,nome:nome,cnpjCpf:cnpj_cpf},function(data){
				$("#internauta_id").val(data);
				$("#cliente").val(nome);
				$("#internauta_id").attr("title",nome);
				$("#atl_nome").attr("disabled","disabled");
				$("#atl_cnpf_cpf").attr("disabled","disabled");
				$("#atl_cadastrar").attr("disabled","disabled");
				$(".modal").hide("slow");	
		})
		
});


</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>   <?=$tela->nome?>
</a>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
<form style="float:left; margin:0; padding:0">
	<input type="hidden" name="tela_id" value="<?=$_GET[tela_id]?>">
	 Inica em <input name="inicio" value="<?=$ano_mes_inicio?>" size="8"> 
	 Exibir <input name="meses" value="<?=$quantidade_meses?>" size="2"> 
     Meses <input type="submit" value="Exibir">
</form>
</div>
<div id='dados' style=" display:block; clear:both">
<script>resize();</script>
<div style="width:<?=300+(($quantidade_meses+1)*85)+200?>px; ">

<table cellpadding="0" cellspacing="0" id='xyz' style=" width:<?=200+(($quantidade_meses+1)*85)+200?>px; <?="position:absolute;"?>">
    <thead>
    	<tr>
    	  <td width="209" style="padding:1px;">Entradas</td>
<?
           for($i=0;$i<$quantidade_meses;$i++){
				$ano_mes_atual 	= retorna_mes_ano_adicionado($data_inicio,$i);
			?>
          	<td width="75" style=""><?=$ano_mes_atual?></td>
            <?
			}
			?>
            <td width="76" align="center">Total</td>
            <td width=""></td>
			
        </tr>
    </thead>
</table>
<!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" id='mjy' cellspacing="0" style="float:right; margin-right:100px; " width="<?=200+(($quantidade_meses+1)*85)+200-212?>" >


<!-- Primeira Linha Imbutida -->
<thead><tr><td >..</td></tr></thead>


<!-- 1ª Linha  Inicial cria as colunas -->
<tbody>
  <tr id='saldo_inicial'  class="al" >
     	<?
		// cria as colunas
       for($i=0;$i<$quantidade_meses;$i++){
			$data_atual 	= retorna_data_adicionada($data_inicio,$i);
		   if($i==0){
				$total_mes[$data_atual] = calcula_saldo_incial();   
			   $saldo_inicial = $total_mes[$data_atual];
				$subtotal_entrada_plano['inicial'][] =$total_mes[$data_atual];
				$subtotal_entrada_mes[$data_atual][] =$total_mes[$data_atual];
			}
		?>
        <td class='cl'><?=n($total_mes[$data_atual])?></td>
        <?
	   }
	   $subtotal_plano_periodo['i'] = $saldo_inicial;
		?>
  	 <td class='cl'><strong><?=n(@$subtotal_plano_periodo['i'])?></strong></td>
    <td></td>
  </tr>


<!-- Lista os totas de planos de contas por mes -->
	<?
	//lista os totdas de cadas plano por es
	for($i=0;$i<count($planos_receber);$i++){
	?>      
	<tr <?=linha_diferente($i)?> id='li<?=$planos_receber[$i]->id?>' >
    	<?
		// cria as colunas
		for($c=0;$c<$quantidade_meses;$c++){
			$data_atual 	= retorna_data_adicionada($data_inicio,$c);

			$total_mes = movimento_no_mes('receber','plano',$planos_receber[$i]->id,$data_atual);
			$subtotal_entrada_plano[$planos_receber[$i]->id][] =$total_mes;
			$subtotal_entrada_mes[$data_atual][] =$total_mes;
			
			
			?><td title='<?=retorna_tip('receber','plano',$planos_receber[$i]->id,$data_atual)?>'  class="cl<?=$cor.$corfundo?>"><?=$total_mes?></td><?
		}
		$subtotal_plano_periodo[$i] =  @array_sum($subtotal_entrada_plano[$planos_receber[$i]->id]);
		?>
       <td width="75" align="right"><b><?=n($subtotal_plano_periodo[$i])?></b></td><!-- Total do periodo -->
    	<td width=""></td>
    </tr>
        
<?	} ?>
</tbody>


<!-- Total de entrada por mes dos palanos -->
<thead>
  <tr>
    <?
     for($i=0;$i<$quantidade_meses;$i++){
	  $data_atual 	= retorna_data_adicionada($data_inicio,$i);
	  $total_entrada_mes[$data_atual] =@array_sum($subtotal_entrada_mes[$data_atual]) ;
	?>
      <td class='cl'><?=n($total_entrada_mes[$data_atual])?></td>
    <? } ?>
    <!-- Total de entrada de um plano no periodo -->
    <td><?=n($total_entradas=@array_sum($subtotal_plano_periodo))?></td>
    <td></td>
  </tr>
</thead>


<!-- Titulo Saida -->
<thead>
	<tr>
		<?
       for($i=0;$i<$quantidade_meses;$i++){ ?>
             <td >&nbsp;</td>
        <? }	?>
        <td></td>
        <td></td>
    </tr>
</thead>


<!-- LISTA TODAS AS SAIDAS --> 
<tbody>
<!-- Totdas Contas Vencidas  --> 
  <tr id='li_vencidas'  class="al" >
     	<?
		// cria as colunas
       for($i=0;$i<$quantidade_meses;$i++){
		?>
        <td class='cl'><?=$i?></td>
        <?
	   }
		?>
  	 <td class='cl'>atrazadas</td>
    <td></td>
  </tr>

<?
	//lista os totdas de cadas plano por es
	for($i=0;$i<count($planos_pagar);$i++){
	?>      
	<tr <?=linha_diferente($i)?> id='li<?=$planos_pagar[$i]->id?>' >
    	<?
		// cria as colunas
		for($c=0;$c<$quantidade_meses;$c++){
			$data_atual 	= retorna_data_adicionada($data_inicio,$c);

			$total_mes = movimento_no_mes('pagar','plano',$planos_pagar[$i]->id,$data_atual);
	
			$subtotal_saida_plano[$planos_pagar[$i]->id][] =$total_mes;
			$subtotal_saida_mes[$data_atual][] =$total_mes;
		
			
			?><td title='<?=retorna_tip('pagar','plano',$planos_pagar[$i]->id,$data_atual)?>'  class="cl<?=$cor.$corfundo?>"><?=$total_mes?></td><?
		}
		
		$subtotal_plano_periodo_saida[$i] =  @array_sum($subtotal_saida_plano[$planos_pagar[$i]->id]);

		?>
       <td width="75" align="right"><strong><?=n($subtotal_plano_periodo_saida[$i])?></strong></td><!-- Total do periodo -->
    	<td width=""></td>
    </tr>
        
<?	} ?>
</tbody>


</table>


<!--  

1ª Coluna Fixa que fica Antes da Segunda

-->

<table cellpadding="0" id='titulos' cellspacing="0" style="background:#FFF; float:left">
<!--  -->
<thead><tr><td width="200" >Entradas</td></tr></thead>
<tbody>
    <tr  id='saldo_inicial' class="al" >
      <td width="200" >Saldo Inicial</td>
    </tr>
<!-- Lista de Planos  -->
    <?
	
	for($i=0;$i<count($planos_receber);$i++){
	?>
    <tr <?=linha_diferente($i)?> id='li<?=$planos_receber[$i]->id?>' >
      <td width="200"  ><?=substr($planos_receber[$i]->nome,0,30)?></td>
    </tr>
    <?
	}
	?>
</tbody>
 <!-- Totral de Entrada  -->
<thead><tr><td>Total Entradas</td></tr></thead>
 <!-- Titulo de Saidas  -->
<thead><tr><td>Saidas</td></tr></thead>
 
<tbody>
 <!-- Atraadas  -->
 <tr  class="al"  id='li_vencidas' >
      <td width="200" title='exibe todos os que tem' >Vencidas</td>
    </tr>
  <!-- Lista  Saidas  -->
      <?
	
	for($i=0;$i<count($planos_pagar);$i++){
	?>
    <tr <?=linha_diferente($i)?> id='li<?=$planos_pagar[$i]->id?>' >
      <td width="200"  ><?=substr($planos_pagar[$i]->nome,0,30)?></td>
    </tr><?
	}
	   ?>
</tbody>

</table>

    </div>
  
</div>
<table cellpadding="0" cellspacing="0" id='trodape' style=" width:<?=200+(($quantidade_meses+1)*85)+200?>px; ">
<!-- Total de Saidaas por mes dos palanos -->
<thead>
  <tr>
	  <td width="209" style="padding-left:1px;">Total Saidas</td>
    <?
     for($i=0;$i<$quantidade_meses;$i++){
	  $data_atual 	= retorna_data_adicionada($data_inicio,$i);
	  $total_saida_mes[$data_atual] =@array_sum($subtotal_saida_mes[$data_atual]) ;
	?>
      <td class='cl'><?=n($total_saida_mes[$data_atual])?></td>
    <? } ?>
    <td class='cl'><?=n(@$total_saidas=array_sum($subtotal_plano_periodo_saida))?></td>
    <td></td>
  </tr>
<!-- Saldo Mensal -->
  <tr>
  	<td width="209" style="padding-left:1px;">Saldo Mensal</td>
    <?
     for($i=0;$i<$quantidade_meses;$i++){
	  $data_atual 	= retorna_data_adicionada($data_inicio,$i);
	  $saldo_mensal[$data_atual]  = $total_entrada_mes[$data_atual]-$total_saida_mes[$data_atual] 
	?>
      <td class='cl'><?=n($saldo_mensal[$data_atual])?></td>
    <?
	 }
	?>
    <td class="cl"><?=n($total_entradas-$total_saidas)?></td>
    <td></td>
  </tr>
<!-- Saldo Mensal -->
  <tr>
  	<td width="209" style="padding-left:1px;">Saldo Acumulado</td>
    <? 
     for($i=0;$i<$quantidade_meses;$i++){
	  $data_atual 	= retorna_data_adicionada($data_inicio,$i);
	  $data_anterior 	= retorna_data_adicionada($data_inicio,$i-1);
	  $saldo_acumulado[$data_atual] = $saldo_mensal[$data_atual] +$saldo_acumulado[$data_anterior] ;
	?>
      <td class='cl'><?=n($saldo_acumulado[$data_atual])?></td>
    <? } ?>
    <td>-</td>
    <td></td>
  </tr>
</thead>

    </table>
</div>
<script>

$('#dados').scroll(function() {
	//document.title= "t"+$(this).scrollTop()+"l"+$(this).scrollLeft();
	
		if ($.browser.mozilla == true) {
			$("#xyz").css("margin-top",$(this).scrollTop()+"px"); 
			$("#trodape").css("margin-left",$(this).scrollTop()+"px"); 
			$("#titulos").css("margin-left",$(this).scrollLeft()+"px"); 
			$("#rodape_t").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
			
			$("#mjy").css("margin-left",'-'+$(this).scrollLeft()+"px");
		}
		if($.browser.webkit == true) {
			$("#xyz").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
			
			$("#trodape").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
			
			$("#titulos").css("margin-left",$(this).scrollLeft()+"px"); 
			
			$("#mjy").css("margin-left",'-'+$(this).scrollLeft()+"px");
		}
	
});


$(function() {
	$(document).ready(function() {
	// mozilla firefox
		if ($.browser.mozilla == true) {
			//alert('Firefox / Versão:' + $.browser.version);
		// internet explorer
		} else if($.browser.msie == true) {
			//alert('Internet Explorer / Versão:' + $.browser.version);
			 // webkit
		} else if($.browser.webkit == true) {
			//alert('Navegador baseado em WebKit / Versão:' + $.browser.version);
			 // outros navegadores
		} else {
			//alert('Outros nevegadores');
		}
	});
});
$("tbody tr").hover(function(){
	id = $(this).attr('id');
	$("[id="+id+"]").addClass('emcima');
});
$("tbody tr").mouseout(function(e) {
	id = $(this).attr('id');
	$("[id="+id+"]").removeClass('emcima');
});
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>
