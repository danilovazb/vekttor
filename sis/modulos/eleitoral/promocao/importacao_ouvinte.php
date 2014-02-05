<?php
	include("../../../_config.php");
	// configuraçao inicial do sistema
	
	$file = fopen("tb_ouvinte.csv",'r');
	
	$c=0;
	
	while(!feof($file)){
		$linha = utf8_decode(fgets($file));
		$conteudo.=$linha."<br>";
		//echo $linha."<br>";
		$dados = explode(",\"",$linha);
		
		$nome     = $dados[1];
		$nome     = str_replace("\"","",$nome);
		$endereco = $dados[3];
		$endereco = str_replace("\"","",$endereco);
		$bairro   = $dados[4];
		$bairro   = str_replace("\"","",$bairro);
		$cep      = $dados[5];
		$cep      = str_replace("\"","",$cep);
		$telefone1= $dados[6];
		$telefone1= str_replace("\"","",$telefone1);
		$telefone1=substr($telefone1,0,4)."-".substr($telefone1,4,4);
		$telefone2= $dados[7];
		$telefone2= str_replace("\"","",$telefone2);
		$telefone2=substr($telefone2,0,4)."-".substr($telefone2,4,4);
		$email    = $dados[8];
		$email    = str_replace("\"","",$email);
		echo $nome." ".$endereco." ".$bairro." ".$cep." ".$telefone1." ".$telefone2." ".$email."<br>";
				
		$existe = mysql_fetch_object(mysql_query($t="SELECT * FROM eleitoral_eleitores WHERE vkt_id='169' AND email='$email'"));
		echo $t."<br>";
		$novos_ids=array();
		$c=0;
		//if(!$existe->id>0){
			//mysql_query($t="INSERT INTO eleitoral_eleitores SET vkt_id='169', nome='$nome', endereco='$endereco', bairro='$bairro', cep='$cep', telefone1='$telefone1', telefone2='$telefone2', email='$email',
			//grupo_social_id='28'");
			
			echo mysql_error()."<br>";
			$id=mysql_insert_id();
			$novos_ids[$c]=$id;
			$c++;
			
			echo $t."<br>";
		//}
		print_r($novos_ids);
	
	}
	/*
	$ouvintes = mysql_query("SELECT * FROM eleitoral_eleitores WHERE vkt_id='169' AND id > 46512");
	
	while($ouvinte = mysql_fetch_object($ouvintes)){
	
		$telefone1 = substr($ouvinte->telefone1,0,4)."-".substr($ouvinte->telefone1,4,4);
		$telefone2 = substr($ouvinte->telefone2,0,4)."-".substr($ouvinte->telefone2,4,4); 
	
		mysql_query($t = "UPDATE eleitoral_eleitores SET telefone1='$telefone1', telefone2='$telefone2', cidade='Manaus',estado='AM' WHERE id='$ouvinte->id'");
		echo mysql_error();
		echo $t."<br>";		
	}*/
?>