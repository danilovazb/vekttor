<?php
function manipulaConfiguracao($dados){
		global $vkt_id;
		
		$email_agendamento = 'nao';
		$sms_agendamento   = 'nao';
		$email_aniversario = 'nao';
		$sms_aniversario   = 'nao';
		$email_visita      = 'nao';
		
		if(isset($dados['email_agendamento'])>0){
			$email_agendamento = "sim";
		}
		if(isset($dados['sms_agendamento'])>0){
			$sms_agendamento = "sim";
		}
		if(isset($dados['email_aniversario'])>0){
			$email_aniversario = "sim";
		}
		if(isset($dados['sms_aniversario'])>0){
			$sms_aniversario = "sim";
		}
		if(isset($dados['email_visita'])>0){
			$email_visita    = "sim";
		}
		if(isset($dados['sms_visita'])>0){
			$sms_visita    = "sim";
		}
		if(!$dados['id']>0){
			$sql_inicio="INSERT INTO";
			$sql_fim="";
		}else{
			$sql_inicio="UPDATE";
			$sql_fim=" WHERE vkt_id='$vkt_id'";
		}
		mysql_query($t="$sql_inicio 
						configuracao_relacionamento
						SET
						vkt_id='$vkt_id',
						email_agendamento = '$email_agendamento',
						sms_agendamento   = '$sms_agendamento',
						email_aniversario = '$email_aniversario',
						sms_aniversario   = '$sms_aniversario',
						email_visita      = '$email_visita',
						sms_visita        = '$sms_visita',
						de_email_agendamento = '$dados[de_email_agendamento]',
						assunto_email_agendamento = '$dados[assunto_email_agendamento]',
						texto_email_agendamento   = '$dados[texto_email_agendamento]',
						de_sms_mensagem   = '$dados[de_sms_mensagem]',
						texto_sms_mensagem= '$dados[texto_sms_mensagem]',
						de_email_aniversariante='$dados[de_email_aniversariante]',
						assunto_email_aniversariante='$dados[assunto_email_aniversariante]', 
						texto_email_aniversariante='$dados[texto_email_aniversariante]',
						de_sms_aniversario   = '$dados[de_sms_aniversario]',
						texto_sms_aniversario= '$dados[texto_sms_aniversario]',
						de_email_visita      = '$dados[de_email_visita]',
						assunto_email_visita = '$dados[assunto_email_visita]',
						texto_email_visita   = '$dados[texto_email_visita]',
						dias_envio_email_visita= '$dados[dias_envio_email_visita]',
						texto_sms_visita     = '$dados[texto_sms_visita]',
						dias_envio_sms_visita= '$dados[dias_envio_sms_visita]'
					 $sql_fim");
					//echo $t;
}

function ENVIAEMAIL($smtp, $porta, $senha, $usuario, $remetente, $remetentenome, $destinatario, $destinatarionome, $assunto, $mensagem, $debug) {
 
  $headers = "MIME-Version: 1.0\r\n".
             "Content-type: text/html;\r\n".
             "Precedence: bulk\r\n".
            "From: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "Reply-To: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "To: \"" . $destinatarionome . "\" <" . $destinatario . ">\r\n".
             "Subject: " . $assunto . " \r\n";
             "Date: ". date('D, d M Y H:i:s O') ." \r\n";
             "X-Mailer: WV Mailer\r\n".
             "X-SenderIP: " . $_SERVER["REMOTE_ADDR"] . "\r\n".
        "v=DKIM1;t=s;p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDb2HAFelMTRSr7LF9rwaayQXct\r\n".
        "fFEoicDrv1jE+vrL1RPmuKC6pxVjTg3s2/upncvZdwelcPvEY7eQJE0Ni9MVT4Dz\r\n".
        "layd2pAzDGvoPnG4pwB1HcXeXAxUcwV7IVbpTpqWUbiXeiNOxBUOHZ18Fwmx8TXG\r\n".
        "yhyM0AOU331PeiVIxwIDAQAB\r\n";
 				
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
  //echo $smtp." ".$porta." $destinatario <br>";
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
	return "1";
  } else {
  	//echo "Nao enviado para $destinatario <br>";
	return "0";
  }
}

function quantidade_sms($cliente_id){
	$limite = mysql_fetch_object(mysql_query($t=" SELECT * FROM clientes_vekttor WHERE id = '$cliente_id'"));
		
	$qtdEnviado = mysql_fetch_object(mysql_query($r=" SELECT COUNT(id) AS enviado FROM rel_sms WHERE vkt_id = '$cliente_id' AND MONTH(data_envio) = MONTH(NOW())"));
	$disponivel =  ($limite->quantidade_sms_mes - $qtdEnviado->enviado);
	
	return $disponivel;
}

function manipula_relacionamento_email($cliente, $origem_id, $paciente_id, $tipo, $assunto,$mensagem){
	mysql_query($t="INSERT INTO relacionamento_email SET vkt_id='$cliente', origem_id='$origem_id',paciente_id='$paciente_id', tipo='$tipo',assunto='$assunto',mensagem='$mensagem',data_envio=NOW()");
	return mysql_insert_id();
}

function manipula_relacionamento_sms($cliente, $origem_id, $paciente_id, $tipo, $mensagem,$status,$telefone){
	mysql_query($t="INSERT INTO relacionamento_sms SET vkt_id='$cliente', origem_id='$origem_id',paciente_id='$paciente_id', tipo='$tipo',mensagem='$mensagem',data_envio=NOW()");
	mysql_query($t="INSERT INTO rel_sms SET vkt_id='$cliente',cliente_id='$paciente_id', msg='$mensagem',data_envio=NOW(),status='$status',numero_destino='$telefone'");
	echo mysql_error();
}

function email_agendamento($cliente,$de,$assunto,$mensagem){
	//seleciona os pacientes com agendamento
	$pacientes = mysql_query($t="SELECT 
									*, aa.id as agendamento_id, cf.id as paciente_id 
								FROM 
									agenda_agendamento aa,
									cliente_fornecedor cf 
								WHERE
									aa.vkt_id='$cliente' AND 
									aa.cliente_id = cf.id AND
									DAY(aa.data_hora_inicio) = DAY(NOW()) AND 
									MONTH(aa.data_hora_inicio) = MONTH(NOW()) AND
									YEAR(aa.data_hora_inicio) = YEAR(NOW())");
	
	while($paciente = mysql_fetch_object($pacientes)){
		//verifica se este email já foi enviado para este paciente
		
		$ja_enviou = mysql_fetch_object(mysql_query("SELECT * FROM relacionamento_email WHERE paciente_id='$paciente->paciente_id' AND origem_id='$paciente->agendamento_id' AND tipo='agendamento'")); 
		
		if(!$ja_enviou->id>0){		
			$email_id = manipula_relacionamento_email ($cliente, $paciente->agendamento_id, $paciente->paciente_id, "agendamento", $assunto,$mensagem);
			$mensagem .= "<br><img src='vkt.srv.br/~nv/respostaemail.php?email_odonto=".base64_encode($email_id.'|'.$cliente.'|'.$paciente->paciente_id)."'>";
			ENVIAEMAIL('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', $de, $paciente->email, $paciente->razao_social, utf8_encode($assunto), utf8_encode($mensagem), true);
			
		}
	}
}

function sms_agendamento($cliente,$de,$mensagem,$config){
	//seleciona os pacientes com agendamento
	$pacientes = mysql_query($t="SELECT 
									*, aa.id as agendamento_id, cf.id as paciente_id 
								FROM 
									agenda_agendamento aa,
									cliente_fornecedor cf 
								WHERE
									aa.vkt_id='$cliente' AND 
									aa.cliente_id = cf.id AND
									DAY(aa.data_hora_inicio) = DAY(NOW()) AND 
									MONTH(aa.data_hora_inicio) = MONTH(NOW()) AND
									YEAR(aa.data_hora_inicio) = YEAR(NOW())");
	
	while($paciente = mysql_fetch_object($pacientes)){
		
		//verifica se este sms já foi enviado para este paciente
		$ja_enviou = mysql_fetch_object(mysql_query("SELECT * FROM relacionamento_sms WHERE paciente_id='$paciente->paciente_id' AND origem_id='$paciente->agendamento_id' AND tipo='agendamento'")); 
		
		if(!$ja_enviou->id>0){	
			//echo "Telefone: ".$paciente->telefone1."<br>";
			$caracter = array('-',')','(',' ','+');
			$telefone = str_replace($caracter,'',$paciente->telefone1);
			/* Modo de Envio do Servidor   1 = Modem , 2 = ComTele */
			$config->SetServidorEnvio(2);
			$return = $config->SMSEnvia($cliente,$telefone,$mensagem);	
			if($return == true){
				manipula_relacionamento_sms($cliente, $paciente->agendamento_id, $paciente->paciente_id, "agendamento", $mensagem,'1',$telefone);
			}else{
				manipula_relacionamento_sms($cliente, $paciente->agendamento_id, $paciente->paciente_id, "agendamento", $mensagem,'0',$telefone);
			}
			
		}
	}
}

function email_aniversario($nome_clinica,$cliente,$de,$assunto,$mensagem){
	//seleciona os pacientes com agendamento
	$mensagem.=" A/C $nome_clinica";
	//echo $mensagem."<br>";
	$pacientes = mysql_query($t="SELECT 
									*, oa.id as atendimento_id 
								FROM 
									odontologo_atendimentos oa,
									cliente_fornecedor cf 
								WHERE
									oa.vkt_id='$cliente' AND 
									oa.cliente_fornecedor_id = cf.id AND
									MONTH(cf.nascimento) = MONTH(NOW()) AND
									DAY(cf.nascimento) = DAY(NOW())");
	
	while($paciente = mysql_fetch_object($pacientes)){
		
		$ja_enviou = mysql_fetch_object(mysql_query("SELECT * FROM relacionamento_email WHERE paciente_id='$paciente->cliente_fornecedor_id' AND origem_id='$paciente->atendimento_id' AND YEAR(data_envio)=YEAR(NOW()) AND tipo='aniversario'"));
		
		if(!$ja_enviou->id>0){		
			$email_id = manipula_relacionamento_email($cliente, $paciente->atendimento_id, $paciente->id, "aniversario", $assunto,$mensagem);
			$mensagem .= "<br><img src='vkt.srv.br/~nv/respostaemail.php?email_odonto=".base64_encode($email_id.'|'.$cliente.'|'.$paciente->cliente_fornecedor_id)."'>";
			ENVIAEMAIL('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', $de, $paciente->email, $paciente->razao_social, utf8_encode($assunto), utf8_encode($mensagem), true);
		}
	}
}

function sms_aniversario($nome_clinica,$cliente,$d,$mensagem,$config){
	//echo $nome_clinica;
	$mensagem.=" \n A/C $nome_clinica";
	//seleciona os pacientes com agendamento
	$pacientes = mysql_query($t="SELECT 
									*, oa.id as atendimento_id 
								FROM 
									odontologo_atendimentos oa,
									cliente_fornecedor cf 
								WHERE
									oa.vkt_id='$cliente' AND 
									oa.cliente_fornecedor_id = cf.id AND
									MONTH(cf.nascimento) = MONTH(NOW()) AND
									DAY(cf.nascimento) = DAY(NOW())");
	
	while($paciente = mysql_fetch_object($pacientes)){
		
		$ja_enviou = mysql_fetch_object(mysql_query("SELECT * FROM relacionamento_sms WHERE paciente_id='$paciente->cliente_fornecedor_id' AND origem_id='$paciente->atendimento_id' AND YEAR(data_envio)=YEAR(NOW()) AND tipo='aniversario'"));
		
		if(!$ja_enviou->id>0){	
			//echo "Telefone: ".$paciente->telefone1."<br>";
			$caracter = array('-',')','(',' ','+');
			$telefone = str_replace($caracter,'',$paciente->telefone1);
			/* Modo de Envio do Servidor   1 = Modem , 2 = ComTele */
			$config->SetServidorEnvio(2);
			$return = $config->SMSEnvia($cliente,$telefone,$mensagem);	
			if($return == true){
				manipula_relacionamento_sms($cliente, $paciente->atendimento_id, $paciente->cliente_fornecedor_id, "aniversario", $mensagem,'1',$telefone);
			}else{
				manipula_relacionamento_sms($cliente, $paciente->atendimento_id, $paciente->cliente_fornecedor_id, "aniversario", $mensagem,'0',$telefone);
			}
			
		}
	}
}

function email_visita($cliente,$de,$assunto,$mensagem,$qtd_dias){
	//seleciona os pacientes com agendamento
	$pacientes = mysql_query($t="SELECT 
									*, oai.id as odontologo_atendimento_item_id 
								FROM 
									odontologo_atendimento_item oai,
									cliente_fornecedor cf 
								WHERE
									oai.vkt_id='$cliente' AND 
									oai.cliente_fornecedor_id = cf.id AND
									(DATEDIFF(NOW(),oai.data_cadastro) >= $qtd_dias)									
								");
	//echo $t;
	while($paciente = mysql_fetch_object($pacientes)){
		//echo $paciente->odontologo_atendimento_item_id."<br>";
		$ja_enviou = mysql_fetch_object(mysql_query($t="SELECT * FROM relacionamento_email WHERE paciente_id='$paciente->cliente_fornecedor_id' AND data_envio=CURDATE() AND tipo='paciente_inativo'"));
		//echo $t." ".$paciente->cliente_fornecedor_id." ".$ja_enviou->id."<br>";
		//echo $t."<br>";
		if(!$ja_enviou->id>0){
			//echo "vai enviar email de visita para $paciente->email";
			$email_id = manipula_relacionamento_email($cliente, $paciente->odontologo_atendimento_item_id, $paciente->cliente_fornecedor_id, "paciente_inativo", $assunto,$mensagem);
			$mensagem .= "<br><img src='vkt.srv.br/~nv/respostaemail.php?email_odonto=".base64_encode($email_id.'|'.$cliente.'|'.$paciente->cliente_fornecedor_id)."'>";
			ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', $de, $paciente->email, $paciente->razao_social, utf8_encode($assunto), $mensagem, true);
		}
	}
}

function sms_visita($cliente,$mensagem,$qtd_dias,$config){
	//seleciona os pacientes com agendamento
	$pacientes = mysql_query($t="SELECT 
									*, oa.id as atendimento_id 
								FROM 
									odontologo_atendimentos oa,
									cliente_fornecedor cf 
								WHERE
									oa.vkt_id='$cliente' AND 
									oa.cliente_fornecedor_id = cf.id AND
									MONTH(cf.nascimento) = MONTH(NOW()) AND
									DAY(cf.nascimento) = DAY(NOW())");
	
	while($paciente = mysql_fetch_object($pacientes)){
		
		$ja_enviou = mysql_fetch_object(mysql_query($t="SELECT * FROM relacionamento_sms WHERE paciente_id='$paciente->cliente_fornecedor_id' AND data_envio=CURDATE() AND tipo='paciente_inativo'"));
		
		if(!$ja_enviou->id>0){	
			//echo "Telefone: ".$paciente->telefone1."<br>";
			$caracter = array('-',')','(',' ','+');
			$telefone = str_replace($caracter,'',$paciente->telefone1);
			/* Modo de Envio do Servidor   1 = Modem , 2 = ComTele */
			$config->SetServidorEnvio(2);
			$return = $config->SMSEnvia($cliente,$telefone,$mensagem);	
			if($return == true){
				manipula_relacionamento_sms($cliente, $paciente->atendimento_id, $paciente->cliente_fornecedor_id, "paciente_inativo", $mensagem,'1',$telefone);
			}else{
				manipula_relacionamento_sms($cliente, $paciente->atendimento_id, $paciente->cliente_fornecedor_id, "paciente_inativo", $mensagem,'0',$telefone);
			}
			
		}
	}
}

?>