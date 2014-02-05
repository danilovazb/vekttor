<?php
include('../../../../_config.php');
include("../../../../_functions_base.php");

	if($_GET['acao'] == 'cadNota'){
			
				
			$avaliacao = $_POST['avaliacao'];	
			$nota      = $_POST['nota'];
			$matricula = $_POST['matricula'];
				
				if($nota == NULL){
					mysql_query(" DELETE FROM escolar_notas WHERE avaliacao_id = '$avaliacao' 
																AND 
																	matricula_aluno_id = '$matricula' 
																AND 
																	status = '2' 
																AND 
																	vkt_id = '$vkt_id'	
																	");	
				}
				
				$nova_nota = limitador_decimal_usa($nota);
				if($nota != NULL and is_numeric($nova_nota)){
				
				
				$sql_vrq=mysql_fetch_array(mysql_query($sr=" SELECT * FROM escolar_notas 
																WHERE 
																	avaliacao_id = '$avaliacao' 
																AND 
																	matricula_aluno_id = '$matricula' 
																AND 
																	status = '2'
																AND 
																	vkt_id = '$vkt_id' "));
						    echo $sr;
							$rows = count($sql_vrq);
							echo $rows;
						if($rows > 1){
									
									$sql_update = " UPDATE  escolar_notas SET nota = '$nova_nota' WHERE avaliacao_id = '$avaliacao'
												AND 
													matricula_aluno_id = '$matricula'
												AND 
													status = '2'
												AND 
													vkt_id = '$vkt_id' ";
									//echo $sql_update;
									mysql_query($sql_update);
									
						} else{
							$sql_insert = "INSERT INTO  escolar_notas
										   SET
											avaliacao_id       = '$avaliacao',
											matricula_aluno_id = '$matricula',
											nota               = '$nova_nota', 
											status             = '2',
											vkt_id             = '$vkt_id'
							";
							mysql_query($sql_insert);											    
							//mysql_query(" UPDATE escolar_avaliacao SET status = '1' WHERE id = '$avaliacao' AND vkt_id = '$vkt_id'");
							echo $sql_insert;
						} //fim de else
							
						mysql_query(" UPDATE escolar_avaliacao SET status = '1' WHERE id = '$avaliacao' AND vkt_id = '$vkt_id'");
							
				} //fim de if
	}
?>