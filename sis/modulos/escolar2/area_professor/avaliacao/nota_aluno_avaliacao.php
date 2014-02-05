<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");

$disabled = "";
if($avaliacao->status == 2){
	$disabled = 'disabled="disabled"';
}
$display = "none";	

  if( $info_bimestre->travado == "sim" ){
	echo "<script> 
			  $(function(){
				  $('table :input').attr('disabled','disabled');
				  $('form#frm_relatorio_individual :input').attr('disabled','disabled');
			  });	 
		  </script> 
		  <style>
		  .click_relatorio{ display:none }
		  </style> "; }
	
	
?>

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
$(function(){
	//some_menu();
})
</script>
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
});

$("#confirmar_relatorio").live('click',function(){
	 html_to_form();
	$("#frm_avaliacao_individual").submit();
});

$(".click_relatorio").live("click",function(){
	var bimestre_id = $("#bimestre_id").val();
	var professor_has_turma_id = $("#professor_has_turma_id").val();
	var matricula_aluno_id = $(this).attr("id");
	var relatorio_id = $(this).attr("relatorio");
	
	window.open('modulos/escolar2/area_professor/avaliacao/form_relatorio_individual.php?bimestre_id='+bimestre_id+'&professor_has_turma_id='+professor_has_turma_id+'&matricula_aluno_id='+matricula_aluno_id+'&relatorio_id='+relatorio_id+'','carregador');
});

$("#nota_aluno").live('blur',function(){
	var avaliacao_id = $("#avaliacao_id").val();
	var nota         = $(this).val();
	var matricula    = $(this).parent().parent().attr("id");
	  
	$.post('modulos/escolar2/area_professor/avaliacao/recebe_nota_aluno.php',
	  	{acao:"cad-nota",avaliacao:avaliacao_id,matricula:matricula,nota:nota});
});//

$("#nota_por_escrito").live('blur',function(){
	var avaliacao_id = $("#avaliacao_id").val();
	var nota         = $(this).val();
	var matricula    = $(this).parent().parent().attr("id");
	
		$.post('modulos/escolar2/area_professor/avaliacao/recebe_nota_aluno.php',
	  		{acao:"cad-nota-escrito",avaliacao:avaliacao_id,matricula:matricula,nota:nota});
	
});//

$("#criterio_avaliacao").live("click",function(){
	  if($(this).is(":checked")){
		  var avaliacao_id = $("#avaliacao_id").val();
		  var matricula    = $(this).parent().parent().attr("id");
		  $.post('modulos/escolar2/area_professor/avaliacao/recebe_nota_aluno.php',
			{acao:"lancar-criterio",avaliacao:avaliacao_id,matricula:matricula,criterio:$(this).val()});
	  }
});

$("#finalizar_nota").live("click",function(){
	var avaliacao_id = $("#avaliacao_id").val();
	var url_voltar = $("#url_voltar").val();
	
	$.post('modulos/escolar2/area_professor/avaliacao/recebe_nota_aluno.php',{acao:"finalizar-nota",avaliacao:avaliacao_id},function(data){
		location.href=url_voltar;	
	});
});

/* novo - nota conceito */
$("#nota_conceito").live("click",function(){	
	var array_notas = { 
		"matricula_id" : $(this).attr("matricula"), 
		"avaliacao_bimestre_id"  : $(this).attr("avaliacao"), 
		"professor_has_turma_id" : $("#professor_has_turma_id").val(),
		"nota" : $(this).val(), "indice": $(this).attr("indice") };
	
	$.post("modulos/escolar2/area_professor/avaliacao/recebe_nota_aluno.php",{funcao:"verifica_avaliacao",dados:array_notas},function(data){
		console.log(data)
	});
});
/* novo - nota numerica ou letras */
$("#nota_aluno").live("blur",function(){	
	var array_notas = { 
		"matricula_id" : $(this).attr("matricula"), 
		"avaliacao_bimestre_id"  : $(this).attr("avaliacao"), 
		"professor_has_turma_id" : $("#professor_has_turma_id").val(),
		"nota_numerica" : $(this).val() };
	
	$.post("modulos/escolar2/area_professor/avaliacao/recebe_nota_aluno.php",{funcao:"verifica_avaliacao",dados:array_notas},function(data){
		console.log(data)
	});
});
/*  */
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
		  
	  document.getElementById("tx_html").value = document.getElementById("ed").contentWindow.document.body.innerHTML;		
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

$("#modelo_id").live("change",function(){	
	var modelo_id = $(this).val();
	var dados = "modelo_id="+modelo_id+"&acao=busca_modelo";
														
	$.ajax({
		url: 'modulos/escolar2/matricula_confirmacao/busca_modelo.php',
		type: 'POST',
		data: dados,
		success: function(data) {
			document.getElementById("ed").contentWindow.document.body.innerHTML = data;
			document.getElementById('tx_html').value = data;
		},
	});	
});


$("#importar_arquivo").live("click",function(){
	window.open("modulos/escolar2/area_professor/avaliacao/form_importar.php?turma_id=<?=$_GET["turma_id"]?>&bimestre_id=<?=$_GET["bimestre_id"]?>&unidade_id=<?=$_GET["unidade_id"]?>&ensino_id=<?=$_GET["ensino_id"]?>&professor_has_turma=<?=$_GET["professor_has_turma"]?>","carregador");
});

$("#exportar_alunos").live("click",function(){
	window.open("modulos/escolar2/area_professor/avaliacao/form_exportar.php?turma_id=<?=$_GET["turma_id"]?>&bimestre_id=<?=$_GET["bimestre_id"]?>&unidade_id=<?=$_GET["unidade_id"]?>&ensino_id=<?=$_GET["ensino_id"]?>&professor_has_turma=<?=$_GET["professor_has_turma"]?>","carregador");
});

$("#enviar_exportar").live("click",function(){
	
	$.post("modulos/escolar2/area_professor/avaliacao/exportar_alunos.php",$("#form_exportar").serialize(),function(data){
		 $("#item_baixar_exportacao").html(data);
		//location=(data);
		//console.log(data);
	  	//console.log(string[1]);
	  	//console.log(data);
	});
});

</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>

<a href="?tela_id=249" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s1'>
    Escolar 
</a>
<a href="#" class='s2'>
    Área Professor 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Nota Avaliação
</a>
</div>
<div id="barra_info">
	
   
    <input type="hidden" name="url_voltar" id="url_voltar" value="<?=$_SESSION["url_voltar"]?>">
    <button onclick="location.href='<?=$_SESSION["url_voltar"]?>'" style="margin-top:1px;">&laquo; Voltar </button>  
    <button type="button" style="float:right; margin-top:3px; margin-right:5px;" id="importar_arquivo">Importar</button>
    <button type="button" style="float:right; margin-top:3px; margin-right:5px;" id="exportar_alunos">Exportar</button>
	
    <span><strong><?=$_GET['descricao']?></strong></span>
    <span><strong> Bimestre: </strong> <?=$info_bimestre->nome?></span> &nbsp;  <strong> Turma: </strong> <?=$s_professor_has_turma->nome_turma?> &nbsp; <strong> Matéria: </strong> <?=$s_professor_has_turma->nome_materia?>  
    
    
    
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="professor_has_turma_id" id="professor_has_turma_id" value="<?=$professor_has_turma?>">
<input type="hidden" name="bimestre_id" id="bimestre_id" value="<?=$bimestre_id?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
       <tr>
           <td width="30">N&ordm;</td>
           <td width="<? echo  count($array_avaliacoes)*87; ?>"> Aluno </td>
           
           <?php for($i=0; $i < count($array_avaliacoes); $i++){ ?>
           <td width="80" title="<?=$array_avaliacoes[$i]["nome"]?>"><?=substr($array_avaliacoes[$i]["nome"],0,12)?></td>
           <?php } ?>
           
           <td width="125" style="text-align:center; padding-left:0;"> Relatório Bimestral </td>
           <td>&nbsp;</td>
       </tr>
        
     </thead>
    
</table>
<div id='dados'>


<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<input type="hidden" name="qtd_av" id="qtd_av" value="<?=count($array_avaliacoes)?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<?
		$cont=0;
		for($i = 0; $i < count($array_alunos_avaliacao); $i++){
			$cont++;
		?>
	    	
            <tr id="<?=$turma_avaliacao->id?>">
               <td width="30"><?=$cont?></td>
               <td id="nome_de_usuario" width="<? echo count($array_avaliacoes)*87; ?>" <?=$colspan?> ><strong><?=strtoupper($array_alunos_avaliacao[$i]["nome_aluno"])?></strong></td>
               
               <? for($j=0; $j < count($array_avaliacoes); $j++){ ?>
               <td width="80">
			   <? 
			   		$nota_conceito = verifica_nota_lancada($array_avaliacoes[$j]["id"],$professor_has_turma,$array_alunos_avaliacao[$i]["matricula_id"]);
					$nota = verifica_nota_lancada_numerica($array_avaliacoes[$j]["id"],$professor_has_turma,$array_alunos_avaliacao[$i]["matricula_id"]);
					
					if( $array_avaliacoes[$j]["tipo"] == "conceito" )
						tipo_conceito($array_avaliacoes[$j]["texto_tipo_avaliacao"],$array_alunos_avaliacao[$i]["matricula_id"],$array_avaliacoes[$j]["id"],$nota_conceito);
					else
			   			tipo_campo($array_avaliacoes[$j]["tipo"],$array_alunos_avaliacao[$i]["matricula_id"],$array_avaliacoes[$j]["id"],$nota);
					
					$rel = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_relatorio_individual_bimestre WHERE vkt_id = '$vkt_id' AND bimestre_id = '".$_GET["bimestre_id"]."' AND matricula_aluno_id = '".$array_alunos_avaliacao[$i]["matricula_id"]."' ")); 
			   ?> 
               </td>
   			   <? } ?>
               
               <td width="125" style="text-align:center; padding-left:0;"> <a href="#" class="click_relatorio" id="<?=$array_alunos_avaliacao[$i]["matricula_id"]?>" relatorio="<?=$rel->id?>"> Relatório Individual </a> </td>          
               <td></td>
            </tr>
            <!-- -->
       <?
		}
	   ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	 <tr>
               <td width="30"></td>
               <td width="250"></td>
               
			   <?php for($i=0; $i < count($array_avaliacoes); $i++){ ?>
               <td width="80" title="<?=$array_avaliacoes[$i]["nome"]?>"></td>
               <?php } ?>
               
               <td width="125" style="text-align:center; padding-left:0;"></td>
               <td>&nbsp;</td>
               
         </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
