<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
	#pagina{
		border:1px solid #000;
		width:840px;
		background:#FFFFFF;
		margin:0px auto;
		box-shadow:2px 1px 2px #333333;
		margin-top:20px;
		padding:20px;
		
	}
	.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}

#scroll-table {  background-color:#F2F2F2;width: 517px;}
#scroll-table table {width: 500px;}
#scroll-table .scrollContainer {width: 517px;height: 150px;overflow: auto;}
#scroll-table thead td span{display: block;}
#scroll-table tbody td span{display: block;}

#scroll-table .coluna0{width: 200px;}
#scroll-table .coluna1{width: 70px;}
#scroll-table .coluna2{width: 70px;}
#scroll-table .coluna3{width: 20px;}
/*-CSS ABA SERVICO -*/
#scroll-table-servico{background-color:#F2F2F2;width: 617px;}
#scroll-table-servico table{width: 600px;}
#scroll-table-servico .scrollContainer {width: 617px;height: 150px;overflow: auto;}
#scroll-table-servico thead td span{display: block;}
#scroll-table-servico tbody td span{display: block;}

#scroll-table-servico .coluna0{width: 200px;}
#scroll-table-servico .coluna1{width: 70px;}
#scroll-table-servico .coluna2{width:120px;}
#scroll-table-servico .coluna3{width: 70px;}
#scroll-table-servico .coluna4{width: 20px;}

#semformatacao tr:hover{
	background-color:none;
}
</style>
<script>
function rteInsertHTML(html) {
	 rteName = 'ed';
	if (document.all) {
		document.getElementById(rteName).contentWindow.document.body.focus();
		var oRng = document.getElementById(rteName).contentWindow.document.selection.createRange();
		oRng.pasteHTML(html);
		oRng.collapse(false);
		oRng.select();
	} else {
		document.getElementById(rteName).contentWindow.document.execCommand('insertHTML', false, html);
	}
}
function ti(m,v){
    w= document.getElementById('ed').contentWindow.document
	if(m=='InsertHTML' ){
		rteInsertHTML(v);
	}else{
		
	if(m == "backcolor"){
		if(navigator.appName =='Netscape'){
			w.execCommand('hilitecolor',false,v);
		}else{
			w.execCommand('backcolor',false,v);
		}
	}else{
		
		w.execCommand(m, false, v);
	}
	}
}

function html_to_form(){
	
		
		document.getElementById("tx_html").value = document.getElementById("ed").contentWindow.document.body.innerHTML
		
		document.getElementById("ed").contentWindow.document.body.innerHTML.replace("\n","");
}


function insere_txt(txt) {
    var myQuery = document.getElementById("ed").contentWindow.document.body;
    var chaineAj = txt;
	//IE support
	if (document.selection) {
		myQuery.focus();
		sel = document.selection.createRange();
		sel.innerHTML = chaineAj;
	}
	//MOZILLA/NETSCAPE support
	else if (document.getElementById("ed").selectionStart || document.getElementById("ed").selectionStart == "0") {
		var startPos = document.getElementById("ed").selectionStart;
		var endPos = document.getElementById("ed").selectionEnd;
		var chaineSql = document.getElementById("ed").innerHTML;

		myQuery.innerHTML = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
	} else {
		myQuery.innerHTML += chaineAj+'++aaa++';
	}
}

</script>
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
	});
	
	$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
		}
	});


/*-remove pacote-*/
$(function(){
		$("#remove-pacote").live('click',function(){
					var id = $(this).parent().parent().parent();
					id.remove();
		})
})

/*-add pacote-*/
var TotalMensal = 0;
var TotalImplantacao = 0;
var TotalVenda = 0;
/*- Valores dos Itens -*/
var valMensal = 0;
var valImplantacao = 0;
$(function(){
			$(".coluna3 input[type='checkbox']").live('click',function(){
						if($(this).is(':checked')){
							/*-Mensalidade-*/
										/* Verifica se existe algum valor */
											var ValMensalEdit = moedaBrToUsa($("#subtotal-foot .coluna1 span").html())*1;
									$(this).parent().parent().parent().find("#valMensalPacote").removeAttr('disabled');									
									valMensal = moedaBrToUsa($(this).parent().parent().parent().find("#valMensalPacote").val())*1;
											var valTMensal = (valMensal + ValMensalEdit);									
									TotalMensal = valTMensal;
									$("#subtotal-foot .coluna1 span").html(moedaUsaToBR(TotalMensal.toFixed(2)));
										//Resumo Mensalidade
											$("#val_mensalidade").val(moedaUsaToBR(TotalMensal.toFixed(2)));
											$("#view_mensalidade").val(moedaUsaToBR(TotalMensal.toFixed(2)));
							/*-Implantaçao-*/
										/* Verifica se axiste algum valor */
											var ValImplantacaoEdit = moedaBrToUsa($("#subtotal-foot .coluna2 span").html())*1;
									$(this).parent().parent().parent().find("#valImplatPacote").removeAttr('disabled');
									valImplantacao = moedaBrToUsa($(this).parent().parent().parent().find("#valImplatPacote").val())*1;
										    var valTImplantacao = (valImplantacao + ValImplantacaoEdit);
									TotalImplantacao = valTImplantacao;
									$("#subtotal-foot .coluna2 span").html(moedaUsaToBR(TotalImplantacao.toFixed(2)));
										//Resumo Implantaçao
											$("#view_implantacao").val(moedaUsaToBR(TotalImplantacao.toFixed(2)));
											$("#val_implantacao").val(moedaUsaToBR(TotalImplantacao.toFixed(2)));
							/*-Total da Venda-*/
									TotalVenda = (TotalMensal+TotalImplantacao);
									$("#total-foot .coluna2 span").html(moedaUsaToBR(TotalVenda.toFixed(2)));
										/* Resumo Total */
											$("#total_venda").val(moedaUsaToBR(TotalVenda.toFixed(2)));
							/*- Chama a funcao para somar o (Total Geral) da Venda-*/
											Total();
						} else if($(this).is(":not(:checked)")){
							/*-Mensalidade-*/
										/* Verifica se existe algum valor */
											var ValMensalMEdit = moedaBrToUsa($("#subtotal-foot .coluna1 span").html())*1;
									var valMensalM = moedaBrToUsa($(this).parent().parent().parent().find("#mensal span").text())*1;
									var TotalMenosMensal = (ValMensalMEdit - valMensalM);
									TotalMensal = TotalMenosMensal;
									
									$("#subtotal-foot .coluna1 span").html(moedaUsaToBR(TotalMenosMensal.toFixed(2)));
										//Resumo Mensalidade
											$("#val_mensalidade").val(moedaUsaToBR(TotalMenosMensal.toFixed(2)));
											$("#view_mensalidade").val(moedaUsaToBR(TotalMenosMensal.toFixed(2)));
							/*-Implantaçao-*/
										/* Verifica se existe algum valor */
											var ValImplantacaoMEdit = moedaBrToUsa($("#subtotal-foot .coluna2 span").html())*1;
									var valImplantacaoM = moedaBrToUsa($(this).parent().parent().parent().find("#implantacao span").text())*1;
									var TotalMenosImplantacao = (ValImplantacaoMEdit - valImplantacaoM);
									TotalImplantacao = TotalMenosImplantacao;
									
									$("#subtotal-foot .coluna2 span").html(moedaUsaToBR(TotalMenosImplantacao.toFixed(2)));
										//Resumo Implantaçao
											$("#view_implantacao").val(moedaUsaToBR(TotalMenosImplantacao.toFixed(2)));
											$("#val_implantacao").val(moedaUsaToBR(TotalMenosImplantacao.toFixed(2)));
							/*-Total da Venda-*/
									var TotalVendaMenos = (TotalMensal + TotalImplantacao);
									TotalVenda = TotalVendaMenos;
									$("#total-foot .coluna2 span").html(moedaUsaToBR(TotalVendaMenos.toFixed(2)));
										/* Resumo Total */
											$("#total_venda").val(moedaUsaToBR(TotalVendaMenos.toFixed(2)));
							/*- Chama a funcao para somar o (Total Geral) da Venda-*/
											Total();	
						}
						
			})		
})
/*-add servico-*/
var totalServico = 0;
$(function(){ 
$('#add-servico').live('click',function(){
				var valTableServico = $("#valTableServico").val();
					if(valTableServico == '2'){
							$(".table-add").remove();
					}
				var ServicoID = $("#servico_id").val(); var dados = "id="+ServicoID;
				var obs = $("input[name='obsItemServico']").val();
					$.ajax({
						url:'modulos/revenda_vekttor/venda/servico_item.php?acao=buscaServico',
						type:'POST',
						data: dados,
						dataType:'json',
						success: function(data){
								$("#scroll-table-servico").show();
								totalServico += moedaBrToUsa(data.valor_normal)*1;
																
								var tr = $('<tr id="aqui-vai">\
												<td class="coluna0" id="servico">\
												<input type="hidden" name="servicoItemID[]" value="'+data.id+'">\
												<span>'+data.nome+'</span></td>\
                        						<td class="coluna1" id="und"><span>'+data.und+'</span></td>\
												<td class="coluna2"><span><input type="text" name="obsItemServico[]" value="'+obs+'" style="width:114px;height:14px;"></span></td>\
                        						<td class="coluna3" id="valor-normal">\
												<input type="hidden" name="valorItemServico[]" id="valorItemServico" value="'+data.valor_normal+'">\
												<span>'+data.valor_normal+'</span></td>\
                        						<td class="coluna4"><span><img src="../fontes/img/menos.png" id="menos-servico"></span></td>\
                        					</tr>');
											// fim de tr
								$("#scroll-table-servico #item-servico tbody").append(tr);
								$("#scroll-table-servico #item-servico tbody tr:even").css("background-color", "#fff");
								$("#scroll-table-servico #item-servico tbody tr:odd").addClass('al');
								$("#servico").val('');
								$("#obsItemServico").val('');
								/*- Escreve o total no final da Tabela -*/
								$("#scroll-table-servico #foot-total-servico .coluna3 span").html(moedaUsaToBR(totalServico.toFixed(2)));
								/* Escreve total de serviço da aba resumo */
									$("#view_servico").val(moedaUsaToBR(totalServico.toFixed(2)));
									$("#val_servico").val(moedaUsaToBR(totalServico.toFixed(2)));
								/*- Chama a funcao para somar o (Total Geral) da Venda-*/
									Total();
						}
					});
	});
$('#menos-servico').live('click',function(){
				var id = $(this).parent().parent().parent();
				var ValorNormal = $(this).parent().parent().parent().find("#valorItemServico").val();
				var TotalFinal = (totalServico - (moedaBrToUsa(ValorNormal)*1));
				totalServico = TotalFinal; 
				$("#scroll-table-servico #foot-total-servico .coluna3 span").html(moedaUsaToBR(TotalFinal.toFixed(2)));
				id.remove();
				/* Escreve total de serviço da aba resumo */
					$("#view_servico").val(moedaUsaToBR(TotalFinal.toFixed(2)));
					$("#val_servico").val(moedaUsaToBR(TotalFinal.toFixed(2)));
				/*- Chama a funcao para somar o (Total Geral) da Venda-*/
					Total();
					
});

$("#cliente_nome").live('keyup blur',function(){
			var nome = $(this).val();
			$("#cliente_nome_fantasia").val(nome);	
	})
});
$("#val_desconto").live('keyup',function(){
		var valImplantacao = moedaBrToUsa($("#val_implantacao").val())*1;
		var valServico     = moedaBrToUsa($("#val_servico").val())*1;		
		var desconto       = moedaBrToUsa($(this).val())*1;
		var subtotal = (valImplantacao + valServico - desconto);
		$("#sub-total").val(moedaUsaToBR(subtotal.toFixed(2)));
		/*--*/
		var totalVenda = moedaBrToUsa($("#total_venda").val())*1;
		var porcentagem = ( desconto / totalVenda ) * 100;
		$("#porcentDesconto").val(moedaUsaToBR(porcentagem.toFixed(1)));
});

$("#porcentDesconto").live('keyup',function(){
			
	  var valPorcentagem = moedaBrToUsa($(this).val())*1;
	  var totalVenda = moedaBrToUsa($("#total_venda").val())*1;

	  var porcentagem = (valPorcentagem / 100) * totalVenda;
	  var subtotal = (totalVenda - porcentagem);
	  $("#sub-total").val(moedaUsaToBR(subtotal.toFixed(2)));
	  $("#val_desconto").val(moedaUsaToBR(porcentagem.toFixed(2)));
			
});

function Total(){
	  var valImplantacao = moedaBrToUsa($("#val_implantacao").val())*1;
	  var valServico = moedaBrToUsa($("#val_servico").val())*1;
	  var total = (valImplantacao + valServico);
	  $("#total_venda").val(moedaUsaToBR(total.toFixed(2)));
}
$(function(){
	var todosCheckboxes = $('.scrollContainer').find(':checkbox');
		if(todosCheckboxes.is(":checked")){
				for(i=0; i < todosCheckboxes.length; i++){
						$(todosCheckboxes[i]).css('background-color','#CCC');	
				}
		}	
})
</script>
<script type="text/javascript">

$(document).ready(function(){	
	$("tr:odd").addClass('al');
	
});
	
$("#tabela_dados tr").live("click",function(){
	var contato_id = $(this).attr('contato_id');
	var id = $(this).attr('id');
		
	//location.href='?tela_id=319';
	window.open("modulos/revenda_vekttor/atendimento_vendedor/form.php?contato_id="+contato_id+"&id="+id,"carregador");
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
$("#o_que_gerou").live("change",function(e){
	
	var o_que_gerou = $(this).val();
	if(o_que_gerou>0 && o_que_gerou<=3){
		$("#dt_prox_interacao").html("");
		$("#dt_prox_interacao").append("<div style='clear:both'></div><label style='width:100px;'>Data<input type='text' name='dt_proxima_interacao' id='dt_proxima_interacao' mascara='__/__/____'/ calendario='1'></label><label style='width:100px;'>Hora<input type='text' name='hr_proxima_interacao' id='dt_proxima_interacao' mascara='__:__'/></label>");
	}else{
		$("#dt_prox_interacao").html("");
	}
});

$("#sel_tipo").live("change",function(){
	//alert("oi");
	tipo = $(this).val();
	
	if(tipo=="juridico"){
		$("#juridico").css("display","block");
		$("#fisico").css("display","none");
		$('#tipo_cadastro').val('Jurídico');
	}else{
		$("#juridico").css("display","none");
		$("#fisico").css("display","block");
		$('#tipo_cadastro').val('Físico');
	}
});
$("#bairro_id").live("change",function(){
	var bairro = $(this).val(); 
	location.href='?tela_id=<?=$_GET['tela_id']?>&bairro='+bairro+'&status=<?=$_GET['status']?>';
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="#" class='s2'>
  	Revenda Vekttor
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Atendimento de Vendedor
</a>
<form class='form_busca' action="" method="get">
   	 <a id="clickbusca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
    <input type="text" value="<?=$_GET[status]?>" name="status" id="status"/>
</form>
</div>
<div id="barra_info">
<a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
<form method="get" autocomplete="off">
	      
    <?php
		$bairros = mysql_query("SELECT DISTINCT(bairro) FROM revenda_contato WHERE vendedor_id = $vendedor->id");
		echo "<select name='bairro_id' id='bairro_id'>";
		echo "<option><?=$bairro->bairro?></option>";
		while($bairro = mysql_fetch_object($bairros)){		 
	?>
    	<option <?php if($_GET['bairro']==$bairro->bairro){echo "selected=selected";}?>><?=$bairro->bairro?></option>
    <?php
		}
		echo "</select>";
		$reuniao_visita = mysql_query($t="SELECT 
				   		DISTINCT(revenda_contato_id) as id
					FROM
						revenda_contato_interacao rci,
						revenda_contato rc
					WHERE
						rci.revenda_contato_id = rc.id AND
						(rci.tipo_interacao = 1 OR rci.tipo_interacao = 2 OR rci.tipo_interacao = 3) AND
						(rc.status != '3' && rc.status != '4') AND
						rci.vendedor_id = '$vendedor->id'
						$busca
						$bairro
						ORDER BY rci.data_hora_interacao						
				   ");
		//echo $t."<br>".mysql_error();
	?>
    <input type="submit" name="status" value="Reuniao, Visita e Telefonema" />(<?php echo mysql_num_rows($reuniao_visita);?>)
  
    <?php
		$cancelamento = mysql_query("SELECT * FROM revenda_contato 
									 WHERE status='3' 
									 AND vendedor_id='$vendedor->id' 
									 ORDER BY ID DESC");
	?>
    <input type="submit" name="status" value="Cancelamento" />(<?php echo mysql_num_rows($cancelamento);?>)
    
    <?php
		$venda = mysql_query("SELECT * FROM revenda_contato WHERE status='4' AND vendedor_id='$vendedor->id' ORDER BY ID DESC");
	?>
    <input type="submit" name="status" value="Venda" />(<?php echo mysql_num_rows($venda);?>)
    
        
    <?php
		//echo $vkt_id;
		$contatos_sem_interacao = mysql_query($t="SELECT * FROM revenda_contato WHERE status='1' AND cliente_vekttor_id = '$vkt_id'");
		//echo $t;
	?>
    <input type="submit" name="status" value="Contatos Sem Interacao" />(<?php echo @mysql_num_rows($contatos_sem_interacao);?>)        
    
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
</form>
    
</div>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>          
          <td width="200">Contato</td>
          <td width="140">Responsável</td>
          <td width="150">Telefone(s)</td>
          <td width="140">E-mail</td>
          <?php
		  	if($_GET['status']!="Contatos Sem Interacao"){			
		  ?>
          <td width="70">Interaçao</td>
          <td width="150">Data - Hora</td>
          <?
		  	}
		  ?>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		$bairro='';
		if(!empty($_GET['bairro'])){
			$bairro = "AND rc.bairro='".$_GET['bairro']."'";
		}
		$busca='';
		if(!empty($_GET['busca'])){
			$busca = "AND rc.razao_social LIKE '%".$_GET['busca']."%'";
		}
		if($_GET['status']=="Contatos Sem Interacao"){
			$sql = "SELECT * FROM revenda_contato rc WHERE rc.status='1'  $busca AND rc.cliente_vekttor_id = '$vkt_id' $bairro";
			//echo $sql;
		}
		
		if($_GET['status']=="Cancelamento"){
			$sql = "SELECT * FROM revenda_contato rc WHERE rc.status='3'  AND rc.vendedor_id='$vendedor->id' $busca $bairro";
			//echo $sql;
		}
		
		if($_GET['status']=="Venda"){
			$sql = "SELECT * FROM revenda_contato rc WHERE rc.status='4'  AND rc.vendedor_id='$vendedor->id' $busca $bairro";
			//echo $sql;
		}
		
		if($_GET['status']=="Reuniao, Visita e Telefonema" || empty($_GET['status'])){
			$sql = "SELECT 
				   		DISTINCT(revenda_contato_id) as id
					FROM
						revenda_contato_interacao rci,
						revenda_contato rc
					WHERE
						rci.revenda_contato_id = rc.id AND
						(rci.tipo_interacao = 1 OR rci.tipo_interacao = 2 OR rci.tipo_interacao = 3) AND
						(rc.status != '3' && rc.status != '4') AND
						rci.vendedor_id = '$vendedor->id'
						$busca
						$bairro
						ORDER BY rci.data_hora_interacao						
				   ";
			//echo $sql;
		}
		$sql=mysql_query($sql);
		while($contato = mysql_fetch_object($sql)){
			$revenda = mysql_fetch_object(mysql_query("SELECT * FROM revenda_contato WHERE id='$contato->id'"));
			
			//seleciona a ultima interacao do contato para ver se está cancelado
			//$ultima_interacao = mysql_fetch_object(mysql_query("SELECT * FROM revenda_contato_interacao WHERE revenda_contato_id=$contato->id ORDER BY id DESC LIMIT 1"));
			
			//seleciona a ultima interaçao com filtros
			$interacao =mysql_fetch_object(mysql_query($t="SELECT * FROM revenda_contato_interacao WHERE revenda_contato_id=$contato->id  
				$data $filtro ORDER BY id DESC LIMIT 1"));
				//echo $t; 	
			 
			if($interacao->tipo_interacao==1){$i="Telefonema";}
			if($interacao->tipo_interacao==2){$i="Visita";}
			if($interacao->tipo_interacao==3){$i="Reuniao";}
		
			$color='';
			if(substr($interacao->data_hora_interacao,0,10)<date("Y-m-d")){
				$color="style='background-color:#F00'";
			}		
?>      
    	<tr <?=$sel?> id="<?=$interacao->id?>" contato_id="<?=$contato->id?>" <?=$color?>>
          <td width="200"><?=$revenda->razao_social?></td>
          <td width="140"><?=$revenda->nome_contato?></td>
          <td width="150"><?=$revenda->telefone1."/".$revenda->telefone2?></td>
          <td width="140"><?=$revenda->email?></td>
          <?php
		  	if($_GET['status']!="Contatos Sem Interacao"){	
			
		  ?>
          <td width="70"><?=$i?></td>
          <td width="150"><?=DataUsaToBr(substr($interacao->data_hora_interacao,0,10))." as ".substr($interacao->data_hora_interacao,11,5);?></td>
           <?
		  	}
		  ?>
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
          
          <td width="200"></td>
          <td width="100"></td>
          <td width="100"></td>
          <td width="100"></td>
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
