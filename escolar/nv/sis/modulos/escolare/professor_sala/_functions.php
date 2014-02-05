<?
function ManipulaSalaProfessor($dados,$vkt_id){
	$professores = $dados['professor_id'];
	
	$cont=0;
	
	foreach($professores as $professor){
		
		if(!empty($professor)){
			if($dados['id'][$cont]>0){$inicio="UPDATE";$fim="WHERE id='{$dados[id][$cont]}'";}
			else{$inicio="INSERT INTO";$fim="";}
			mysql_query($t="$inicio escolar_sala_materia_professor SET 
			professor_id='$professor',
			materia_id='{$dados[materia_id][$cont]}',
			sala_id='{$dados[sala_id]}',
			limite_aula='{$dados[limite_aula][$cont]}',
			vkt_id='$vkt_id'
			$fim");
			
		}//if professor
		//echo $t;
		$cont++;
		
	}//foreach professores

}

function converte_numeros_comvirgula_em_dias_semanas($dias,$semana_abreviado){
	
	$dias = explode(',',$dias );
	
	for($i=0;$i<count($dias);$i++){
		$dias_semana[] = $semana_abreviado[$dias[$i]];	
	}
	return implode(', ',$dias_semana);
}
