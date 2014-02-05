<?php
include('Config.class.php');

	class EleitoralSMSController{
		
	public function listagem($id = NULL){
		$statusSMS = new Eleitoral_SMS_Model;
		if(!empty($id))						
				$dados = $statusSMS->listar($id);
		 else
				$dados = $statusSMS->listar();
		
		return $dados;		
			
	}/*-Fim do Metodo-*/
			
	public function listagem_data($inicio,$fim){
		$statusSMS = new Eleitoral_SMS_Model;
		$d_inicio = $statusSMS->DataToUsa($inicio);
		$d_fim = $statusSMS->DataToUsa($fim);
		$dados = $statusSMS->lista_por_data($d_inicio,$d_fim);
		return $dados;
	}/*-Fim do Metodo-*/
			
	public function DateTime($datetime){			
		$statusSMS = new Eleitoral_SMS_Model;
		$statusSMS->DataToBr($datetime);
	}/*-Fim do Metodo -*/
			
	public function SMSCreditos($vkt_id){
		$totalCreditos = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id = '$vkt_id' "));
		return $totalCreditos->quantidade_sms_mes;				
	} /*-Fim Do Metodo-*/
			
	public function SelectNumTable($vkt_id,$table){
		$array = array();
		$sql = mysql_query(" SELECT * FROM $table WHERE vkt_id = '$vkt_id'");
		  while($rows = mysql_fetch_object($sql)){
			  $eventsArray['telefone'] = $rows->telefone1;
			  $eventsArray['id'] = $rows->id;
			  $array[] = $eventsArray;
		  }
		return $array;
	}/*Fim do Metodo*/
			
	public function Enviados(){		
		  $statusSMS = new Eleitoral_SMS_Model;
			  $total = $statusSMS->TotalEnviados();
		 return $total;	
	}/*-Fim do Metodo -*/
				
	public function BuscaTodosColaborador($colaborador = NULL){
		  $statusSMS = new Eleitoral_SMS_Model;
		  $dados = $statusSMS->Colaborador();		
		  return $dados;
	} /* Fim do Metodo */
			
			
	public function AddEleitoralSMS($msg,$vkt,$eleitor,$politico,$colaborador){
		  $statusSMS = new Eleitoral_SMS_Model;
		  $id_mensagem = $statusSMS->AddEleitoralSMSModel($msg,$vkt,$eleitor,$politico,$colaborador);
		  return $id_mensagem;
		
	}/*Fim do Metodo*/
			
	public function VerificaNumMsg($id,$grupo,$table){
		  $statusSMS = new Eleitoral_SMS_Model;
		  $total = $statusSMS->Verifica_Num_Msg($id,$grupo,$table);	  
		  return $total;
	} /*Fim do Metodo*/
			
	public function SelectTableWhere($table = NULL,$coluna = NULL, $id = NULL,$tipo){
			$statusSMS = new Eleitoral_SMS_Model;
			$dados = $statusSMS->ReturnTableWhere($table,$coluna,$id,$tipo);				
			return $dados;
	}/*Fim do Metodo*/
			
			
	public function VerificaEnvio(array $dados, $disponivel,$id_mensagem,$vkt,$msg){
		$config = new Config;
		$statusSMS = new Eleitoral_SMS_Model;
		$i = 0; $j = 0;					
		  foreach($dados as $id => $lista){
			$i++;
			  if($i <= $disponivel){
					foreach($lista as $l){
						$j++;
						if($j <= $disponivel){
							$sql = mysql_query($t=" INSERT INTO eleitoral_sms_envios SET $id='$l', eleitoral_sms_id='$id_mensagem' ");
						} 																		
										  
					}
			  	} 
				  $i=$j;
			}
											
											
				/* faz uma consulta na tabela eleitoral_sms_envios para pegar somente os que foram enviados */		
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
										
							/* Caso Modem, Seta o ip do servidor e port do modem */
							//$config->SetHostEnvio('10.0.1.109'); /* Servidor*/
							//$config->SetPortEnvio('8800');       /* Modem */
							
							/*
							*	Modo de Envio do Servidor   1 = Modem , 2 = ComTele
							*/
							$config->SetServidorEnvio(2);
						
							if($nenvio <= $disponivel){
								foreach($telefone as $fone){
									$return = $config->SMSEnvia($vkt,$fone,$msg);
								}
							
								if($return == true){
									echo "<div>Mensagem Enviada</div>";			
								}	
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
			
			public function EnviaParaGrupoSocial($grupo_social_id){
						$config = new Config;
						$sql = mysql_query($r=" SELECT * FROM eleitoral_eleitores WHERE grupo_social_id = '$grupo_social_id' ");
						while($grupo=mysql_fetch_object($sql)){
							$telefones[] = $grupo->telefone1;
						}
						//print_r();
						/*- Modo de Envio do Servidor   1 = Modem , 2 = ComTele -*/
						$config->SetServidorEnvio(2);
						if(sizeof($telefones) > 0){
							foreach($telefones as $fones){
								if($fones != NULL){
									$caracter = array('-',')','(',' ','+');
									$fone = str_replace($caracter,'',$fones);
								}
								$return = $config->SMSEnvia($_POST['vkt'],$fone,$_POST['msg']);													
							}								
							if($return == true){
									echo "<div> Enviado com Sucesso para o Grupo Social!</div>";	
							}
						} else{
							echo "Nao existe pessoas neste grupo!";	
						}
			}/*- Fim do Metodo -*/
			
			public function EnviaParaBairro($bairro){
				$config = new Config;
						$sql = mysql_query($p=" SELECT * FROM eleitoral_eleitores WHERE bairro like '%$bairro%' ");
						while($grupo=mysql_fetch_object($sql)){
								$telefones[] = $grupo->telefone1;
						}
						/*- Modo de Envio do Servidor   1 = Modem , 2 = ComTele -*/
						$config->SetServidorEnvio(2);												
						if(sizeof($telefones) > 0){
							foreach($telefones as $fones){
								if($fones != NULL){
								  $caracter = array('-',')','(',' ','+');
								  $fone = str_replace($caracter,'',$fones);
								  $return = $config->SMSEnvia($_POST['vkt'],$fone,$_POST['msg']);
								}
							}								
							if($return == true){
									echo "<div> Enviado com Sucesso para o Grupo Bairro!</div>";	
							}
						}else{
							echo "Nao existe pessoas nesse bairro!";	
						}
			}/*- Fim do Metodo -*/	
				
		
	} /* Fim da Classe */
	
	
	$status = new EleitoralSMSController;
	
	switch($_SERVER['REQUEST_METHOD']){
		
			case 'POST':
					$acao = $_GET['acao'];
						if($acao == 'envia'){
							include("../../../_config.php"); /* abre a conexao com o Banco devido a requisicao pelo formulario */
							$config = new Config;
									
									  $dadosEnviados = array();																		
				  					  $totalCreditos = $status->SMSCreditos($_POST['vkt']);
				  					  $totalEnviados = $status->Enviados();
				  					  $disponivel = ($totalCreditos - $totalEnviados);
									
									
									if($disponivel > 0){
											if(!empty($_POST['grupo_social_id'])){
												$status->EnviaParaGrupoSocial($_POST['grupo_social_id']);
											}
											if(!empty($_POST['bairro'])){
												$status->EnviaParaBairro($_POST['bairro']);	
											}	
									}
								
									/* Verifica se o eleitor foi marcado para o envio */
									if(!empty($_POST['eleitor'])){
											$eleitor = 1;
											$rowsEleitor = $status->SelectNumTable($_POST['vkt'],'eleitoral_eleitores');
											  foreach($rowsEleitor as $chave => $telEleitor){
												$rows['eleitor_id'][] = $telEleitor['id'];
												$caracter = array('-',')','(',' ','+');
												$telefone[] = str_replace($caracter,'',$telEleitor['telefone']);															
											  }
										
									} else{ $eleitor = 0; }
									/* Verifica se o politico foi marcado para o envio */
									if(!empty($_POST['politico'])){ 
										   $politico = 1;
										   $rowsPolitico = $status->SelectNumTable($_POST['vkt'],'eleitoral_politicos');
											  foreach($rowsPolitico as $telPolitico){
												$rows['politico_id'][] = $telPolitico['id'];
												$caracter = array('-',')','(',' ','+');
												$telefone[] = str_replace($caracter,'',$telPolitico['telefone']);		
											  }
									} else{ $politico = 0; }
									/* Verifica se o colaborador foi marcado para o envio */
									if(isset($_POST['colaborador'])){
										$colaborador = 1;
										$rowsColaborador = $status->SelectNumTable($_POST['vkt'],'eleitoral_colaboradores');
											foreach($rowsColaborador as $telColaborador){
											  $rows['colaborador_id'][] = $telColaborador['id'];
											  $caracter = array('-',')','(',' ','+');
											  $telefone[] = str_replace($caracter,'',$telPolitico['telefone']);
											}
									
									} else{ $colaborador = 0; }
/* ------------------------------------ TRATAMENTOS DOS DADOS PARA O ENVIO ---------------------------------------*/
										
				  if($disponivel > 0  ){
					  if(sizeof($rows) > 0){
						/* Cadastra e Pega o ID da Ultima Mensagem Cadastrada na Tabela */				
						$id_mensagem = $status->AddEleitoralSMS($_POST['msg'],$_POST['vkt'],$eleitor,$politico,$colaborador);
						$dadosEnviados = $status->VerificaEnvio($rows,$disponivel,$id_mensagem,$_POST['vkt'],$_POST['msg']);
					  }
				  } else{
					echo " Voc&ecirc; n&atilde;o tem Cr&eacute;ditos ";
					exit;
				  }
											
				  if(sizeof($rows) > 0){
					  foreach($rows as $id => $lista){			  
						  foreach($dadosEnviados as $id_2 => $lista_2){
							if($id == $id_2){
								$result[$id] = array_diff($lista,$lista_2);
							}		
						  }															
					  }
				  }
				
				if(sizeof($result) > 0){ 
					foreach($result as $item => $list){
						foreach($list as $l){
							$sql = mysql_query($t=" INSERT INTO eleitoral_sms_falhou SET $item='$l', eleitoral_sms_id='$id_mensagem' ");								
						}
					}
				}
									
			 } /*fim de if envia */
/*------------------------------------------------- REENVIA MENSAGEM -------------------------------------------------------*/				
					if($acao == 'reenvia'){
							
								include("../../../_config.php"); /* abre a conexao com o Banco devido a requisicao pelo formulario */
							
								$config = new Config;
								$id_msg = $_POST['id_msg'];
											$erros=0;
											$msgerro="";
											
												if(($_POST['colaborador_id'])){		
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
										
									  if(($_POST['eleitor_id'])){
										  foreach($_POST['eleitor_id'] as $eleitor_id){
											  if($eleitor_id != 0){
												  $rows = $status->SelectTableWhere('eleitoral_eleitores','id',$eleitor_id,1);
													foreach($rows as $eleitor){
														$e_id[] = $eleitor->id;
														$caracter = array('-',')','(',' ','+');
														$telefone[] = str_replace($caracter,'',$eleitor->telefone1);
													}
												  
											  }
											  
										  }
									  
									  }
											
											$erros=0;
											$msgerro="";
											
											$result_c = sizeof($c_id);
											$result_p = sizeof($p_id);
											$result_e = sizeof($e_id);
											
												if($result_c == 0){ $erros++; $msgerro .= "Colaborador<br/>";}
												if($result_p == 0){ $erros++; $msgerro .= "Politico<br/>";}
												if($result_e == 0){ $erros++; $msgerro .= "Eleitor<br/>";}
												
													if($erros > 0 and $erros == 3){
														$msgerro = "N&atilde;o existe registro para reenvio de:<br> $msgerro";
															echo $msgerro;
															exit;
													} 
													
													if($erros > 0){
														$msgerro = "N&atilde;o existe registro para reenvio de:<br> $msgerro";
															echo $msgerro;
													}
										
											$resultMax = count($telefone); // Verifica a quantidade de registros para reenviar
										
											
											$totalCreditos = $status->SMSCreditos($_POST['vkt']);
											$totalEnviados = $status->Enviados();
											
											$disponivel = ($totalCreditos - $totalEnviados);
											
												if($resultMax <= $disponivel ){
															
													if($result_c > 0) { $status->AtualizaReenvio($c_id,$id_msg,'colaborador_id');}
													if($result_p > 0) { $status->AtualizaReenvio($p_id,$id_msg,'politico_id');}
													if($result_e > 0) { $status->AtualizaReenvio($e_id,$id_msg,'eleitor_id');}
															/*foreach($telefone as $fone):
																		
																	$return = $config->SMSEnvia($_POST['vkt'],$fone,$_POST['msg']);
																				
															endforeach;
															
															if($return == true){
																echo "<div> Mensagem Enviada</div>";	
															}*/
															//print_r($rows);
													
												} else{
													
													echo 'N&atilde;o Existe Credito Suficiente';
													exit;	
												}
								
						} /* fim de if($acao == 'reenvia') */
						
			break;
			
			case 'GET':
			
			break;	
		
	}


?>