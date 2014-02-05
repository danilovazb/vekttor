<?php

if($_POST['action']== 'Salvar'){
	/*if($_POST['id']>0){
		altera_corretor($_POST);
	}else{
		insere_corretor($_POST);
	}*/
}
if($_POST['action']== 'Excluir'){
	//deletar_corretor($_POST['id']);
}
if(!$_GET[pago]){
	$pago = 'S';	
}else{
	$pago = $_GET[pago];	
}
if($_GET['periodo'] > 0){
	
	$id = $_GET['periodo'];
	
	$_matricula = mysql_query($t="SELECT *, 
							a.nome,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5)) AS age,m.id as matricula_id
								FROM escolar_matriculas AS m, escolar_alunos AS a
											
											WHERE 
												m.aluno_id = a.id
											AND 
												m.periodo_id = '$id'
											AND 
												m.pago       = '$pago'
											ORDER BY 
												age
										");
	//echo $p;
} 
if($_GET['escola'] > 0){
	
	$periodo_id  = $_GET['periodo'];
	$escola_id   = $_GET['escola'];
	
	$_matricula = 	mysql_query($t="
						SELECT *, 
						
							a.nome,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5)) AS age,m.id as matricula_id
							
							FROM escolar_matriculas AS m, escolar_alunos AS a
						
						WHERE
							 
							 m.aluno_id = a.id
							 
						AND 
							periodo_id = '$periodo_id'
						AND escola_id    = '$escola_id'
						AND pago         = '$pago'
							
							ORDER BY age
					");
}

if($_GET['curso'] > 0){
	
	$periodo_id  = $_GET['periodo'];
	$escola_id   = $_GET['escola'];
	$curso_id    = $_GET['curso'];
	
	$_matricula = 	mysql_query($t="SELECT 
				 
							*,a.nome,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5)) AS age,m.id as matricula_id
								FROM escolar_matriculas AS m, escolar_alunos AS a
						
						WHERE 
							 m.aluno_id = a.id
						AND periodo_id = '$periodo_id'
						AND escola_id    = '$escola_id'
						AND curso_id     = '$curso_id'
						AND pago         = '$pago'
							
							ORDER BY age
					");
}

if($_GET['modulo'] > 0){
	
	$periodo_id  = $_GET['periodo'];
	$escola_id   = $_GET['escola'];
	$curso_id    = $_GET['curso'];
	$modulo_id    = $_GET['modulo'];
	
	$_matricula = 	mysql_query($t="SELECT 
							*,a.nome,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5)) AS age,m.id as matricula_id
								FROM escolar_matriculas AS m, escolar_alunos AS a
						WHERE
							 m.aluno_id = a.id
						AND periodo_id ='$periodo_id'
						AND escola_id = $escola_id
						AND curso_id  = $curso_id
						AND modulo_id = $modulo_id
						AND pago      = '$pago'
						ORDER BY age
					");
}

if($_GET['horario'] > 0){
	
	$periodo_id  = $_GET['periodo'];
	$escola_id   = $_GET['escola'];
	$curso_id    = $_GET['curso'];
	$modulo_id   = $_GET['modulo'];
	$horario_id  = $_GET['horario'];
	
	$_matricula = 	mysql_query($t="SELECT 
	
					*,a.nome,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5)) AS age,m.id as matricula_id
								FROM escolar_matriculas AS m, escolar_alunos AS a
						WHERE 
								m.aluno_id = a.id
						AND horario_id   = '$horario_id'
						AND pago         = '$pago'
						ORDER BY age
						");
}

if($_GET['sala'] > 0){
	
	$sala_id     = $_GET['sala'];
	$periodo_id  = $_GET['periodo'];
	$horario_id  = $_GET['horario'];
	
	$_matricula = 	mysql_query($t="SELECT 
	
				*,a.nome,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5)) AS age,m.id as matricula_id
								FROM escolar_matriculas AS m, escolar_alunos AS a
						
						
						WHERE 
							m.aluno_id = a.id
						AND
						 sala_id      = '$sala_id'
						AND pago         = '$pago'
						ORDER BY  age
						
						");
}


?>