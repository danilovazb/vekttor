<?php
include("control/Config.class.php");
include("control/EnviaSMS.class.php");

	$config = new Config;
	
	$config->SetServidorEnvio(2);
	
	   $vkt  = '1';
		$fone = '9282211733';
		$msg  = 'Teste de Mensagem de SMS Vekttor'; 	
	
	$return = $config->SMSEnvia($vkt,$fone,$msg);
	
		
		if($return == true){
			echo "<div>Mensagem Enviada</div>";																			
		}	
	
	
	
	
	
		/* Caso Modem Seta o ip do servidor e port do modem */
		//$config->SetHostEnvio('10.0.1.109'); /* Servidor*/
		//$config->SetPortEnvio('8800');       /* Modem */
																		
		/*
		*	Modo de Envio do Servidor   1 = Modem , 2 = ComTele
		*/
		
		
																																						
		
		
																		

?>