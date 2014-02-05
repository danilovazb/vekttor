<?php


	function CadastraMediaFinalAluno($smp_id,$aluno_id,$media){
					
					
					$sql_vrq = mysql_fetch_array(mysql_query(" SELECT * FROM escolar_media_final
										WHERE 
											aluno_id = '$aluno_id'
										AND
											sala_materia_professor_id = '$smp_id'
										AND	
											status = '1' "));
					$rows = count($sql_vrq);
					
					if($rows > 1){
										$sql_update = "UPDATE  escolar_media_final
													SET
														media_final = '$media'
													WHERE
														id = '$sql_vrq[id]'
													AND 
														status = '1'
										";
										//echo $sql_update;
										mysql_query($sql_update);
										//echo $sql_update;
					} //fim de if
					
					else{
			
							$sql_insert=" INSERT INTO escolar_media_final
													SET
														sala_materia_professor_id = '$smp_id',
														aluno_id                  = '$aluno_id',
														media_final               = '$media',
														status                    = '1'
														
							";
							mysql_query($sql_insert);
					}
	} /* Fim da Funcao */
	
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
									 data      = '".dataBrToUsa($campos[data_avaliacao])."'
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
										 sala_materia_professor_id = '$campos[periodo_materia_id]',
										 descricao                 = '$campos[descricao]',
										 data                      = '".dataBrToUsa($campos[data_aula])."',
										 vkt_id                    = '$vkt_id',
										 status                    = '0' 
								
							";
							//echo $sql_insert;
							mysql_query($sql_insert);
	}

?>