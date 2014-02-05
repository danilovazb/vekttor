<?

 function sql_lista_tabela($aluno_id = NULL, $filter = NULL){
	
	$filterMateria = !empty($filter) ? " AND serie_materia.id = '$filter'  " : NULL;
	
	$sql = (" 
		SELECT *, 
			materia.nome AS nome_materia, serie_materia.id AS materia_id,
			professor_turma.id AS professor_has_turma,
			turma.nome AS descricao_turma 
		FROM escolar2_matriculas AS matricula 
		
		JOIN escolar2_turmas AS turma
			ON matricula.turma_id = turma.id
		
		JOIN escolar2_professor_has_turma AS professor_turma
			ON turma.id = professor_turma.turma_id
		
		JOIN escolar2_serie_has_materias AS serie_materia
			ON professor_turma.serie_has_materia_id = serie_materia.id
		
		JOIN escolar2_materias AS materia
			ON serie_materia.materia_id = materia.id
		
		WHERE matricula.aluno_id = '$aluno_id' $filterMateria ");
		
	return $sql; 
 }
 
 function sql_option($aluno_id = NULL){
	 
	 $sql = (" 
		SELECT *, 
			materia.nome AS nome_materia, serie_materia.id AS materia_id,
			professor_turma.id AS professor_has_turma,
			turma.nome AS descricao_turma 
		FROM escolar2_matriculas AS matricula 
		
		JOIN escolar2_turmas AS turma
			ON matricula.turma_id = turma.id
		
		JOIN escolar2_professor_has_turma AS professor_turma
			ON turma.id = professor_turma.turma_id
		
		JOIN escolar2_serie_has_materias AS serie_materia
			ON professor_turma.serie_has_materia_id = serie_materia.id
		
		JOIN escolar2_materias AS materia
			ON serie_materia.materia_id = materia.id
		
		WHERE matricula.aluno_id = '$aluno_id'  ");
		
	return $sql; 
	 
 }