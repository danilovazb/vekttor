<?php
include("../../../_config.php");
include_once("../../sysms/SendSms.php");

		
			if(!empty($_POST['tel_unico'])){
							
				$clienteBD = mysql_fetch_object(mysql_query($t=" SELECT * FROM cliente_fornecedor WHERE id = '".$_POST['cliente_id']."' $and"));
				
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
			
			} else {
			
				  $and = "";	
				  if(!empty($_POST['grupo_id'])){
						  $and .= " AND grupo_id = '".$_POST['grupo_id']."'";	
				  } 
				  if(!empty($_POST['mes'])){
					  $and .= " AND MONTH(nascimento) = '".$_POST['mes']."'    ";
				  }
				  if(!empty($_POST['bairro'])){
					  $and .= " AND bairro ='".$_POST['bairro']."'";
				  }
		
				$sql= mysql_query($t=" SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id = '$vkt_id' $and");
		   
					while($cliente=mysql_fetch_array($sql)){
							$dados[] = $cliente;
							$caracter = array('-',')','(',' ','+');
							$telefones[] = str_replace($caracter,'',$cliente['telefone1']);
						
					}
			
					/* Modo de Envio do Servidor   1 = Modem , 2 = ComTele */	
					$config->SetServidorEnvio(2);	
					
					foreach($telefones as $telefone){
						//echo $telefone;
						$return = $config->SMSEnvia($vkt_id,$telefone,$_POST['mensagem']);
					}
		  
					/*gravar no banco de dados*/
					if($return == true){
						echo "<div> Mensagem Enviada</div>";	
						/*--*/	
						for($i=0;$i<sizeof($dados);$i++){
							 $data = date('Y-m-d H:i:s');			  	
							 $caracter = array('-',')','(',' ','+');
							 $telefones = str_replace($caracter,'',$dados[$i]['telefone1']);
							 
							 $sql = mysql_query("INSERT INTO rel_sms 
								  SET vkt_id = '$vkt_id', cliente_id='".$dados[$i]['id']."', numero_destino = '$telefones', msg = '".$_POST['mensagem']."', data_envio = '$data', status = '1' 
							");
						}
						/*--*/
					}
			} /* fim de 1 else */
		  	
?>	