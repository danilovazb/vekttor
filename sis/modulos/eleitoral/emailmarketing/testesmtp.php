<?
function ENVIAEMAIL ($smtp, $porta, $senha, $usuario, $remetente, $remetentenome, $destinatario, $destinatarionome, $assunto, $mensagem, $debug) {
 
  $headers = "MIME-Version: 1.0\r\n".
             "Content-type: text/html;\r\n".
             "From: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "Reply-To: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "To: \"" . $destinatarionome . "\" <" . $destinatario . ">\r\n".
             "Subject: " . $assunto . " \r\n";
             "Date: ". date('D, d M Y H:i:s O') ." \r\n";
             "X-Priority: 3\r\n".
             "X-MSMail-Priority: High\r\n".
             "X-Mailer: WV Mailer\r\n".
             "X-SenderIP: " . $_SERVER["REMOTE_ADDR"] . "\r\n";
 
  if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    $headers .= "X-SenderIP-Lan: " . $_SERVER["HTTP_X_FORWARDED_FOR"] . "\r\n";
  }
 
  $corpo = "\r\n<html>\r\n".
           "<head>\r\n".
           "<style>\r\n".
           "body { margin: 4px; padding: 4px; text-align: left; text-decoration: none; font-size: 11px; font-family: \"Lucida Sans Unicode\", Arial, Geneva, Helvetica, sans-serif; }\r\n".
           "input, textarea, td, th { font-family: \"Lucida Sans Unicode\", Arial, Geneva, Helvetica, sans-serif; font-size: 11px; }\r\n".
           "input, textarea, td, th {font-family: \"Lucida Sans Unicode\", Arial, Geneva, Helvetica, sans-serif;font-size: 11px;}\r\n".
           "a { text-decoration:none; font:bold; color:#989CAE; }\r\n".
           "a:hover { color:dimgray; font:bold; }\r\n".
           "</style>\r\n".
           "</head>\r\n".
           "<body bgcolor=\"#FFFFFF\">\r\n".
           $mensagem . "\r\n".
           "</body>\r\n".
           "</html>\r\n".
           "\n";
  $conn = fsockopen($smtp, $porta, $errno, $errstr, 30);
  fputs($conn, "EHLO " . $smtp . "\r\n");
  fputs($conn, "AUTH LOGIN\r\n");
  fputs($conn, base64_encode($usuario) . "\r\n");
  fputs($conn, base64_encode($senha) . "\r\n");
  fputs($conn, "MAIL FROM: " . $remetente . "\r\n");
  fputs($conn, "RCPT TO: " . $destinatario . "\r\n");
  fputs($conn, "DATA\r\n");
  fputs($conn, $headers);
  fputs($conn, "\r\n");
  fputs($conn, $corpo . "\r\n");
  fputs($conn, ".\r\n");
  fputs($conn, "QUIT\r\n");
  $log = "";
  while (!feof($conn)) {
    $log .= fgets($conn) . "<BR>\n";
  }
 	 $log .= $headers;
	 $log .= $corpo;
  if ($debug == true) {
   fclose($conn);
	//echo "Enviado para $destinatario <br>";
	return $log;
  } else {
  	//echo "Nao enviado para $destinatario <br>";
	return fclose($conn);
  }	
}

//$emails = array("joao1silva_1980@hotmail.com","rensantos2013@hotmail.com","itamar2013_amaral@outlook.com","joana2013_silva@hotmail.com","k.leti@hotmail.com","marjo_drummond@hotmail.com","yannah_rodrigues@hotmail.com","elma_antenna@hotmail.com",
//"janaina_muniz2013@hotmail.com","tayllor_nunes2013@hotmail.com","yara_dutra1979@hotmail.com","reni_patacho1984@hotmail.com","ticiana_gones1965@hotmail.com","robisson_dias1996@hotmail.com","lanna_rocha1981@hotmail.com","adriana_souza1957@hotmail.com",
//"rosana_rodrigues1997@hotmail.com","hellen_fernandes1982@hotmail.com","ana_bittencourt1980@outlook.com","jheniza_pinheiro1998@hotmail.com","julio_dotte1997@hotmail.com","anderson_andrade1994@hotmail.com","julio.nascimento1995@hotmail.com","lea_santos1991@hotmail.com",
//"lanna_moreira1977@outlook.com","ricardo_duarte1976@hotmail.com","jaqueline_linck1975@hotmail.com","francieli_ingrid1985@hotmail.com","ellensandra_jardim2000@hotmail.com","thais_vircosa2001@hotmail.com","ricardo_lima20101@hotmail.com","dernandonc@hotmail.com","marionovo@live.com","mario@vekttor.com");

//$emails = array("dernandonc@hotmail.com","dernando@hotmail");

//echo ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', 'vekttor@vkt.srv.br', 'Vekttor ', 'dernandonc@hotmail.com', 'dernando', 'teste de envio php smtp',' hurru testando', true);
//foreach($emails as $email){
	ENVIAEMAIL ('cmail.josueneto.com', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josueneto', 'dernandonc@hotmail.com', 'dernandonc@hotmail.com', 'teste de envio hotmail josue neto','mensagem teste de envio hotmail josue neto', true);
	ENVIAEMAIL ('cmail.josueneto.com', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josueneto', 'marionovo@live.com', 'marionovo@live.com', 'teste de envio hotmail josue neto','mensagem teste de envio hotmail josue neto', true);
	ENVIAEMAIL ('cmail.josueneto.com', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josueneto', 'cvsb8675@hotmail.com', 'cvsb8675@hotmail.com', 'teste de envio hotmail josue neto','mensagem teste de envio hotmail josue neto', true);
	ENVIAEMAIL ('cmail.josueneto.com', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josueneto', 'cvsb8675@outlook.com', 'cvsb8675@outlook.com', 'teste de envio hotmail josue neto','mensagem teste de envio hotmail josue neto', true);
	//echo "<br>";
//}
?>