<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
?>
<script src="modulos/financeiro/financeiro.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#rodape_t td, #mjy td{text-align:right}
#mjy .al td.cl{width:75px;text-align:right;}

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

</style>
<link href="../fontes/css/select2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../fontes/js/select2.min.js"></script>
<script type="text/javascript" src="../fontes/js/select2_locale_pt-BR.js"></script>
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

/* Plano de contas */
$("#plano_conta").live("focus",function(e){
	$insercao = $(this).closest("div").attr("id");
	$("#insercao").html($insercao);
	$("#janela_centro_custo").hide();
	$("#janela_plano_contas").css("display","block");
	$("#janela_plano_contas #result-modal").html("");
	$("#janela_plano_contas #busca_plano").focus();
	
});

$("#click_plano_contas").live("click",function(){
	var insercao  = $("#insercao").text();
	var plano_id  = ($(this).attr("class")); 
	var descricao = $(this).find("#descplano").text();
	var modal     = "janela_plano_contas";
	insere_campo_planos( plano_id, descricao, modal, insercao);
	
});//

/* Centro de Custos */
$("#click_centro_custo").live("click",function(){
	
	var array_centro = Array();
	
	var insercao  = $("#insercao").text();
	var centro_id = ($(this).attr("class"));
	var descricao = $(this).find("#descentro").text();
	var modal     = "janela_centro_custo";
	
	$("label #centro_custo_id").each(function(index, element) {
		array_centro[index] = element.value;
    });
	var indice = $.inArray(centro_id, array_centro);
	if(indice == -1)
		insere_centro_custo( centro_id, descricao, modal, insercao);
	 else 
		$("#janela_centro_custo #result-modal").html(" <div class='badge-default'>Você já selecionou esse Centro </div>");
	
});//

$("#centro_custo").live("focus",function(e){
	$insercao = $(this).closest("div").attr("id"); 
	$("#insercao").html($insercao);
	$("#janela_plano_contas").hide();
	$("#janela_centro_custo").css("display","block");
	$("#janela_centro_custo #busca_plano").focus();
	$("#janela_centro_custo #result-modal").html("");
	
});

/*busca*/
/**/
$("#busca_plano").live("keyup",function(event){
	
	var filter = $(this).val(), count = 0;
	codigo = event.keyCode;
	index = $(this).attr('index');
	
	var modal = $(this).attr("modal"); // verifica qual o modal
	
	quantidade = $("#"+modal+" #desc").length;
	
	var insercao  = $("#insercao").text();
		
	$("#"+modal+"").find("#desc").css('background','none');
	
	if(codigo ==40 || codigo ==39){//pra baixo
		index++;
		if(index>quantidade){
			index = 0;	
		}
		$("#"+modal+"").find("#desc:eq("+index+")").css('background','#ccc');
		
	}
	if(codigo == 38 || codigo == 37){//pra Cima
		index--;
		if(index==-1){
			index=quantidade-1;
		}
		$("#"+modal+"").find("#desc:eq("+index+")").css('background','#ccc');

	}
	$(this).attr('index',index);
	
	if(codigo==13){
		
		if(modal = "janela_plano_contas"){
			var id = $("#"+modal+"").find("#desc:eq("+index+")").parent().parent().parent().attr('class');
			var descricao = $("#"+modal+"").find("#descplano:eq("+index+")").text();
			insere_campo_planos(id,descricao,modal,insercao);
		}
		if(modal = "janela_centro_custo"){
			var id = $("#"+modal+"").find("#desc:eq("+index+")").parent().parent().parent().attr('class');
			var descricao = $("#"+modal+"").find("#descentro:eq("+index+")").text();
			
			insere_centro_custo(id,descricao,modal,insercao);
		}
		
	}
	
	$(".table-dados tr td").each(function() {
		
		  
		  if ($(this).parent().find(".filter_centro").text().search(new RegExp(filter, "i")) < 0) {
			  $(this).parent().fadeOut();
		  } else {
			  $(this).parent().parent().find("tr #desc").css("text-decoration","underline");
			  $(this).parent().show();
		  }
		     		
			
    });
	
	$(".table-dados-plano tr td").each(function() {
		
		  
		  if ($(this).parent().find(".filter_plano").text().search(new RegExp(filter, "i")) < 0) {
			  $(this).parent().fadeOut();
		  } else {
			  $(this).parent().parent().find("tr #desc").css("text-decoration","underline");
			  $(this).parent().show();
		  }
		     		
			
    });
	
});

$("#busca").live('keydown',function(e){
	
	if(e.keyCode==13){
	
		var exibicao = $("#exibicao").val();
		var centro   = $("#s_centro").val();
		var plano    = $("#s_plano").val();
		var tela_id  = $("#tela_id").val();
		var filtro_inicio = $("#filtro_inicio").val();
		var filtro_fim = $("#filtro_fim").val();
		var busca    = $("#busca").val();
	
		location.href = '?tela_id=52&exibicao='+exibicao+'&centro='+centro+'&plano='+plano+'&filtro_inicio='+filtro_inicio+'&filtro_fim='+filtro_fim+'&busca='+busca;
	}
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
<span></span>   Fluxo de Caixa
</a>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
<form style="float:left; margin:0; padding:0"> 
    Exibi&ccedil;&atilde;o
      
     
    
    Inicio
    <?
    if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
		
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
	
	?>
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="margin:0; padding:0" >
    
     Fim
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="margin:0; padding:0">
    <label>Forma de pagamento:
        <select name="forma_pagamento">
            <option value="0" <? if($_GET[forma_pagamento]=='0')echo 'selected'; ?> >Todas</option>
            <option value="1" <? if($_GET[forma_pagamento]=='1')echo 'selected'; ?> >Dinheiro</option>
            <option value="2" <? if($_GET[forma_pagamento]=='2')echo 'selected'; ?> >Cheque</option>
            <option value="3" <? if($_GET[forma_pagamento]=='3')echo 'selected'; ?> >Cartao</option>
            <option value="4" <? if($_GET[forma_pagamento]=='4')echo 'selected'; ?> >Boleto</option>
            <option value="5" <? if($_GET[forma_pagamento]=='5')echo 'selected'; ?> >Permuta</option>
            <option value="6" <? if($_GET[forma_pagamento]=='6')echo 'selected'; ?> >Outros</option>
        </select>
    </label>
    <label>Conta:
    	<?php
			$contas = mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id='$vkt_id'");
		?>
        <select name="conta">
        <option value=''>Todas</option>
            <?php
            	while($conta = mysql_fetch_object($contas)){
					echo "<option value='$conta->id'>$conta->nome $conta->conta</option>";					
				}
			?>
        </select>
    </label>
    <input type="hidden" name="tela_id" value="80" />
<input type="submit" name="button" id="button" value="Ir" />
</form>
</div>
<div id='dados' style=" display:block; clear:both">
<script>resize();</script>
<div style="width:<?=300+(($total_dias+1)*85)+200?>px; ">
  <table cellpadding="0" cellspacing="0" id='xyz' style=" width:<?=200+(($total_dias+1)*85)+200?>px; <?="position:absolute;"?>">
    <thead>
    	<tr>
    	  <td width="209" style="padding:1px;">Entradas</td>
<?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo 	= mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$mesinfo    = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%m')"),0,0);
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);
				$dtinfo 	= mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%d')"),0,0);
				;
			?>
          	<td width="75" style=""><?=$semana_abreviado[$semanainfo].','.$dtinfo." ".substr($mes_abreviado[$mesinfo-1],0,3)?></td>
            <?
			}
			?>
            <td width="76" align="center">Total</td>
            <td width=""></td>
			
        </tr>
    </thead>
</table><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" id='mjy' cellspacing="0" style="float:right; margin-right:100px; " width="<?=200+(($total_dias+1)*85)+200-212?>" >
    <thead>
    	<tr>
    	  <td >..</td>
</tr></thead>
  <tbody>
  <tr id='saldo_inicial'>
<?
            for($i=0;$i<=$total_dias;$i++){
				if($i==0){
					$vlr = @mysql_result(mysql_query("
SELECT 
sum(m.saldo)
FROM 
	financeiro_contas as c,
        financeiro_movimento as m
WHERE 
	c.cliente_vekttor_id='$vkt_id'
        AND
        c.id=m.conta_id
        AND 
        m.id= (SELECT id FROM financeiro_movimento WHERE conta_id=c.id ORDER BY data_movimento DESC limit 1)	
	"),0,0);
				$val =$vlr;
				$somadia_pago_entrada_dia[$i][]=$vlr ;
				$soma_enrada_geral[]=$vlr ;

				}else{
					$val='';	
				}

			?><td style="width:75px;text-align:right;<?=$color?>"><?=$val?></td><?
			}
			?>
            <td>-</td>
            <td></td>
  </tr>
	<?
	
	if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND forma_pagamento ='{$_GET[forma_pagamento]}'";
	
	$q= mysql_query($t="
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		tipo='receber'  
	AND 
		`status`='0'
	AND
		extorno='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	ORDER BY  
		data_vencimento ");
	
	while($r=mysql_fetch_object($q)){
		$total++;
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id ' "));

		if($total%2){$sel='class="al"';}else{$sel='class=""';}
		if($r->status==0){
			$datainfo = $r->data_vencimento;
		}else{
			$datainfo = 	$r->data_info_movimento ;
		}
		
	?>      
    	<tr <?=$sel?> id='li<?=$r->id?>' onclick="opf(<?=$r->id?>)" style="">
            <?
			for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$color='';
				if($datainfo==$diainfo){
					$somadia_pago_entrada_dia[$i][]=$r->valor_cadastro ;
					$soma_enrada_geral[]=$r->valor_cadastro ;
					
					if($r->status ==1){
						$somapago[$diainfo][]=$r->valor_cadastro ;
						$color = ' cla';
	
					}
					if($r->status ==0){
						if($diainfo<date("Y-m-d")){
							$color = ' clv';
						}
						$somaPendente[$diainfo][]=$r->valor_cadastro ;
					}
					
					$val=  moedaUsaToBr($r->valor_cadastro);
					$somatotal[$r->id]=$r->valor_cadastro;
				}else{
					$val = '';
				}
				// define a cor do fundo para dia
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);
				
				
				if($diainfo==date('Y-m-d')){
					$corfundo= ' clh';	
				}elseif($semanainfo==0 ||$semanainfo==6){
					$corfundo= ' clf';	
				}else{
					$corfundo= '';	
				}
				//
				?><td title='<?=$r->descricao?> <br> <?=$cliente_fornecedor->razao_social?>'  class="cl<?=$cor.$corfundo?>"><?=$val?></td><?
			}
			?>
          	<td width="75" align="right"><?=moedaUsaToBr($somatotal[$r->id])?></td>
          	<td width=""></td>
        </tr>
        
<?
	}
?>    </tbody>

    	<thead>
        	<tr>
    	<tr>
        <?
         for($i=0;$i<=$total_dias;$i++){
		?>
    	  <td ><?=n(@array_sum($somadia_pago_entrada_dia[$i]))?></td>
          
        <?
		 }
		?>
        <td><?=@array_sum($soma_enrada_geral)?></td><td></td>
          </tr>
        </thead>
    	<thead>
        	<tr>
    	<tr>
        <?
         for($i=0;$i<=$total_dias;$i++){
		?>
    	  <td >&nbsp;</td>
          
        <?
		 }
		?>
        <td></td><td></td>
          </tr>
        </thead>
        
<tbody>
	<?
	
	if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND forma_pagamento ='{$_GET[forma_pagamento]}'";
	
	$q= mysql_query($t="
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		tipo='pagar'  
	AND 
		`status`='0'
	AND
		extorno='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	ORDER BY  
		data_vencimento ");
//echo $t;	
	while($r=mysql_fetch_object($q)){
		$total++;
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id ' "));
		if($total%2){$sel='class="al"';}else{$sel='class=""';}
		if($r->status==0){
			$datainfo = $r->data_vencimento;
		}else{
			$datainfo = 	$r->data_info_movimento ;
		}
	?>      
    	<tr <?=$sel?> id='li<?=$r->id?>' onclick="opf(<?=$r->id?>)">
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$color='';

			if($datainfo==$diainfo){
				$vlpg[$i][] = 	$r->valor_cadastro;								
				$somadia_pago[$diainfo][]=$r->valor_cadastro ;
				if($r->status ==1){
					$somapago[$diainfo][]=$r->valor_cadastro ;
					$color = ' cla';

				}
				if($r->status ==0){
					if($diainfo<date("Y-m-d")){
						$color = ' clv';
					}
					$somaPendente[$diainfo][]=$r->valor_cadastro ;
				}
				
				$val=  moedaUsaToBr($r->valor_cadastro);
				$soma_total_saidas[] = $r->valor_cadastro;
				$somatotal[$r->id]=$r->valor_cadastro;
			}else{
				$val = '';
			}
				// define a cor do fundo para dia
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);
				
				
				if($diainfo==date('Y-m-d')){
					$corfundo= ' clh';	
				}elseif($semanainfo==0 ||$semanainfo==6){
					$corfundo= ' clf';	
				}else{
					$corfundo= '';	
				}
				//
			?><td title='<?=$r->descricao?> <br> <?=$cliente_fornecedor->razao_social?>' class="cl<?=$color.$corfundo?>"><?=$val?></td><?
			}
			?>
          	<td width="75" align="right" ><?=moedaUsaToBr($somatotal[$r->id])?></td>
          	<td width=""></td>
        </tr>
<?
	}
?>    



    


</tbody>

</table>
<table cellpadding="0" id='titulos' cellspacing="0" style="background:#FFF; float:left">
    <thead>
    	<tr>
    	  <td width="200" >Entradas</td>
</tr></thead>
  <tbody>
  <tr id='saldo_inicial'>
  <td >Saldo Inicial</td>
  
  </tr>
    <?
	
	if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND forma_pagamento ='{$_GET[forma_pagamento]}'";
	if($_GET[conta]>0)$filtro_conta.=" AND conta_id ='{$_GET[conta]}'";
	$q= mysql_query($t="
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		tipo='receber'  
	AND 
		`status`='0'
	AND
		extorno='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	$filtro_conta
	ORDER BY  
		data_vencimento ");
		
	
	while($r=mysql_fetch_object($q)){
		$total++;
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id ' "));
		$cliente_mov[$r->id]=$cliente_fornecedor->razao_social;
		if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->status==0){
			$datainfo = $r->data_vencimento;
		}else{
			$datainfo = 	$r->data_info_movimento ;
		}
		
	?>
    <tr <?=$sel?> id='li<?=$r->id?>' onclick="opf(<?=$r->id?>)">
      <td width="200" title='<?=$r->descricao.$r->id?>' ><?=substr($cliente_fornecedor->razao_social,0,30)?></td>
    </tr>
    <?
	}
	   ?>
  </tbody>
      	<thead>
        	<tr>
            <td>Total Entradas</td>
            </tr>
        </thead>
      	<thead>
        	<tr>
            <td>Saidas</td>
            </tr>
        </thead>
        
        
        <tbody>
    <?
	
	if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND forma_pagamento ='{$_GET[forma_pagamento]}'";
	if($_GET[conta]>0)$filtro_conta.=" AND conta_id ='{$_GET[conta]}'";
	$q= mysql_query($t="
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		tipo='pagar'  
	AND 
		`status`='0'
	AND
		extorno='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	$filtro_conta
	ORDER BY  
		data_vencimento ");
		
	
	while($r=mysql_fetch_object($q)){
		$total++;
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id ' "));
		$cliente_mov[$r->id]=$cliente_fornecedor->razao_social;
		if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->status==0){
			$datainfo = $r->data_vencimento;
		}else{
			$datainfo = 	$r->data_info_movimento ;
		}
		
	?>
    <tr <?=$sel?> id='li<?=$r->id?>2' onclick="opf(<?=$r->id?>)">
      <td title='<?=$r->descricao.$r->id?>' ><?=substr($cliente_fornecedor->razao_social,0,30)?></td>
    </tr><?
	}
	   ?>
        </tbody>
  
</table>
<script>

$('#dados').scroll(function() {
	//document.title= "t"+$(this).scrollTop()+"l"+$(this).scrollLeft();
	
		if ($.browser.mozilla == true) {
			$("#xyz").css("margin-top",$(this).scrollTop()+"px"); 
			$("#titulos").css("margin-left",$(this).scrollLeft()+"px"); 
			$("#rodape_t").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
			
			$("#mjy").css("margin-left",'-'+$(this).scrollLeft()+"px");
			$("#trodape").css("margin-left",$(this).scrollTop()+"px"); 
		}
		if($.browser.webkit == true) {
			$("#xyz").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
			$("#titulos").css("margin-left",$(this).scrollLeft()+"px"); 
			$("#trodape").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
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
    </div>
  
</div><table cellpadding="0" cellspacing="0" id='trodape' style=" width:<?=200+(($total_dias+1)*85)+200?>px;">
<thead>

        	<tr><td width="209" style="padding:1px;"><strong>Total Saidas</strong></td>
                    <?
         for($i=0;$i<=$total_dias;$i++){
		?>
    	  <td width="75"><?=@array_sum($vlpg[$i])?></td>
          
        <?
		 }
		?>
			<td style="width:70px"><?=@array_sum($soma_total_saidas)?></td><td></td>
           </tr>




           <tr><td width="209" style="padding:1px;"><strong>Saldo</strong></td>
       <?
         for($i=0;$i<=$total_dias;$i++){
		?>
    	  <td ><?=$saldo_dia[$i]=@array_sum($somadia_pago_entrada_dia[$i])-@array_sum($vlpg[$i])?></td>
          
        <?
		 }
		?>
              <td>&nbsp;</td><td></td>
          </tr>
        	<tr><td width="209" style="padding:1px;"><strong>Acumulado</strong></td>
            
        <?
         for($i=0;$i<=$total_dias;$i++){
		?>
    	  <td ><?=$saldo_acumulado[$i]=$saldo_dia[$i]+$saldo_acumulado[$i-1]?></td>
          
        <?
		 }
		?>
            <td>&nbsp;</td><td></td></tr>

</thead>      </table>
</div>
