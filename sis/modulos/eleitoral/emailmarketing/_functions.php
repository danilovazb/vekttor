<?php
function ENVIAEMAIL ($smtp, $porta, $senha, $usuario, $remetente, $remetentenome, $destinatario, $destinatarionome, $assunto, $mensagem, $debug) {
 
  $headers = utf8_encode("MIME-Version: 1.0\r\n".
             "Content-type: text/html; charset=utf-8\r\n".
             "Precedence: bulk\r\n".
            "From: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "Reply-To: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "To: \"" . $destinatarionome . "\" <" . $destinatario . ">\r\n".
             "Subject: " . $assunto . " \r\n");

  $corpo = utf8_encode("\r\n<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n". 
           "<body bgcolor=\"#FFFFFF\">\r\n".
           $mensagem . "\r\n".
           "</body>\r\n".
           "</html>\r\n".
           "\n");
  $conn = fsockopen($smtp, $porta, $errno, $errstr, 30);
  fputs($conn, "EHLO " . $smtp . "\r\n");
  fputs($conn, "AUTH LOGIN\r\n");
  fputs($conn, base64_encode($usuario) . "\r\n");
  fputs($conn, base64_encode($senha) . "\r\n");
  fputs($conn, "MAIL FROM: " . $remetente . "\r\n");
  fputs($conn, "RCPT TO: " . $destinatario . "\r\n");
  fputs($conn, "DATA\r\n");
  fputs($conn, $headers);
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

function manipulaEmailmarketing($dados,$vkt_id,$origem){
	
	$texto = $dados[texto];
	
	if($dados['id']>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id'];
	}else{
		$inicio="INSERT INTO";
		$fim=",status='0'";
	}
	$sql=mysql_query($t="$inicio eleitoral_emailmarketing SET 
			vkt_id='$vkt_id',
			nome_envio='{$dados['nome_envio']}',
			email_envio='{$dados['email_envio']}',
			html='$texto',
			data_hora_envio=NOW(),
			mes_aniversario = '{$dados['mes']}',
			bairro          = '{$dados['bairro']}',
			status_voto        = '{$dados['status_voto']}',
			grupo_social_id = '{$dados['grupo_social']}' 
			$fim");
			
			//echo $t."<br>".mysql_error();
	
	if($dados['id']>0){
		$id=$dados['id'];
	}else{
		$id=mysql_insert_id();
	}
	
	
	if($dados['enviar_email']>0&&$origem=='emailmarketing'){
		enviarEmail($dados['nome_envio'],$dados['email_envio'],$texto,$dados['mes'],$dados['bairro'],$dados['grupo_id'],$vkt_id,$id,$dados['grupo_social'], $dados['sexo'], $dados['cidade'],$dados['estado'],$id);
	}
	return $id;
}

function exclui_emailmarketing($id){
	mysql_query($t="DELETE FROM eleitoral_emailmarketing WHERE id=$id");
	//echo $t." ".mysql_error();
}

function enviarEmail($nome_envio,$email_envio,$texto,$mes_aniversario,$bairro,$grupo_id,$vkt_id,$id,$grupo_social_id, $sexo, $cidade, $estado,$id){
	
	$texto = mysql_result(mysql_query("SELECT html FROM eleitoral_emailmarketing WHERE id='$id'"),0,0);
	
	
	$filtro = '';
	if($mes_aniversario>0){
		$filtro .= " AND MONTH(data_nascimento) = '$mes_aniversario' ";
	}
	if($bairro>0){
		$filtro .= " AND bairro = '$bairro' ";
	}
	if($grupo_id>0){
		$filtro .= " AND status_voto = '$status_voto' ";
	}
	if($grupo_social_id>0){
		$filtro .= " AND grupo_social_id = '$grupo_social_id' ";
	}
	if($sexo=='m'){
		$filtro .= " AND sexo='masculino' ";
	}
	if($sexo=='f'){
		$filtro .= " AND sexo='feminino' ";
	}
	
	if(!empty($cidade)){
		$filtro .= " AND cidade='$cidade' ";
	}
	
	if(!empty($estado)){
		$filtro .= " AND estado='$estado' ";
	}
	
	//if($_POST[limite]>0){
	//	$filtro .= " LIMIT $_POST[limite] ";
	//}
	
	$emails = mysql_query($t="SELECT id,email FROM eleitoral_eleitores WHERE vkt_id='$vkt_id'  AND recebe_email='sim' AND email LIKE '%@%.%'  $filtro");

	$qtd_emails = mysql_num_rows($emails);


	$c=0;
	
	if(strlen($_POST[emailteste])>0){

		
		if(ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josu� Neto', $_POST[emailteste], $_POST[emailteste],$nome_envio.'[teste]', $texto, true)){
			
			alert("Email Enviado de teste para $_POST[emailteste]");
		}
		
		if($vkt_id=='173'){
			//$enviaemail = ENVIAEMAIL ('smtp.live.com', '587', 'cdwq8i9o','marcelo_ramos_@hotmail.com', 'marcelo_ramos_@hotmail.com', $_POST['email_envio'], $email->email, $email->nome, $nome_envio, $textot, true);
			$enviaemail = ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', 'vekttor@vkt.srv.br', $_POST['email_envio'], $_POST[emailteste], $_POST[emailteste],$nome_envio.'[teste]', $texto, true);
		}else if($vkt_id=='169'){
			$enviaemail = ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josué Neto', $_POST[emailteste], $_POST[emailteste],$nome_envio.'[teste]', $texto, true);
		}else{
			$enviaemail = ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', 'vekttor@vkt.srv.br', $_POST['email_envio'], $_POST[emailteste], $_POST[emailteste],$nome_envio.'[teste]', $texto, true);
		//$enviaemail = ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josu� Neto', $email->email, $email->nome, $nome_envio, $textot, true);
		}
	}else{
		$c=0;
		while($email = mysql_fetch_object($emails)){
				$textot = $texto.' <br /><br /><br />
<a href="http://bdamz.com.br/sis/modulos/eleitoral/emailmarketing/cancela_recebimento.php?eleitor_id='.base64_encode($email->id).'">Caso n�o queira mais receber estes e-mails</a> <img src="bdamz.com.br/respostaemail.php?usr='.base64_encode($email->id.'|'.$vkt_id.'|'.$id).'">';
			if($c<$_POST[limite]||empty($_POST[limite])){

				$recebeu = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_emailmarketing_envio WHERE vkt_id='$vkt_id' AND email_marketing_id='$id' AND eleitor_id='$email->id'"));
	
				if(($c==0||$c==250||$c==500||$c==750||$c==999||$c==2000||$c==4000||$c==6000||$c==8000||$c==10000||$c==12000||$c==15000||$c==2000||$c==2000) && $vkt_id=="169"){

					ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josu� Neto', "mario@vektor.com", "M�rio Novo", "[$c] confirmacao ".$nome_envio, $textot, true);
					
				}
				
				if($recebeu->id<1){
					
					if($vkt_id=='173'){
						//$enviaemail = ENVIAEMAIL ('smtp.live.com', '587', 'cdwq8i9o','marcelo_ramos_@hotmail.com', 'marcelo_ramos_@hotmail.com', $_POST['email_envio'], $email->email, $email->nome, $nome_envio, $textot, true);
						$enviaemail = ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', 'vekttor@vkt.srv.br', $_POST['email_envio'], $email->email, $email->nome, $nome_envio, $textot, true);
					}else if($vkt_id=='169'){
						ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josu� Neto', "mario@vektor.com", "M�rio Novo", "[$c] confirmacao ".$nome_envio, $textot, true);
					}else{
						$enviaemail = ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', 'vekttor@vkt.srv.br', $_POST['email_envio'], $email->email, $email->nome, $nome_envio, $textot, true);
						//$enviaemail = ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','deputado@josueneto.com', 'deputado@josueneto.com', 'Josu� Neto', $email->email, $email->nome, $nome_envio, $textot, true);
					}
					
					
					if($enviaemail){
						mysql_query("INSERT INTO eleitoral_emailmarketing_envio SET vkt_id='$vkt_id', email_marketing_id='$id',eleitor_id='$email->id',data=now(),sucesso='$sucesso'");
						$c++;
					}
				}
			}
		}
		alert("($qtd_emails)$c emails, $c emails enviados !");
	}
	
	
	mysql_query("UPDATE eleitoral_emailmarketing SET status='1' WHERE id='$id'");
	
	if($dados['id']>0){
		return $dados['id'];
	}else{
		return mysql_insert_id();
	}
}

function incluirImagem($dados){
	
	global $vkt_id;
	
	if($dados['id']<=0){
		$id = manipulaEmailmarketing($dados,$vkt_id,'imagem');
		echo "<script>top.document.getElementById('id').value= '$id'</script>";
	}else{
		$id = $dados['id'];
	}
	
	$filis_autorizados = array('jpg','gif','png','pdf','jpeg');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT ordem as ordem FROM eleitoral_emailmarketing_imagens WHERE eleitoral_emailmarketing_id='$id' ORDER BY id DESC LIMIT 1"));
	
	$ordem = $infomovimento->ordem+1;
	//alert($ordem);
	$pasta 	= 'modulos/eleitoral/emailmarketing/img/';
	  $extensao = str_replace('.','',strtolower(substr($_FILES['imagem']['name'],-4)));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  //alert($arquivo);
	  $arquivodel= $pasta.$produto_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['imagem'][tmp_name],$arquivo)){
			  mysql_query($f="INSERT INTO eleitoral_emailmarketing_imagens SET ordem='$ordem',extensao='$extensao',eleitoral_emailmarketing_id='$id'");
			  $imagem_id = mysql_insert_id();
			  //alert($imagem_id);
			  @rename("modulos/eleitoral/emailmarketing/img/$id.$extensao","modulos/eleitoral/emailmarketing/img/$imagem_id.$extensao");
			  //alert($f);
			  echo "<script>top.document.getElementById('d_imagens').innerHTML += '<div style=\"height:70px;float:left;\" id=\"$imagem_id\"><img src=\"modulos/eleitoral/emailmarketing/img/$imagem_id.$extensao\" width=\"50\" height=\"50\" class=\"imagens\"/><div style=\"clear:both\"></div><a href=\"#\" id=\"remover_imagem\">Remover</a></div>'</script>";
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
}
?>