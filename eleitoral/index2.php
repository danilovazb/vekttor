<?php
 	$_SESSION['usuario']->cliente_vekttor_id='169';
	$_SESSION['usuario']->usuario_tipo_id='200';
	$vkt_id='169';
	//var_dump($_POST);

	include('../sis/_config.php');
	include('../sis/_functions_base.php');
 
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
		$mail->Host       = "cmail.josueneto.com";
 
		//Define a porta utilizada pelo Gmail para o envio autenticado
		$mail->Port       = "587";                  
 
		// Deine que a mensagem utiliza m�todo de envio autenticado
		$mail->SMTPAuth   = "true";
 
		// Define o usu�rio do hotmail autenticado respons�vel pelo envio
		$mail->Username   = $from;
 
		// Define a senha deste usu�rio citado acima
		$mail->Password   = "cdwq8i9o";
 
		// Defina o email e o nome que aparecer� como remetente no cabe�alho
		$mail->From       = "deputado@josueneto.com";
		$mail->FromName   = "Deputado";
 
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
 
		}
		else{
 
    		echo "Mensagem enviada com sucesso para $para!"."<br>";
 
		}
	}
/*$emails = array("joao1silva_1980@hotmail.com");

foreach($emails as $email){
	envia_email($email,"Teste Hotmail PHP Mailer","Teste de Hotmail Usando PHP Mailer","deputado@josueneto.com");
}*/

//Caso acao venha do form de cadastro de eleitores
if($_POST['action']=="Salvar"){
	$email = $_POST['email'];
	if($_POST['qtd_dependentes']>0){
		for($i=0;$i<=count($_POST['qtd_dependentes']);$i++){
			$_POST['dependente_nome'][$i]="filho ".($i+1);
			$_POST['dependente_vinculo'][$i]='6';
		}
	}
	
	$_POST['grupo_social_id']='57';
	include('../sis/modulos/eleitoral/eleitores/_function.php');
	include('../sis/modulos/eleitoral/eleitores/_ctrl.php');
	$eleitor_id = base64_encode($eleitor_id);
	$assunto = "Confirmacao de Cadastro Josue Neto";
	$mensagem = "Por favor, confirme seu cadastro <br> <a href='http://www.bdamz.com.br/eleitoral/confirma_email.html'>clicando aqui</a>";
	envia_email($email,$assunto,$mensagem,"deputado@josueneto.com");
	echo "<script>alert('Cadastro Realizado Com Sucesso!Um E-mail De Confirmacao Foi enviado para voc�, verifique sua caixa de entrada, lixeira ou spam!');history.back();</script>";
	exit();
}
/*$mensagem = "Voc� precisa confirmar o cadastro efetuado no site do Josu� Neto. Por favor, clique no link abaixo.";
$email = $_POST['email'];
envia_email($email,'Confirma��o de Cadastro Josu� Neto',$mensagem,$from);
*/
?>