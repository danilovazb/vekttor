<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
criaFormaPagamento($forma_pagamento);
/* FILTROS DE CONSULTA */
if($_GET[tipo] && $_GET[tipo]!='nulo'){
	$tabela_tipo=", financeiro_{$_GET[tipo]}_has_movimento as fhm";
	$filtro_tipo=" AND fm.id=fhm.movimento_id AND fhm.plano_id='{$_GET[$_GET[tipo]]}' ";
}

if($_GET[forma_pagamento]>0)$filtro_forma=" AND fm.forma_pagamento ='{$_GET[forma_pagamento]}'";

/* FILTRO DE EXIBICAO */

	$filtro_exibicao =  $exibicao ? $_GET[exibicao]  : $_COOKIE[conta_receber_exibicao];
    if(isset($_GET[filtro_inicio])){
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
		
	}elseif(isset($_COOKIE[conta_receber_filtro_inicio])){
		$filtro_inicio 	= dataBrToUsa($_COOKIE[conta_receber_filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_COOKIE[conta_receber_filtro_fim]);
	}else{
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);

?>
<script>
 $(function() {
	$( document ).tooltip({
		track: true
	});
});

</script>

<script src="modulos/financeiro/financeiro.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<link href="../fontes/css/select2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../fontes/js/select2.min.js"></script>
<script type="text/javascript" src="../fontes/js/select2_locale_pt-BR.js"></script>

<style>
.ui-tooltip{ white-space: pre-wrap; opacity:1;}

a{ text-decoration:none;}
.plano_pai{ color:#999; font-weight:bold;}
tbody .al td.smn0{ background:#F9F9F9}
tbody .al td.smn6{ background:#F9F9F9}
#cabeca_print{ display:none;}  
#conteudo_info td{ padding:0;}
thead td{ padding:0;}
tbody td{ padding:0;}
tbody .al td.smn0{ background:#F9F9F9}
tbody .al td.smn6{ background:#F9F9F9}
#tabela_forma_pagamento{ display:none;}

.select2-results li.select2-result-with-children > .select2-result-label { font-size:11px;}
.select2-results ul.select2-result-sub > li .select2-result-label{ padding-left:25px;}
.select2-results ul.select2-result-sub > li .select2-result-label {font-size:10px;}
</style>
<script>
$(".ir").live('click',function(){
	$("#exibicao").val($(this).attr('tipo_exibicao'));
	setCookie('conta_receber_filtro_inicio',$('#filtro_inicio').val(),999999999);
	setCookie('conta_receber_filtro_fim',$('#filtro_fim').val(),999999999);
	setCookie('conta_receber_exibicao',$('#exibicao').val(),999999999);
	
	$("#formfiltro").submit();
});

function abreformfi(){
	
	window.open('modulos/financeiro/form_movimentacao.php?&info_pgto=receber','carregador')
}
$(document).keydown(function (e) {
	if(e.which == 18) {pressedCtrl = true; }

	//document.title=e.which;
	if(e.which == 27){
		$("#exibe_formulario").html('');
	}
document.title= e.which;
	// 
	if((e.which == 61 || e.which == 187)  && pressedCtrl == true) { 
		//Aqui vai o código e chamadas de funções para o ctrl++
		//abreformfi();	
	}
});
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
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"
    title='Novo Registro <br> alt+"+"' rel="tip" ></a>
     <button type="button" onclick="window.open('modulos/tela_impressao.php?url=')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;">
	<img src="../fontes/img/imprimir.png">
</button>
<form id='formfiltro' style="float:left; margin:0; padding:0"> 
    
    
      <input type="hidden"  id="exibicao" value="<?=$filtro_exibicao?>">
      Vencimento de
      <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     a
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    
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
  
        <select name="forma_pagamento">
        	<option>Forma de pagamento</option>
            <?
			$formas_pagamento_lista_q=mysql_query($a="SELECT * FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id' ");
			
			
           while($formas_pagamento_lista=mysql_fetch_object($formas_pagamento_lista_q)){
			  if($_GET[forma_pagamento]==$formas_pagamento_lista->id){ $sel = 'selected="selected"';}else{$sel = '';}

			  echo "<option value='$formas_pagamento_lista->id'  $sel    >".$formas_pagamento_lista->nome.'</option>';
			 } 
			?>
   </select>
      
      
      Efetivado
<select name="efetivado" id="efetivado">
    <option value="0" <?php if($_GET['efetivado']=='0'){echo "selected='selected'";}?>>Não</option>
    <option value="1" <?php if($_GET['efetivado']=='1'){echo "selected='selected'";}?>>Sim</option>
	<option <?php if($_GET['efetivado']=='Ambos'){echo "selected='selected'";}?>>Ambos</option>
</select>
      
    <input type="hidden" name="tela_id" value="53" />
<input type="button" class="ir" value="Coluna" tipo_exibicao='coluna'/>
<input type="button" class="ir" value="Lista" tipo_exibicao='lista'/>
</form>
</div>

<div id="dados" style=" display:block; clear:both">
<div id="info_filtro">
<?=$template_cabecalho_impressao?>
<?php
if(empty($_GET['mes'])){
	$mes_filtro = date('m');
	
}else{
	$mes_filtro = $_GET['mes'];
}
if(empty($_GET['ano'])){
	$ano_filtro = date('Y');
}else{
	$ano_filtro = $_GET['ano'];
}	
	//$ultimo_dia = date('t',	"$ano_filtro-$mes_filtro-01");
	echo "<h3><strong>Contas a receber <br />De ".dataUsaToBr($filtro_inicio)." até ".dataUsaToBr($filtro_fim)."</strong></h3>";
?>
</div>
<?


?>
<? 
if(empty($_GET['efetivado'])||$_GET['efetivado']=='0'){
		$filtro_status = "fm.status='0'";
	}else if($_GET['efetivado']=='1'){
		$filtro_status = "fm.status='1'";
	}else{
		$filtro_status = "fm.status!='2'";
	}
if($filtro_exibicao=='coluna' ){ ?>


<table id='heder_conteudo' cellpadding="0" cellspacing="0"  width="<?=$largura_tabela=300+(($total_dias+1)*70)+100?>" style="position:absolute;margin-top: 0px;">
    <thead>
    	<tr>
    	  <td width="300" style="padding:1px;">
          <!--<div style="width:304px; position:fixed; height:18px; background:url(../fontes/img/bb.jpg) 5px  -2px ; margin:-3px 0 0 -10x; border-right:1px solid  #CCC ">Descricao <div style="float:right;margin-right:5px;">-->
		  <?php
		  /*$mes_referente = substr($filtro_inicio,5,2);
		  if($mes_referente<10){
		  	$mes_referente = $mes_referente[1];
		  }
		  $mes_referente = substr($mes_extenso[$mes_referente-1],0,3)
		  */?>
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
</table>

<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>
<div style="width:<?=400+(($total_dias+1)*70)?>px;margin-top:20px;">

<table cellpadding="0" cellspacing="0" width="<?=(($total_dias+1)*70)+100?>" style="float:right; "  id='conteudo_info'>
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
		date_format(fm.data_vencimento,'%d') as dia_vencimento ,
		ffp.nome as forma_pagamento
	FROM 
		financeiro_movimento as fm
			LEFT JOIN  cliente_fornecedor as cf  ON cf.id=fm.internauta_id
			LEFT JOIN  financeiro_formas_pagamento as ffp ON ffp.id = fm.forma_pagamento
		$tabela_tipo
	WHERE 
		fm.cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	$filtro_tipo
	AND
		fm.tipo='receber'
	AND
		fm.extorno='0'  
	AND 
		$filtro_status
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	$filtro
	ORDER BY  
		fm.data_vencimento, cf.razao_social ");
	while($r=mysql_fetch_object($q)){
		$rr[]=$r;
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
?>    
    <tr <?=$sel?> rid="<?=$r->movimentacao_id?>">
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

<table cellpadding="0" cellspacing="0" width="300" id='titulos' style="float: left; background: none repeat scroll 0% 0% rgb(255, 255, 255); margin-left: 0px;">
    <tbody>
	<?php
		for($c=0;$c<count($rr);$c++){
			
			if($c%2){$sel='';}else{$sel='class="al"';}
			$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='".$rr[$c]->internauta_id."' "));
			$desc =  $cliente_fornecedor->nome_fantasia.' - '.$rr[$c]->descricao;
	?>      
    	<tr <?=$sel?> rid="<?=$rr[$c]->movimentacao_id?>">
          	<td width="300" title='<?=$desc?>'><?=substr($desc,0,50)?></td>
        </tr>
     <?php
		}
	 ?>
       </tbody>
       </table>
</div>
<script>
	//-------------------------------
$('#dados').scroll(function() {
	//document.title= "t"+$(this).scrollTop()+"l"+$(this).scrollLeft();
	
		if ($.browser.mozilla == true) {
			//topo
			$("#heder_conteudo").css("margin-top",$(this).scrollTop()+"px"); 
			//titulos
			$("#titulos").css("margin-left",$(this).scrollLeft()+"px"); 
			//rodape
			//$("#rodape_t").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
			//conteudo
			$("#conteudo_info").css("margin-left",'-'+$(this).scrollLeft()+"px");
		}
		if($.browser.webkit == true) {
			$("#heder_conteudo").css("margin-left",'-'+$(this).scrollLeft()+"px"); 
			$("#titulos").css("margin-left",$(this).scrollLeft()+"px"); 
			$("#conteudo_info").css("margin-left",'-'+$(this).scrollLeft()+"px");
		}
	
});

$("#titulos tr,#conteudo_info tr").live("click",function(){
	id = $(this).attr('rid');
	opf(id);
})

$("#titulos tr,#conteudo_info tr").live("mouseover",function(){
	id = $(this).attr('rid');
	$("[rid="+id+"]").addClass('emcima');
})
$("#titulos tr,#conteudo_info tr").live("mouseout",function(){
	id = $(this).attr('rid');
	$("[rid="+id+"]").removeClass('emcima');
})
</script>
<table cellpadding="0" cellspacing="0" width="<?=$largura_tabela?>">
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

<? }else{
	
	
	 
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
          	<td width="90" align="center">
			<?=linkOrdem("Data","data_vencimento",1,"exibicao=lista&ordem=".$_GET['ordem']."&filtro_inicio=".dataUsaToBr($filtro_inicio)."&filtro_fim=".dataUsaToBr($filtro_fim)."&tipo=".$_GET['tipo']."&centro=".$_GET['centro']."&plano=".$_GET['plano']."&forma_pagamento=".$_GET['forma_pagamento']."&efetivado=".$_GET['efetivado'])?>
            </td>
			<td width="120" align="right">Valor</td>
             <td width="80" align="center"><?=linkOrdem("Forma","forma_pagamento",0,"exibicao=lista&ordem=".$_GET['ordem']."&filtro_inicio=".dataUsaToBr($filtro_inicio)."&filtro_fim=".dataUsaToBr($filtro_fim)."&tipo=".$_GET['tipo']."&centro=".$_GET['centro']."&plano=".$_GET['plano']."&forma_pagamento=".$_GET['forma_pagamento']."&efetivado=".$_GET['efetivado'])?></td>
             
            <td <?php if($_GET['efetivado']!='Ambos'){echo "class='wp'";}?>></td>
           
			
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
	
	if($_GET['ordem']){
		$ordem_tipo=$_GET['ordem']." ".$_GET['ordem_tipo'];
	}else{
		$ordem_tipo="fm.data_vencimento";
	}
	
	$q= mysql_query($t="
	SELECT 
		*, fm.id as movimentacao_id,
		date_format(fm.data_vencimento,'%d') as dia_vencimento ,
		ffp.nome as forma_pagamento,
		fm.status as status
	FROM 
		financeiro_formas_pagamento as ffp,
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
		$filtro_status
	AND 
		fm.extorno='0'
	AND 
		fm.data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	AND
		ffp.id = fm.forma_pagamento
	$filtro
	$filtro_forma
	ORDER BY  
		$ordem_tipo");
	$valor_total=0;
	$total_pendente=0;
	$total_pago=0;
	while($r=mysql_fetch_object($q)){
		
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$valor_total+=$r->valor_cadastro;
		$total_forma_pagamento[$r->forma_pagamento]+=$r->valor_cadastro;
		
		if($r->status=='0'||empty($r->status)){
			$total_pendente +=$r->valor_cadastro; 
		}else if($r->status=='1'){
			$total_pago +=$r->valor_cadastro;
		}
		//$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id' "));
		$title = "$r->email \n $r->telefone1 \n $r->telefone2"; 
	?>  
    	<tr <?=$sel?> onclick="opf(<?=$r->movimentacao_id?>)">
       	  <td width="400" title="<?=$title?>"><?=$r->nome_fantasia.' - '.$r->descricao?></td>
            <td width="90" align="center"><?=strftime('%d/%m',strtotime($r->data_vencimento))?></td>
            <td style="width:120px;text-align:right;"><?=number_format($r->valor_cadastro,2,',','.')?></td>
             <td width="80" align="center">
               
			   <?=$r->forma_pagamento?>    
			 
        	</td>
          <td <?php if($_GET['efetivado']!='Ambos'){echo "class='wp'";}?>>
          <?
          	if($r->status=="1"){
				echo "Efetivado ";
			}
		  ?>
          </td>
        </tr>
<?
}
?>
</tbody>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
  <thead>
    <tr>
      <td width="400">Total</td>
      <td width="90" align="right">&nbsp;</td>
      <td style="width:120px;text-align:right;"><?=number_format($valor_total,2,',','.')?></td>
      <td width="80">          			 
        </td>
      <td <?php if($_GET['efetivado']!='Ambos'){echo "class='wp'";}?>></td>
    </tr>
  </thead>
</table>
<table cellpadding="0" cellspacing="0" width="30%" id="tabela_forma_pagamento" style="margin-top:25px;">
	<thead>
    	<tr>
    	  <td width="60%">Forma de Pagamento</td>
          <td width="39%">Total</td>
        </tr>
        
    </thead>
    <tbody>
    	<?php
			if(count($total_forma_pagamento)>0){
				
				foreach($forma_pagamento as $fopa => $fp){	
					
				  if(array_key_exists($fopa,$total_forma_pagamento)){
						
			?>
    	<tr align="right">        	
        	<td><?=$fp?></td>
            <td><?=moedaUsaToBr($total_forma_pagamento[$fopa])?></td>
        </tr>
       
     </tbody>
     
       <?php
				  }
				  
				}
				
			}
		?>
     <thead>
        <tr align="right">        	
        	<td>Total</td>
            <td><?=moedaUsaToBr($valor_total)?></td>
        </tr>
         <tr>
    	  <td width="60%">Pago</td>
          <td width="39%" style="background-color:#FFF;text-align:right"><?=moedaUsaToBr($total_pago)?></td>
        </tr>
         <tr>
    	  <td width="60%">Pendente</td>
          <td width="39%" style="background-color:#FFF;text-align:right"><?=moedaUsaToBr($total_pendente)?></td>
        </tr>
    </thead>
</table>
<?
}
//echo"<pre>";print_r($_POST);echo"</pre>";
?>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?
//pr($_COOKIE);
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
