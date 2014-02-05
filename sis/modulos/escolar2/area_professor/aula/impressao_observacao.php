<?php
include('../../../../_config.php');
	
	$aula_id = $_GET["aula"];
	$turma = $_GET["turma"];
	
	$sql = mysql_query(" SELECT * FROM  escolar2_obs_aluno_aula WHERE aula_id = '$aula_id' ");
	
	$turma = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_turmas WHERE id = '$turma' "));
	$horario = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$turma->horario_id' "));
	
	$professor = mysql_fetch_object(mysql_query(" SELECT funcionario.nome FROM escolar2_professor_has_turma AS professor_turma
		JOIN escolar2_professores AS professor
			ON professor_turma.professor_id = professor.id
		
		JOIN rh_funcionario AS funcionario
			ON professor.funcionario_id = funcionario.id
			
			WHERE professor_turma.vkt_id = '$vkt_id'
			AND professor_turma.turma_id = '$turma->id'
			AND professor_turma.serie_has_materia_id = '".trim($_GET["materia_id"])."'	"));
			 
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Relatório Observações</title>
<style>
	 html,body{  margin:0; padding:0;}
	 body {
	  color : #000000;
	  background : #ffffff;
	  font-family: verdana, arial, sans-serif ;
	  font-size : 12pt;
	}
	
  .conteudo{ margin:0 auto; max-width:768px; border:0px solid #666; margin-top:20px; }
  .header{ margin:2px;}
  .titulo{ padding-left:20px;line-height:30px;  }
  .conteudo table{ border-collapse:collapse;margin:0 auto; width:98%; margin-top:20px; margin-bottom:20px;}
   h4{ font-size:11pt; padding-left:10px; font-weight:inherit; }
  table, th, td{
  border-collapse:collapse;
  border: 1px solid black;
  text-align:left;
  font-size:11pt; padding:3px; text-transform:uppercase
  }
  th{
  background-color:lightgrey;
  }
  td {
  padding: 4px 4px 4px 4px ;
  font-size:10pt;
  }
  tr:nth-child(odd) {
  	background-color: #EDEDED;
  }
	
</style>
</head>

<body>
<div class="conteudo">
	<div>
    	<p class="header">
        	 <div class="titulo"><strong>Turma:</strong> <?=utf8_encode($turma->nome)?> | <strong>Horario:</strong> <?=utf8_encode($horario->nome)?> | <strong>Professor:</strong> <?=utf8_encode($professor->nome)?></div>
             
        </p>
    </div>
   	<table width="100%">
        	<thead>
            	<tr>
                	<th style="width:100px;">Aluno</th>
                    <th style="width:100px;">Observação</th>
                </tr>
            </thead>
            <!-- -->
            <tbody>
            	<?php
                	while($aula_obs = mysql_fetch_object($sql) ){
						$aluno_matricula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_matriculas AS matricula 
						JOIN escolar2_alunos AS aluno ON matricula.aluno_id = aluno.id WHERE matricula.id = '$aula_obs->matricula_aluno_id' AND matricula.status = 'matricula' ")); 
				?>
            	<tr>
                	<td > <?php echo $aluno_matricula->nome?> </td>
                    <td> <?php echo utf8_encode($aula_obs->observacao)?> </td>
                </tr>
            	<?php
					}
				?>
            </tbody>
        </table>
    </div>
</body>
</html>
