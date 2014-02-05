<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
a.mais:hover{ display:block;}
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
<a href="" class='s1'>
  	Sistema
</a>
<a href="" class='s2'>
  	Vekttor
</a>
<a href="" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>

<div id="barra_info"><select name="modulo_id" id="modulo_id" onchange="location='?tela_id=182&modulo_id='+this.value" style="margin-top:3px;">
             		
                    
                    <?
					
	function menu_submenu2($modulo_id,$ident,$id){
		$sql = mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='$modulo_id' ORDER BY ordem_menu ");
		
		$identador = $ident*10;
		$ident++;
		
		while($r=mysql_fetch_object($sql)){
				if($_GET[modulo_id] ==$r->id){$sel='selected="selected"';}else{$sel='';}
			
	?>
    <option <?=$sel;?>  value="<?=$r->id;?>" style="margin-left:<?=$identador?>px">
     <?
			echo $r->nome;
	
	?> 
    
    </option>
<?php
		}
	}	
	if($modulo->modulo_id=='0'){
		$selecionado='selected="selected"';
	}else{$selecionado='';}
	?>
    <option <?=$selecionado?> style="font-weight:bold;" value="0">
    Modulo Principal
    </option>
    <?
		if(isset($modulo->modulo_id))
			$id=$_GET['modulo_id'];
	menu_submenu2(0,0,$id);

                    		
					?>
                    	
             </select>
  <a href="modulos/vekttor/item_menu/form.php" target="carregador" class="mais"></a>
</div>


<!--ScriptContratoHTML-->
<script type="text/javascript">

function checaprogresso(){
    id_chave=$("#id_chave").val();
                
    d = new Date();
    s = d.getTime();
    url = '<?=$tela->caminho?>/informacao_do_progresso.php?id_progresso='+id_chave+'&'+s;	
    carregabarra(url);
}
            
            
            function carregabarra(url){
                console.log(url);
                if($("#vkt_barra").css('display')=='none'){
                    $("#vkt_barra").slideDown();
                }
                $("#progresso").load(url, function() {
                    porcentagem = $("#progresso").html();
                    $("#vkt_barra_progresso").css("width",porcentagem.replace(',','.')+'%');
                
                    if($("#vkt_barra_progresso").css("width")!=100){
                        carregabarra(url);
                    }
            
                });
            }
                
            
            function chegouao100porcento(){
                $('#vkt_barra_progresso').css('width','100%');
            }

$("#add_arquivo").live("click",function(){
	//$("#tbl_arquivos").append("<tr><td width='80'></td><td width='280'></td><td width='280'></td><td></td></tr>");
	sys_modulos_id = $("#sys_modulos_id").val();
	window.open('modulos/vekttor/item_menu/form_tutorial.php?id='+sys_modulos_id,'carregador');
});
$("#remove_arquivo").live("click",function(){
	//$("#tbl_arquivos").append("<tr><td width='80'></td><td width='280'></td><td width='280'></td><td></td></tr>");
	//sys_modulos_id = $("#sys_modulos_id").val();
	//window.open('modulos/vekttor/item_menu/form_tutorial.php?id='+sys_modulos_id,'carregador');
	$(this).parent().parent().remove();
});

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


<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="300">Itens</td>
          <td width="100">A&ccedil;&atilde;o Menu</td>
          <td width="350">Caminho</td>
          <td width="200">Tela</td>
          <td width="50">N&ordm; Tela</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	
	function menu_submenu($modulo_id,$ident){
		
		$sql = mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='$modulo_id' ORDER BY ordem_menu,nome ");
		for($i=0;$i<$ident;$i++){
			$html_idente .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";	
		}
		$ident++;
		
		while($r=mysql_fetch_object($sql)){
		global $contador;
		$contador++;
	?>      
    	<tr id="<?=$r->id?>" >
          <td width="300"><?
		  if($modulo_id==0||$r->acao_menu=='expande'){
				echo "<strong>$html_idente $r->ordem_menu  $r->nome</strong>";
			}else{
				echo $html_idente." ".$r->ordem_menu." ".$r->nome;
			}
		  ?></td>
          <td width="100"><?=$r->acao_menu?></td>
          <td width="350"><?=$r->caminho?></td>
          <td width="200"><?=$r->tela?></td>
          <td width="50"><?=$r->id?></td>
          <td></td>
        </tr>
<?php
		menu_submenu($r->id,$ident);
		}
	}
	if($_GET[modulo_id]||$_POST[modulo_id]){
		$modulo_id=$_GET[modulo_id];	
	}else{
		$modulo_id=0;	
	}
	menu_submenu($modulo_id,0);
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"><?=$contador?></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>
<?php  // $user = isset($db->user) ? $db->user : NULL;
if($sys_modulo_id>0){
/*
		echo "
		<script>
		location.href='?tela_id=182#$sys_modulo_id'
		</script>";
		*/
}
?>
<div id='rodape'>
	
</div>

<script>
			$("tr:odd").addClass('al');

	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/vekttor/item_menu/form.php?id='+id,'carregador');
		$("#exibe_formulario").css("left","500px");
		
	});

/*
	$(document).ready(function(){
			$("span .mais").mouseover(function(){
      			$(this).css("display","block");
    		}).mouseout(function(){
      			$("p:first",this).text("mouse out");
      			$("p:last",this).text(++i);
    		});

	});
	*/
</script>
