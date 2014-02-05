<?php
	$plano_saude_id = $_GET['plano_saude_id'];
	$plano_saude = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$plano_saude_id'"));
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<style>
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

	function html_to_form(ed,tx_html){
	
		document.getElementById(tx_html).value = document.getElementById(ed).contentWindow.document.body.innerHTML
		
		document.getElementById(ed).contentWindow.document.body.innerHTML.replace("\n","");
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




function insertValueQuery() {
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if(myListBox.options.length > 0) {
        sql_box_locked = true;
        var chaineAj = "";
        var NbSelect = 0;
        for(var i=0; i<myListBox.options.length; i++) {
            if (myListBox.options[i].selected){
                NbSelect++;
                if (NbSelect > 1)
                    chaineAj += ", ";
                chaineAj += myListBox.options[i].value;
            }
        }

        //IE support
        if (document.selection) {
            myQuery.focus();
            sel = document.selection.createRange();
            sel.text = chaineAj;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var chaineSql = document.sqlform.sql_query.value;

            myQuery.value = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
        } else {
            myQuery.value += chaineAj;
        }
        sql_box_locked = false;
    }
}


	$(".link_form").live("click",function(){
		
		var aba = $(this).text();
		var id = $("#id").val();
				
				
		if(id<=0){
			alert('Por favor, Digite os dados do Funcionário e clique em Salvar');
		}else{
			
			
			
			$(".form_float").css("display","none");
			
				
			if(aba=="Dados"){ 
				
				$("#form_cliente").css("display","block");
				$("#dados_funcionario").css("display","block");
				$("#dados_pis").css("display","none");
		
			}
			
			if(aba=="PIS"){ 
				$("#form_cliente").css("display","block");
				$("#dados_funcionario").css("display","none");
				$("#dados_pis").css("display","block");
		
			}
		
			if(aba=="Documentos"){ 
													
				$("#form_documentos").css("display","block");
		
			}
			
			if(aba=="Dependentes"){ 
													
				$("#form_dependentes").css("display","block");
		
			}	
			
			if(aba=="Contrato"){ 
													
				$("#form_contrato").css("display","block");
		
			}	
			
			
		}
		
	});
	
	$("#adicionar_documento").live("click",function(){
		
		//alert('oi');
		
		$("#form_documentos").submit();
		$("#documento_descricao").val('');
		$("#documento_arquivo").val('');
		
		
	});
	
	$("#remove_documento").live('click',function(){
		var documento_id=$(this).parent().parent().attr("id_documento");
		var funcionario_id   =$("#id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "funcionario_id="+funcionario_id+"&documento_id="+documento_id+"&remove_documento=1";
		//alert(dados);			
		$("#dados_documentos").load("modulos/rh/funcionarios/tabela_documentos.php?"+dados);		
	});
	
	function replaceAll(string, token, newtoken) {
		while (string.indexOf(token) != -1) {
 			string = string.replace(token, newtoken);
		}
		return string;
	}
	
	$("#adicionar_dependente").live("click",function(){
	
					
				var funcionario_id   =$("#id").val();
				var nome   =replaceAll($("#nome_dependente").val()," ","_");
				
							
				var data_nascimento   =$("#data_nascimento_dependente").val();
				var grau_parentesco   =$("#grau_parentesco_dependente").val();
				
				//alert(numparcelas);		
				var dados = "funcionario_id="+funcionario_id+'&nome='+nome+"&data_nascimento="+data_nascimento+"&grau_parentesco="+grau_parentesco+"&adicionar_dependente=1";
				
				$("#nome_dependente").val('');
				$("#data_nascimento_dependente").val('');
				
				
				$("#dados_dependentes").load("modulos/rh/funcionarios/tabela_dependentes.php?"+dados);		
											
	
	});
	
	$("#remove_dependente").live('click',function(){
		var dependente_id=$(this).parent().parent().attr("id_dependente");
		var funcionario_id   =$("#id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "funcionario_id="+funcionario_id+"&dependente_id="+dependente_id+"&remove_dependente=1";
		//alert(dados);			
				$("#dados_dependentes").load("modulos/rh/funcionarios/tabela_dependentes.php?"+dados);		
	});
	
	$("#f_quando_estrangeiro").live('change',function(){
		
		if($(this).val()=="sim"){
			$("#estrangeiro").css("display","block");			
		}else{
			$("#estrangeiro").css("display","none");	
		}
	});
	
	$("#modelo_id").live("change",function(){
	//alert(numparcelas);	
	var modelo_id = $(this).val();
		
	var dados = "modelo_id="+modelo_id+"&acao=busca_modelo";
														
	$.ajax({
		url: 'modulos/rh/empresa/busca_modelo_contrato.php',
		type: 'POST',
		data: dados,
		success: function(data) {
			//alert(data);
			document.getElementById("ed").contentWindow.document.body.innerHTML = data;
		
		},
	});	
	

});
	$("#imprimir_contrato").live('click',function(){
		//alert('oi');
			
		
		var id=$("#id").val();
		window.open('modulos/rh/funcionarios/impressao_contrato_experiencia.php?id='+id);
	});
	$(".imprimir_relatorio").live('click',function(){
		
		var id=$("#id").val();
		var relatorio = $(this).val();
		
		
		switch(relatorio){
			case 'Ficha Frente': window.open('modulos/rh/funcionarios/ficha_registro_empregado.php?id='+id);break;
			case 'Ficha Costa': window.open('modulos/rh/funcionarios/ficha_registro_empregado2.php?id='+id);break;
			case 'PIS': window.open('modulos/rh/funcionarios/ficha_pis.php?id='+id);break;
			case 'Termo de Opçao': window.open('modulos/rh/funcionarios/termo_opcao.php?id='+id);break;
			
			case 'Termo de Transporte': window.open('modulos/rh/funcionarios/termo_transporte.php?id='+id);break;
			
			case 'ASO': window.open('modulos/rh/funcionarios/atestado_saude.php?id='+id);break;
			
			case 'Entrega de Carteira': window.open('modulos/rh/funcionarios/impressao_comprovante_carteira.php?id='+id+'&acao=entrega');break;
			
			case 'Devolução de Carteira': window.open('modulos/rh/funcionarios/impressao_comprovante_carteira.php?id='+id+'&acao=devolucao');break;
		}
		//window.open('modulos/rh/funcionarios/impressao_contrato_experiencia.php?id='+id);
	});
	
	$('.imprimir_documentos').live('click',function(){
		var id =  $(this).parent().parent().attr('id_documento');
		
		window.open("modulos/rh/funcionarios/download_documento.php?id="+id);
	});
	
	$("#f_estado_civil").live('change',function(){
		
		estado_civil = $(this).val();
		
		if(estado_civil=='Casado'){
			$("#conjugue").css('display','block');
		}else{
			$("#conjugue").css('display','none');
		}
	});
	
	$(".modelo").live('click',function(){
		alert('oi');
	});
	
	$("#possui_deficiencia").live('change',function(){
		
		if($(this).val()=='1'){
			$("#div_tipo_deficiencia").css('display','block');
		}
		
		if($(this).val()=='2'){
			$("#div_tipo_deficiencia").css('display','none');
		}
		
	});
</script>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" /><input type="hidden" name="empresa1id" value="<?=$_GET['empresa1id']?>" />
   
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">
	<input type="button" value="<<" onclick="location.href='?tela_id=568'"/>
    <strong>Plano:</strong> <?=$plano_saude->razao_social?>
        
	<button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/tela_impressao.php?url=')" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
  </div>
<div id='dados'>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
 <div id="info_filtro">
 	<?=date('d/m/Y')?>
    <strong style="margin-left:200px;">Relação de Valores e Descontos de Planos de Saúde</strong>
 	<div style="clear:both"></div>
    <?=date('H:i:s')?>
 </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	
    	<tr>
        	
            <td width="250">Plano de Saúde</td>
                
            <td width="100">Vlr Funcionários</td>
            <td width="100">Qtd Dependentes</td>
            <td width="100">Vlr Dependentes</td>
            <td width="100">Total Plano</td>
            <td width="100">Total Desconto</td>	
          	<td class="wp">&nbsp;</td>
			
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
	//$empresa_id=$_GET['empresa_id'];
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	if($_GET[limitador]<1){
		$_GET[limitador]	=100;
	}
	if(strlen($_GET[ordem])>0){
		$ordem = $_GET[ordem];
	}else{
		$ordem =  'nome';
	}
	$registros= mysql_result(mysql_query("SELECT * FROM rh_funcionario WHERE plano_saude_id='$plano_saude_id'"),0,0);
	$q = mysql_query($t="SELECT * FROM rh_funcionario WHERE plano_saude_id='$plano_saude_id'");
						
	while($r=mysql_fetch_object($q)){
				
		$total_plano = $total_dependente + $r->total_funcionario;
		if($total%2){$sel='class="al"';}else{$sel='';}		
		$total++;
		
		$dependentes_plano = mysql_query(
			"SELECT 
							rh_funcionario.id as funcionario_id, rh_funcionario.plano_saude_valor_depenente, COUNT(*) as qtd_dependente
						FROM 
							rh_funcionario_dependentes,
							rh_funcionario
						WHERE
							rh_funcionario_dependentes.funcionario_id=rh_funcionario.id AND
							rh_funcionario.id = $r->id AND
							rh_funcionario_dependentes.plano_saude='sim'
							GROUP BY rh_funcionario.id"
		);
		
		$qtd_dependente = 0;
		$total_dependente = 0;
		
		while($dependente_plano=mysql_fetch_object($dependentes_plano)){
			$total_dependente += $dependente_plano->plano_saude_valor_depenente*$dependente_plano->qtd_dependente."<br>";
			$qtd_dependente   += $dependente_plano->qtd_dependente;
		}
		$total_plano = $total_dependente + $r->plano_saude_valor_funcionario;
	?>       
    	<tr <?=$sel ?>>
      		<td width="250"><?=$r->nome?></td>
            <td width="100"><?=MoedaUsaToBr($r->plano_saude_valor_funcionario)?></td>
            <td width="100"><?=$qtd_dependente?></td>
            <td width="100" ><?=MoedaUsaToBr($total_dependente)?></td>
          	<td width="100" ><?=MoedaUsaToBr($total_plano)?></td>
            <td width="100"><?=MoedaUsaToBr($r->plano_saude_valor_descontado)?></td>
          	<td width="" class="wp"></td>
        </tr>
      
<?
		
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr <?=$sel ?>>
      		<td width="250">&nbsp;</td>
            <td width="100"><?=$total_qtd_funcionario?></td>            
            <td width="100"><?=MoedaUsaToBr($total_valor_funcionario)?></td>
            <td width="100"><?=$total_qtd_dependente?></td>
            <td width="100" ><?=MoedaUsaToBr($total_valor_dependente)?></td>
          	<td width="100" ><?=MoedaUsaToBr($total_valor_plano)?></td>
            <td width="100"><?=MoedaUsaToBr($total_valor_descontado)?></td>
          	<td width="" class="wp"></td>
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
<script>
$('#sub93').show();
$('#sub418').show()
</script>