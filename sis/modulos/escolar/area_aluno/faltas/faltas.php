<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

$aluno_id=$_SESSION['aluno']->id;
if($aluno_id>0){
include ("_functions.php");
include ("_ctrl.php");

//$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$("select#options").live('change',function(){
	        var tela            = $(this).val();
			
			var turma      = $(this).parents().find('#sala_turma').val();
			var materia    = $(this).parents().find('#materia_id').val();
			var periodo_id = $(this).parents().find('#periodo_id').val();
			var sala_materia       = $(this).parents().find('#sala_materia').val();
				//alert(periodo_materia);
				location.href='?tela_id='+tela+'&materia='+materia+'&periodo_id='+periodo_id+'&sala='+turma+'&sala_materia='+sala_materia;
})

function selmatricula(mat){
			location.href='?tela_id=<?=$_GET['tela_id']?>&matricula='+mat.value;
}
</script>
<style>
	blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
	tbody td{ vertical-align:top; line-height:14px;}
	.cz{ color:#999999; cursor:default}
</style>
<?
//pr($_POST);
?>
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>Escolar</a>
        <a href="./" class='s2'>Área do Aluno</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Faltas<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
     <form method="get">
     <label>
	 <?php
	 	//selecionar os cursos do aluno
	 	echo "<select name='matricula' onchange='selmatricula(this)'>";
		echo "<option value='0'>SELECIONE UMA MATRÍCULA</option>";
		while($m=mysql_fetch_object($mat)){
			if($m->idmatricula==$_GET['matricula']){
				$selected='selected=selected';
			}else{
				$selected='';
			}
			echo "<option value='$m->idmatricula' $selected>$m->idmatricula - $m->escola - $m->curso - $m->modulo - $m->sala</option>";
		}
		echo "</select>";
		
	 ?>
     </label>
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
                <td width="100">Matéria</td>
                <?php
					$aulas=selecionaAulas($aluno_id,$matricula->id);
					//armazena as sala_materia_professor_id
					$sala_mat_pro=array();
					$cont_d=0;
					
					//armazena os períodos normais
					$periodos=array();
					$cont_p=0;
					
					
					while($aula=mysql_fetch_object($aulas)){
						if(!in_array($aula->periodicidade_id,$periodos)){
							$periodos[$cont_p]=$aula->periodicidade_id;
							$cont_p++;
						}	
					}
					
					foreach($periodos as $p){
						$periodo=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_periodicidade_avaliacao WHERE id=$p"));
						echo "<td width='100'>$periodo->nome</td>";
						if(!in_array($nota->sala_materia_professor_id,$sala_mat_pro)){
								$sala_mat_pro[$cont_d]=$nota->sala_materia_professor_id;
								$cont_d++;
						}
					}
				?>
                <td></td>
            </tr>
        </thead>
    </table>
    
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
    <div id="dados">
    	<?php
        	$aluno=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_matriculas WHERE aluno_id=$aluno_id AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));	
			 
			$materias=mysql_query("SELECT * FROM escolar_materias WHERE modulo_id=$aluno->modulo_id")
		?>
	  <script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            	<?
					
					while($m=mysql_fetch_object($materias)){
						echo "<tr>";
						echo "<td width='100'>$m->nome</td>";
						
						foreach($periodos as $p){
							
							//seleciona a quantidade de faltas de um determinado período e matéria
							$faltas=mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM 
																			escolar_frequencia_aula efa,
																			escolar_aula ea,
																			escolar_sala_materia_professor smp,
																			escolar_materias em
																		WHERE 
																			efa.aula_id=ea.id AND
																			ea.sala_materia_professor_id=smp.id AND
																			smp.materia_id=em.id
																			AND em.id=$m->id
																			AND ea.periodicidade_id=$p
																			AND efa.matricula_aluno_id=$aluno_id
																			AND efa.presenca='0'
																	"));
																	//echo $t."<br>";																																		
							echo "<td width='100'>$faltas->qtd</td>";
						}						
						echo "<td></td>";
						echo "</tr>";
						
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
               <td width="100%"><?=$salas?></td>
            </tr>
        </thead>
    </table>
    <script>
    $("tr:odd").addClass('al');
    </script>
</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	
    
</div>
<?php
	}
?>