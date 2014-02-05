<?php

$file = fopen("Fatima.vcf",'r');
	
$dados = array();
$cont=0;
$cont_telefone = 0;
$info[] = "
{\rtf1\ansi\ansicpg1252\cocoartf1187\cocoasubrtf370 \n
{\fonttbl\f0\fmodern\fcharset0 Courier;} \n
{\colortbl;\red255\green255\blue255;} \n
\vieww10800\viewh8400\viewkind0 \n
\deftab720 \n
\pard\pardeftab720 \n
\n
\f0\fs24 \cf0 
";
while(!feof($file)){
	
	$linha = fgets($file);
	
		
	//if(strstr($linha,'BEGIN:VCARD')){
		//echo "<tr>";
	//}
	
	/*if(strstr($linha,'FN:')){
		$fullname = explode(":",$linha);
		$dados[$cont]['nome'] = $fullname[1];
		$nome=$dados[$cont]['nome'];
		//echo $nome;
		//$info[] = $dados[$cont]['nome'].";";
	}
	
	if(strstr($linha,'EMAIL;')){
		
		$fullname = explode(";",$linha);
		//print_r($fullname);
		$fullname = explode(":",$fullname[2]);
		//print_r($fullname);
		//if(sizeof($fullname)>0){
		$email = $fullname[1];
			//$email = explode(":",$email);
			//echo "<td>".$email[1]."</td>";
		//}
		$dados[$cont]['email'] = $email;
		$email2=$dados[$cont]['email'];
		//$info[] = $dados[$cont]['email'].";";
		//echo $email;
	}	
	
	if(strstr($linha,'X-SOCIALPROFILE;')){
		
		$fullname = explode(";",$linha);
		
		$email = $fullname[2];
		$email = explode("=",$email);
		$id    = $email[1];
		
		//recebe o tamanho da linha
		$tamlinha = strlen($email[1]);
		
		//Encontra a primeira ocorrencia do caracter :
		$pos = strpos($email[1], ':');
		
		$qtd_caracteres = $tamlinha-$pos;
		
		$email = substr($email[1],$pos+1,$qtd_caracteres);
		
		$dados[$cont]['profile'] = $id;
		//$info[] = $dados[$cont]['profile'].";";
		 
	}	

	if(strstr($linha,'ORG:')){
		
		$fullname = explode(":",$linha);
				
		$org = $fullname[1];
				
		$tamorg = strlen($org);
		//echo $tamorg." ";
		$org = substr($org,0,$tamorg-3);
		
		$dados[$cont]['org'] = $org;
		//$info[] = $dados[$cont]['bday'].";";
	}
	*/	
		
	if(strstr($linha,'TEL;')){
		
		//$telefone = $fullname[3];
		$pospref = strpos($linha,'pref:');
		//tamanho da linha
		$tamlinha = strlen($linha);
			
		$telefone = substr($linha,$pospref,$tamlinha);
			
		if(strstr($telefone,"-")){			
			$telefone = substr($telefone,-11);
			$telefone = str_replace("-","",$telefone);			
		}else{
			$telefone = substr($telefone,-10);
		}
			
		if(strstr($telefone,":")){
			$telefone = str_replace(":","",$telefone);				
		}
			//echo $telefone;
		if(strlen($telefone)>8){
			$telefone = substr($telefone,-9);
		}
			//$telefone = "(".substr($telefone,0,2).")".substr($telefone,2,4)."-".substr($telefone,6,4);
		$dados[$cont]['tel']=" ".$telefone;
		trim($dados[$cont]['tel']);
		//$info[] = $dados[$cont]['tel'].";";
			
			
	}
	
	if(strstr($linha,'TEL:')){
		
		$telefone = explode(":",$linha);
		//print_r($telefone);
		$telefone = $telefone[1];
		//echo $telefone;
		
		$dados[$cont]['tel']=$telefone;
		trim($dados[$cont]['tel']);
		//$info[] = $dados[$cont]['tel'].";";
		
		//echo $telefone;
	}
		
			
	if(strstr($linha,'END:VCARD')){
		$cont++;
		$cont_telefone = 0;
		$nome = trim($nome);
		$email2 = trim($email2);
		$id = trim($id);
		$org = trim($org);
		
		$telefone = trim($telefone);
		
		if($telefone[0]>7){
			$info[] = "x,$telefone,\ \n";
		}
		
		$email2='';
		$id='';
		$org='';
	}
}
$info[] = "}";
//var_dump($info);
fclose($file);
$infos = implode("",$info);
$file = "sms.csv";
@unlink("$file");
$handle = fopen($file, 'a');
fwrite($handle,$infos);
fclose($handle);
$i =date("Ymdhis");
echo "<script>location='$file?$i'</script>";
exit();
?>