<?php
	
	
	function AlteraStatus($campos){
		
		$exibe = $campos['exibe'];
		
			if($exibe == "aula")
				$tabela = "escolar2_aula";
			else 
				$tabela = "escolar2_avaliacao";
				
		$sql = " UPDATE $tabela SET $tabela.status = '".$campos['status']."' WHERE $tabela.id = '".$campos['id']."'";
		//echo $sql;
		mysql_query($sql); 
	}
	
	
	function consulta(array $array){
		
		global $vkt_id;
		$dados = array();
		
		$turma = "";
		
		if(!empty($array["aula_id"])){
			
			$id = $array["aula_id"];
			$tabela = "escolar2_aula";
		
		} if(!empty($array["avaliacao_id"])) {
			
			$id = $array["avaliacao_id"];
			$tabela = "escolar2_avaliacao";
		
		} if(!empty($array["turma_id"])){
			
			$turma = " AND turma.id = '".$array["turma_id"]."' ";
		}
		
		
		
		
		$result = mysql_fetch_object(mysql_query($ty=" SELECT *, turma.nome AS turma FROM $tabela
		JOIN 
			escolar2_professor_has_turma AS professor_turma ON professor_turma.id = $tabela.professor_as_turma_id
		JOIN
			escolar2_turmas AS turma ON turma.id = professor_turma.turma_id	
		WHERE 
			$tabela.id = '$id'
		$turma
		
		"));
		
		//=================
		$result2 = mysql_fetch_object(mysql_query(" SELECT *, materia.nome AS nome_materia FROM escolar2_serie_has_materias AS serie_materia
		JOIN
			escolar2_materias AS materia ON materia.id = serie_materia.materia_id
		WHERE 
			serie_materia.id = '$result->serie_has_materia_id'
		"));
		
		//=================	PROFESSOR	
		$result3 = mysql_fetch_object(mysql_query("SELECT *,funcionario.nome AS nome_professor FROM escolar2_professores AS professor
		JOIN
			rh_funcionario AS funcionario ON funcionario.id = professor.funcionario_id
		WHERE 
			professor.id = '$result->professor_id'	
		"));
		
		
		$dados["turma"] = $result->turma;
		$dados["materia"] = $result2->nome_materia;
		$dados["professor"] = $result3->nome_professor;
		
		return $dados;
			
	}
	

?>