	<?php  
	$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
	$caminho =$tela->caminho;
	include '_functions.php';
	include '_ctrl.php';
	 
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some"><<</div>

<a href="#" class='s1'>
  	Sistema
</a>
<a href="#" class='s1'>
  	Cozinha
</a>
<a href="#" class='s2'>
  	Cotação
</a>
<a href="#" class='navegacao_ativo'>
<span></span> Cotação Produto
</a>
</div>
<style type="text/css" media="all">
/*thead tr th {text-align:center;border-bottom: 2px solid #999;}
tr th {padding: 1px 6px;font-size: 0.9em;} 
tfoot tr td {text-align:center;border-top: 2px solid #999;}
tr.sub {background:#999;color:#FFF;}
#row{font-weight:500;}
#prod{text-align:left;}
#tabela_dados{ overflow:auto;}*/
.qtd{width:30px;height:12px;}
.vlr{width:50px;height:12px; text-align:right}
.marca{height:12px; width:55px;}
.cz{ color:#999999}

.g{background:url(../fontes/img/bb.jpg); font-weight:bold; }
.escondido{  position:absolute; display:none; color:black !important;left:10%;}
.modal-body table tr td{ background:white !important;color:black !important;}
.modal-body table tr td:hover{ background:white !important; color:black !important;}
.menu_adicional{border:1px solid #CCC;  background:#FFF; position:absolute; right:27px; top:30px; box-shadow:#999 0 0 10px}
	.menu_adicional a{ display:block; padding:0px 10px 0px 10px; cursor:pointer; font-size:11px; text-decoration:none;}
	.menu_adicional a:hover{ background-color:#F2F5FA;}
</style>
<script>
$(document).ready(function(){
	$('table#tabela_dados tbody > tr:odd').addClass('al');
	//------------------------------------------------
	 
  	$("table .tn").mouseover(function() {
    	$('table .tn').css('color','#000');
  	}).mouseout(function(){
    	$('table .tn').css('color','');
  	});
	
	$(".form_float input:eq(0)").focus();
	$('.qtd:eq(0)').focus();
	
})

/*$(".exibe_formulario").ready(function(){
	$(".exibe_formulario input:eq(0)").focus();	
})*/

function chama_cotacao(t){
	fornecedor_id=$('#fornecedor_id').val();
	if(fornecedor_id>0){
		location.href='?tela_id=119&necessidade_id=<?=$_GET['necessidade_id']?>&fornecedor_id='+fornecedor_id+'&acao=cotacao';
	}else{
		alert('Selecione um fornecedor');
	}
}

function valores_compra(t){
	//alert(t.name);
	alert(t.value);
}

function novaCompra(cont){
	
	var itens           = new Array();
	var necessidade_id  = document.getElementById('necessidade_id').value;
	var almoxarifado_id = document.getElementById('almoxarifado_id_filt').value;
	//alert(almoxarifado_id);
	var cont2=0;
	if(almoxarifado_id > 0){
		for(i=1;i<=cont;i++){
		
			t=document.getElementById('escolha'+i);
			if(t!=null){
				itens[cont2]=t.value;
				cont2++;
			}
		}
		
		url='modulos/cozinha/cotacao/nova_compra.php?item_cot_id='+itens+'&necessidade_id='+necessidade_id+'&almoxarifado_id='+almoxarifado_id;
		//alert(url);
		window.open(url,'carregador');
	}else{
		alert('Selecione a unidade de destino da compra!');
	}
}

function atualizaValores(){
	cont = $('#numprod').text();
	valor = 0;
	for(i=1;i<=cont;i++){
		t=$('#escolha'+i).val();
		valor+=(moedaBrToUsa($('#vlr'+t).val()))*1;
	}
	//$('#total_c').html(moedaUsaToBR(valor.toFixed(2)));
}

function foco(){
	$('.qts_pessoas eq:[0]').focus();
}

$("#duplicar").live('click',function(){

	window.open('modulos/cozinha/cotacao/form.php','carregador');

	/*var necessidade_id = $("#necessidade_id").val();

	var dados = 'necessidade_id='+necessidade_id+'&acao=duplica_necessidade';
	
	$.ajax({
		url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
						
			$('#tbody').append(data);
			$("tr:odd").addClass('al');
		},
	});*/
	
});
$("#criar_cotacao").live('click',function(){
	
	var necessidade_id = top.document.getElementById('necessidade_id').value;
	var data_inicio    = $("#data_inicio").val();
	var data_final     = $("#data_final").val();
	
	var dados = 'necessidade_id='+necessidade_id+'&data_inicio='+data_inicio+'&data_final='+data_final+'&acao=duplica_necessidade';
	
	$.ajax({
		url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
			//alert(data);
			location.href='?tela_id=118&necessidade_id='+data;			
			
		},
	});
	
});


function funcao_bsc2(resultado,acao,origem){	
	actions_W= acao.split('|');
	//alert(actions_W);
//	document.title=resultado.innerHTML+','+resultado.getAttribute('r0')+','+resultado.getAttribute('r1')+','+resultado.getAttribute('r2')+','+acao+','+origem+','+actions_W.length;
	
	//document.getElementById(origem).value=resultado.getAttribute('r0');
	
	for(w=0;w<actions_W.length;w++){
		vlores_e_locais = actions_W[w].split("-");
		local_e_acao = vlores_e_locais[1].split('>');
		
		valor = vlores_e_locais[0].replace(/@/g,'');
		local = local_e_acao[0];
		acao_W  = local_e_acao[1];
		
		if(local=='innerHTML'){
			document.getElementById(acao_W).innerHTML=resultado.getAttribute(valor);
		}else if(local=='value'){
			document.getElementById(acao_W).setAttribute('value',resultado.getAttribute(valor));
			document.getElementById(acao_W).value=resultado.getAttribute(valor);
		}else{
			document.getElementById(acao_W).setAttribute(local,resultado.getAttribute(valor));
		}
	}
	/*--------- funcoes para pegar valor e enviar a requisicao para o servidor via ajax ----------------------*/
	var produto_id    = $("#busca_produto_id").val();
	
	var fornecedor_id = $("#fornecedor_id").val();
	//linha = $("<tr><td>"+nome+"</td><td></td> <td></td> <td></td> <td></td> </tr>");ocorrencia	
	//linha.appendTo("#tbody");
	//alert(produto_id);
	$("#produto_id").val('');
	$("#busca_produto_id").val('');
	$("#busca_produto").val('');
	

		var dados = 'produto_id='+produto_id+'&necessidade_id=<?=$necessidade_id?>&acao=criar_cotacao'
						//alert(dados);
						$.ajax({
							url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
							dataType: 'html',
							type: 'POST',
							data: dados,
							success: function(data, textStatus) {
								
								$('#tbody').append(data);
								$("#tbody tr:odd").addClass('al');
							},
						}); /* Fim Ajax*/
					
}

$(".qtd, .obs").live('blur',function(){
	
	var id  = $(this).parent().parent().attr("item_id");
	
	var necessidade_id = $("#necessidade_id").val();
	var produto_id = $(this).parent().parent().find(".produto_id_item").val();
	var qtd = qtdBrToUsa($(this).parent().parent().find(".qtd").val(),3)*1;
	var obs = $(this).parent().parent().find(".obs").val();
	var id_qtd	= $(this).parent().parent().find(".qtd").attr('id');
	var dados = 'produto_necessidade_id='+id+'&qtd='+qtd+'&obs='+obs+'&acao=edita_produto_cotacao&produto_id='+produto_id+'&necessidade_id='+necessidade_id;
	
	$.ajax({
		url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
			$("#"+id_qtd).parent().parent().attr("item_id",data);			
			//$('#tbody').append(data);
			//$("#tbody tr:odd").addClass('al');
		},
	});

});
$("#cotar_produto").live('click',function(){
	
	var produto_id = $(this).parent().parent().find(".produto_id_item").val();
	var necessidade_id = $("#necessidade_id").val();
	var item_id = $(this).parent().parent().attr('item_id');
	var id_qtd	= $(this).parent().parent().find(".qtd").attr('id');
	if($(this).is(':checked')){
		acao='criar_cotacao';
	}else{
		acao='excluir_item';
	}
	
	var dados = 'produto_id='+produto_id+'&necessidade_id='+necessidade_id+'&item_id='+item_id+'&acao='+acao;
						//alert(dados);
	$.ajax({
		url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
			
			$("#"+id_qtd).parent().parent().attr("item_id",data);
			//$('#tbody').append(data);
			//$("#tbody tr:odd").addClass('al');
		},
	}); /* Fim Ajax*/
});

$("#planejar").live('click',function(){
	var item_id  = $(this).parent().parent().attr("item_id");
	var produto_id_item = $(this).parent().parent().find('.produto_id_item').val();
	var necessidade_id  = $("#necessidade_id").val();
	var id_qtd	= $(this).parent().parent().find(".qtd").attr('id');
	
	if(!item_id>0){
		
		var dados = 'produto_id='+produto_id_item+'&necessidade_id='+necessidade_id+'&item_id='+item_id+'&acao=criar_cotacao';
		
		$.ajax({
		url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
			success: function(data, textStatus) {
			
				$("#"+id_qtd).parent().parent().attr("item_id",data);
								
			},
		});		
	}
	//item_id  = $(this).parent().parent().attr("item_id");
	
	window.open('modulos/cozinha/cotacao/form_planejamento.php?produto_id_item='+produto_id_item+'&necessidade_id='+necessidade_id,'carregador');
	
});

$(".qtd_pessoas,.f_gramatura").live('keyup',function(){
	var item_id  = $("#item_id").val();
	var qtd_pessoas = qtdBrToUsa($(this).parent().parent().find(".qtd_pessoas").val(),3)*1;
	var f_gramatura = qtdBrToUsa($(this).parent().parent().find(".f_gramatura").val(),3)*1;
	
	total = qtd_pessoas*f_gramatura;
	$(this).parent().parent().find(".valor_total_planejamento").text(qtdUsaToBr(total,2));
	
	var total_planejamento = 0;
	
	$("#tbl_planejamento tbody tr").each(function(){
		//alert('oi');
		total_planejamento+=qtdBrToUsa($(this).find(".valor_total_planejamento").text(),3)*1;
	});
	//alert(total_planejamento);
	$("#total_planejamento").html('');
	$("#total_planejamento").text(qtdUsaToBr(total_planejamento,2));
	/*$("#tbody tr").each(function() {
        if($(this).attr('item_id')==item_id){
			$(this).find('.qtd_sugerida').text(qtdUsaToBr(total_planejamento,2));
			//break();
		}
    });*/
});
$("#fornecedor_id").live('change',function(){
	$("#cotar_fornecedor").focus();
});
$("#grupo_id").live('change',function(){
	var necessidade_id  = $("#necessidade_id").val();
	var grupo_id = $(this).val();
	location.href='?tela_id=118&acao=necessidade&necessidade_id='+necessidade_id+'&grupo_id='+grupo_id;
});

$(".nome_produto").live('click',function(){
	
	$(".escondido").hide();
	id=$(this).attr('id')

	$("#modal"+id).show();
	$("#modal"+id+" .sub-janela").show();
	$(".mostrar_detalhes").show();
});

$("div").on("click","#cad_fornecedor",function(){
	$(".modal").css('display','block');
});

$(".atl_natureza input:radio").live('click',function(){
	$("#atl_nome").val("");
	$("#atl_cnpf_cpf").val("");
	$("#atl_nome").attr("disabled","disabled");
	$("#atl_cnpf_cpf").attr("disabled","disabled");
	$("#atl_cadastrar").attr("disabled","disabled");
	$("#atl_cnpf_cpf").attr('sonumero','1');
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
$("#atl_cadastrar").live('click',function(){
		//Físico - Jurídico
		var natureza = $(".atl_natureza").find(":radio");
			if($(natureza[0]).is(":checked")){
				var tipo_cadastro = 'F';
			}else{
				var tipo_cadastro = 'J';
			}
			
	 
		  var nome = $("#atl_nome").val();
		  var cnpj_cpf = $("#atl_cnpf_cpf").val();
		  var tela_id = $("#tela_id").val();
		  var necessidade_id=$("#necessidade_id").val();  		
		$.post('modulos/cozinha/cotacao/_ctrl.php?acao=cad_fornecedor',{tipo_cadastro:tipo_cadastro,nome:nome,cnpj_cpf:cnpj_cpf},function(data){
				location.href='?tela_id='+tela_id+'&necessidade_id='+necessidade_id+'&acao=necessidade';
				/*$("#atl_nome").attr("disabled","disabled");
				$("#atl_cnpf_cpf").attr("disabled","disabled");
				$("#atl_cadastrar").attr("disabled","disabled");
				$(".modal").hide("slow");	
				$(".modal").html("");*/
		})
		
		//location.href='?tela_id='+tela_id+'&necessidade_id='+necessidade_id+'&acao=necessidade';
		//window.open('modulos/cozinha/cotacao/_ctrl.php?acao=cad_fornecedor&tipo_cadastro='+tipo_cadastro+'&nome='+nome+'&cnpj_cpf='+cnpj_cpf+'&tela_id='+tela_id+'&necessidade_id'+necessidade_id,'carregador');
		
		//$(".modal").hide("slow");	
		//$(".modal").html("");		
});
$("#novo_produto").live('click',function(){
	window.open('modulos/estoque/produtos/form.php','carregador');;
});
</script>
<script>
	$(".menu_actions").live('click',function(){
		$(".menu_adicional").toggle();
	
	})
	$(".menu_adicional > a").live('click',function(){
		$(".menu_adicional").toggle();
	});
</script>
<div id="barra_info">

<form method="post">
<input type="hidden" name="tela_id" value="119" />

<!-- select na tabela projetos -->
<strong>Necessidade No: <?=$necessidade_id?></strong>

<!--<input type="hidden" name="busca_produto_id[]" id="busca_produto_id" value="">
Adicionar Produto<input type="text" id='busca_produto' onkeyup="return vkt_ac(this,event,'0','modulos/cozinha/cotacao/busca_produto.php','@r0','funcao_bsc2(this,\'@r1-value>busca_produto_id\',\'produto\')')"
   autocomplete='off' name="produto" value=""  valida_minlength="3"  style='width:170px;height:10px;font-size:11px;' retorno='focus|Coloque no minimo 3 caracter' <? if(($pedido->status=='Finalizado')||($pedido->status=='cancelado')){echo "disabled='disabled'";}?> />
-->
<select name="grupo_id" id="grupo_id">
	<option>Todos os Grupos</option>
	<?php
		$grupo_produtos=mysql_query($t="SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id' ORDER BY nome ASC");
		while($grupo_produto=mysql_fetch_object($grupo_produtos)){
			if($_GET['grupo_id']==$grupo_produto->id){
				$selected="selected='selected'";
			}else{
				$selected="";
			}
			echo "<option value='$grupo_produto->id' $selected>$grupo_produto->nome</option>";
		}
	?>
</select>

<input type="button" name="duplicar" id="duplicar" value="Duplicar Cotação" /> 
<input type="button" id="cotar_fornecedor" value="Cotar no fornecedor" style="float:right; margin:3px 5px 0 10px;" onclick="chama_cotacao(fornecedor_id)"/>
<select name="fornecedor_id" id='fornecedor_id' style="float:right; margin:3px 5px 0 10px;">
<?
	$fornecedores=mysql_query($t="SELECT * FROM cliente_fornecedor WHERE tipo='Fornecedor' AND  cliente_vekttor_id ='$vkt_id' ORDER BY razao_social ASC");
	//echo $t."<br>";
	while($fornecedor=mysql_fetch_object($fornecedores)){
?>
<option value="<?=$fornecedor->id?>"> <?=$fornecedor->nome_fantasia?></option>
<?
	}
?>
</select>
<input type="button" id="cad_fornecedor" value="Cadastrar Fornecedor" />
<input type="button" id="novo_produto" value="Cadastrar Produto" />
<!--<button type="button" class="menu_actions" style="float:right; padding:0px; margin:3px 2px 0 0"> <img src="../fontes/img/menu-alt.png"></button>-->
</form>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
<thead>
    	<tr>
           <td width="35">Item</td>
            <td width="35"></td>
          <td width="110">Produto</td>
          <td width="100">Em Estoque</td>
          <td width="70"></td>
          <td width="80">Qtd Sugerida</td>
          <td width="110">Qtd Sugerida Emb.</td>
          <td width="50" title="Quantidade Necessidade">QTD N</td>
          <td width="35">R$</td>          
          <td width="100">Fornecedor 1</td>
          <td width="45">Valor</td>
          <td width="100">Fornecedor 2</td>
          <td width="45">Valor</td>
          <td width="100">Fornecedor 3</td>
          <td width="45">Valor</td>
   		  <td></td>	
        </tr>
    </thead>
</table>

<div id='dados' style="overflow:auto;">

	<!-- modal -->
           <div style="position:absolute;  margin-top:51px;">
              <div class="modal" style="display:none">
              <div class="modal-header-2">
              	<a href="#" style="color:#CCC; font-weight:bold; float:right;" class="modal_close">x</a>
                <span>Cadastro de Fornecedor</span>
              </div>
                    <div class="modal-body">
                    	<p>
                        	<div class="atl_natureza" style="padding:3px; height:30px;">
                            	<div style="float:left"><input type="radio" name="natureza" id="cpf" value="1" style="width:20px;">CPF</div>
                            	<div style="float:left"><input type="radio" name="natureza" id="cnpj" value="2" style="width:20px;">CNPJ</div>
                               
                            </div>
                            <div style="clear:both;"></div>
                        	<div style=" float:left;"><label style="width:175px;">Nome/Razão Social<br/><input type="text" name="atl_nome" id="atl_nome" style="height:15px;" disabled="disabled"></label></div>
                            <div><label style="width:120px;">CNPJ/CPF <br/><input type="text" name="atl_cnpf_cpf" id="atl_cnpf_cpf" style="height:15px;" disabled="disabled"></label></div>      
                         </p>
                         <!--<button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" style="margin-top:8px;" >cadastrar</button>-->
                         <div><small style=" color:#999999; font-size:11px;">ap&oacute;s cadastro v&aacute; para tela fornecedores para completar as informa&ccedil;&otilde;es </small></div>
                    </div>
              <div class="modal-footer">
              	<!--<div style="padding:3px;"><span>ap&oacute;s o cadastro vá para tela cliente</span></div>999999-->
                <button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" >cadastrar</button>
                
              </div>
			</div>
    		</div>

<?
	$necessidade_id=$_GET['necessidade_id'];
	if($_GET['grupo_id']>0){
		$filtro_grupo = "AND id='".$_GET['grupo_id']."'";
	}
	//$itens_necessidades = mysql_query("SELECT * FROM cozinha_necessidade_item WHERE necessidade_id='".$necessidade_id."' AND vkt_id='$vkt_id'");
	$grupo_produtos=mysql_query($t="SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id' $filtro_grupo ORDER BY nome ASC");
	$qtd_produtos=0;
	$cont=0;
	
	$soma_contratos = mysql_fetch_object(mysql_query($t="
			SELECT 
				SUM(almoco_mes) as almoco_mes
			FROM 
				cozinha_contratos cc,
				cliente_fornecedor cf
			WHERE
				cc.vkt_id='$vkt_id' AND
				cc.cliente_id=cf.id AND
				cc.status='1'"));
	
	$y=0;
	while($grupo_produto=mysql_fetch_object($grupo_produtos)){
	$produtos = mysql_query($t="SELECT * FROM produto WHERE vkt_id='$vkt_id' AND produto_grupo_id='$grupo_produto->id' ORDER BY nome");
	if(mysql_num_rows($produtos)>0){
?>
<table style='width:100%'>
<thead>
<tr>
	<td><?=$grupo_produto->nome?></td>
</tr>
</thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
	<tbody dir="dados" id="tbody">
    	<?
			
			
			while($produto=mysql_fetch_object($produtos)){
			$selecionado =     mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_necessidade_item WHERE necessidade_id='$necessidade_id' AND produto_id='$produto->id'"));
			$ultimas_compras = mysql_query($t="SELECT * FROM estoque_compras_item eci, estoque_compras ec
												WHERE 
												eci.vkt_id='$vkt_id' AND
												eci.pedido_id = ec.id  AND
												eci.produto_id='$produto->id' AND
												ec.status    !='cancelado'												
												ORDER BY  eci.id DESC LIMIT 5");
			$qtd_estoque = @mysql_result(@mysql_query("SELECT saldo/$produto->conversao2 as qtd_estoque FROM estoque_mov WHERE produto_id='$produto->id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"),0,0);
			if(!$qtd_estoque>0){
				$qtd_estoque=0;
			}
			
			echo mysql_error();
			//echo $t."<br>";
		?>
   		<tr item_id="<?=$selecionado->id?>">
        	<? 
				//verifica se o pruduto está selecionado para cotação
				
				if($selecionado->cotar=='sim'){
					$checked="checked='checked'";
					$qtd_produtos++;
				}else{
					$checked='';
				}
				//echo $t;
				$produto_cotacao_item = mysql_query($t=
				"SELECT 
					* 
				FROM 
					cozinha_cotacao_item 
				WHERE 
					vkt_id='$vkt_id' AND
					produto_id='".$produto->id."' AND 
					necessidade_id='".$necessidade_id."' 
				ORDER BY valor_ini 
				LIMIT 3");
				//echo $t;
				//verifica se já tem planejamento para este contrato e este produto
				$existe_planejamento = mysql_fetch_object(mysql_query($t="
					SELECT 
						SUM(qtd_pessoas*gramatura) as total_planejamento 
					FROM 
						cozinha_cotacao_planejamento 
					WHERE 
						item_necessidade_id='$selecionado->id' AND
						item_necessidade_id > 0 AND
						vkt_id='$vkt_id'						
				"));
				//echo $selecionado->id." ".$t." ".$existe_planejamento->total_planejamento."<br>";
				if($existe_planejamento->total_planejamento>0){
					$total_planejamento=$existe_planejamento->total_planejamento;
				}else{
					/*$qtd_pessoas=$soma_contratos->almoco_mes;
					$gramatura  =$produto->gramatura;
					$total_planejamento=$qtd_pessoas*$gramatura;*/
					$total_planejamento=$selecionado->qtd_digitada;
				}
				if($produto->conversao2>0){
				$total_planejamento_emb=$total_planejamento/$produto->conversao2;
				}else{
					$total_planejamento_emb=0;
				}
				//$total_geral+=$total_planejamento;
			?>
          <td width="35"><?=$cont+1?></td>    
          <td width="35"><input type="checkbox" name="cotar_produto" id="cotar_produto" <?=$checked?> /></td>
          <td width="110"title="<?=$produto->nome?>" class="nome_produto" id="<?=$y?>">
		  	
			<?=substr($produto->nome,0,30)?><input type="hidden" class="produto_id_item" value="<?=$produto->id?>" />
          	<!--<div  id="modal<?=$y?>" class="escondido"  style="z-index:10">
             <div class="sub-janela"  id="janela_plano_contas">
             <div class="modal-header-2">
                     <a href="#" style="color:#CCC; font-weight:bold;float:right;" class="modal_close">x</a>
               <span><?=$nome?></span>
             </div>
             <div class="modal-body" >
             	<div style="font-weight:bold"><?=$produto->nome?></div>
                <table cellpadding="0" cellspacing="0" style="background:white !important;">
              <thead>
              	<tr>
                    <td>Compra</td>
                    <td>Nota</td>
                    <td>Qtd</td>
                    <td>Valor</td>                  
                </tr>
              </thead>
              <tbody>
				<?php
                	while($ultimas_compra = mysql_fetch_object($ultimas_compras)){
						
				?>
					<tr>
                    	<td><?=$ultimas_compra->pedido_id?></td>
                        <td><?=$ultimas_compra->nro_nota_fiscal?></td>
                    	<td><?=($ultimas_compra->qtd_enviada/$produto->conversao2)." ".substr($produto->unidade_embalagem,0,2)?></td>
                    	<td><?=MoedaUsaToBr($ultimas_compra->valor_fim)?></td>                  
                	</tr>	
				<?php
                	}
             	?>
                 </tbody>
              </table>
			 </div>
             <div class="modal-footer">
             </div>
         	</div>
      		</div>
            <!-- fim modal-body--> 
          </td>
          <td width="110"><?=$qtd_estoque." ".substr($produto->unidade_embalagem,0,2)?></td>
          <td width="70"><input type="button" value="planejar" id="planejar"/></td>
          <td width="80" align="right" class="qtd_sugerida"><?=limitador_decimal_br($total_planejamento,3)." ".substr($produto->unidade_uso,0,2)?></td>
          <td width="110" align="right" class="qtd_sugerida_emb"><?=limitador_decimal_br($total_planejamento_emb,3)." ".substr($produto->unidade_embalagem,0,2)?></td>
          <td width="50" title="<?=" com ".$produto->conversao2." ".$produto->unidade_uso?>">
		  <input class='qtd' type='text' sonumero='1' name='qtd[]' size='3' id="<?=$grupo_produto->nome.$cont?>" value="<?=limitador_decimal_br($selecionado->qtd_digitada)?>"/><?=substr($produto->unidade_embalagem ,0,2)?></td>
          <td width="35">
		  	<?php
          
		  		if($produto->conversao>0){
					echo number_format($produto->custo/$produto->conversao,2,',','.');
				}else{
					echo "0,00";
				}
			?>
          </td>
          
           	<?
		  		$cont++;
				$soma=0;
				$valores = array();
				$c=0;
				while($produto_cotacao=mysql_fetch_object($produto_cotacao_item)){
					//echo $produto_cotacao->id;
					$qtd_embalagem = '';
					$unidade       = '';
					$v_embalagem   = '';
		  			$fornecedor_produto_id = mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_cotacao WHERE id='".$produto_cotacao->cotacao_id."'"));
					$fornecedor=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$fornecedor_produto_id->fornecedor_id."'"));
					
					//echo $produto_cotacao->unidade." ".$produto->conversao." ".$produto->conversao2;
					//echo $produto_cotacao->unidade;
					//echo $produto_cotacao->id;
					if($produto_cotacao->unidade==$produto->unidade){
						$qtd_embalagem = $produto_cotacao->qtd_pedida*$produto_cotacao->fatorconversao;
						$unidade       = substr($produto->unidade_embalagem,0,2);
						//echo $produto_cotacao->qtd_pedida." ";
						$v_embalagem   = $produto_cotacao->valor_ini/$produto_cotacao->fatorconversao;
							
					}
					
					if($produto_cotacao->unidade==$produto->unidade_embalagem){
						$v_embalagem   = $produto_cotacao->valor_ini;
						$unidade       = substr($produto->unidade_embalagem,0,2);
						$qtd_embalagem = $produto_cotacao->qtd_pedida;
					}
					if($produto_cotacao->unidade==$produto->unidade_uso){
						$qtd_embalagem 	= $produto_cotacao->qtd_pedida/$produto_cotacao->fatorconversao2;
						$unidade        = substr($produto->unidade_embalagem,0,2);
						$v_embalagem	= $produto_cotacao->valor_ini*$produto_cotacao->fatorconversao2;
					}
					$valores[$c]['valor'] = $v_embalagem;
					$valores[$c]['item_id'] = $produto_cotacao->id;
					$valores[$c]['cotacao_id'] = $produto_cotacao->cotacao_id;
					$valores[$c]['fornecedor'] = $fornecedor->razao_social;
					$valores[$c]['marca']      = $produto_cotacao->marca;
					
					$c++;
				}
			  	
				array_multisort($valores,SORT_ASC);
				//echo "Valores: ".print_r($valores);
				//exit();
				
				$cont2=0;
				foreach($valores as $valor){
									
			?>
          		<td width="100">
            	<input type="radio" name="f<?=$cont?>" id="f<?=$cont?>" value="<?=$valor['item_id']?>" <? if($cont2==0){echo "checked=checked";}?> title='<?=$valor['item_id']?>' 
                onclick="document.getElementById('escolha<?=$cont?>').value=this.getAttribute('title');atualizaValores();" /><?=substr($valor['fornecedor'],0,15)?>
                </td>
          		<td align="left" width="45" title="<?=$valor['marca']?>">
          		<?=moedaUsaToBr($valor['valor'])?>
            	<input type="hidden" name="escolha<?=$cont?>" id="escolha<?=$cont?>" value="<?=$valor['item_id']?>"/>
				</td>
		 	<?
					$cont2++;
				}
				
				//Bloco para completar as colunas da tabela
				//echo $cont2++;
				if($cont2<3){
					for($i=$cont2;$i<3;$i++){
						print("<td width='100'></td>");
						print("<td width='45'></td>");
						
					}
					
				}
		?>
          <td></td>
        </tr>
		<?
        		$y++;
			}
		
	}
		
	}
		?>
        	
     </tbody>
</table>
<div style=""></div>
<span id="numprod" style="display:none"><?=$cont?></span>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->

</div>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="90"></td>
          <td width="45"></td>
          <td width="35"></td>
          <td width="100"></td>
          <td width="40"></td>
          <td width="35"></td>
          <td width="45"></td>
          <td width="100"></td>
          <td width="40"></td>
          <td width="35"></td>
          <td width="45"></td>
          <td width="100"></td>
          <td width="40"></td>
          <td width="35"></td>
          <td width="45"  id="total_c"></td>
   		  <td></td>	
        </tr>
    </thead>
</table>
</div>

<div id='rodape'>
<label style="width:100px;">
	<select id="almoxarifado_id_filt" name="almoxarifado_id_filt">
    <option value="">Selecione uma Unidade</option>
   
    <? 
	$almoxarifados_q=mysql_query($t="SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY id ASC"); 
	while($almoxarifado=mysql_fetch_object($almoxarifados_q)){
	?>
    	<option value="<?=$almoxarifado->id?>" <? if(isset($_POST['almoxarifado_id_filt'])&&$_POST['almoxarifado_id_filt']==$almoxarifado->id){echo "selected=selected";}?>><?=$almoxarifado->nome?></option>
    <? } ?>
    </select>
</label>
<input type="button" value="Criar pedidos de compras por fornecedor" name="" style="margin-top:3px;" onclick="novaCompra(<?=$cont?>)"/>
<input type="hidden" name="necessidade_id" id="necessidade_id" value="<?=$_GET['necessidade_id']?>" />	
<input type="hidden" name="tela_id" id="tela_id" value="<?=$_GET['tela_id']?>" />	
</div>