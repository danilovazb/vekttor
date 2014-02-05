<?php
include('Config.class.php');

	class EleitoralSMSController{
		
			public function listagem($id = NULL){
				
						$statusSMS = new Eleitoral_SMS_Model;
						
						if(!empty($id)){						
							
							$dados = $statusSMS->listar($id);
							
						} else{
							
							$dados = $statusSMS->listar();
							
						}
						return $dados;		
					
			}
			
			public function listagem_data($inicio,$fim){
				
						$statusSMS = new Eleitoral_SMS_Model;
						
							
							$d_inicio = $statusSMS->DataToUsa($inicio);
							
							$d_fim = $statusSMS->DataToUsa($fim);
							
							
							$dados = $statusSMS->lista_por_data($d_inicio,$d_fim);
							
							return $dados;
						
						
			}
			
			
			
			public function DateTime($datetime){
						
						$statusSMS = new Eleitoral_SMS_Model;
						
							$statusSMS->DataToBr($datetime);
			}
			
			public function SMSDisponivel($vkt_id){
				
					$statusSMS = new Eleitoral_SMS_Model;
					
						$dados = $statusSMS->Disponivel($vkt_id);
						
						return $dados;
					
				
			} /* Fim Do Metodo */
			
			public function NumeroEleitores(){
			
				$statusSMS = new Eleitoral_SMS_Model;
				
							$rows = $statusSMS->Eleitores();
							
							return $rows;
				
			}
			
			public function NumeroPoliticos(){
			
				$statusSMS = new Eleitoral_SMS_Model;
				
							$rows = $statusSMS->Politicos();
							
							return $rows;
				
			}
			public function SelectNumTable($id,$table){
			
				$statusSMS = new Eleitoral_SMS_Model;
				
							$rows = $statusSMS->ReturnNumSQL($id,$table);
							
							return $rows;
				
			}
			
			public function Enviados(){
					
						$statusSMS = new Eleitoral_SMS_Model;
							
							$total = $statusSMS->TotalEnviados();
							
								return $total;	
			}
			
			
			public function BuscaTodosColaborador($colaborador = NULL){
				
						$statusSMS = new Eleitoral_SMS_Model;
					
								$dados = $statusSMS->Colaborador();
								
									 return $dados;	
				
			} /* Fim do Metodo */
			
			
			public function AddEleitoralSMS($msg,$vkt,$eleitor,$politico,$colaborador){
				
						$statusSMS = new Eleitoral_SMS_Model;
						
							$id_mensagem = $statusSMS->AddEleitoralSMSModel($msg,$vkt,$eleitor,$politico,$colaborador);
							
							return $id_mensagem;
						
						//print_r($dados);
				
			}
			
			/**/
			
			public function VerificaNumMsg($id,$grupo,$table){
				
						$statusSMS = new Eleitoral_SMS_Model;
						
								$total = $statusSMS->Verifica_Num_Msg($id,$grupo,$table);
								
								return $total;
								
								
			}
			
			public function SelectTableWhere($table = NULL,$coluna = NULL, $id = NULL,$tipo){
				
						$statusSMS = new Eleitoral_SMS_Model;
						
										$dados = $statusSMS->ReturnTableWhere($table,$coluna,$id,$tipo);
										
										return $dados;
						
				
			}
			
			
			public function VerificaEnvio(array $dados, $disponivel,$id_mensagem,$vkt,$msg){
				
							$config = new Config;
				
						$statusSMS = new Eleitoral_SMS_Model;
						
											$i = 0;
											$j = 0;
												
											foreach($dados as $id => $lista){
													$i++;
														if($i <= $disponivel){
																
																foreach($lista as $l){
																	$j++;
																	if($j <= $disponivel){
																		
																		
																$sql = mysql_query($t=" INSERT INTO eleitoral_sms_envios SET $id='$l', eleitoral_sms_id='$id_mensagem' ");		
																		//echo $t;
																		
																	} 																		
																			
																}
														} 
													$i=$j;
											}
											
											
									/* faz uma consulta na tabela eleitoral_sms_envios para pegar somente os os foram enviados */		
									$sql2 = mysql_query(" SELECT * FROM eleitoral_sms_envios WHERE eleitoral_sms_id = ".$id_mensagem);
											
													while($r=mysql_fetch_array($sql2)){
																	//if($r['eleitor_id'] != 0)
																		$dadosInseridos['eleitor_id'][] = $r['eleitor_id'];
																		
																	//if($r['politico_id'] != 0)
																		$dadosInseridos['politico_id'][]    = $r['politico_id'];
																	
																	//if($r['colaborador_id'] != 0)
																		$dadosInseridos['colaborador_id'][] = $r['colaborador_id'];			
													}
													
													
													foreach($dadosInseridos as $id => $lista){
														
																	if($id == 'eleitor_id'){
																		
																			foreach($lista  as $e){
																				
																				if($e != 0){
																				
																					$rows = $this->SelectTableWhere('eleitoral_eleitores','id',$e,1);
																					
																						foreach($rows as $eleitor_envio){
																									$caracter = array('-',')','(',' ','+');
											 														$telefone[] = str_replace($caracter,'',$eleitor_envio->telefone1);
																						}
																				}
																				
																			}	
																	}
																	
																	if($id == 'politico_id'){
																		
																		
																			foreach($lista  as $p){
																				
																				if($p != 0){
																						
																						$rows = $this->SelectTableWhere('eleitoral_politicos','id',$p,1);
																						
																							foreach($rows as $politico_envio){
																									
																										$caracter = array('-',')','(',' ','+');
											 															$telefone[] = str_replace($caracter,'',$politico_envio->telefone1);
																							}
																				}
																						
																			}
																		
																	}
																	
																	if($id == 'colaborador_id'){
																		
																			foreach($lista as $c){
																				
																				if($c != 0){
																						$rows = $this->SelectTableWhere('eleitoral_colaboradores','id',$c,1);
																						
																							foreach($rows as $colaborador_envio){
																										$caracter = array('-',')','(',' ','+');
											 															$telefone[] = str_replace($caracter,'',$colaborador_envio->telefone1);
																							}
																				}
																				
																			}
																		
																	}
													}
													$nenvio = count($telefone);
													
																		/* Caso Modem Seta o ip do servidor e port do modem */
																		//$config->SetHostEnvio('10.0.1.109'); /* Servidor*/
																		//$config->SetPortEnvio('8800');       /* Modem */
																		
																		/*
																		*	Modo de Envio do Servidor   1 = Modem , 2 = ComTele
																		*/
																		//$config->SetServidorEnvio(1);
														
															if($nenvio <= $disponivel){
																	
																		/*foreach($telefone as $fone){
																			$return = $config->SMSEnvia($vkt,$fone,$msg);
																		}*/
																		
																		//if($return == true){
																			//	echo "<div>Mensagem Enviada</div>";
																					
																		//}	
																		echo "<div>Mensagem Enviada</div>";
															} else{
																	echo "<div> Voce nao tem credito suficiente </div>";	
															}
															
															
															
													return($dadosInseridos);
											
											
				
				
			} /* Fim do Metodo */
			
			
			public function AtualizaReenvio(array $dados,$idMsg,$grupo){
				//print_r($dados);
				foreach($dados as $id){
						mysql_query(" INSERT INTO eleitoral_sms_envios SET eleitoral_sms_id = '$idMsg' , ".$grupo." = '$id'");
						mysql_query(" DELETE FROM eleitoral_sms_falhou WHERE eleitoral_sms_id = '$idMsg' AND ".$grupo." = '$id' ");
						//print_r($c_id);
				}
			}
				
		
	} /* Fim da Classe */
	
	
	$status = new EleitoralSMSController;
	
	switch($_SERVER['REQUEST_METHOD']){
		
	
			case 'POST':
					
					$acao = $_GET['acao'];
					
						if($acao == 'envia'){
							
									include("../../../_config.php"); /* abre a conexao com o Banco devido a requisicao pelo formulario */
							
									$config = new Config;
									
									/* Verifica se o eleitor foi marcado para o envio */
									if(isset($_POST['eleitor'])){
										
											$rowsEleitor = $status->SelectNumTable('','eleitoral_eleitores');
											
												$eleitor = 1;
											
												foreach($rowsEleitor as $chave => $telEleitor):
															$rows['eleitor_id'][] = $telEleitor->id;
															
															$caracter = array('-',')','(',' ','+');
											 				$telefone[] = str_replace($caracter,'',$telEleitor->telefone1);
															
															
												endforeach;
												
												
										
									} else{
										
										$eleitor = 0;
									}
									
									/* Verifica se o politico foi marcado para o envio */
									if(isset($_POST['politico'])){
										   
										   $politico = 1;
										   
										   $rowsPolitico = $status->SelectNumTable('','eleitoral_politicos');
												
												foreach($rowsPolitico as $telPolitico):
															$rows['politico_id'][] = $telPolitico->id;
															
															$caracter = array('-',')','(',' ','+');
											 				$telefone[] = str_replace($caracter,'',$telPolitico->telefone1);
															
												endforeach;		
									} else{
										
										$politico = 0;
										
									}
									
									/* Verifica se o colaborador foi marcado para o envio */
									if(isset($_POST['colaborador'])){
									
											$rowsColaborador = $status->SelectNumTable('','eleitoral_colaboradores');
											
													$colaborador = 1;
											
													foreach($rowsColaborador as $telColaborador):
													
															$rows['colaborador_id'][] = $telColaborador->id;
															
															$caracter = array('-',')','(',' ','+');
											 				$telefone[] = str_replace($caracter,'',$telPolitico->telefone1);
																
													endforeach;		
									
									} else{
										$colaborador = 0;
									}
									
/* ------------------------------------ TRATAMENTOS DOS DADOS PARA O ENVIO ---------------------------------------*/
															
											$dadosEnviados = array();			
											/* Cadastra e Pega o ID da Ultima Mensagem Cadastrada na Tabela */				
											$id_mensagem = $status->AddEleitoralSMS($_POST['msg'],$_POST['vkt'],$eleitor,$politico,$colaborador,$qtd_enviado);
											
											
											$totalCreditos = $status->SMSDisponivel($_POST['vkt']);
											$totalEnviados = $status->Enviados();
											
											$disponivel = ($totalCreditos - $totalEnviados);
											
											$dadosEnviados = $status->VerificaEnvio($rows, $disponivel,$id_mensagem,$_POST['vkt'],$_POST['msg']);
											
											
														foreach($rows as $id => $lista){
																			
																foreach($dadosEnviados as $id_2 => $lista_2){
																	
																	if($id == $id_2){
																		$result[$id] = array_diff($lista,$lista_2);
																	}
																			
																}															
															
														}
														
													foreach($result as $item => $list){
													
																foreach($list as $l){
																		
																$sql = mysql_query($t=" INSERT INTO eleitoral_sms_falhou SET $item='$l', eleitoral_sms_id='$id_mensagem' ");		
																		//echo $t;
																								
																}
														
													}
									
						}
						
						if($acao == 'reenvia'){
							
								include("../../../_config.php"); /* abre a conexao com o Banco devido a requisicao pelo formulario */
							
								$config = new Config;
								$id_msg = $_POST['id_msg'];
							
										if(isset($_POST['colaborador_id'])){
										
											foreach($_POST['colaborador_id'] as $colaborador_id){
														
														if($colaborador_id != 0){
														
																$rows = $status->SelectTableWhere('eleitoral_colaboradores','id',$colaborador_id,1);
																
																	foreach($rows as $colaborador){
																		
																				$c_id[] = $colaborador->id;
																				$caracter = array('-',')','(',' ','+');
																				$telefone[] = str_replace($caracter,'',$colaborador->telefone1);
																		
																	}	
														}
														
											}
											
											
											
										}
										
										if(($_POST['politico_id'])){
											
											foreach($_POST['politico_id'] as $politico_id){
										
														if($politico_id != 0){				
															
															$rows = $status->SelectTableWhere('eleitoral_politicos','id',$politico_id,1);
														
																foreach($rows as $politico){
																
																		$p_id[] = $politico->id;
																		$caracter = array('-',')','(',' ','+');
											 							$telefone[] = str_replace($caracter,'',$politico->telefone1);
																
																}
																
														}
														
											}
											
										}
										
										
										if(isset($_POST['eleitor_id'])){
											
											foreach($_POST['eleitor_id'] as $eleitor_id){
												
														if($eleitor_id != 0){
														
															$rows = $status->SelectTableWhere('eleitoral_eleitores','id',$eleitor_id,1);
																
																	foreach($rows as $eleitor){
																		
																				$caracter = array('-',')','(',' ','+');
											 									$telefone[] = str_replace($caracter,'',$eleitor->telefone1);
																	}
															
														}
											
											}
											
										}
										
											$resultMax = count($telefone); // Verifica a quantidade de registros para reenviar
										
											
											$totalCreditos = $status->SMSDisponivel($_POST['vkt']);
											$totalEnviados = $status->Enviados();
											
											$disponivel = ($totalCreditos - $totalEnviados);
											
											
											
											
												if($resultMax <= $disponivel ){
													
													$status->AtualizaReenvio($c_id,$id_msg,'colaborador_id');
													$status->AtualizaReenvio($c_id,$id_msg,'eleitor_id');
													$status->AtualizaReenvio($p_id,$id_msg,'politico_id');
													
															/*foreach($telefone as $fone):
																		
																	$return = $config->SMSEnvia($_POST['vkt'],$fone,$_POST['msg']);
																				
															endforeach;
															
															if($return == true){
																echo "<div> Mensagem Enviada</div>";	
															}*/
															//print_r($rows);
															
															
															
													
													
												} else{
													
													echo 'Nao Existe Credito Suficiente';
													exit;	
												}
								
						} /* fim de if($acao == 'reenvia') */
						
			break;
			
			case 'GET':
			
			break;	
		
	}


?>