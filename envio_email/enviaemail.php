<?php
 
	// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
	
	require("class.phpmailer.php");
	//echo "oi";
	function envia_email($para,$assunto,$mensagem,$from){
		
		$mail = new PHPMailer();
		$mail->Mailer     = "smtp";
		// Define que a mensagem poder� ter formata�ao HTML
		$mail->IsHTML(true); //
 		 
		// Define que a codifica�ao do conte�do da mensagem ser� utf-8
		$mail->CharSet    = "iso8859-i";
 
		// Define que os emails enviadas utilizarao SMTP Seguro tls
		$mail->SMTPSecure = "tls";
 
		// Define que o Host que enviar� a mensagem � o Hotmail
		$mail->Host       = "cmail.vkt.inf.br";
 
		//Define a porta utilizada pelo Gmail para o envio autenticado
		$mail->Port       = "587";                  
 
		// Deine que a mensagem utiliza m�todo de envio autenticado
		$mail->SMTPAuth   = "true";
 
		// Define o usu�rio do hotmail autenticado respons�vel pelo envio
		$mail->Username   = $from;
 
		// Define a senha deste usu�rio citado acima
		$mail->Password   = "cdwq8i9o";
 
		// Defina o email e o nome que aparecer� como remetente no cabe�alho
		$mail->From       = $from;
		$mail->FromName   = $from;
 
		// Define o destinat�rio que receber� a mensagem
		$mail->AddAddress($para);
 
		/*
		Define o email que receber� resposta desta
		mensagem, quando o destinat�rio responder
		*/
		$mail->AddReplyTo("dernandonc@hotmail.com", $mail->FromName);
 
		// Assunto da mensagem
		$mail->Subject    = $assunto;
 
		// Toda a estrutura HTML e corpo da mensagem
		$msg=$mensagem;
		$mail->Body       = $msg;
 
		// Controle de erro ou sucesso no envio
		if (!$mail->Send())
		{
 
    		echo "Erro de envio para $para: " . $mail->ErrorInfo."<br>";
 			//return 1;
		}
		else{
 
    		echo "Mensagem enviada com sucesso para $para!"."<br>";
 			//return 0;
		}
	}
	envia_email("dernandonc@hotmail.com","Teste","Mensagem de Teste","Dernando");
?>