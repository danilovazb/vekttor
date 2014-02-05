<?php
	function upload_arquivo($grupo_social_id){
		
	global $vkt_id;
	global $usuario_id;
	
	$filis_autorizados = array('vcf');
	//alert('oi');
	if(strlen($_FILES['arquivo']['name'])>4){
	  $pasta 	= 'modulos/eleitoral/importacao_facebook/arquivos/';
	  $extensao = strtolower(substr($_FILES['arquivo']['name'],-3));
	  $arquivo 	= $pasta."$usuario_id.".$extensao;
	  $arquivodel= $pasta.$usuario_id;
	
	  if(in_array($extensao,$filis_autorizados)){
		 
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo'][tmp_name],$arquivo)){
			 // alert('oi2');
			  importa_facebook($grupo_social_id);			  
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
			
	}
	
	function importa_facebook($grupo_social_id){
	
	global $vkt_id;
	global $usuario_id;	
		
	$file = fopen("modulos/eleitoral/importacao_facebook/arquivos/$usuario_id.vcf",'r');
	
	$dados = array();
	$cont=0;
	$cont_telefone = 0;
	while(!feof($file)){
		
		$linha = fgets($file);
		
			
		//if(strstr($linha,'BEGIN:VCARD')){
			//echo "<tr>";
		//}
		
		if(strstr($linha,'FN:')){
			$fullname = explode(":",$linha);
			//if(sizeof($fullname)>0){
				//echo "<td>".$fullname[1]."</td>";
			//}
			$dados[$cont]['nome'] = $fullname[1];
		}
		if(strstr($linha,'EMAIL;')){
			
			$fullname = explode(";",$linha);
			//if(sizeof($fullname)>0){
				$email = $fullname[2];
				$email = explode(":",$email);
				//echo "<td>".$email[1]."</td>";
			//}
				$dados[$cont]['email'] = $email[1];
		}
		
		if(strstr($linha,'X-SOCIALPROFILE;')){
			
			$fullname = explode(";",$linha);
			
			$email = $fullname[3];
			$email = explode("=",$email);
			$id    = $email[2];
			
			//recebe o tamanho da linha
			$tamlinha = strlen($email[1]);
			
			//Encontra a primeira ocorrencia do caracter :
			$pos = strpos($email[1], ':');
			
			$qtd_caracteres = $tamlinha-$pos;
			
			$email = substr($email[1],$pos+1,$qtd_caracteres);
			
			$dados[$cont]['profile'] = $email."=".$id;
		}	
		
		if(strstr($linha,'BDAY;')){
			
			$fullname = explode(":",$linha);
			
			$data     = explode("-",$fullname[1]);
			
			$dia = substr($data[2],0,2);
			
			$data     = $dia."/".$data[1]."/".$data[0];
						
			$dados[$cont]['bday'] = $data;
		}
		
		if(strstr($linha,'BDAY:')){
			
			$fullname = explode(":",$linha);
			
			$data       = explode("-",$fullname[1]);
			
			$dia = substr($data[2],0,2);
			
			$data       = $dia."/".$data[1]."/".$data[0];
						
			$dados[$cont]['bday'] = $data;
		}
		
		if(strstr($linha,'ORG:')){
			
			$fullname = explode(":",$linha);
			
			
			$org = $fullname[1];
			
			
			$tamorg = strlen($org);
			//echo $tamorg." ";
			$org = substr($org,0,$tamorg-3);
			
			$dados[$cont]['org'] = $org;
		}
		
		if(strstr($linha,'TITLE:')){
			
			$fullname = explode(":",$linha);
			$dados[$cont]['cargo'] = $fullname[1];
		}
		
		if(strstr($linha,'URL:')){
			//recebe o tamanho da linha
			$tamlinha = strlen($linha);
			
			//Encontra a primeira ocorrencia do caracter :
			$pos = strpos($linha, ':');
			
			$qtd_caracteres = $tamlinha-$pos;
			
			$fullname = substr($linha,$pos+1,$qtd_caracteres);
			//if(sizeof($fullname)>0){
				//echo "<td>".$email[1]."</td>";
			//}
				$dados[$cont]['url'].=$fullname."<br>";
				
				
				
		}
		
		if(strstr($linha,'URL;')){
			//recebe o tamanho da linha
			$tamlinha = strlen($linha);
			
			//Encontra a primeira ocorrencia do caracter :
			$pos = strpos($linha, ':');
			
			$qtd_caracteres = $tamlinha-$pos;
			
			$fullname = substr($linha,$pos+1,$qtd_caracteres);
			//if(sizeof($fullname)>0){
				//echo "<td>".$email[1]."</td>";
			//}
				$dados[$cont]['url'].=$fullname."<br>";
				
				
				
		}
		
		if(strstr($linha,'TEL;')){
			
			//$telefone = $fullname[3];
			$pospref = strpos($linha,'pref:');
			//tamanho da linha
			$tamlinha = strlen($linha);
			
			
			
			$telefone = substr($linha,$pospref,$tamlinha);
			
			if(strlen($telefone)>8){
			
				if(strstr($telefone,"-")){			
					$telefone = substr($telefone,-11);
					$telefone = str_replace("-","",$telefone);			
				}else{
					$telefone = substr($telefone,-10);
				}
				//$telefone = "(".substr($telefone,0,2).")".substr($telefone,2,4)."-".substr($telefone,6,4);
				$dados[$cont]['tel'].=" ".$telefone;
				trim($dados[$cont]['tel']);
				//recebe o tamanho da linha
			
				/*$tamtelefone = strlen($linha);
			
				$telefone = substr($linha,$posmais+3	,$tamtelefone);
			
				$telefone = "(".substr($telefone,0,2).")".substr($telefone,2,4)."-".substr($telefone,6,4);
			
				$dados[$cont]['tel'].=" ".$telefone;
			
				$cont_telefone++;*/
			}
			//echo $telefone."<br>";	
				
		}
				
		if(strstr($linha,'END:VCARD')){
			$cont++;
			$cont_telefone = 0;
		}
	}
	
	fclose($file);
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
		$empresa =addslashes($dado['org']);
		$telefone  =explode(" ",$dado[tel]);
		$telefone1 = $telefone[1]; 
		$telefone1 = trim($telefone1);
		$fim='';
		if(!empty($telefone[2])){
			$telefone2 = trim($telefone[2]);
			$fim = ", telefone2='$telefone2'";
		}
		//verifica se existe email
		$existe_email = mysql_fetch_object(mysql_query($t="SELECT * FROM eleitoral_eleitores WHERE email='$dado[email]' AND vkt_id='$vkt_id'"));
		//echo $t."<br>";
		if(!$existe_email->id>0){		
			mysql_query($t="INSERT INTO eleitoral_eleitores set vkt_id='$vkt_id', nome=\"$nome\",email='$dado[email]',data_nascimento='".DataBrToUsa($dado[bday])."',empresa=\"$empresa\", origem='importacao_facebook', grupo_social_id='$grupo_social_id', telefone1='$telefone1' $fim");
			//echo $t."<br>";
		}
		//echo mysql_error()."<br>";
	}
	//alert('Importaçao Realizada Com Sucesso!');
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