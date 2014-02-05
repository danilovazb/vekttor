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
		// Define que a mensagem poderá ter formataçao HTML
		$mail->IsHTML(true); //
 		 
		// Define que a codificaçao do conteúdo da mensagem será utf-8
		$mail->CharSet    = "iso8859-i";
 
		// Define que os emails enviadas utilizarao SMTP Seguro tls
		$mail->SMTPSecure = "tls";
 
		// Define que o Host que enviará a mensagem é o Hotmail
		$mail->Host       = "vkt.srv.br";
 
		//Define a porta utilizada pelo Gmail para o envio autenticado
		$mail->Port       = "587";                  
 
		// Deine que a mensagem utiliza método de envio autenticado
		$mail->SMTPAuth   = "true";
 
		// Define o usuário do hotmail autenticado responsável pelo envio
		$mail->Username   = $from;
 
		// Define a senha deste usuário citado acima
		$mail->Password   = "cdwq8i9o";
 
		// Defina o email e o nome que aparecerá como remetente no cabeçalho
		$mail->From       = "deputado@marceloramos.com";
		$mail->FromName   = "Deputado Marcelo Ramos";
 
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
 
    		//echo "Erro de envio para $para: " . $mail->ErrorInfo."<br>";
 
		}
		else{
 
    		//echo "Mensagem enviada com sucesso para $para!"."<br>";
 
		}
	}

//Caso acao venha do form de cancelar recebimento de email
if($_POST['action']=='retirar_email'){
	mysql_query($t="UPDATE eleitoral_eleitores SET recebe_email='nao' WHERE email='".$_POST['email']."' AND vkt_id='173'");
	//alert($t);
	echo "<script>alert('Este email não irá mais receber nossas mensagens!');history.back();</script>";
	exit();
}

if($_POST['action']=='confirmar_email'){
	$id = base64_decode($_POST['id']);
	mysql_query($t="UPDATE eleitoral_eleitores SET grupo_social_id='56' WHERE id='$id'");
	//alert($t);
	echo "<script>alert('Seu cadastro foi confirmado com Sucesso!');history.back();</script>";
	exit();
}

//Caso acao venha do form de cadastro de eleitores
if($_POST['action']=="Salvar"){
	
	//$_POST = utf8_encode($_POST);
	
	$email = $_POST['email'];
	$vkt_id="173";
	$existe_email=mysql_fetch_object(mysql_query($t="SELECT * FROM eleitoral_eleitores WHERE email='$email' AND vkt_id='$vkt_id'"));
	//$via_site = "sim";	
	//echo $t." ".mysql_error();
	
	if(!$existe_email->id > 0){	
		//alert('Vai cadastrar');
		if($_POST['qtd_dependentes']>0){
			for($i=0;$i<$_POST['qtd_dependentes'];$i++){
				$_POST['dependente_nome'][$i]="filho ".($i+1);
				$_POST['dependente_vinculo'][$i]='6';
			}
		}//if($_POST['qtd_dependentes']>0)
		$_POST['receber_email']="on";
		$_POST['receber_sms']="on";
		//$_POST['grupo_social_id']='56';
		include('../sis/modulos/eleitoral/eleitores/_function.php');
		include('../sis/modulos/eleitoral/eleitores/_ctrl.php');
		$eleitor_id = base64_encode($eleitor_id);
	}else{
		echo "<script>alert('Este email ja este cadastrado!');history.back();</script>";
	}
	//if(empty($email))
	
	
	$assunto = "Confirmacao de Cadastro Deputado Marcelo Ramos";
	$mensagem = "Por favor, confirme seu cadastro <br> <a href='http://vkt.srv.br/~nv/eleitoral/confirma_email.php?id=$eleitor_id'>clicando aqui</a>";
	envia_email($email,$assunto,$mensagem,"deputado@josueneto.com");
	echo "<script>alert('Cadastro Realizado Com Sucesso!Um E-mail De Confirmacao Foi enviado para voce, verifique sua caixa de entrada, lixeira ou spam');history.back();</script>";
	exit();
}
?>