<?php


	function consulta_materia($materia){
		
			$sql_m = " SELECT * FROM escolar_materias WHERE id = '$materia'";
			//echo $sql_m;
			$nome_materia = mysql_fetch_object(mysql_query($sql_m));
			return $nome_materia->nome;
	}
	
	function altera_aula($campos){
			$sql_update = " UPDATE escolar_aula
										SET
									 descricao = '$campos[descricao]',
									 obs       = '$campos[obs]',
									 data      = '".dataBrToUsa($campos[data_aula])."'
							 WHERE 
							 		id = '$campos[id]'
							 	
			";
			mysql_query($sql_update);
	}
	
	function deletar_aula($id){

		$sql = mysql_query(" DELETE FROM escolar_aula WHERE id = '$id' ");	
	}
	
	function insere_aula($campos){
		
				global $vkt_id;
					$sql_insert = " 
								INSERT INTO escolar_aula
										SET
										 sala_materia_professor_id = '$campos[sala_materia]',
										 descricao                 = '$campos[descricao]',
										 data                      = '".dataBrToUsa($campos[data_aula])."',
										 obs                       = '$campos[obs]',
										 vkt_id                    = '$vkt_id',
										 status                    = '0' 
								
							";
							//echo $sql_insert;
							mysql_query($sql_insert);
	}

?>