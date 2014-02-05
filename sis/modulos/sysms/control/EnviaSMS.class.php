<?php

date_default_timezone_set('America/Manaus');
	
	class EnviaSMS{
			
		public function SMSModem($host,$port,$vkt,$telefone,$msg){	
															
				$return = $this->SendSMS($host, $port, "", "", '+55'.$telefone, $msg);
				
				$return = "Message Submitted";
				
				$pos = strpos($return, 'Message Submitted');
										
					if ($pos === false) {
						return false;
					} else {
						$data = date('Y-m-d H:i:s');	
						$sql = mysql_query($t="INSERT INTO rel_sms (vkt_id,numero_destino,msg,data_envio,status) VALUES($vkt,'$telefone','$msg','$data','1')");
						return true;
					}
			
		} /* Fim Do Metodo*/
		
		public function SMSComTele($vkt,$telefone,$msg){
			
			$origem = '9293396873';
			
			$id = file_get_contents("http://webapi.comtele.com.br/api/api_fuse_connection.php?fuse=get_id&user=50624&pwd=novo624");
			
			$id = trim($id);
			
			$url = "http://webapi.comtele.com.br/api/api_fuse_connection.php?fuse=send_msg&id=".rawurlencode($id)."&from=".rawurlencode($origem)."&msg=".rawurlencode($msg)."&number=".rawurlencode($telefone);
					
					$r = file_get_contents($url);
					
						if($r == true){					
							//$data = date('Y-m-d H:i:s');	
							//$sql = mysql_query("INSERT INTO rel_sms (vkt_id,numero_destino,msg,data_envio,status) VALUES($vkt,'$telefone','$msg','$data','1')");
							return $r;
						} else{
							return false;
						}
																
								
			
		} /* Fim do Metodo*/	
		
		
		public function SendSMS($host, $port, $username, $password, $phoneNoRecip, $msgText){
				
				$fp = fsockopen($host, $port, $errno, $errstr);
						if (!$fp) {
							$erro =  "errno: $errno \n";
        					$erro .= "errstr: $errstr\n";
        					return $erro;
						}
    
				fwrite($fp, "GET /PhoneNumber=" . rawurlencode($phoneNoRecip) . "&Text=" . rawurlencode($msgText) . " HTTP/1.0\n");		
						
						//echo $aux3;
						
						if ($username != "") {
						   $auth = $username . ":" . $password;
						   echo "auth: $auth\n";
						   $auth = base64_encode($auth);
						   echo "auth: $auth\n";
						   fwrite($fp, "Authorization: Basic " . $auth . "\n");
						}
						
						fwrite($fp, "\n");
					  
						$res = "";
					 
						while(!feof($fp)) {
							$res .= fread($fp,1);
						}
						fclose($fp);
    
 
    				return $res;
			
			
		} /* Fim do Metodo*/
		
		public function verifica_sms($vkt_id,$qtd_sms){
			try{
				
					$sql = " SELECT * FROM clientes_vekttor WHERE id = ".$vkt_id;
						
						$this->Query($sql);
						
				
			}catch(Exception $e){
				echo $e->getMessage();
			}
			
		
		} /* Fim Do Metodo */
		
		
		/* Metodo Para executar sql 
		* @param String sql
		* @return um objeto com os dados
		*/
		public function Query($sql){
		
		
					$result = mysql_query($sql);
			
						while($registro=mysql_fetch_object($result)){
						
								$dados[] = $registro;
						
						}
				
					return $dados;	
			
		} /* Fim do Metodo */
		
		
	} /* Fim da Classe */

?>