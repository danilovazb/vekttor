<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
?>
<script src="modulos/financeiro/financeiro.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
a{ text-decoration:none;}
.plano_pai{ color:#999; font-weight:bold;}
.smn0{ opacity:0.5;}
.smn6{ opacity:0.5;}
</style>
<script>

/**/

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
		
})

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
	var insercao  = $("#insercao").text();
	var centro_id = ($(this).attr("class"));
	var descricao = $(this).find("#descentro").text();
	var modal     = "janela_centro_custo";
	
	insere_centro_custo( centro_id, descricao, modal, insercao);
	
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
			insere_campo_planos(id,descricao,modal,insercao); //chama essa função para inserir os campos como array de elementos (id) do plano de contas
		}
		if(modal = "janela_centro_custo"){
			var id = $("#"+modal+"").find("#desc:eq("+index+")").parent().parent().parent().attr('class');
			var descricao = $("#"+modal+"").find("#descentro:eq("+index+")").text();
			insere_centro_custo(id,descricao,modal,insercao); // chama essa função para inserir os campos como array de elementos (id) do centro de custos
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
		var tipo     = $("#tipo").val();
		var centro   = $("#s_centro").val();
		var plano    = $("#s_plano").val();
		var tela_id  = $("#tela_id").val();
		var filtro_inicio = $("#filtro_inicio").val();
		var filtro_fim = $("#filtro_fim").val();
		var busca    = $("#busca").val();
		var forma_pagamento = $("#forma_pagamento").val();
	
		location.href = '?tela_id=53&exibicao='+exibicao+'&tipo='+tipo+'&centro='+centro+'&plano='+plano+'&filtro_inicio='+filtro_inicio+'&filtro_fim='+filtro_fim+'&busca='+busca;
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
<a href="?tela_id=52" class='navegacao_ativo'>
<span></span>    Contas a Receber
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca"/>
</form>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
     <button type="button" onclick="window.open('modulos/tela_impressao.php?url=')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;">
	<img src="../fontes/img/imprimir.png">
</button>
<form style="float:left; margin:0; padding:0"> 
    
     <?
    	$selected_exibe = 'selected="selected"';
		if(isset($_GET["exibicao"])){
			$selected_exibe = "";	
		}
	?>
    
    <select name="exibicao" id="exibicao">
    <option>Exibição</option>
        <option value="coluna" <? if($_GET["exibicao"]=='coluna')echo 'selected="selected"'; ?> <?=$selected_exibe?> >Colunas</option>
        <option value="lista" <? if($_GET["exibicao"]=='lista')echo 'selected="selected"'; ?> >Lista</option>
    </select> 
      <select name="tipo" id="tipo">
      	<option value="nulo">Escolha o filtro</option>
        <option value="centro" id="centro_escolha" title="Centro de Custo" <? if($_GET[tipo]=='centro')echo 'selected="selected"'; ?> >Centro de Custo</option>
        <option value="plano" id="plano_escolha" title="Plano de Conta" <? if($_GET[tipo]=='plano')echo 'selected="selected"'; ?> >Plano de Contas</option>
      </select> 
      <label id="centro" <? if($_GET[tipo]!='centro'){ ?> style="display:none;" <? } ?> >
      <select name="centro" id="s_centro">
      <option>- Centro de Custo -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND cliente_id='$vkt_id' AND plano_ou_centro='centro' "); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE  centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[centro]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[centro]==$sub->id)echo "selected"; ?>  value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  <label id="plano" <? if($_GET[tipo]!='plano'){ ?> style="display:none;" <? } ?> >
      <select name="plano" id="s_plano">
      <option>- Plano de Conta -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro = 'plano' AND cliente_id='$vkt_id'"); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[plano]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){ 
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[plano]==$sub->id)echo "selected"; ?> value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
    De
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
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     a
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <label>
        <select name="forma_pagamento" id="forma_pagamento">
        	<option>Forma de pagamento:</option>
            <option value="0" <? if($_GET[forma_pagamento]=='0')echo 'selected'; ?> >Todas</option>
            <option value="1" <? if($_GET[forma_pagamento]=='1')echo 'selected'; ?> >Dinheiro</option>
            <option value="2" <? if($_GET[forma_pagamento]=='2')echo 'selected'; ?> >Cheque</option>
            <option value="3" <? if($_GET[forma_pagamento]=='3')echo 'selected'; ?> >Cartao</option>
            <option value="4" <? if($_GET[forma_pagamento]=='4')echo 'selected'; ?> >Boleto</option>
            <option value="5" <? if($_GET[forma_pagamento]=='5')echo 'selected'; ?> >Permuta</option>
            <option value="6" <? if($_GET[forma_pagamento]=='6')echo 'selected'; ?> >Outros</option>
        </select>
    </label>
    <input type="hidden" name="tela_id" value="53" />
<input type="submit" name="button" id="button" value="Ir" />
</form>
</div>


<? 
/* FILTROS DE CONSULTA */
if($_GET[tipo] && $_GET[tipo]!='nulo'){
	$tabela_tipo=", financeiro_{$_GET[tipo]}_has_movimento as fhm";
	$filtro_tipo=" AND fm.id=fhm.movimento_id AND fhm.plano_id='{$_GET[$_GET[tipo]]}' ";
}
if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND fm.forma_pagamento ='{$_GET[forma_pagamento]}'";


/* FILTRO DE EXIBICAO*/
if($_GET[exibicao]=='coluna' || empty($_GET[exibicao])){ ?>

<div id='dados' style="clear:both;">
<table cellpadding="0" cellspacing="0"  width="<?=400+(($total_dias+1)*70)?>">
    <thead>
    	<tr>
    	  <td width="308" style="padding:1px;">
          <div style="width:304px; position:fixed; height:18px; background:url(../fontes/img/bb.jpg) 5px  -2px ; margin:-3px 0 0 -10x; border-right:1px solid  #CCC ">Descricao <div style="float:right;margin-right:5px;">
		  <?php
		  /*$mes_referente = substr($filtro_inicio,5,2);
		  if($mes_referente<10){
		  	$mes_referente = $mes_referente[1];
		  }
		  $mes_referente = substr($mes_extenso[$mes_referente-1],0,3)
		  */?></div></div>
          Descricao
          </td>
<?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo 	= mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$mesinfo    = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%m')"),0,0);
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);
				$dtinfo 	= mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%d')"),0,0);
				;
				if($mesinfo<10){
					$mesinfo = $mesinfo[1];
				}
				
			?>
          	<td width="70" class='smn<?=$semanainfo?>' style="margin:0; padding:0; text-align:center;font-size:10px;"><?=$semana_abreviado[$semanainfo].', '.$dtinfo." ".substr($mes_abreviado[$mesinfo-1],0,3)?></td>
            <?
			}
			?>
            <td width="70" align="center">Total</td>
            <td width=""></td>
			
        </tr>
    </thead>
</table><script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>

<table cellpadding="0" cellspacing="0" width="<?=400+(($total_dias+1)*70)?>" >
    <tbody>
	<?
	
	if(!empty($_GET['busca'])){
		$filtro = "AND (cf.nome_fantasia LIKE '%".$_GET['busca']."%' OR fm.descricao LIKE '%".$_GET['busca']."%' OR fm.doc LIKE '%".$_GET['busca']."%'";
	
		$valor_cadastro = moedaBrToUsa($_GET['busca']);
		if(isset($valor_cadastro)){
	
			$filtro.= "OR fm.valor_cadastro = ".$valor_cadastro;
	
		}
		$filtro.=")";
	}
	
	$q= mysql_query($t="
	SELECT 
		fm.*, fm.id as movimentacao_id,
		date_format(fm.data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento as fm
		LEFT JOIN  cliente_fornecedor as cf  ON cf.id=fm.internauta_id
		$tabela_tipo
	WHERE 
		fm.cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	$filtro_tipo
	AND
		fm.tipo='receber'
	AND
		fm.extorno='0'  
	AND 
		fm.status='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	$filtro
	ORDER BY  
		fm.data_vencimento, cf.razao_social ");
	
	while($r=mysql_fetch_object($q)){
		
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id ' "));
		
	?>      
    	<tr <?=$sel?> onclick="opf(<?=$r->movimentacao_id?>)">
          	<td width="299" ><div class='sobre' style="width:303px;"><?=$cliente_fornecedor->nome_fantasia.' - '.$r->descricao?></div>&nbsp;</td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);

			$color='';
			if($r->data_vencimento==$diainfo){
				$somadia[$diainfo][]=$r->valor_cadastro ;
				if($r->status ==1){
					$somapago[$diainfo][]=$r->valor_cadastro ;
					$color = 'color:#00F';

				}
				if($r->status ==0){
					if($diainfo<date("Y-m-d")){
						$color = 'color:#F00';
					}
					$somaPendente[$diainfo][]=$r->valor_cadastro ;
				}
				
				$val=  moedaUsaToBr($r->valor_cadastro);
				$somatotal[$r->id]=$r->valor_cadastro;
			}else{
				$val = '';
			}

			?><td class="smn<?=$semanainfo?>" style="width:70px;margin:0;padding:0;text-align:right;<?=$color?>"><?=$val?></td><?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr($somatotal[$r->id])?></td>
          	<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>

<table cellpadding="0" cellspacing="0" width="<?=400+(($total_dias+1)*70)?>">
  <thead>
    	<tr>
       	  <td width="300">Total</td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
       	  <td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somadia[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			?></td>
            <?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr(@array_sum($totaln));?></td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0"width="<?=400+(($total_dias+1)*70)?>" >
  <thead>
    <tr>
      <td width="300">Pago</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
       	  <td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somapago[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			
			$totalna=0;
			?></td>
            <?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr(@array_sum($totaln));?></td>
	      <td width=""></td>
    </tr>
  </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=400+(($total_dias+1)*70)?>">
  <thead>
    <tr>
      <td width="300">Pendente</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
          	<td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somaPendente[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			?></td>
            <?
			}
			?>
           	<td width="70" align="right"><?=moedaUsaToBr(@array_sum($totaln));?></td>
     <td width=""></td>
    </tr>
  </thead>
</table>

<? }elseif($_GET[exibicao]=='lista'){
	
	
	$forma_pagamento = array("1"=>"Dinheiro",
							 "2"=>"Cheque",
							 "4"=>"Boleto",
							 "5"=>"Permuta",
							 "6"=>"Outros",
							 "7"=>"Transferência",
							 "8"=>"Depósito",
							 "3"=>"Cartão Crédito Visa",
							 "9"=>"Cartão Crédito Master",
							 "10"=>"Débito Master",
							 "11"=>"Débito Visa",
							 "12"=>"Cielo Débito",
							 "13"=>"Cielo Crédito");
	 
	if(!empty($_GET['busca'])){
		$filtro = "AND (cf.nome_fantasia LIKE '%".$_GET['busca']."%' OR fm.descricao LIKE '%".$_GET['busca']."%' OR fm.doc LIKE '%".$_GET['busca']."%'";
	
		$valor_cadastro = moedaBrToUsa($_GET['busca']);
		if(isset($valor_cadastro)){
	
			$filtro.= "OR fm.valor_cadastro = ".$valor_cadastro;
	
		}
		$filtro.=")";
	}
?>
<div id='dados' style="clear:both;">
<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
    	  <td width="400">Descricao</td>
          	<td width="90" align="right">Data</td>
			<td width="120" align="right">Valor</td>
             <td width="80">Forma</td>
             
            <td class="wp"></td>
           
			
        </tr>
    </thead>
</table>
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>

<table cellpadding="0" cellspacing="0" width="100%"  >
    <tbody>
	<?
	
	
	
	$q= mysql_query($t="
	SELECT 
		*, fm.id as movimentacao_id,
		date_format(fm.data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento as fm
		LEFT JOIN  cliente_fornecedor as cf  ON cf.id=fm.internauta_id
		$tabela_tipo
	WHERE 
		fm.cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
		$filtro_tipo
	AND 
		fm.tipo='receber'  
	AND
		fm.transferencia='0'
	AND 
		fm.status='0'
	AND 
		fm.extorno='0'
	AND 
		fm.data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro
	ORDER BY  
		fm.data_vencimento ");
	//echo $t;	
	$valor_total=0;
	while($r=mysql_fetch_object($q)){
		
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$valor_total+=$r->valor_cadastro;
		//$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id' "));
	?>  
    	<tr <?=$sel?> onclick="opf(<?=$r->movimentacao_id?>)">
       	  <td width="400"><?=$r->nome_fantasia.' - '.$r->descricao?></td>
            <td width="90" align="right"><?=strftime('%d/%m',strtotime($r->data_vencimento))?></td>
            <td style="width:120px;text-align:right;"><?=number_format($r->valor_cadastro,2,',','.')?></td>
             <td width="80">
               <?=$forma_pagamento[$r->forma_pagamento]?>     
			 
        	</td>
          <td class="wp"></td>
        </tr>
<?
}
?>
</tbody>
</table>
<table cellpadding="0" cellspacing="0" width="100%" >
  <thead>
    <tr>
      <td width="400">Total</td>
      <td width="90" align="right">&nbsp;</td>
      <td style="width:120px;text-align:right;"><?=number_format($valor_total,2,',','.')?></td>
      <td width="80">
              			 
        </td>
      <td class="wp"></td>
    </tr>
  </thead>
</table>
<?
}
//echo"<pre>";print_r($_POST);echo"</pre>";
?>

</div>

</div>
<div id='rodape'>
	<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();
	})
		
	
	
</script>
</div>
