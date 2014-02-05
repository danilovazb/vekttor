<?php
	function upload_arquivo($grupo_social_id){
		
	global $vkt_id;
	global $usuario_id;
	
	$filis_autorizados = array('csv','txt','xls');
	
	if(strlen($_FILES['arquivo']['name'])>4){
	  $pasta 	= 'modulos/eleitoral/importacao_email/arquivos/';
	  $extensao = strtolower(substr($_FILES['arquivo']['name'],-3));
	  $arquivo 	= $pasta."$usuario_id.".$extensao;
	  $arquivodel= $pasta.$usuario_id;
	
	  if(in_array($extensao,$filis_autorizados)){
		 
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo'][tmp_name],$arquivo)){
			 // alert('oi2');
			  importa_email($grupo_social_id,$extensao);			  
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
			
	}
	
function importa_email($grupo_social_id,$extensao){
	
	global $vkt_id;
	global $usuario_id;	
		
	$file = file("modulos/eleitoral/importacao_email/arquivos/$usuario_id.$extensao");
	
	$cont=count($file);
	
	$emails_cadastrados = 0;
	$emails_cadastrados_anteriormente = 0;
	for($l=0;$l<$cont;$l++){
		$linha =$file[$l];
		
		//echo $linha."1<br>";
		
		
		if(strpos($linha,';')){
			$emails = explode(";",$linha);
			$email  = $emails[0];
			//$nome   = $emails[1];
		}elseif(strpos($linha,',')){
			$emails = explode(";",$linha);
			$email  = $emails[0];
			//$nome   = $emails[1];
		}else{
			$email=trim($linha);
		}
		//verifica se o email já existe no banco de dados
		$existe_email = mysql_query($t="SELECT * FROM eleitoral_eleitores WHERE vkt_id='$vkt_id' AND email = '$email'");
		echo $t."<br>";
		//echo $email."<br>";
						
		/*if(strstr($email,"@")&&strstr($email,".")){
			if(mysql_num_rows($existe_email)>0){
				$emails_cadastrados_anteriormente++;
			}
			else{
				mysql_query($t="INSERT INTO eleitoral_eleitores SET email='$email', vkt_id='$vkt_id', origem='importacao_email', grupo_social_id='$grupo_social_id'");
				//echo $t;
				$emails_cadastrados++;
			}					
		}*/	
	}
	//alert("$emails_cadastrados emails cadastrados \n $emails_cadastrados_anteriormente já estavam cadastrados");
		
	//fclose($file);
	foreach($dados as $dado){
		
		//verifica se a profissao ja esta cadastrada
		$profissao = mysql_query($t="SELECT * FROM eleitoral_profissoes WHERE vkt_id='$vkt_id' AND descricao='$dado[cargo]'");
		//echo $t."<br>";
		if(mysql_num_rows($profissao)>0){
			$profissao_id = mysql_fetch_object($profissao);
			$profissao_id = $profissao_id->id;
		}else{
			$t=mysql_query("INSERT INTO eleitoral_profissoes SET vkt_id='$vkt_id', descricao='$dado[cargo]'");
			//echo $t."<br>";
			//echo mysql_error()."<br>";
		}
		
		$nome      =addslashes($dado['nome']);
		$empresa = addslashes($dado['org']);
				
		mysql_query($t="INSERT INTO eleitoral_eleitores set vkt_id='$vkt_id', nome=\"$nome\",email='$dado[email]',data_nascimento='".DataBrToUsa($dado[bday])."',empresa=\"$empresa\", origem='importacao_facebook'");
		//echo $t."<br>";
		//echo mysql_error()."<br>";
	}
	alert('Importaçao Realizada Com Sucesso!');
}
	
function trataTxt($var) {

	$var = strtolower($var);
	
	$var = preg_replace("[áàâãª]","a",$var);	
	$var = preg_replace("[éèê]","e",$var);	
	$var = preg_replace("[í]","e",$var);	
	$var = preg_replace("[óòôõº]","o",$var);	
	$var = preg_replace("[úùûü]","u",$var);	
	$var = str_replace("ç","c",$var);
	
	return $var;
}
?> 