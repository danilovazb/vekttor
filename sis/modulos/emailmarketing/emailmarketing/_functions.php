<?php
function manipulaEmailmarketing($dados,$vkt_id){
	
	$texto = $dados[texto];
	
	if($dados['id']>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id'];
	}else{
		$inicio="INSERT INTO";
		$fim=",status='0'";
	}
	$sql=mysql_query($t="$inicio emailmarketing SET 
			vkt_id='$vkt_id',
			nome_envio='{$dados['nome_envio']}',
			email_envio='{$dados['email_envio']}',
			html='$texto',
			data_hora_envio=NOW(),
			mes_aniversario = '{$dados['mes']}',
			bairro          = '{$dados['bairro']}',
			grupo_id        = '{$dados['grupo_id']}'
			$fim");
			//echo $t;
	
	if($dados['id']>0){
		$id=$dados['id'];
	}else{
		$id=mysql_insert_id();
	}
	
	
	if($dados['enviar_email']>0){
		enviarEmail($dados['nome_envio'],$dados['email_envio'],$texto,$dados['mes'],$dados['bairro'],$dados['grupo_id'],$vkt_id,$id);
	}
	return $id;
}

function exclui_emailmarketing($id){
	mysql_query($t="DELETE FROM emailmarketing WHERE id=$id");
	//echo $t." ".mysql_error();
}

function enviarEmail($nome_envio,$email_envio,$texto,$mes_aniversario,$bairro,$grupo_id,$vkt_id,$id){
	//echo $texto;
	$filtro = '';
	if($mes_aniversario>0){
		$filtro.= "AND MONTH(nascimento) = '$mes_aniversario'";
	}
	if($bairro>0){
		$filtro.= "AND bairro = '$bairro'";
	}
	if($grupo_id>0){
		$filtro.= "AND grupo_id = '$grupo_id'";
	}
	$emails = mysql_query($t="SELECT id,email FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id'  AND email not like '%facebook%' AND email LIKE '%@%.%' $filtro");
	//echo $t;
	$qtd_emails = mysql_num_rows($emails);
	//alert($qtd_emails);
	//$destinatarios = '';
	$c=0;
	$headers = 'MIME-Version: 1.0' . "\r\n".
	'Content-type: text/html; charset=iso-8859-1' . "\r\n".
	'From: '.trim($email_envio)."\r\n" .
    'Return-Path: '.trim($email_envio). ">\r\n" .
    'Reply-To: '.trim($email_envio).">\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	$texto =  file_get_contents("http://vkt.srv.br/~nv/sis/modulos/emailmarketing/emailmarketing/email.php?id=".$id."&vkt_id=".$vkt_id);
	
	
	
	while($email = mysql_fetch_object($emails)){

		
		$corpo = $texto.' <div style="clear:both;margin-bottom:5px;"></div>
    Caso não queira mais receber estes e-mails, 
	<a href="http://vkt.srv.br/~nv/sis/modulos/emailmarketing/emailmarketing/cancela_recebimento.php?cliente_fornecedor_id='.base64_encode($email->id).'">
	clique aqui</a></div><img 
		src="http://vkt.srv.br/~nv/sis/modulos/emailmarketing/emailmarketing/respostaemail.php?usr='.base64_encode($email->id.'|'.$vkt_id.'|'.$id).'">';
		$destinatarios="$email->email";
		
		
		// pergunta se ja foi enviado para essa pessoa esse email
		$recebeu = mysql_fetch_object(mysql_query("SELECT * FROM emailmarketing_envio WHERE vkt_id='$vkt_id' AND emailmarketing_id='$id' AND cliente_fornecedor_id='$email->id'"));
		//se não foi tenta enviar 
		if($recebeu->id<1){
			if(mail($destinatarios,$nome_envio,$corpo,$headers)){
				$sucesso=1;
				$c++;
			}else{
				$sucesso=0;
			}
			// guarda a informação que foi enivado
			mysql_query("INSERT INTO emailmarketing_envio SET vkt_id='$vkt_id', emailmarketing_id='$id',cliente_fornecedor_id='$email->id',data=now(),sucesso='$sucesso'");
		}
	}
	
	
	alert("Email Enviado com sucesso, $c emails enviados !");
	mysql_query("UPDATE emailmarketing SET status='1' WHERE id='$id'");
	
	if($dados['id']>0){
		return $dados['id'];
	}else{
		return mysql_insert_id();
	}
}

function incluirImagem($dados){
	
	global $vkt_id;
	
	if($dados['id']<=0){
		$id = manipulaEmailmarketing($dados,$vkt_id);
		echo "<script>top.document.getElementById('id').value= '$id'</script>";
	}else{
		$id = $dados['id'];
	}
	
	$filis_autorizados = array('jpg','gif','png','pdf','jpeg');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT ordem as ordem FROM emailmarketing_imagens WHERE emailmarketing_id='$id' ORDER BY id DESC LIMIT 1"));
	
	$ordem = $infomovimento->ordem+1;
	//alert($ordem);
	$pasta 	= 'modulos/emailmarketing/emailmarketing/img/';
	  $extensao = str_replace('.','',strtolower(substr($_FILES['imagem']['name'],-4)));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  //alert($arquivo);
	  $arquivodel= $pasta.$produto_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['imagem'][tmp_name],$arquivo)){
			  mysql_query($f="INSERT INTO emailmarketing_imagens SET ordem='$ordem',extensao='$extensao',emailmarketing_id='$id'");
			  $imagem_id = mysql_insert_id();
			  //alert($imagem_id);
			  @rename("modulos/emailmarketing/emailmarketing/img/$id.$extensao","modulos/emailmarketing/emailmarketing/img/$imagem_id.$extensao");
			  //alert($f);
			  echo "<script>top.document.getElementById('d_imagens').innerHTML += '<img src=\"modulos/emailmarketing/emailmarketing/img/$imagem_id.$extensao\" width=\"50\" height=\"50\" class=\"imagens\"/>'</script>";
			  
              chmod($pasta,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
}
?>