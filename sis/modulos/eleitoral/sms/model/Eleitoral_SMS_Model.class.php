<?php

	class Eleitoral_SMS_Model{
	
	
		protected $table = 'eleitoral_sms';
		
			protected $id;
			protected $grupo_id;
			protected $msg_enviada;
			protected $qtd_enviada;
			protected $nao_enviada;
			protected $data;
			
			
				public function setId($id){  
					$this->id = $id;	
				}
				
				public function getId(){ 
					return $this->id; 
				}
				
				/*
				* MSG Enviada
				*/
				
				public function setMsgEnviada($msg_enviada){ 
					$this->msg_enviada = $msg_enviada;
				}
				
				public function getMsgEnviada(){ 
					return $this->msg_enviada; 
				}
				
			
				/*
				* Metodo para Listar
				*/
				
				public function listar($id = NULL){
			
					if(!empty($id)){
					
						if(is_numeric($id))
							
								$this->setId($id);
							
							$where = " WHERE id = ".$this->getId();
							$sql = " SELECT * FROM ".$this->table."".$where;
							$dados = $this->Query($sql,1);
							
					} else{
						$sql = "SELECT * FROM ".$this->table;
						$dados = $this->Query($sql,1);
					
					}
				
						return $dados;
			
				}
				
				public function lista_por_data($inicio,$fim){
					
							try{
								
										$sql = " SELECT * FROM eleitoral_sms WHERE data  BETWEEN '".$inicio."' AND '".$fim."'";
										
											$rows = $this->Query($sql,1);
											
												return $rows;
								
							} catch(Exception $e){
								
									echo $e->getMessage();
								
							}
					
					
				}
				
				
				
				/* Metodo retorna a quantidade de Eleitores */
				public function Eleitores(){
					try{
						
							$sql = " SELECT * FROM eleitoral_eleitores";
							
								$rows = $this->QueryNumSql($sql);
								
								return $rows;
						
					} catch(Exception $e){
						echo $e->getMessage();
					}	
					
				}
				
				/* Metodo retorna a quantidade de Politicos */
				public function Politicos(){
					try{
						
							$sql = " SELECT * FROM eleitoral_politicos";
							
								$rows = $this->QueryNumSql($sql);
								
								return $rows;
						
					} catch(Exception $e){
						echo $e->getMessage();
					}	
					
				}
				/* Metodo retorna a quantidade de registros ou os dados de uma tabela */
				public function ReturnNumSQL($id = NULL, $table = NULL){
					try{
						
							if(!empty($id) and !empty($table)){
							$sql = " SELECT * FROM ".$table;
							
								$rows = $this->QueryNumSql($sql);
							} 
							
							else if(!empty($table)){
								
								$sql = " SELECT * FROM ".$table;
						
										$rows = $this->Query($sql,1);
								
							} 
								
								return $rows;
						
					} catch(Exception $e){
						echo $e->getMessage();
					}	
					
				}	
				
				public function ReturnTableWhere($table = NULL,$coluna = NULL, $id = NULL, $tipo){
					
						if(!empty($table) and !empty($id)){
							
							$sql = " SELECT * FROM ".$table." WHERE ".$coluna." = ".$id;
							
								if($tipo == 2)
								
									$rows = $this->Query($sql,2);
									
								else if($tipo == 1)
								
									$rows = $this->Query($sql,1);
							
						}
					
					return $rows;
				}
				
				
				
							
				
				
				public function TotalEnviados(){
					
							$sql = mysql_query(" SELECT COUNT(eleitoral_sms_id) AS soma FROM eleitoral_sms_envios");
							
							$soma = mysql_result($sql,0,0);
							
							return $soma;	
				}				
				
				public function Disponivel($vkt_id){					
					try{
								
							$sql = " SELECT * FROM clientes_vekttor WHERE id = ".$vkt_id;
							
								$disponivel = $this->Query($sql,1);
								
									foreach($disponivel as $v):
											return $v->quantidade_sms_mes;
									endforeach;
									
									//return $sql;
						
					} catch(Exception $e){
						
						echo $e->getMessage();
					}
					
				} /* Fim do Metodo */
				
				
				
				public function Verifica_Num_Msg($id,$grupo,$table){
					
						$sql = mysql_query($t="SELECT count(".$grupo.") FROM ".$table." WHERE eleitoral_sms_id = ".$id." AND ".$grupo." <> 0 ");
						
							$soma_eleitor = mysql_result($sql,0,0);
							
								return $soma_eleitor;
					
				}
				
				public function AddEleitoralSMSModel($msg,$vkt,$eleitor,$politico,$colaborador){
					
									$data = date('Y-m-d H:i:s');
						
				$sql = mysql_query("INSERT INTO eleitoral_sms (colaborador,politicos,eleitores,msg_enviada,data,vkt_id) VALUES('$colaborador','$politico','$eleitor','$msg','$data','$vkt')");
				
						$id_mensagem = mysql_insert_id();
									
							return $id_mensagem;		
						
						
							
				}
				
				public function RetornaDadosInseridos(){
					
					
				}
				
				
				public function DataToBr($datatime){
					
					$array = explode(" ",$datatime);
					
						$data = explode("-",$array[0]);
					
							echo $data[2]."/".$data[1]."/".$data[0];
					
				}
				
				public function DataToUsa($data){
					
					$array = explode('/',$data);
					
					return $array[2].'-'.$array[1].'-'.$array[0];	
					
				}
				
				public function Query($sql, $return){
		
		
					$result = mysql_query($sql);
			
						
						if($return == 1) {
						
								while($registro=mysql_fetch_object($result)){
								
										$dados[] = $registro;
								
								}
								
						} else if($return == 2){
								
								while($registro=mysql_fetch_array($result)){
										
										$dados[] = $registro;
								}	
						}
				
					return $dados;	
			
				}
				
				
				/*
				* Metodo retorna o numero de registros
				* @return n° registros
				*/
				public function QueryNumSql($sql){
					
						$result = mysql_query($sql);
						
							$numRows = mysql_num_rows($result);
							
							return $numRows;
					
				}
		
	}

?>