<?php
function consulta_materias($dados){
	
	global $vkt_id;
	
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
			et.id = $dados[turma_id]");
		
		$t="Materia: <select name='materia_id' id='materia_id'>";
		
		while($materia_turma = mysql_fetch_object($materias_turma)){
			$t.="<option value='$materia_turma->materia_id'>$materia_turma->nome_materia</option>";
		}
		
		$t.="</select>";
		
		return utf8_encode($t);
}
?>