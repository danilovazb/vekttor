<?
?>
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
	$('#modulo_mais').live('click',function(){
			var html = $('<div> <label>Materia<input type="text" name="nome" size="30"></label></div><div style="clear:both"></div>');
			$("#result_mateira").append(html);
	});
$(document).ready(function(){
	$("#tabela_dados tr td#descricao").live("click",function(){
		var id = $(this).parent().attr('id');
			//alert(id);
		window.open('modulos/escolar/area_professor/aula/form_nova_aula.php?id='+id,'carregador');
	});
})
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'><a href="?tela_id=231" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=231" class='s2'>
    Escolar 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Turmas
</a>
</div>
<div id="barra_info">
<select >

<?

?>
<option>Matricula: 2344 - Escolar - Curso - Modulo - Turma</option>
</select>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Materias</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
    		$sql_aula = mysql_query(" SELECT * FROM escolar_aula 
											WHERE vkt_id = '$vkt_id' 
											AND sala_materia_professor_id = '{$_GET['sala_materia']}'  ");
											
					while($r=mysql_fetch_object($sql_aula)){
	?> 
            <tr id="<?=$r->id?>">
               <td width="40"><?=$r->id?></td>
               <td width="250" id="descricao"><?=$r->descricao?></td>
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
           <td width="230">&nbsp;</td>
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
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
