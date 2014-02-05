<?php
//require_once("../../../_config.php");

class Config {
	
		/*
		* Modo de envio do SMS 0 = Modem, 1 = Comtele
		*/
		
		protected $modoEnvio;
		protected $hostEnvio;
		protected $portEnvio;
		
		public function SetServidorEnvio($modo){
				
				$this->modoEnvio = $modo;
		
		} /* Fim do Metodo */
		
		public function GetServidorEnvio(){
	
				return $this->modoEnvio;
				
		} /* Fim do Metodo*/
		
		/*
		* Metodo para Selecionar o Host de Envio 
		*/
		
		public function SetHostEnvio($hostEnvio){
			
				$this->hostEnvio = $hostEnvio;
			
		}
		
		/*
		* Metodo para Retornar o Host de Envio 
		*/
		
		public function GetHostEnvio(){
			
				return $this->hostEnvio;
		}
		
		/*
		* Metodo para Selecionar a porta de Envio 
		*/
		public function SetPortEnvio($portEnvio){
			
				$this->portEnvio = $portEnvio;
		
		}
		
		/*
		* Metodo para Retornar a porta de Envio 
		*/
		public function GetPortEnvio(){
			
				return $this->portEnvio;
		
		}
		
		/*
		* Metodo Para enviar o SMS
		*/
		public function SMSEnvia($vkt,$telefone,$msg){
					
					$sms = new EnviaSMS;
					
					switch($this->GetServidorEnvio()):
					
								case 1:
										$return = $sms->SMSModem($this->GetHostEnvio(),$this->GetPortEnvio(),$vkt,$telefone,$msg);
										return $return;
								break;
								
								case 2:
										$return = $sms->SMSComTele($vkt,$telefone,$msg);
										return $return;
								break;
																
								default:
        							echo "Falha ao enviar Mensagem: O Metodo de Envio nao foi Definido";
					endswitch;
						
			
		}		
		
		/*
		* Metodo que executa uma String sql
		* @return um objeto de dados
		*/
		public function Query($sql){
		
		
					$result = mysql_query($sql);
			
						while($registro=mysql_fetch_object($result)){
						
								$dados[] = $registro;
						
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
		
	
} /*Fim da Classe*/

?>