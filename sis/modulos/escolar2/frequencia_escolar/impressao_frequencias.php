<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	global $vkt_id;
	$periodo_avaliacao_id = $_GET['periodo_id'];
	$periodo_avaliacao = mysql_fetch_object(mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE id='$periodo_avaliacao_id'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Frequência Escolar</title>
<style>
	#content{
		
		width: 1000px;
		height: 500px;
		margin-bottom:20px;
		margin-left:auto;
		margin-right:auto;
		border: solid 1px #000000;
		padding-top:20px;
		font-size:14px;
	}
	#header{
		width:90%;
		margin-left:auto;
		margin-right:auto;
	}
	table{
		width:90%;
		margin-top:30px;
		border-collapse:collapse;
		margin-left:auto;
		margin-right:auto;
		font-size:11px;
	}
	table tr td{
		border: solid 1px #000000;
		
	}
</style>
</head>

<body>
<?php
	$ensinos = mysql_query("SELECT * FROM escolar2_ensino WHERE vkt_id='$vkt_id'");
	
		while($ensino=mysql_fetch_object($ensinos)){	
					
					$horarios = mysql_query("SELECT * FROM escolar2_horarios WHERE vkt_id='$vkt_id'");
					
					while($horario= mysql_fetch_object($horarios)){
						
						$turmas = mysql_query($t="SELECT *, et.id as turma_id, et.nome as nome_turma FROM 
													escolar2_turmas et,
													escolar2_series es,
													escolar2_ensino ens
												WHERE
												et.vkt_id='$vkt_id' AND 
												et.serie_id = es.id AND
												es.ensino_id = ens.id AND
												ens.id = '$ensino->id' AND 
												et.horario_id='$horario->id' ORDER BY 
												et.nome");
						
						if(mysql_num_rows($turmas)>0){
						//echo $ensino->nome."<br>";
						//echo "&nbsp;&nbsp;".$horario->nome."<br>";
						while($turma = mysql_fetch_object($turmas)){
							$materias_turma = mysql_query($t="
							SELECT 
								*, em.id as materia_id, em.nome as nome_materia 
							FROM 
								escolar2_serie_has_materias shm,
								escolar2_materias em,
								escolar2_series es,
								escolar2_turmas et
							WHERE
								shm.vkt_id ='$vkt_id' AND
								shm.serie_id = es.id AND
								shm.materia_id = em.id AND
								et.serie_id = es.id AND
								et.id = '$turma->turma_id'");	
								while($materia_turma = mysql_fetch_object($materias_turma)){
								echo $materia_turma->professor->id;	
									 
								$aulas = mysql_query($t="SELECT *, ea.id as aula_id FROM 
												escolar2_aula ea,
												escolar2_professor_has_turma pht,
												escolar2_serie_has_materias shm
											WHERE 
												ea.vkt_id='$vkt_id' AND
												ea.professor_as_turma_id = pht.id AND
												pht.serie_has_materia_id = shm.id AND
												ea.periodicidade_id='$periodo_avaliacao->id' AND
												pht.turma_id = '$materia_turma->id' AND
												shm.materia_id = '$materia_turma->materia_id'
												ORDER BY ea.data
												");
								
		
					$aulas_turma_materia = array();
					$c=0;
					if(mysql_num_rows($aulas)>0){
				 	$alunos=mysql_query("SELECT *, em.id as matricula_aluno_id FROM 
							escolar2_matriculas em,
							escolar2_alunos ea
							WHERE 
							em.turma_id='$materia_turma->id' AND
							em.aluno_id=ea.id AND
							em.vkt_id='$vkt_id'");
				if(mysql_num_rows($alunos)>0){
					
					$professor_turma = mysql_result(mysql_query($t="SELECT 
																	rf.nome as nome_professor 
																FROM 
																	escolar2_professor_has_turma pht,
																	escolar2_serie_has_materias shm,
																	escolar2_professores ep,
																	rh_funcionario rf
																WHERE
																	pht.professor_id = ep.id AND
																	ep.funcionario_id = rf.id AND
																	pht.serie_has_materia_id = shm.id AND
																	shm.materia_id = '$materia_turma->materia_id' AND
																	pht.turma_id='$turma->turma_id'"),0,0);
?>
				<div id="content">
	<div id="header">
    	<div style="float:left">
    		<img src="../../vekttor/clientes/img/<?=$vkt_id?>.png">
    	</div>
		<div style="float:left" style="padding-top:5px;height:100%">
			<strong><?=strtoupper($empresa[nome])?></strong>
			<div style="clear:both"></div>
    		<strong>Lista de Chamada</strong>
    		<div style="clear:both"></div>
    		<strong>Curso:</strong> <?=$ensino->nome?> <strong>Horário:</strong> <?=$horario->nome?>
            <div style="clear:both"></div>
    		<strong>Turma:</strong> <?=$turma->nome_turma?>
    		<div style="clear:both"></div>
    		<strong>Período:</strong> <?=$periodo_avaliacao->nome." - De ".DataUsaToBr($periodo_avaliacao->data_inicio)." até ".DataUsaToBr($periodo_avaliacao->data_final)?>
        	<div style="clear:both"></div>
    		<strong>Matéria:</strong> <?=$materia_turma->nome_materia?> 
            <div style="clear:both"></div>
    		<strong>Professor:</strong> <?=$professor_turma?> 
    	</div>
    </div>
    <div style="clear:both"></div>


    <div class="pagela">
		<table>
            <tr>
                <td width="220">Aluno</td>
				<?php
					while($aula = mysql_fetch_object($aulas)){
						echo "<td width='40'>".substr(DataUsaToBr($aula->data),0,5)."</td>";
						$aulas_turma_materia[$c] = $aula->aula_id;
						$c++;
					}
				?>
             <td></td>
             </tr>

<?				
				while($aluno=mysql_fetch_object($alunos)){
			 ?>
             	<tr align="center">
             		<td  align="left"><?=$aluno->nome?></td>
             		
					<?php
                    	foreach($aulas_turma_materia as $aula_materia){
							$frequencia = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_frequencia_aula WHERE aula_id='$aula->aula_id' AND matricula_aluno_id='$aluno->matricula_aluno_id'"));
							echo "<td align='center'>";
								if($frequencia->presenca=='1'){ echo "P";}else{echo "F";}
							echo "</td>";
						}
                    ?>
                    <td></td>
                </tr>
			 <?php
				}//while aluno
			 ?>
         </table>	
	 </div>
</div>
<?php
								}//materias
					}//if aluno
								}

						}//turma
						
						}//if
					}//horario
		}//ensino
?>
	

</body>
</html>