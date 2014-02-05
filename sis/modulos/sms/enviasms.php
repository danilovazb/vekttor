<?php
include("../../_config.php");
include_once("../sysms/SendSms.php");
global $vkt_id;
		
			if(!empty($_POST['tel_unico'])){			
				/*Verifica se o envio do SMS estar disponivel*/
				$limite = mysql_fetch_object(mysql_query(" SELECT * FROM clientes_vekttor WHERE id = '$vkt_id'"));
				$qtdEnviado = mysql_fetch_object(mysql_query($r=" SELECT COUNT(id) AS enviado FROM rel_sms WHERE vkt_id = '$vkt_id'"));
				$disponivel =  ($limite->quantidade_sms_mes - $qtdEnviado->enviado);
				
				
					if($disponivel > 0){
					$caracter = array('-',')','(',' ','+');
					$telefone = str_replace($caracter,'',$_POST['tel_unico']);
			
						/* Modo de Envio do Servidor   1 = Modem , 2 = ComTele */	
						$config->SetServidorEnvio(2);
						$return = $config->SMSEnvia($vkt_id,$telefone,$_POST['msg']);
						
						/*gravar no banco de dados*/
						if($return == true){
							echo "<div> Enviado com sucesso </div>";
								 $data = date('Y-m-d H:i:s');	
								 $sql = mysql_query("INSERT INTO rel_sms 
														SET 
														vkt_id     = '$vkt_id', 
														cliente_id ='".$_POST['cliente_id']."', 
														numero_destino = '$telefone', 
														msg = '".iconv('UTF-8','ISO-8859-1',($_POST['msg']))."', 
														data_envio = '$data', 
														status = '1' ");
						}
					}
			} 
			
		  	
?>	