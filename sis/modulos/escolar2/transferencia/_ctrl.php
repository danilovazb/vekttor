<?php

//Ações do Formulário

/*if($_POST['action']=="Salvar"){
	transfere_aluno($_POST);
}*/

if($_POST['salva_formulario_contrato_cliente']== '1'){
		transfere_aluno($_POST);
}


// Seleciona
if ( $_GET['id'] > 0 ) {
	
	
	$aluno_id = $_GET['id'];

	
	$mat_atual = mysql_fetch_object(mysql_query($mt="
		SELECT *, 
			periodo_letivo.id AS periodo_id,
			periodo_letivo.nome AS nome_periodo, 
			unidade.id          AS id_unidade,
			unidade.nome        AS nome_unidade, 
			serie.nome          AS nome_serie, 
			turma.nome          AS nome_turma,
			horario.nome        AS nome_horario
		
		FROM escolar2_matriculas AS matricula
		
		JOIN escolar2_alunos AS aluno 
			ON aluno.id = matricula.aluno_id
			
		JOIN escolar2_turmas AS turma 
			ON matricula.turma_id = turma.id
			
		JOIN escolar2_series AS serie
			ON turma.serie_id = serie.id
		
		JOIN escolar2_periodo_letivo AS periodo_letivo
			ON periodo_letivo.id = turma.periodo_letivo_id
			
		JOIN escolar2_unidades AS unidade 
			ON unidade.id = turma.unidade_id 
			
		JOIN escolar2_horarios AS horario
			ON horario.id = turma.horario_id 
		
		AND 
			matricula.aluno_id = '$aluno_id'
		AND 
			matricula.status = 'matricula'    
	"));
		
	$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$aluno_id' "));
	
	$matricula = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno_id' AND situacao = 'cursando' "));
	
	$responsavel = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$matricula->responsavel_id' "));
	
	$matricula_aluno = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_matriculas WHERE id = '".$_GET['matricula_id']."' "));
	
	$matricula_turma = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_turmas WHERE id = '$matricula_aluno->turma_id' "));
	
	$matricula_serie = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_series WHERE id = '$matricula_turma->serie_id' "));
	
	$matricula_unidade = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_unidades WHERE id = '$matricula_turma->unidade_id' "));
	
	$matricula_periodo_letivo = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_periodo_letivo WHERE id = '$matricula_turma->periodo_letivo_id' "));
	
	
}

?>