<?php
 
	// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
	
	require("class.phpmailer.php");
	//echo "oi";
	function envia_email($para,$assunto,$mensagem,$from){
		
		$mail = new PHPMailer();
		$mail->Mailer     = "smtp";
		// Define que a mensagem poderá ter formataçao HTML
		$mail->IsHTML(true); //
 		 
		// Define que a codificaçao do conteúdo da mensagem será utf-8
		$mail->CharSet    = "iso8859-i";
 
		// Define que os emails enviadas utilizarao SMTP Seguro tls
		$mail->SMTPSecure = "tls";
 
		// Define que o Host que enviará a mensagem é o Hotmail
		$mail->Host       = "cmail.vkt.inf.br";
 
		//Define a porta utilizada pelo Gmail para o envio autenticado
		$mail->Port       = "587";                  
 
		// Deine que a mensagem utiliza método de envio autenticado
		$mail->SMTPAuth   = "true";
 
		// Define o usuário do hotmail autenticado responsável pelo envio
		$mail->Username   = $from;
 
		// Define a senha deste usuário citado acima
		$mail->Password   = "cdwq8i9o";
 
		// Defina o email e o nome que aparecerá como remetente no cabeçalho
		$mail->From       = $from;
		$mail->FromName   = $from;
 
		// Define o destinatário que receberá a mensagem
		$mail->AddAddress($para);
 
		/*
		Define o email que receberá resposta desta
		mensagem, quando o destinatário responder
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