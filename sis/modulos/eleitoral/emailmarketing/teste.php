<?php

require("phpmailer.inc.php");



$mail = new phpmailer;



$mail->IsSMTP(); // set mailer to use SMTP

$mail->From = "deputadojosueneto@vkt.srv.br";

$mail->FromName = "Mario TEste";

$mail->Host = "vkt.srv.br";  // specify main and backup server

$mail->AddAddress("deputadojosueneto@vkt.srv.br", "Josh Adams");

$mail->AddAddress("deputadojosueneto@vkt.srv.br");   // name is optional

$mail->AddReplyTo("mrio@vekttor.com", "Mario");

$mail->WordWrap = 50;    // set word wrap

//$mail->AddAttachment("c:\\temp\\js-bak.sql");  // add attachments

//$mail->AddAttachment("c:/temp/11-10-00.zip");



$mail->IsHTML(true);    // set email format to HTML

$mail->Subject = "Teste de envio de email";

$mail->Body = "Corpo do email com varias linhas


Corpo do email com varias linhas


Corpo do email com varias linhas


";

$mail->Send(); // send message

?>