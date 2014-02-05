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
		$mail->Host       = "cmail.josueneto.com";
 
		//Define a porta utilizada pelo Gmail para o envio autenticado
		$mail->Port       = "587";                  
 
		// Deine que a mensagem utiliza método de envio autenticado
		$mail->SMTPAuth   = "true";
 
		// Define o usuário do hotmail autenticado responsável pelo envio
		$mail->Username   = $from;
 
		// Define a senha deste usuário citado acima
		$mail->Password   = "cdwq8i9o";
 
		// Defina o email e o nome que aparecerá como remetente no cabeçalho
		$mail->From       = "deputado@josueneto.com";
		$mail->FromName   = "Deputado";
 
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
 
		}
		else{
 
    		echo "Mensagem enviada com sucesso para $para!"."<br>";
 
		}
	}
$emails = array("joao1silva_1980@hotmail.com","rensantos2013@hotmail.com","itamar2013_amaral@outlook.com","joana2013_silva@hotmail.com","k.leti@hotmail.com","marjo_drummond@hotmail.com","yannah_rodrigues@hotmail.com","elma_antenna@hotmail.com",
"janaina_muniz2013@hotmail.com","tayllor_nunes2013@hotmail.com","yara_dutra1979@hotmail.com","reni_patacho1984@hotmail.com","ticiana_gones1965@hotmail.com","robisson_dias1996@hotmail.com","lanna_rocha1981@hotmail.com","adriana_souza1957@hotmail.com",
"rosana_rodrigues1997@hotmail.com","hellen_fernandes1982@hotmail.com","ana_bittencourt1980@outlook.com","jheniza_pinheiro1998@hotmail.com","julio_dotte1997@hotmail.com","anderson_andrade1994@hotmail.com","julio.nascimento1995@hotmail.com","lea_santos1991@hotmail.com",
"lanna_moreira1977@outlook.com","ricardo_duarte1976@hotmail.com","jaqueline_linck1975@hotmail.com","francieli_ingrid1985@hotmail.com","ellensandra_jardim2000@hotmail.com","thais_vircosa2001@hotmail.com","ricardo_lima20101@hotmail.com","dernandonc@hotmail.com",
"marionovo@live.com","mario@vekttor.com","dernando@hotmailcom","dernando@hot.com");

foreach($emails as $email){
	envia_email($email,"Teste Hotmail PHP Mailer","Teste de Hotmail Usando PHP Mailer","deputado@josueneto.com");
}
/*$mensagem = "Você precisa confirmar o cadastro efetuado no site do Josué Neto. Por favor, clique no link abaixo.";
$email = $_POST['email'];
envia_email($email,'Confirmação de Cadastro Josué Neto',$mensagem,$from);
*/
?>