<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

		
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$("select#options").live('change',function(){
	var tela       = $(this).val();	
	var turma      = $(this).parents().find('#sala_turma').val();
	var materia    = $(this).parents().find('#materia_id').val();
	var periodo_id = $(this).parents().find('#periodo_id').val();
	var sala_materia = $(this).parents().find('#sala_materia').val();
				
	location.href='?tela_id='+tela+'&materia='+materia+'&periodo_id='+periodo_id+'&sala='+turma+'&sala_materia='+sala_materia;
});

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
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Notas<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
     <form method="get">
     <label>
	 <?
	 	$mat = mysql_query($gh="
		SELECT 
			em.id as id, 
			eu.id as unidade_id,
			et.id as turma_id,
			eu.nome as unidade,
			ee.nome as ensino,
			es.nome as serie,
			esa.nome as sala
		FROM escolar2_alunos as ea, escolar2_matriculas as em, escolar2_turmas as et, escolar2_unidades as eu, escolar2_series as es, escolar2_ensino as ee, escolar2_salas as esa
		WHERE 
			ea.usuario_id='$usuario_id' 
		AND 
			em.aluno_id = ea.id
		AND
			et.id = em.turma_id
		AND
			eu.id = et.unidade_id
		AND
			es.id = et.serie_id
		AND
			ee.id = es.ensino_id
		AND
			esa.id = et.sala_id
			");
			
	 	//selecionar os cursos do aluno
	 	echo "<select name='matricula' onchange='selmatricula(this)'>";
		echo "<option value='0'>SELECIONE UMA MATRÍCULA</option>";
		while($m=mysql_fetch_object($mat)){
			if($m->id==$_GET['matricula']){
				$selected='selected=selected';
			}else{
				$selected='';
			}
			echo "<option value='$m->id' $selected>$m->id - $m->unidade - $m->ensino - $m->serie - $m->sala</option>";
		}
		echo "</select>";
		
	 ?>
     </label>
     </form>
    </div>
    <?
	if($_GET['matricula']>0){
	$sql_fim="AND em.id='{$_GET['matricula']}'";
	}else{
		$sql_fim=" ORDER BY em.id DESC LIMIT 1 ";
	}
	$mat_q = mysql_query($a="
			SELECT 
				em.id as id, 
				eu.id as unidade_id,
				et.id as turma_id,
				es.id as serie_id,
				eu.nome as unidade,
				ee.nome as ensino,
				es.nome as serie,
				esa.nome as sala
			FROM escolar2_alunos as ea, escolar2_matriculas as em, escolar2_turmas as et, escolar2_unidades as eu, escolar2_series as es, escolar2_ensino as ee, escolar2_salas as esa
			WHERE 
				ea.usuario_id='$usuario_id' 
			AND 
				em.aluno_id = ea.id
			AND
				et.id = em.turma_id
			AND
				eu.id = et.unidade_id
			AND
				es.id = et.serie_id
			AND
				ee.id = es.ensino_id
			AND
				esa.id = et.sala_id
			$sql_fim
			");
	 	$matricula=mysql_fetch_object($mat_q);
		echo mysql_error();
	?>
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
       
    </table>
    
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
    <div id="dados">
    	<?php
			$materias_q=mysql_query(" SELECT * FROM escolar2_serie_has_materias as es, escolar2_materias as em 
			WHERE 
				es.vkt_id='$vkt_id' 
			AND 
				es.serie_id='{$matricula->serie_id}' 
			AND 
				em.id = es.materia_id ");
			echo mysql_error();
		?>
	  <script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">    
            <tbody>
             <thead>
            <tr>
                <td>Matérias</td>
                <? 
				$n_avaliacoes_cache=array();
				
				$periodos_avaliacao_q=mysql_query("
				SELECT periodoAvaliacao.nome FROM 
					escolar2_periodos_avaliacao AS periodoAvaliacao 
				
				JOIN escolar2_avaliacao_bimestre AS avaliacaoBimestre
					ON periodoAvaliacao.id = avaliacaoBimestre.bimestre_id
				WHERE 
					periodoAvaliacao.vkt_id='$vkt_id' AND periodoAvaliacao.unidade_id='{$matricula->unidade_id}' 
					GROUP BY avaliacaoBimestre.bimestre_id  ORDER BY avaliacaoBimestre.ordem ASC  ");
				
				while($p=mysql_fetch_object($periodos_avaliacao_q)){
					
					$n_avaliacoes=mysql_fetch_object(mysql_query($a="SELECT COUNT(*) as qtd_max_avaliacoes FROM escolar2_avaliacao 
					WHERE vkt_id='$vkt_id' AND avaliacao_bimestre_id='{$p->id}' GROUP BY professor_as_turma_id ORDER BY COUNT(*) DESC LIMIT 1"));
					
					$n_avaliacoes_cache[$p->id]=$n_avaliacoes->qtd_max_avaliacoes;
					?>
                    <td colspan="<?=$n_avaliacoes->qtd_max_avaliacoes+2?>"><?=$p->nome?></td>
                    <?
				}
				?>
                <td></td>
            </tr>
        </thead>
            <tr>
            	<td style="background-color:#666 !important; color:white;">Avaliações</td>
                <?
                $periodos_avaliacao_q=mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' AND unidade_id='{$matricula->unidade_id}' ");
				while($p=mysql_fetch_object($periodos_avaliacao_q)){
					$n_avaliacoes=mysql_fetch_object(mysql_query($a="SELECT COUNT(*) as qtd_max_avaliacoes FROM escolar2_avaliacao WHERE vkt_id='$vkt_id' AND avaliacao_bimestre_id='{$p->id}' GROUP BY professor_as_turma_id ORDER BY COUNT(*) DESC LIMIT 1"));
					for($i=0;$i<$n_avaliacoes_cache[$p->id];$i++){
						
						?>
						<td style="background-color:#666 !important; color:white;"><?=$i+1?>ª</td>
						<? 
					}
					?>
                    <td style="background-color:#666 !important; color:white;">Faltas</td>
                    <td style="background-color:#666 !important; color:white;">Média</td>
                    <?
				} ?>
                <td style="background-color:#666 !important; color:white;"></td>
            </tr>
            <?
            $materias_q=mysql_query("SELECT em.nome as nome, esm.id as serie_has_materia_id, em.id as materia_id FROM escolar2_serie_has_materias as esm, escolar2_materias as em WHERE esm.vkt_id='$vkt_id' AND esm.serie_id='$matricula->serie_id' AND em.id=esm.materia_id ");
			while($materia=mysql_fetch_object($materias_q)){
				
			?>
            	<tr>
                	<td><?=$materia->nome?></td>
                    <?
                
				$periodos_avaliacao_q=mysql_query("
				SELECT *, avBimestre.id avaliacao_bimestre_id  FROM escolar2_periodos_avaliacao AS periodoAV 
				
				JOIN escolar2_avaliacao_bimestre AS avBimestre
					ON periodoAV.id =  avBimestre.bimestre_id
				WHERE 
					periodoAV.vkt_id='$vkt_id' 
				AND 
					periodoAV.unidade_id='{$matricula->unidade_id}' GROUP BY avBimestre.bimestre_id ORDER BY avBimestre.ordem ASC  ");
				
				while($p=mysql_fetch_object($periodos_avaliacao_q)){
					$avaliacoes_q=mysql_query($a="
					SELECT *, et.id as professor_has_turma_id 
					FROM escolar2_avaliacao as ea, escolar2_professor_has_turma as et 
					WHERE 
						ea.vkt_id='$vkt_id' AND ea.avaliacao_bimestre_id='{$p->avaliacao_bimestre_id}' 
					AND 
						et.id = ea.professor_as_turma_id 
					AND 
						et.turma_id='{$matricula->turma_id}' 
					AND 
						et.serie_has_materia_id='{$materia->serie_has_materia_id}' ORDER BY ea.data ASC ");
					$num_avaliacao=0;
					
					while($avaliacao=mysql_fetch_object($avaliacoes_q)){
					?>
                    <td><?=rand(0,10)?></td>
                    <?
						$num_avaliacao++;
					}
					$td_restante=$n_avaliacoes_cache[$p->id]-$num_avaliacao;
					for($i=0;$i<$td_restante;$i++){
					?>
                    <td> s/ avaliação</td>
                    <?
					}
					$faltas=mysql_query($f="
					SELECT COUNT(fa.id) 
					FROM 
						escolar2_frequencia_aula as fa, 
						escolar2_aula as a, 
						escolar2_professor_has_turma as et 
					WHERE 
						fa.matricula_aluno_id='$matricula->id' 
					AND
						fa.aula_id=a.id
					AND 
						a.vkt_id='$vkt_id' 
					AND 
						a.professor_as_turma_id = et.id
					AND
						a.periodicidade_id='$p->id'
					AND
						et.id='$avaliacao->professor_has_turma_id'
					AND
						fa.status='1'
					GROUP BY
						fa.presenca
					ORDER BY fa.presenca ASC
						");
					
					?>
                        <td><?=$f?></td>
                        <td>10</td>
                        <?
                        
					}
                    ?>
                </tr>
              <?
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