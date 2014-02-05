<?

	function insereGrupoMateria($campos){
		global $vkt_id;
		
		$sql = mysql_query(" INSERT INTO escolar2_grupo_materia SET vkt_id = '$vkt_id', nome = '$campos[grupo_materia]' "); 
	}
	
	function updateGrupoMateria($campos){
		global $vkt_id;
		
		$sql = mysql_query(" UPDATE escolar2_grupo_materia SET vkt_id = '$vkt_id', nome = '$campos[grupo_materia]' WHERE id = '$campos[id]' "); 
	}
	
	function delete($id = NULL){
		global $vkt_id;
		
		if(!empty($id)){
			$sql = mysql_query(" DELETE FROM escolar2_grupo_materia WHERE vkt_id = '$vkt_id' AND id = '$id' ");
		}
	}