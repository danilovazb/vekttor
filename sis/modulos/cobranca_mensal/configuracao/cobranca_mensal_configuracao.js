
	$("#grupo_id").live("change",function(){
		var grupo_id = $(this).val();
		//alert(grupo_id);
		if(grupo_id!="novo"){
			$("#botoes").text("");
			$("#botoes").append("<input type='button' value='Editar' id='edt_grupo'><input type='button' value='filtrar' id='filtrar'>");
		}else if(grupo_id=="novo"){
			window.open('modulos/administrativo/clientes/form_grupo.php','carregador');
		}else{
			$("#botoes").text("");
		}
	});
	$("#edt_grupo").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		//alert(grupo_id);
		window.open('modulos/administrativo/clientes/form_grupo.php?grupo_id='+grupo_id,'carregador');
	});
	$("#filtrar").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		location.href='?tela_id=15&grupo_id='+grupo_id+'&filtro=filtrar';
	});
	/*$("#botoes button").on("click",function(event){
			window.open('modulos/administrativo/clientes/form_exportar.php','carregador');	
	});*/
	$("#exportar").live("click",function(event){
			//alert('ater');
			
			window.open('modulos/administrativo/clientes/form_exportar.php?tipo=Cliente','carregador');	
	});
	
	$("#aniversariante").live("click",function(event){
			//alert('ater');
			location.href='?tela_id=15&aniversariantes=sim';	
	});
	/*$("#foto_cliente").live("change",function(){
		var input = $("<input>").attr("type", "hidden").attr("name", "action").val("Salvar");
		$('#form_cliente').append($(input));
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		
	});*/
	$('.remover_foto').live('click',function(){
		
		$('.div_foto_cliente').css('display','none');
		$('#action2').val("ExcluirFoto");
		
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		$("#form_cliente").attr("target","");
		$('#action2').val("");
	});
	
	
	$('#add_documento').live('click',function(){
		
		var descricao_documento = $("#descricao_documento").val();
		$('#action2').val("adicionarDocumento");
		
				
		$("#dados_documentos").append("<tr><td style='width:250px;'><img src='../fontes/img/menos.png' class='remove_documento'>"+descricao_documento+"</td><td style='width:30px;' align='center'><a class='download_documento'><img src='../fontes/img/baixar.png' class='download'/></a></td></tr>");
		//var
		
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		$("#form_cliente").attr("target","");
		$('#action2').val("");
		
	});
	
	$('.remove_documento').live('click',function(){
		var id =  $(this).parent().parent().attr('id');
		
		$("#id_documento_exclusao").val(id);
		
		$('#action2').val("excluirDocumento");		
		
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		$("#form_cliente").attr("target","");
		$('#action2').val("");
		$(this).parent().parent().remove();
	});
	
	$('.download_documento').live('click',function(){
		var id =  $(this).parent().parent().attr('id');
		
		window.open("modulos/administrativo/clientes/downloadDocumento.php?documento_id="+id,"carregador");
	});	
	$("#btn_configuracao_id").live('click',function(){
		window.open("modulos/cobranca_mensal/configuracao/form.php","carregador");
	});
	
	$("#botao_salvar").live('click',function(){
		
		html_to_form();
		$("#frmconfiguracao").submit();
	});
	
	
	//-----SCRIPT DO CONTRATO-----//
	function rteInsertHTML(html,id) {
	 rteName = id;
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
function ti(m,v,id){
   
	w= document.getElementById(id).contentWindow.document
	if(m=='InsertHTML' ){
		rteInsertHTML(v,id);
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
	
	
		document.getElementById("texto_envio_cobranca").value = document.getElementById("ed_texto_conbranca").contentWindow.document.body.innerHTML
		
		document.getElementById("ed_texto_conbranca").contentWindow.document.body.innerHTML.replace("\n","");
		
		document.getElementById("texto_contas_vencidas").value = document.getElementById("ed_contas_vencidas").contentWindow.document.body.innerHTML
		
		document.getElementById("ed_contas_vencidas").contentWindow.document.body.innerHTML.replace("\n","");
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

$("#excluir_configuracao").live('click',function(){
	if(confirm("Deseja Realmente Excluir a Configuração da Conta? Obs.:O cliente não será excluido.")){
		$("#form_cliente").submit();
	}else{
		return false;		
	}
});