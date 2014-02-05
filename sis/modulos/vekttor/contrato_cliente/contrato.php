<?php
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
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
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="#" class='s2'>
  	Vekttor
</a>
<a href="#" class='navegacao_ativo'>
<span></span>Contrato Cliente
</a>
</div>

<div id="barra_info">
<a href="modulos/vekttor/contrato_cliente/form.php" target="carregador" class="mais"></a>
</div>
<script type="text/javascript">
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


</script>
<!-- -->
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<?
//print_r($_POST);
?>
<div id="pagina">
<?php
	$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM contrato_modelo_cliente WHERE id='$vkt_id'"));
	
   echo $contrato->contrato;

?>
</div>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
 </div>

