<?php
	function upload_arquivo(){
		
	global $vkt_id;
	global $usuario_id;
	
	$filis_autorizados = array('csv');
	//alert('oi');
	if(strlen($_FILES['arquivo']['name'])>4){
	  $pasta 	= 'modulos/eleitoral/sms_importado/arquivos/';
	  $extensao = strtolower(substr($_FILES['arquivo']['name'],-3));
	  $arquivo 	= $pasta."$usuario_id.".$extensao;
	  $arquivodel= $pasta."usuario_id.";
	  //	alert('oi2');
	  if(in_array($extensao,$filis_autorizados)){
		 
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo'][tmp_name],$arquivo)){
			  
			  importa_mensagens();			  
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
			
	}
	
	function importa_mensagens(){
		
		global $vkt_id;
		global $usuario_id;
		$promocao_id=$_POST['promocao_id'];
		
		$file = fopen("modulos/eleitoral/sms_importado/arquivos/$usuario_id.csv",'r');
		
		$linha_anterior = '';
		
		while(!feof($file)){
					
					$linha = fgets($file);
					
					//tamanho da linha
					$tam_linha = strlen($linha)-2;
										
					//primeiro caracter da string linha
					$primeiro_caractere_linha = substr($linha,0,1);
					//ultimo caracter da string linha
					$ultimo_caractere_linha = trim(substr($linha,-3));
										
					$string_linha = explode("\",\"",$linha);
					
					//tamanho da string $linha
					$tam_string_linha = sizeof($string_linha);						
					//echo $linha[1]; 
					
					//echo $tam_string_linha."<br>";
					if($tam_string_linha>1){
						$data_hora = $string_linha[5];
						$telefone    = $string_linha[2];
						$mensagem = utf8_decode($string_linha[7]);
												
					}else{
						$mensagem.=utf8_decode($linha);
					}
					
					if($ultimo_caractere_linha=="\""){
						$exibe="sim";
					}else{
						$exibe="nao";
					}
					
					/*if($primeiro_caractere_linha=="\""&&$string_linha[0]=="\"sms\""){
						if($string_linha[1]=="\"RECEIVED\""){
							$telefone = $string_linha[2];	
						}else{
							$telefone = $string_linha[3];
						}
					
						if($string_linha[5]!="\"\""){
							$data_hora = $string_linha[5];	
						}else{
							$data_hora = $string_linha[6];
						}
					}
										
					
					if($primeiro_caractere_linha=="\""&&$ultimo_caractere_linha=="\""&&$string_linha[0]=="\"sms\""){
					
						if($string_linha[1]=="\"RECEIVED\""){
							$inicio = 7;
							//$mensagem = $string_linha[7];
							
							$exibe = "sim";
						}else
						{
							$inicio = 8;
							//$mensagem = $string_linha[8];
							$exibe = "sim";
						}
						for($i=$inicio;$i<=$tam_string_linha-1;$i++){
								if($i==$inicio){
									$mensagem.=$string_linha[$i];
								}else{
									$mensagem.=",".$string_linha[$i];
								}
						}
					}else if($primeiro_caractere_linha=="\""&&$ultimo_caractere_linha!="\""){
						$mensagem.=$string_linha[8];
						$exibe = "nao";
					}else if($primeiro_caractere_linha!="\""&&$ultimo_caractere_linha!="\""){					
						$mensagem.=$linha;
						$exibe="nao";
					}else if($primeiro_caractere_linha!="\""&&$ultimo_caractere_linha=="\""){
						$mensagem.=$linha;
						$exibe="sim";
					}*/
					//$exibe="sim";
					
					if($exibe=="sim"){
						//retira as aspas da data_hora, teelfone e mensagem
						
						//$data_hora     = retira_aspas($data_hora);
						//$telefone        = retira_aspas($telefone);
						//$mensagem    = retira_aspas_mensagem($mensagem);
						$verifica = @mysql_result(mysql_query($t="SELECT id FROM eleitoral_sms_importados WHERE promocao_id='$promocao_id' AND telefone='$telefone'"),0,0);
					
						if(!$verifica>0){
							mysql_query($t="INSERT INTO eleitoral_sms_importados SET vkt_id='$vkt_id', telefone='$telefone', data_hora = '$data_hora',mensagem='$mensagem', promocao_id='$promocao_id'");
						
						}
						//$mensagem ='';
					}
	}
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
?> 