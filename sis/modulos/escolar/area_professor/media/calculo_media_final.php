<?php

				while($matricula_m=mysql_fetch_object($r_matricula)){
						$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '$matricula_m->aluno_id'"));
						
						$sala_materia_m = mysql_fetch_object(mysql_query($i="SELECT * FROM escolar_sala_materia_professor WHERE sala_id = '$sala' AND materia_id = '$materia' AND vkt_id = '$vkt_id'"));
						
						$n_avaliacao_m=mysql_query("SELECT * FROM escolar_avaliacao a WHERE sala_materia_professor_id = '$sala_materia_m->id'
														AND
															vkt_id = '$vkt_id'
														ORDER BY 
															periodicidade_id
														 
														
								");
								
								
										$soma = 0;
										$cont = 0;
										while($r_m=mysql_fetch_object($n_avaliacao_m)){
											
												 $nota_m = mysql_fetch_object(mysql_query($n="SELECT * FROM escolar_notas WHERE avaliacao_id = '$r_m->id' AND matricula_aluno_id = '$aluno->id'"));
												 $soma += $nota_m->nota;
												 
										if($nota_m->nota != NULL){
															$cont++;
													}
										}
								
								
								
								if($cont != 0){
										$media = ($soma/$cont);
										$media_final = number_format($media,2,'.',''); 
											CadastraMediaFinalAluno($sala_materia_m->id,$aluno->id,$media_final); 	 
								}
											
				} /*Fim do while principal */

?>