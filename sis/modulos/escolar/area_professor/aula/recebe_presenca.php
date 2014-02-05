<?php
include('../../../../_config.php');
		if($_GET['acao'] == 'cadPresenca'){
						
						$aula      = $_POST['aula'];
						$matricula = $_POST['matricula'];
						$presenca  = $_POST['presenca'];
						$sql_vrq=mysql_fetch_array(mysql_query($s=" SELECT * FROM escolar_frequencia_aula
																	WHERE 
																		aula_id = '$aula'
																	AND
																		matricula_aluno_id = '$matricula'
																	AND
																		status = '1' "));
						
						
							
							$rows = count($sql_vrq);
							echo $s.'<br/>';
							echo $rows;
							
							
							if($rows > 1){
									$sql_update = "
													UPDATE escolar_frequencia_aula
															SET
																presenca           = '$presenca'
															WHERE 
																matricula_aluno_id = '$matricula'
															AND 
																aula_id            = '$aula'
															AND
																status = '1' 
												
									";	
											echo $sql_update;
											mysql_query($sql_update);
											mysql_query(" UPDATE escolar_aula SET status = '1' WHERE id = '$aula' ");							
							} else{
										$sql_insert = "
							
													INSERT INTO escolar_frequencia_aula
															SET
																aula_id            = '$aula',
																matricula_aluno_id = '$matricula',
																presenca           = '$presenca',
																status             = '1'  					
										";	
							echo $sql_insert;
							mysql_query($sql_insert);
							
									//$sql_delete = mysql_query(" DELETE FROM escolar_frequencia_aula WHERE matricula_aluno_id = '$matricula' AND presenca = '0'");
									mysql_query(" UPDATE escolar_aula SET status = '1' WHERE id = '$aula' ");
									//echo "<br>".$ip;
								
							}
		}
?>