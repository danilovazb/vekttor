<?php
function ENVIAEMAIL ($smtp, $porta, $senha, $usuario, $remetente, $remetentenome, $destinatario, $destinatarionome, $assunto, $mensagem, $debug) {


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
           "\r\n";

  $headers = "MIME-Version: 1.0\r\n".
             "Content-Type: text/plain; charset=\"Windows-1252\";\r\n".
              "Content-Transfer-Encoding: quoted-printable\r\n".
              "Precedence: bulk\r\n".
          "From: \"" . $remetentenome . "\" <" . $remetente . ">\r\n".
             "To: \"" . $destinatarionome . "\" <" . $destinatario . ">\r\n".
            "Subject: " . $assunto . " \r\n".
              "Reply-To: \"" . $remetentenome . "\" <" . $remetente . ">\r\n";
			  
//  $headers .= "dkim-signature:v=1;a=rsa-sha1;bh=".base64_encode(pack("H*", sha1($corpo))). //";c=relaxed;d=vkt.srv.br;h=mime-version:content-type:subject:Precedence:from:to:Subject:Reply-To;s=1373330478.vkt;".
//  "b=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC9yhbefmuFal0OqOiqKAd6mJsX".
// "BaFKvMO/dMoG1lPLr0z8P/C1m3tNHVE1UGM4/Hv+ruoNHGEVlLNiHszn0WQBhuoC".
//"i8PC+9zNG1SzK8BOOEfsXqPpqt9ZLCvbE8tecLmU1vokz0dfn9iSXRFwa8EhEwne".
//"sPYBFmvtNfjbJOqEyQIDAQAB\r\n";
 				
 
  $conn = fsockopen($smtp, $porta, $errno, $errstr, 30);
  fputs($conn, "EHLO " . $smtp . "\r\n");
  fputs($conn, "AUTH LOGIN\r\n");
  fputs($conn, base64_encode($usuario) . "\r\n");
  fputs($conn, base64_encode($senha) . "\r\n");
  fputs($conn, "MAIL FROM: " . $remetente . "\r\n");
  fputs($conn, "RCPT TO: " . $destinatario . "\r\n");
  fputs($conn, "DATA\r\n");
  fputs($conn, $headers);
  fputs($conn, $corpo);
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
		enviarEmail($dados['nome_envio'],$dados['email_envio'],$texto,$dados['mes'],$dados['bairro'],$dados['grupo_id'],$vkt_id,$id,$dados['grupo_social'], $dados['sexo'], $dados['cidade'],$dados['estado']);
	}
	return $id;
}

function exclui_emailmarketing($id){
	mysql_query($t="DELETE FROM eleitoral_emailmarketing WHERE id=$id");
	//echo $t." ".mysql_error();
}

function enviarEmail($nome_envio,$email_envio,$texto,$mes_aniversario,$bairro,$grupo_id,$vkt_id,$id,$grupo_social_id, $sexo, $cidade, $estado){
	//echo $texto;
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
	
	$emails = mysql_query($t="SELECT id,email FROM eleitoral_eleitores WHERE vkt_id='$vkt_id'  AND recebe_email='sim' AND email like '%facebook%' OR email LIKE '%hotmail%' AND email LIKE '%@%.%'  $filtro");

	$qtd_emails = mysql_num_rows($emails);

	$c=0;
	
	if(strlen($_POST[emailteste])>0){

		if(ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br',  $_POST[email_envio], 'Josueneto', $_POST[emailteste], $_POST[emailteste],$nome_envio, $texto, true)){
			alert("Email Enviado de teste para $_POST[emailteste]");
		}
	}else{

		while($email = mysql_fetch_object($emails)){
				$textot = $texto.' <br /><br /><br />
Caso não queira mais receber estes e-mails, <a href="http://bdamz.com.br/sis/modulos/eleitoral/emailmarketing/cancela_recebimento.php?eleitor_id='.base64_encode($email->id).'">clique aqui</a> <img src="bdamz.com.br/respostaemail.php?usr='.base64_encode($email->id.'|'.$vkt_id.'|'.$id).'">';
			if($c<$_POST[limite]){

				$recebeu = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_emailmarketing_envio WHERE vkt_id='$vkt_id' AND email_marketing_id='$id' AND eleitor_id='$email->id'"));
	
				if($c==0||$c==250||$c==500||$c==750||$c==999){

					ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', $_POST[email_envio], $_POST[email_envio], "mario@vektor.com", "Mário Novo", "[$c] confirmacao ".utf8_encode($nome_envio), utf8_encode($textot), true);

				}
		
				if($recebeu->id<1){
					
					if(ENVIAEMAIL ('vkt.srv.br', '587', 'cdwq8i9o','vekttor@vkt.srv.br', $_POST[email_envio], $_POST[email_envio], $email->email, $email->nome, utf8_encode($nome_envio), utf8_encode($textot), true)){
						$sucesso=1;
						mysql_query("INSERT INTO eleitoral_emailmarketing_envio SET vkt_id='$vkt_id', email_marketing_id='$id',eleitor_id='$email->id',data=now(),sucesso='$sucesso'");
						$c++;
					}else{
						$sucesso=0;
					}
				}
			}
		}
		alert("Email Enviado com sucesso, $c emails enviados !");
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