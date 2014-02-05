<?php
	$host		= 'localhost';
	$login_bd	= 'nv';
	$senha_bd	= 'ybu4zfs60h';
	$bd			= 'nv_sistema';
	
	mysql_connect($host,$login_bd,$senha_bd);
	mysql_select_db($bd);
	
	$file = file("emails.csv");
	
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
		$existe_email = mysql_query($t="SELECT * FROM eleitoral_eleitores WHERE vkt_id='173' AND email = '$email'");
		echo $t."<br>";
		//echo $email."<br>";
						
		if(strstr($email,"@")&&strstr($email,".")){
			if(mysql_num_rows($existe_email)>0){
				//$eleitor = mysql_fetch_object($existe_email);
				echo "Email Já Existe $eleitor->grupo_social_id <br>"; 
				$emails_cadastrados_anteriormente++;
			}
			else{
				mysql_query($t="INSERT INTO eleitoral_eleitores SET email='$email', vkt_id='173', origem='importacao_email', grupo_social_id='61'");
				echo $t." ".mysql_error()."<br><br>";
				$emails_cadastrados++;
			}						
		}
		
	}
	echo "<script>alert($emails_cadastrados_anteriormente $emails_cadastrados)</script>";
?>