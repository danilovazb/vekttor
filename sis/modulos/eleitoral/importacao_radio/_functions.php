 <?php
	function upload_arquivo($grupo_social_id){
		
	global $vkt_id;
	global $usuario_id;
	
	$filis_autorizados = array('csv');
	
	if(strlen($_FILES['arquivo']['name'])>4){
	   	
	  $pasta 	= 'modulos/eleitoral/importacao_radio/arquivos/';
	  $extensao = strtolower(substr($_FILES['arquivo']['name'],-3));
	  $arquivo 	= $pasta."$usuario_id.".$extensao;
	  $arquivodel= $pasta."usuario_id.";
	  
	  if(in_array($extensao,$filis_autorizados)){
		 
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo'][tmp_name],$arquivo)){
			  
			  importa_radio($extensao,$grupo_social_id);			  
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
			
	}
	
	function importa_radio($extensao,$grupo_social_id){
		
		global $vkt_id;
		global $usuario_id;
		
		$file = fopen("modulos/eleitoral/importacao_radio/arquivos/$usuario_id.$extensao",'r');
		
		//$file = utf8_encode(fread($file, filesize("modulos/eleitoral/importacao_radio/arquivos/$usuario_id.$extensao")));
		
		$linha_anterior = '';
		$email_anteriormente_cadastrados=0;
		$email_novos=0;
		
		//seleciona o grupo social, este preencherá o campo origem
		$nome_grupo_social = mysql_fetch_object(mysql_query("SELECT nome FROM eleitoral_grupos_sociais WHERE id='$grupo_social_id' AND vkt_id='$vkt_id'"));
		
				
		while(!feof($file)){
					
			$linha = fgets($file);
			//alert($linha);
			
			$linha = utf8Fix($linha);
			//alert($linha);
					
			$parametros_linha = explode("\",\"",$linha);
			
			$nome          =  $parametros_linha[1];
			if($linha!=''){
				if(substr($parametros_linha[3],0,1)!="\"")	{	
				
					$rua             = $parametros_linha[3];
					$bairro         = $parametros_linha[4];
					$cep            = $parametros_linha[5];
					$telefone2    = substr($parametros_linha[6],0,4)."-".substr($parametros_linha[6],4,4);
					$telefone1    = substr($parametros_linha[7],0,4)."-".substr($parametros_linha[7],4,4);
					$email          = $parametros_linha[8];
					$programa   = $parametros_linha[10];		
				}else{
					$cont = 3;
					$temaspas = false;
					do{
						$rua.=  $parametros_linha[$cont];
						if(strstr($parametros_linha[$cont+1],"\"")){
							$rua.=  $parametros_linha[$cont+1];
							$temaspas = true;
					}
					$cont++;
					}while(!$temaspas);
				
					$bairro         = $parametros_linha[$cont+1];
					$cep            = $parametros_linha[$cont+2];
					$telefone2    = substr($parametros_linha[$cont+3],0,4)."-".substr($parametros_linha[$cont+3],4,4);
					$telefone1    = substr($parametros_linha[$cont+4],0,4)."-".substr($parametros_linha[$cont+4],4,4);
					$email          = $parametros_linha[$cont+5];
					$programa   = $parametros_linha[$cont+7];		
				}
			}
			
			
			$cep = substr($cep,0,5)."-".substr($cep,5,3); 
			
			$verifica_email = mysql_query("SELECT * FROM eleitoral_eleitores WHERE email='$email' AND vkt_id='$vkt_id'");
			 
			if(!mysql_num_rows($verifica_email)>0){		
				//$rua = utf8_decode($rua);
				//$bairro = utf8_decode($bairro);			
				mysql_query($t="INSERT INTO eleitoral_eleitores SET vkt_id='$vkt_id', nome='$nome', telefone1='$telefone1', telefone2='$telefone2', email='$email', endereco='$rua', bairro='$bairro', cep='$cep', origem='$nome_grupo_social->nome', grupo_social_id='$grupo_social_id'");
				//echo mysql_error()."<br>";
				$email_novos++;
			}else{
				$email_anteriormente_cadastrados++;
			}
			//echo $t."<br>";
			//echo mysql_error();
			//$mensagem ='';
		}
		alert("$email_novos cadastrados. \n $email_anteriormente_cadastrados já estavam cadastrados");
}
	
function retira_aspas($palavra){
		
		//tamanha da palavra
		$tamanho_palavra = strlen($palavra);
		
		$palavra = substr($palavra,1,$tamanho_palavra-2);
		
		return $palavra;
	}

function retira_aspas_mensagem($palavra){
		
		//tamanha da palavra
		$tamanho_palavra = strlen($palavra);
		
		$palavra = substr($palavra,1,$tamanho_palavra-3);
		
		return $palavra;
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

function utf8Fix($msg){
	
	$simbolo = "A§A?";
	$simbolo2 = "A?";
	$accents = array("ô");
	$utf8 = array("A?Â´");
	//$fix = utf8_decode($msg);
	$fix = str_replace($simbolo, "ç", $msg);
	//alert($fix);
	return $fix;
}
?> 