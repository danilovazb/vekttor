<?php
require_once("sysms/SendSms.php");

$host		= 'localhost';
$login_bd	= 'root';
$senha_bd	= '001236';
$bd			= 'novo_projeto';

mysql_connect($host,$login_bd,$senha_bd);
mysql_select_db($bd);


			/* Caso Modem Seta o ip do servidor e port do modem */
			$config->SetHostEnvio('10.0.1.109'); /* Servidor*/
			$config->SetPortEnvio('8800');       /* Modem */
			
			/*
			*	Modo de Envio do Servidor   1 = Modem , 2 = ComTele
			*/
			$config->SetServidorEnvio(1);
			
			$config->SMSEnvia(24,"9292022909","agora pegou sim");


?>