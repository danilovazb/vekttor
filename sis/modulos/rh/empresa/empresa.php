<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<div id='form_socio'></div>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
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

function rteInsertHTML2(html) {
	 rteName = 'ed2';
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

function ti2(m,v){
	
    w= document.getElementById('ed2').contentWindow.document
	
	if(m=='InsertHTML' ){
		rteInsertHTML2(v);
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

	
	$('.remover_foto').live('click',function(){
		
		$('.div_foto_cliente').css('display','none');
		$('#action2').val("ExcluirFoto");
		
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		$("#form_cliente").attr("target","");
		$('#action2').val("");
	});
	
	$(".form2").live("click",function(){
		
		var aba = $(this).text();
		var empresa_id = $("#cliente_fornecedor_id").val();
		var qtd_socios = $("#qtd_socios").val();
		
		if(empresa_id<=0){
			alert('Por favor, Digite os dados da Empresa e clique em Salvar');
		}else if(aba=="Contrato Social"&&qtd_socios<=1){
			alert('A empresa precisa ter mais de um sócio para obter um contrato social');
		}else{
			$(".form_float").hide();
				
			if(aba=="Jurídico"){ 
			
				$("#form_cliente").css("display","block");
		
			}
		
			if(aba=="Sócios"){ 
				
							
				$("#form_socios").css("display","block");
		
			}
		
			if(aba=="Contrato Social"){ 			
			
				$("#form_contrato_social").css("display","block");
								
			}
				
			if(aba=="Contrato Interno"){
		
				$("#form_contrato_interno").css("display","block");
		
			}		
			
			if(aba=="Documentos"){
		
				$("#form_documentos").css("display","block");
		
			}
			
			if(aba=="Requerimento de Empresários"){
		
				$("#form_requerimentos").css("display","block");
		
			}		
			
		}
		
	});
	
	
	$("#adicionar_socio").live("click",function(){
		
		var empresa_id   =$("#cliente_fornecedor_id").val();
		//alert(empresa_id);
		window.open('<?=$caminho?>/form_socio_funcional.php?empresa_id='+empresa_id,'carregador');
	});
	
	
	
	$("#adicionar_socio_empresa").live("click",function(){
	
					
				var novo_socio    = $("#novo_socio").val();
				
				var empresa_id   =$("#cliente_fornecedor_id").val();
				//alert(numparcelas);		
				var dados = "novo_socio="+novo_socio+"&empresa_id="+empresa_id+'&associa_socio=1';
				
				$("#busca_socio").val('');
					
				$("#dados_socios").load("modulos/rh/empresa/tabela_socios.php?"+dados);							
	
	});
	
	$(".edita_socio").live("click",function(){
		var socio_id=$(this).parent().attr("id_socio");
		var empresa_id   =$("#cliente_fornecedor_id").val();
		window.open('<?=$caminho?>/form_socio_funcional.php?empresa_id='+empresa_id+'&socio_id='+socio_id,'carregador');
	});
	
	$("#remove_socio").live('click',function(){
		var socio_id=$(this).parent().parent().attr("id_socio");
		var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "novo_socio="+socio_id+"&empresa_id="+empresa_id+'&remove_socio=1';
					
				$("#dados_socios").load("modulos/rh/empresa/tabela_socios.php?"+dados);		
	});
	
//});
	$("#imprimir_social").live("click",function(){
		var id = $("#contrato_id_social").val();
		window.open("modulos/rh/empresa/impressao_contrato.php?id="+id+"&tipo=social");
	});
	
	$("#imprimir_interno").live("click",function(){
		var id = $("#contrato_id_interno").val();
		window.open("modulos/rh/empresa/impressao_contrato.php?id="+id+"&tipo=interno");
	});
	
	$("#adicionar_documento").live("click",function(){
		
		$("#form_documentos").submit();
		
		$("#documento_descricao").val('');
		$("#documento_arquivo").val('');
		
	});
	
	$("#adicionar_documento_socio").live("click",function(){
		
		$("#form_documento_socio").submit();
		
	});
	
	$("#remove_documento").live('click',function(){
		var documento_id=$(this).parent().parent().attr("id_documento");
		var cliente_fornecedor_id   =$("#cliente_fornecedor_id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "cliente_fornecedor_id="+cliente_fornecedor_id+"&documento_id="+documento_id+"&remove_documento=1";
		//alert(dados);			
		$("#dados_documentos").load("modulos/rh/empresa/tabela_documentos.php?"+dados);		
	});
	
	$("#remove_documento_socio").live('click',function(){
		var documento_id=$(this).parent().parent().attr("id_documento");
		var cliente_fornecedor_id   =$("#socio_id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "socio_id="+cliente_fornecedor_id+"&documento_id="+documento_id+"&remove_documento_socio=1";
		//alert(dados);			
		$("#dados_documentos_socios").load("modulos/rh/empresa/tabela_documentos_socios.php?"+dados);		
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

$(".link_socio").live('click',function(){
			var aba = $(this).text();
			var socio_id = $("#socio_id").val();
			//var qtd_socios = $("#qtd_socios").val();
		
			/*if(empresa_id<=0){
				alert('Por favor, Digite os dados da Empresa e clique em Salvar');
			}else if(aba=="Contrato Social"&&qtd_socios<=1){
				alert('A empresa precisa ter mais de um sócio para obter um contrato social');
			}else{*/
								
			if(aba=="Documentos"&&socio_id<=0){
				alert('Por Favor Preencha os Dados e clique Em Salvar');
			}else{
				if(aba=="Dados"){ 
			
					$("#form_documento_socio").css("display","none");
					$("#form_socio_funcional").css("display","block");
					
		
				}
				if(aba=="Documentos"){ 
					
					$("#form_socio_funcional").css("display","none");
					$("#form_documento_socio").css("display","block");
		
				}
			}
	});
	
	$("#imprimir_empresario").live('click',function(){
		empresa_id=$("#cliente_fornecedor_id").val();
		empresario_id = $(this).parent().parent().attr('id_socio');
		window.open('modulos/rh/empresa/requerimento_empresario.php?empresa_id='+empresa_id+'&empresario_id='+empresario_id);
	});
	
	$('.imprimir_documento_empresa').live('click',function(){
		var id =  $(this).parent().parent().attr('id_documento');
		
		window.open("modulos/rh/empresa/download_documento.php?id="+id);
	});	

	$("#f_estado_civil").live('click',function(){
		
		var estado_civil = $(this).val();
		
		if(estado_civil=='Casado'){
			$("#informacoes_casados").css('display','block');
		}else{
			$("#informacoes_casados").css('display','none');
		}
	});
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    RH 
</a>
<a href="#" class="navegacao_ativo">
<span></span>    Empresas 
</a>
</div>
<div id="barra_info">
      
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="230">Razao Social</td>
          	<td width="130">CNPJ</td>
          	<td width="110">Qtd. Funcionários</td>
          	<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1'"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, cf.id as cliente_forencedor_id FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1' 
		$busca_add 
		$filtro 
		ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		
		$qtd_func = mysql_num_rows(mysql_query($t="
		SELECT 
			* 
		FROM 
			rh_funcionario 
		WHERE 
			empresa_id='$r->id' AND
			status = 'admitidos' AND
			vkt_id='$vkt_id'
			"));
		//echo $t.mysql_error();
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?id=<?=$r->cliente_fornecedor_id?>','carregador')">
<td width="50" align="right"><?=str_pad($r->cliente_fornecedor_id,5,"0",STR_PAD_LEFT)?></td>
<td width="230"><?=$r->razao_social?></td>
<td width="130"><?=$r->cnpj_cpf?></td>
<td width="110"><?=$qtd_func?></td>
<td></td>
</tr>
<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
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
