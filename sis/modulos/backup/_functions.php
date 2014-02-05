<?
function backup($nome,$tipo){
	global $host,$login_bd,$senha_bd,$bd;
	//exec("mysqldump --user=nv --password=ybu4zfs60h --databases nv_sistema");
	
	$backupFile = 'arquivos_backup/'.$bd . date("Y-m-d-H-i-s") . '.sql';
	//$command = "mysqldump --opt -h $host -u $login_bd -p $senha_bd $bd | gzip > $backupFile";
	$command = "mysqldump --opt --host=$host --user=$login_bd --password=$senha_bd --databases $bd > $backupFile";
	echo $command;
	exec($command);
	
	echo "<script>window.open('recebe_acao.php?file=".$backupFile."')</script>";
	// enviar os cabeçalhos HTTP para o browser
			/*
	$tabelas=mysql_list_tables($bd);
	$arq = fopen("$nome.sql","w");
	$i=0;
	$sql='';
	while($linha=mysql_fetch_row($tabelas)){
		$i++;
		$tabela=$linha[0];
		$res=mysql_query("SHOW CREATE TABLE $tabela");
		while($lin=mysql_fetch_row($res)){
			$sql.="\n#\n# Criação da Tabela : $tabela \n#\n\n";
			$sql.="$lin[1] ; \n\n#\n# Dados a serem incluídos na tabela\n#\n\n";
			//fwrite($arq,"\n#\n# Criação da Tabela : $table\n#\n\n");
			//fwrite($arq,"$lin[1] ; \n\n#\n# Dados a serem incluídos na tabela\n#\n\n");
		}
		
		if($i<5){
			$res3=mysql_query("SELECT * FROM $tabela");
			while($r=mysql_fetch_row($res3)){
				$sql.=" INSERT INTO  $tabela VALUE(";
				for($j=0; $j<mysql_num_fields($res3); $j++){
					$v = ($j==(mysql_num_fields($res3)-1))?'':', ';
					if(!isset($r[$j])){
						$sql.=" ''$v ";
					}else{
						$sql.=" '".addslashes($r[$j])."'$v ";
					}
				}
				$sql=ereg_replace(",$", "", $sql);
				$sql.=" ); \n";
			}
		}
	}
	fwrite($arq,$sql);
	fclose($arq);
	
	/*
	$arquivo=$bd.".sql";
	ob_start();
	require('zip.lib.php');
 
 
 
  //Gera o objeto
 
   $zipfile = new zipfile($bd.".zip",'', '');
 
 
 
  //Adiciona o diretorio corrente com todos arquivos
 
  //$zipfile->addDirContent('./');
 
 
 
  //Adicionado o aquivo criado
 
  $zipfile->addFileAndRead($arquivo);
 
 
 
  //Saida do aquivo compactado
 
  echo $zipfile->file();*/
 
}

