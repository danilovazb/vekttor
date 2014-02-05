<?php


	function consulta_materia($materia){
				global $vkt_id;
			$sql_m = " SELECT * FROM escolar_materias WHERE id = '$materia' AND vkt_id = '$vkt_id' ";
			//echo $sql_m;
			$nome_materia = mysql_fetch_object(mysql_query($sql_m));
			return $nome_materia->nome;
	}
	
	function altera_avaliacao($campos){
		global $vkt_id;
			$sql_update = " UPDATE escolar_avaliacao
							 SET
									 descricao        = '$campos[descricao]',
									 data             = '".dataBrToUsa($campos[data_avaliacao])."',
									 obs              = '$campos[obs]',
									 periodicidade_id = '$campos[periodicidade_id]'
							 WHERE 
							 		id = '$campos[id]'
							 AND 
							 		vkt_id = '$vkt_id'
							 	
			";
			//echo $sql_update;
			mysql_query($sql_update);
	}
	
	function deletar_avaliacao($id){
		global $vkt_id;
				$sql_consulta_notas = mysql_query("SELECT * FROM escolar_notas WHERE avaliacao_id = '$id' AND vkt_id = '$vkt_id'");
						
							while($result_nota=mysql_fetch_array($sql_consulta_notas)){
											$count = count($result_nota);
							}
							//echo $count;
							if($count > 0){
										echo "<script>
													alert('Existem Pendencias em Notas');
										      </script>";
							} else{
								$sql = mysql_query(" DELETE FROM escolar_avaliacao WHERE id = '$id' AND vkt_id = '$vkt_id'");
							}
					
	}
	
	function insere_avaliacao($campos){
		
				global $vkt_id;
					$sql_insert = " 
								INSERT INTO escolar_avaliacao
										SET
										 sala_materia_professor_id = '$campos[periodo_materia_id]',
										 descricao                 = '$campos[descricao]',
										 obs                       = '$campos[obs]',
										 data                      = '".dataBrToUsa($campos[data_avaliacao])."',
										 vkt_id                    = '$vkt_id',
										 periodicidade_id          = '$campos[periodicidade_id]',
										 status                    = '0' 
								
							";
							//echo $sql_insert;
							mysql_query($sql_insert);
	}

?>