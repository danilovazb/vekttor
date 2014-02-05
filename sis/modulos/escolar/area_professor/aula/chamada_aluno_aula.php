<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
	
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$("#selectAll").live('click',function(){
		var todosCheckboxes = $('.mudar').find(':checkbox');
		if($(this).is(":checked")) {
			$(todosCheckboxes).attr('checked', 'checked');
			var aula      = $("#aula").val();
			if(todosCheckboxes.is(":checked")){
				for(i=0; i < todosCheckboxes.length; i++){		
					if($(todosCheckboxes[i]).is(":checked")){
						var presenca = '1';
						var matricula = $(todosCheckboxes[i]).attr('matricula');
							var dados = 'aula='+aula+'&presenca='+presenca+'&matricula='+matricula;
							//alert(dados);
						  $.ajax({
							  url: 'modulos/escolar/area_professor/aula/recebe_presenca.php?acao=cadPresenca',
							  type: 'POST',
							  data: dados,
							  success: function(data){
								  $("#result").html(data);
							  }							
						  })/*Fim de ajax*/
					} //fim de if
				} // fim de for		
			} //fim if
		} //fim if 
		else{
			$(todosCheckboxes).removeAttr('checked');
		}
			
});


$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
});
$("#presenca").live('click',function(){
	var matricula = $(this).attr('matricula');
	var aula      = $("#aula").val();
	if($(this).is(":checked")){
		var presenca = '1';
		//alert(matricula+presenca);
	} else {
		var presenca = '0';
		//alert(matricula+presenca);
	}						  
	  var dados = 'aula='+aula+'&presenca='+presenca+'&matricula='+matricula;
	  //alert(dados);
	  $.ajax({
		  url: 'modulos/escolar/area_professor/aula/recebe_presenca.php?acao=cadPresenca',
		  type: 'POST',
		  data: dados,
		  success: function(data){
			  $("#result").html(data);
		  }							
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
    
	<span><button type="button" onclick="location.href='?tela_id=259&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$sala?>&sala_materia=<?=$_GET['sala_materia']?>'">Finalizar</button></span> 
    <!--<span style=" margin-top:10px;"><button type="button" id="selectAll">Todos</button></span>-->
    <?
    	$descricao = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula 
											WHERE vkt_id = '$vkt_id' 
											AND sala_materia_professor_id = '{$_GET['sala_materia']}'  "));
	?>
    <span><strong><?=$descricao->descricao?></strong></span>
    
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="aula" id="aula" value="<?=$aula?>">
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
    	<?php
        if($count_sala->qtd_aluno >0){
		?>
    	<tr>
            <td align="center" width="60"></td>
        	<td width="200"><strong>SELECIONAR TODOS</strong></td>
            <td width="65"><input type="checkbox" name="selectAll" id="selectAll"> </td>
            <td></td>
        </tr>
    	<?
        	
				while($result_mat=mysql_fetch_object($sql_sala)){
					$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '$result_mat->aluno_id'"));
					$aluno_presenca = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_frequencia_aula WHERE aula_id = '$aula' AND matricula_aluno_id = '$aluno->id'"));
		?>
	    	<tr>
               <td width="60"><?=$result_mat->id?></td>
               <td width="200"><?=$aluno->nome?></td>
   			   <td width="65" class="mudar"><input type="checkbox" <? if($aluno_presenca->presenca == '1'){echo 'checked="checked"';}?>  matricula="<?=$aluno->id?>" name="presenca[]" id="presenca"></td>
               <td></td>
            </tr>
         <?
				}
			} else{
				echo "<div style='margin-left:20px;'> N&atilde;o existe Aluno! </div>";	
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
