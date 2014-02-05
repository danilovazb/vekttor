<?

$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");

$checkbox_disabled = '';

	if($aula->status == 2)
		$checkbox_disabled = 'disabled="disabled"';
	
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$("#selectAll").live('click',function(){
		var aula = $("#aula").val();
		var todosCheckboxes = $('.mudar').find(':checkbox');
		
		if($(this).is(":checked")) {
			$(todosCheckboxes).attr('checked', 'checked');
			
			if(todosCheckboxes.is(":checked")){
				
				for(i=0; i < todosCheckboxes.length; i++){		
					
					if($(todosCheckboxes[i]).is(":checked")){
						var presenca = '1';
						var matricula = $(todosCheckboxes[i]).parent().parent().attr('id');
						
						$.post('modulos/escolar2/area_professor/aula/recebe_presenca.php',
	  					{acao:"presenca_todos",aula:aula,presenca:presenca,matricula:matricula});
						  
					} //fim de if 
				} // fim de for
			} //fim if
		} //fim if 
		else{
		  $(todosCheckboxes).removeAttr('checked');
		  for(i=0; i < todosCheckboxes.length; i++){		
				  
			  if($(todosCheckboxes[i]).is(":not(:checked)")){
				var presenca = '2';
				var matricula = $(todosCheckboxes[i]).parent().parent().attr('id');
				  
				  $.post('modulos/escolar2/area_professor/aula/recebe_presenca.php',
				  {acao:"retira_presenca_todos",aula:aula,presenca:presenca,matricula:matricula});
					
			  } //fim de if 
		  } // fim de for
		}
});

$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
});

$("#presenca").live('click',function(){
	var acao = "";
	var matricula = $(this).parent().parent().attr('id');
	var aula      = $("#aula").val();
	
	if($(this).is(":checked")){
		var presenca = '1';
		acao = "cad_presenca";
	} else {
		var presenca = '2';
		acao = "retira_presenca";
	}						  
	  
	  $.post('modulos/escolar2/area_professor/aula/recebe_presenca.php',
	  	{acao:acao,aula:aula,presenca:presenca,matricula:matricula},function(data){
		  $("#result").html(data);
	  });
	  
});

$("#finalizar_chamada").live("click",function(){
	
	var aula = $("#aula").val();
	var acao = "finalizar_chamada";
	var status = 1;
	var url_voltar = $("#url_voltar").val();
	
	$.post('modulos/escolar2/area_professor/aula/recebe_presenca.php',{acao:acao,aula:aula,status:status},function(){
		location.href=url_voltar;
	});
	
	
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

<a href="" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s2'>
    Escolar 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Chamada
</a>
</div>
<div id="barra_info">
    <!--<a href="<?$caminho?>/form.php" target="carregador" class="mais"></a>-->  
    <input type="hidden" name="url_voltar" id="url_voltar" value="<?=$_SESSION["url_voltar"]?>">
    <button onclick="location.href='<?=$_SESSION["url_voltar"]?>'">&laquo; Voltar </button>  
    <span><strong> Aula: </strong><?=$aula->descricao?> | <strong> Matéria:</strong> <?=$sql_serie_materia->nome?></span>
    <span><button type="button" id="finalizar_chamada" <?=$checkbox_disabled;?> style="margin-top:-3px;">Finalizar Chamada</button></span>   
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="aula" id="aula" value="<?=$aula_id?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	 <tr>
               <td width="60">Matricula</td>
               <td width="200">Aluno</td>
               <td width="65">Presença</td>
               <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	
    	<tr>
            <td align="center" width="60"></td>
        	<td width="200"><strong>SELECIONAR TODOS</strong></td>
            <td width="65"><input type="checkbox" name="selectAll" <?=$checkbox_disabled;?> id="selectAll"> </td>
            <td></td>
        </tr>
    	<?
        	
				while($result_matricula=mysql_fetch_object($sql_turma)){
					
					$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$result_matricula->aluno_id'"));
					
					$aluno_presenca = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_frequencia_aula WHERE aula_id = '$aula_id' AND matricula_aluno_id = '$result_matricula->id'"));
					$frequencia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_frequencia_aula WHERE matricula_aluno_id = '$result_matricula->id' AND aula_id = '$aula_id' "));
					
		?>
	    	<tr id="<?=$result_matricula->id?>">
               <td width="60"><?=$result_matricula->id?></td>
               <td width="200"><?=strtoupper($aluno->nome);?></td>
   			   <td width="65" class="mudar"><input type="checkbox" <?=$checkbox_disabled;?> <? if($aluno_presenca->presenca == '1'){echo 'checked="checked"';}?>  matricula="<?=$aluno->id?>" name="presenca[]" id="presenca"></td>
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
