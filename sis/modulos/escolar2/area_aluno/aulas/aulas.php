<?php
include("_functions.php");

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;
$info_aluno =  mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE usuario_id = '$usuario_id' "));
	
	$busca_materia = !empty($_GET["materia_id"]) ? $_GET["materia_id"] : NULL; 
	
	$sql_lista_table = sql_lista_tabela($info_aluno->id,$busca_materia);
	
		
		$sql_option = sql_option($info_aluno->id);
	
	$turma =  mysql_fetch_object(mysql_query($t="SELECT *, 
			turma.nome AS descricao_turma, horario.nome AS nome_horario 
		FROM escolar2_matriculas AS matricula 
		
		JOIN escolar2_turmas AS turma
			ON matricula.turma_id = turma.id
			
		JOIN escolar2_horarios AS horario
			ON turma.horario_id = horario.id
		
		WHERE matricula.aluno_id = '$info_aluno->id'"));
		
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"> 
$(function(){
	$("tr:odd").addClass('al');
	
	$("#click_aula").live("click",function(){
		window.open("modulos/escolar2/area_aluno/aulas/form.php?aula_id="+$(this).closest("tr").attr("id")+"","carregador");
	});
	
	$("#materia_id").live("change",function(){
		$("form#form_filtro").submit();
	}); 
});
</script>
<style>
.icon-up small{ color:#999; float:right; margin-top:2px; font-weight:400;}
</style>
<div id="conteudo">

<!--
  ///////////////////////////////////////
  Barra de Navegação
  ///////////////////////////////////////
-->

<div id="navegacao"> 
   <div id="some">«</div>
    <a href="#" class='s1'> SISTEMA </a>
    <a href="./" class='s1'> Escolar </a>
    <a href="./" class='s2'>Área do Aluno</a>
    <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"> Aulas <span></span></a>
</div>  
<!--
  ///////////////////////////////////////
  Barra de Ações
  ///////////////////////////////////////
-->
    <div id="barra_info"> 
    <div style="float:left;"> <strong> Turma: </strong> <?=$turma->descricao_turma?> &nbsp; <strong>Horário:</strong> <?=$turma->nome_horario?> </div>  &nbsp;  &nbsp;
    <form method="get" style="float:left; margin-top:3px; margin-left:8px;" id="form_filtro">
     	<select name="materia_id" id="materia_id">
        	<option value="0"><strong>Selecione Matéria</strong></option>
        	<?php
            	$sql_option = mysql_query($sql_option);
				while($op_materia = mysql_fetch_object($sql_option)){
					
					if( $_GET["materia_id"] == $op_materia->materia_id ) $sel = 'selected="selected"'; else $sel = ''; 
			?>    
            <option <?=$sel?> value="<?=$op_materia->materia_id?>"><?=$op_materia->nome_materia?></option>
        	<?php
				}
			?>
        </select>
        <input type="hidden" name="tela_id" value="<?=$_GET[tela_id]?>" />
     </form>
     
    </div>
<!--
  ///////////////////////////////////////
  Cabeçalho da tabela
  ///////////////////////////////////////
-->
    <table cellpadding="0" cellspacing="0" width="100%">
    	<thead>
    		<tr>
		   		<!--<td width="50"> N&deg; </td>-->
                <td width="200"> Aulas </td>
                <td width="80"> Data </td>
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
    <table cellpadding="0" cellspacing="0" width="100%">    
       <tbody>
        <?
			$info_aula = mysql_query($sql_lista_table);
			
        	while($aula=mysql_fetch_object($info_aula)){
		?> 
        
        <tr>
        	<!--<td width="50"></td>-->
            <td width="200"><b><?=strtoupper($aula->nome_materia);?></b></td>
            <td width="80"><!-- Data --></td>
        	<td>&nbsp;</td>
        </tr>
		<?
			$sql_aulas = mysql_query($sa=" SELECT *, aula.id AS aula_id FROM escolar2_aula AS aula
				JOIN escolar2_professor_has_turma AS professor_turma
					ON aula.professor_as_turma_id = professor_turma.id
				WHERE aula.vkt_id = '$vkt_id'
				AND professor_turma.id = '$aula->professor_has_turma' ");
				
				$contAula = 0;	
				while($aulas_materia = mysql_fetch_object($sql_aulas)){ 
				$contAula++;
				
				$upload = mysql_fetch_object(mysql_query($po=" SELECT count(*) AS qtd FROM escolar2_upload WHERE aula_id = '$aulas_materia->aula_id' ")); 
				
				$icon = !empty($upload->qtd) ? '<span style="float:right;padding-right:5px;" class="icon-up"> <img src="../fontes/img/clip-small.png">  ' : NULL;    		
		?>        
                <tr id="<?=$aulas_materia->aula_id?>">
                  <!--<td width="50"></td>-->
                  <td width="200" id="click_aula"><div style="padding-left:15px;"><?=strtolower($aulas_materia->descricao);?>  <?=$icon?> </div></td>
                  <td width="80"> <?=dataUsaToBr($aulas_materia->data);?><!-- Data --></td>
                  <td>&nbsp;</td>
                </tr>
        <?
				}
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
           <td width="100%"></td>
           
        </tr>
    </thead>
</table>
    
</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape"></div>