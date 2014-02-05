<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");
$ano_corrente = date("Y");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

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

.carregador{ display:none;}
.carregador span{
	position:absolute; 
	background:#FC3;
	color:#333;  
     padding: 2px 4px 2px;
	-webkit-border-radius: 5px;
     -moz-border-radius: 5px;
          border-radius: 5px; 
}
.status_mat{
	background:#F1D741;
	padding:5px;
	border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;
	font-size:10px;
	display:none;
	position:absolute;
}
.outra_turma p{ color:#666;}
.outra_turma hr {
  margin: 2px 0 20px 0;
  border: 0;
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #eee;
}
.matricula_outra_turma{
	display:none;
}
#table-info-matricula tbody tr td{ padding:4px;}
</style>
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

$("#modelo_id").live("change",function(){	
	var modelo_id = $(this).val();
	var dados = "modelo_id="+modelo_id+"&acao=busca_modelo";
														
	$.ajax({
		url: 'modulos/escolar2/matricula_confirmacao/busca_modelo.php',
		type: 'POST',
		data: dados,
		success: function(data) {
			document.getElementById("ed").contentWindow.document.body.innerHTML = data;
		},
	});	
});
</script>

<script type="text/javascript">
$(function(){
//some_menu();	
});
</script>
<script>
$(document).ready(function(){
	
	$("tr:odd").addClass('al');
	//========================
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		var matricula_id = $(this).attr("matricula");
		window.open('modulos/escolar2/matricula_confirmacao/form.php?id='+id+"&matricula_id="+matricula_id,'carregador');
	});
});

</script>
<script type="text/javascript">

function verifica_idade(t){
	
	ultima = t.value.substr(9,1);
	if(ultima!='_' && t.value.length=='10' ){
		ano_nascimento = t.value.substr(6,4)*1;
		mes_nascimento = t.value.substr(3,2)*1;
		dia_nascimento = t.value.substr(0,2)*1;
		var d = new Date();
		var ano = d.getFullYear();
		var mes = d.getMonth()+1;
		var dia = d.getDate();
		idade_ano  = ano-ano_nascimento;
		idade = idade_ano;
		if(mes_nascimento>mes){
			idade = idade_ano-1
		}
		if(mes_nascimento==mes&& dia_nascimento>=dia){
			idade = idade_ano-1
		}
		if(idade>=18){
			$(t.parentNode.parentNode).find('#cpf').attr('valida_cpf','1');
			$(t.parentNode.parentNode).find('#cpf').attr('retorno','focus|Digite o CPF corretamente do aluno');
		}else{
			$(t.parentNode.parentNode).find('#cpf').removeAttr('valida_cpf');
			$(t.parentNode.parentNode).find('#cpf').removeAttr('retorno');
			$(t.parentNode.parentNode).find('#cpf').parent().removeClass('valida_error');
		}
	}
	
}


$('.al,.dl').live('click',function (){
	xabi=$(this).attr('id');
	window.open('<?=$caminho?>form.php?matricula_id='+xabi,'carregador')	
});



$(".avancar").live('click',function(){
	
	 aba_form(this,1);
	 var pagina = $("#pagina_atual").val(1);
	 
	 $("#confirma_turma").hide();
	 $("#menu_cadastro_aluno").show();
	 
	 // BOTAO
	 $(this).hide();
	 $('.voltar').show();              //BOTAO VOLTAR
	 //$("#confirmar_matricula").show(); //BOTAO CONFIRMAR
	 $("#btn-aba").html('<button type="button" id="avanca_pagina"> <i style="float:left; margin-top:1px;">Avan&ccedil;ar</i> &nbsp; <img src="../fontes/img/arrow-2.png" style="opacity:0.5;float:right;"> </button>'); /* BOTAO AVANÇAR */ 
	
});

/*==========*/

$(".voltar").live('click',function(){
	/*pagina = $(".avancar").attr('pagina')*1;
	pagina = pagina-1;*/
	$("#confirma_turma").show();
	$("#menu_cadastro_aluno").hide();
	aba_form(this,0);
	
	//BOTAO
	$(this).hide();
	$(".avancar").show(); // BOTAO AVANÇAR
	$("#confirmar_matricula").hide(); //BOTAO CONFIRMAR
	$("#avanca_pagina").hide(); // BOTAO PARA CONTROLE DE ABAS
	/*$(".avancar").attr('pagina',pagina);
	
	$('.paginamatricula').hide(); 
	$('#pagina_id_'+pagina).show();
	if(pagina==1){
		$('.voltar').hide();
	}
	if(total_paginas== pagina){
		$(".avancar").hide();
		$('.salvar').show();
	}else{
		$(".avancar").show();
		$('.salvar').hide();
	}*/
});

$(".alunos_a_ser_matriculados").live('change',function(){
	
	alunos =$(this).val();
	d_html = $(".axluml:first").html();
	alunos_descartaveis = $(".alunodescartavel").size();
	alunos_amais = alunos_descartaveis+1;
	if(alunos<alunos_amais){
		diferenca_alunos = alunos_amais-alunos;
		
		for(i=alunos_descartaveis;i>=alunos;i--){
			pagina = i+2;
			$('#pagina_id_'+pagina).remove();
		}
		
	}else{
		for(i=1;i<alunos;i++){
			pagina=i+2;
			if($('#pagina_id_'+pagina).attr('criado')!=1){
				inner = "<div id='pagina_id_"+pagina+"' criado='1' class='paginamatricula alunodescartavel' style='width:770px;  display:none'>"+d_html+'</div>';
				
				$('#paidaspaginas').append(inner);
			}
		}
	}
});



$(".periodo_id").live('change',function(){
	periodo_id=$(this).val();
	$(this.parentNode.parentNode).find('.lb_escola_id').load('<?=$tela->caminho?>select_escolas.php?periodo_id='+periodo_id)
	
})


$(".escola_id").live('change',function(){
	periodo_id=$(this.parentNode.parentNode).find(".periodo_id").val();
	escola_id=$(this.parentNode.parentNode).find(".escola_id").val();
	
	$(this.parentNode.parentNode).find('.lb_curso_id').load('<?=$tela->caminho?>select_cursos.php?periodo_id='+periodo_id+'&escola_id='+escola_id);
	
})

$(".curso_id").live('change',function(){
	periodo_id=$(this.parentNode.parentNode).find(".periodo_id").val();
	escola_id=$(this.parentNode.parentNode).find(".escola_id").val();
	curso_id=$(this.parentNode.parentNode).find(".curso_id").val();
	
	$(this.parentNode.parentNode).find('.lb_modulo_id').load('<?=$tela->caminho?>select_modulos.php?periodo_id='+periodo_id+'&escola_id='+escola_id+'&curso_id='+curso_id);
	
})


$(".modulo_id").live('change',function(){
	periodo_id=$(this.parentNode.parentNode).find(".periodo_id").val();
	escola_id=$(this.parentNode.parentNode).find(".escola_id").val();
	curso_id=$(this.parentNode.parentNode).find(".curso_id").val();
	modulo_id=$(this.parentNode.parentNode).find(".modulo_id").val();
	
	$(this.parentNode.parentNode).find('.lb_horario_id').load('<?=$tela->caminho?>select_horarios.php?periodo_id='+periodo_id+'&escola_id='+escola_id+'&curso_id='+curso_id+'&modulo_id='+modulo_id);
	
})

$(".horario_id").live('change',function(){
	horario_id=$(this.parentNode.parentNode).find(".horario_id").val();
	valor =  $(this).find("option:selected").attr('valor');
	valor_bolsista =  $(this).find("option:selected").attr('valor');
	
	$(this.parentNode.parentNode).find('.lb_valor span').html(valor);
	
	$(this.parentNode.parentNode).find('.valor').val(valor);
	$(this.parentNode.parentNode).find('.lb_sala_id').load('<?=$tela->caminho?>select_salas.php?horario_id='+horario_id);
	
	
	
})
$(".remove_imagem_aluno").live("click", function(){
	aluno_id= $(this).attr('aluno_id');
	//alert(aluno_id);
	window.open('?tela_id=473&deleta_imagem='+aluno_id,'carregador');
	
	$("#img_curso").hide(200);
	
});

//--- Codigo Gerar senha

var Password = function() {
	this.pass = "";

	this.generate = function(chars) {
	  for (var i= 0; i<chars; i++) {
		this.pass += this.getRandomChar();
	  }
	  return this.pass;
}

	this.getRandomChar = function() {
		/* 
		*	matriz contendo em cada linha indices (inicial e final) da tabela ASCII para retornar alguns caracteres.
		*	[48, 57] = numeros;
		*	[64, 90] = "@" mais letras maiusculas;
		*	[97, 122] = letras minusculas;
		*/
		var ascii = [[48, 57],[97,122]];
		var i = Math.floor(Math.random()*ascii.length);
		return String.fromCharCode(Math.floor(Math.random()*(ascii[i][1]-ascii[i][0]))+ascii[i][0]);
	} 
}

function newPass(destino) {
	var pwd = new Password();
	senha =  pwd.generate(6);
	
	document.getElementById(destino).value = senha;
}

$('#val-matricula').live('click',function(){
		window.open('modulos/escolar/matriculas/form_valor.php','carregador');
});

$("#confirmar_matricula").live("click",function(){
	html_to_form();
	$("#frmcontrato").submit();		
});
//
$("#filter_tipo_matricula").live("change",function(){
		$("#form_filtro").submit();
});
$("#filter_turma_id").live("change",function(){
		$("#form_filtro").submit();
});
$("#periodo_letivo_id").live("change",function(){
		$("#form_filtro").submit();
});
$("#escola_id").live("change",function(){
		$("#form_filtro").submit();
});
</script>

<script type="text/javascript" src="modulos/escolar2/matricula_confirmacao/matricula.js"></script>
<style>
tbody td:nth-child(1){width:30px;}
tbody td:nth-child(2){width:60px;}
tbody td:nth-child(3){width:200px;}
tbody td:nth-child(4){width:90px;}
tbody td:nth-child(5){width:60px;}
#turma_id option blockquote{ padding:3px;}
</style>
<div id="conteudo">
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        <form class='form_busca' action="" method="get">
             <a></a>
            <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
            <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
            <input type="text" id='busca' value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
         <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=217" class="navegacao_ativo"><span></span>Confirma&ccedil;&atilde;o Matr&iacute;culas</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
	 <form method="get" id="form_filtro" style="float:left;">
	 <input type="hidden" name="tela_id" value="473" />
      
       <select name="filter_tipo_matricula" class="filter_tipo_matricula" id='filter_tipo_matricula' style="margin-top:3px;">
        <option value="0">Tipo</option>
        
        <option value="matricula" <? if($_GET[filter_tipo_matricula]=='matricula'){echo "selected='selected'";}?>>Matricula</option>
        <option value="rematricula" <? if($_GET[filter_tipo_matricula]=='rematricula'){echo "selected='selected'";}?>>Rematricula</option>
      </select>
      
       <select name="escola_id" id="escola_id" style="width:120px;">
          	<option value="0">Escola</option>
          	<?php
				$escolas = mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id' ");
				
				while($escola = mysql_fetch_object($escolas)){
					
					if($_GET['escola_id']==$escola->id)
						$selected="selected='selected'";
					
					echo "<option value='$escola->id' $selected>$escola->nome</option>";
					$selected='';
					
				} ?>
      	  </select>
      
      <select name="periodo_letivo_id" id="periodo_letivo_id" style="width:120px;">
          <option value="0">Per&iacute;odo Letivo</option>
          <?
              $periodos_letivos = mysql_query("SELECT * FROM escolar2_periodo_letivo WHERE vkt_id='$vkt_id'");
              
              while($periodo_letivo = mysql_fetch_object($periodos_letivos)){
              
                  if($_GET['periodo_letivo_id']==$periodo_letivo->id){
                      $selected = "selected='selected'";
                  }
              
                  echo "<option value='$periodo_letivo->id' $selected>$periodo_letivo->nome</option>";
                  $selected='';
              }
          ?>
      </select> 
      
      
      <select name="turma_id" id="filter_turma_id">
      	<option value="0">Turma Salas</option>
        <?php
        	$sql_turma = mysql_query($t=" SELECT * FROM escolar2_matriculas AS matricula
			JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id WHERE matricula.vkt_id = '$vkt_id' GROUP BY turma.nome ");
			
			while($turma=mysql_fetch_object($sql_turma)){
				$salas = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma->sala_id' "));
				if( $_GET["turma_id"] == $salas->id){ $selts = 'selected="selected"';} else { $selts = ''; }
		?>
        <option <?=$selts?>  value="<?=$salas->id?>"><?=$turma->nome." - ".$salas->nome?></option>
      	<?php }?>
      </select>
      
     </form>  
      <a href="modulos/escolar2/matricula_confirmacao/form.php" target="carregador" class="mais"></a>
      </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td style="width:15px;"><?php echo linkOrdem( "T", "m.tipo_matricula", 0 ); ?></td>
                <td style="width:40px;">N&ordm;</td>
                <!--<td style="width:40px;">MAT</td>-->
                <td style="width:180px;"><?php echo linkOrdem( "Nome", "a.nome", 1 ); ?></td>
                <td width="90"><?php echo linkOrdem( "CPF", "a.cpf", 0 ); ?></td>
                <td style="width:40px;">Idade</td>
                <td width="140">Escola</td>
                <td width="220">S&eacute;rie</td>
                <td width="70">COD.Turma</td>
                <td>&nbsp;</td>
            </tr>
        </thead>
    </table>
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
<div id="dados">
    
	<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
    <?
    //pr($_POST);
	?>
        <table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
           <tbody> 
          <?php
          	$n_count = 0;
			$filtro_barro_info = "";
			$filterTurma = false;
			$filter = "";
				
			  if(isset($_GET['busca'])){ 
				if(!is_numeric($_GET['busca']))
					$and_busca = " AND aluno.nome like '%".$_GET['busca']."%' ";
				else 	
					$and_busca = " AND matricula.id = '".$_GET['busca']."' ";		
			  }
			  
			  /* Filtro Turmas Salas */
			  
			  if(!empty($_GET["turma_id"])){
				  $filter = " AND turma.sala_id =  ".trim($_GET["turma_id"]);
			  }
			  
			  /* Período Letivo */
			  $filterPeriodo = !empty($_GET["periodo_letivo_id"]) ? " AND turma.periodo_letivo_id =  '".trim($_GET["periodo_letivo_id"])."'" : "" ;
			  
			  /* Filtro Escola */
			  $filterEscola = !empty($_GET["escola_id"]) ? " AND turma.unidade_id = '".$_GET["escola_id"]."' " : "";
			  /* Tipo */
			  if(!empty($_GET["filter_tipo_matricula"])){
				  $filtro_barro_info .= " AND matricula.matricula_rematricula = '".trim($_GET["filter_tipo_matricula"])."'";
			  }
			  
			  

			
			$sql_matricula = mysql_query($sm=" 
				SELECT *, matricula.id AS matricula_id FROM escolar2_matriculas AS matricula 
				JOIN escolar2_alunos AS aluno ON aluno.id = matricula.aluno_id 
				JOIN escolar2_turmas AS turma ON matricula.turma_id  = turma.id 
				$filter
				$filterPeriodo
				$filterEscola
				WHERE 1 
				AND
					matricula.status = 'matricula'
				AND 
					matricula.vkt_id = '$vkt_id' $and_busca $filtro_barro_info ORDER BY aluno.nome ASC ");
					
			//echo $sm;
			while($matricula=mysql_fetch_object($sql_matricula)){
				   $n_count++;
				   $aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$matricula->aluno_id' "));
				   
				   list($ano_nascimento, $mes_nascimento,$dia_nascimento) = explode("-",$aluno->data_nascimento); // Nascimento
				   $idade = $ano_corrente -  $ano_nascimento; //Idade Aluno
				   
				   $matricula_aluno = mysql_fetch_object(mysql_query($yu=" SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno->id' "));
				   	
					if($matricula->matricula_rematricula == "matricula")
						$tipo_matricula = "M";	
					 else 
						$tipo_matricula = "R";
						
				   $turma = mysql_fetch_object(mysql_query($ui=" SELECT * FROM escolar2_turmas WHERE id = '$matricula->turma_id' ")); 
				   
				   $sala = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_salas WHERE id = '$turma->sala_id' "));
				   
				   $horario = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$turma->horario_id' "));
				   
				   $unidade = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma->unidade_id' "));
				   //echo $yu;		
					
		  ?> 	
            <tr id="<?=$aluno->id?>" matricula="<?=$matricula->matricula_id?>">
            	<td style="width:15px;"><?=$tipo_matricula?></td>
                
                <td style="width:40px;"><?=$matricula->id?></td>
            	<!--<td style="width:44px; padding-left:6px;"><?=get_nome($matricula->matricula_id,5)?></td>-->
                
            	<td style="width:180px;text-transform:uppercase;" id="aluno" title="<?=$aluno->nome?>"><?=get_nome($aluno->nome,26)?></td>
            	<td width="90"><?=$aluno->cpf?></td>
            	<td style="width:40px;"><?=$idade?></td>
            	<td width="140" ><?=get_nome($unidade->nome,20)?></td>
            	<td width="220"><?=$turma->nome.", ".$sala->nome.", ".$horario->nome?></td>
                <td width="70"><?=$matricula->matricula_id?></td>
                <td>&nbsp;</td>
           </tr>
          <?php
          }
		  
		  ?>
          </tbody>
        </table>        
        
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="100%">&nbsp;</td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<?
/*

		$file = "modulos/administrativo/matriculas/arquivos/exportado".date('YMD')."_.csv";
		@unlink("$file");
		$handle = fopen($file, 'a');
		$infos = implode($linha_xls);
		fwrite($handle,$infos);
		fclose($handle);
*/

		

?>
<script>
function mudaTipo(t){
	tipo=t.value;
	if(tipo=='Jurídico'){
		$("#cpf").css('display','none');
		$("#cpf input").attr('disabled','disabled');
		$("#cpf input").removeAttr('retorno');
		$("#cpf input").removeAttr('valida_cpf');
		
		$("#cnpj").css('display','');
		$("#cnpj input").removeAttr('disabled');
	}
	if(tipo=='Físico'){
		$("#cnpj").css('display','none');
		$("#cnpj input").removeAttr('retorno');
		$("#cnpj input").attr('disabled','disabled');
		
		$("#cpf").css('display','');
		$("#cpf input").removeAttr('disabled');
	}
	
}
</script>
<div id="rodape" >

    
</div>
