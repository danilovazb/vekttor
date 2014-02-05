<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
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
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="?tela_id=231" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=231" class='s2'>
    Escolar 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Turma
</a>
</div>
<div id="barra_info">
<input type="button" name="voltar" value="&laquo;" onclick="location.href='?tela_id=259&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$_SESSION['sala']?>&sala_materia=<?=$_SESSION['sala_materia']?>'">
	Materia: <strong style="text-transform:capitalize;"><?php echo $materia;?></strong>
    <a href="modulos/escolar/area_professor/aula/form_nova_aula.php?sala_materia=<?=$_GET['sala_materia']?>" target="carregador" class="mais"></a>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Aluno</td>
           <td width="80">Total Faltas</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php									
					while($r=mysql_fetch_object($sql_sala)){	
						$aluno=mysql_fetch_object(mysql_query("SELECT * FROM escolar_alunos WHERE id = '$r->aluno_id' AND vkt_id = '$vkt_id'"));
						$sala_aula = mysql_fetch_object(
														mysql_query("SELECT count(ef.aula_id) as qtd_faltas
																		FROM escolar_sala_materia_professor as es 
																		JOIN escolar_aula as ea            
																			ON es.id=ea.sala_materia_professor_id 
																		JOIN escolar_frequencia_aula as ef 
																			ON ef.matricula_aluno_id = '$aluno->id'  and ef.aula_id=ea.id 
 																		
																		WHERE 
																			es.sala_id = '$turma' 
																		AND 
																			es.materia_id = '".$_SESSION['materia_id']."' 
																		AND 
																			es.professor_id = '$professor->id'
																		AND 
																			ef.presenca = '0' 
																		AND 
																			es.vkt_id = '$vkt_id' 
																		")
													   ); 
						
												
						
	?> 
            <tr id="<?=$r->id?>">
               <td width="40"><?=$r->id?></td>
               
               <td width="250"><?=$aluno->nome?></td>
               <td width="80"><?=$sala_aula->qtd_faltas?></td>
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
