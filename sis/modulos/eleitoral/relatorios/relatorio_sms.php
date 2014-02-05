<?php

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
while($eleitor=mysql_fetch_object($eleitores_q)){ 
				//if(!empty($eleitor->telefone1)){
					//$telefone_original = $eleitor->telefone1;
				//}else{
  if(!empty($eleitor->telefone1)){
	  $telefone_original = $eleitor->telefone1;
  }else{
	  $telefone_original = $eleitor->telefone2;
  }
  
  //echo $telefone_original;
  if(!empty($telefone_original)){
  $tamtelefone = strlen($telefone_original);
  
  $telefone = str_replace("-","",$telefone_original);
  $telefone = str_replace(" ","",$telefone);
  $telefone = str_replace(")","",$telefone);
  $telefone = str_replace("(","",$telefone);
  $telefone = str_replace(".","",$telefone);
  $telefone = trim($telefone);
  
  $caracteres = strlen($telefone);
  $caracter_inicio = $caracteres-8;
  $telefone = substr($telefone,$caracter_inicio,8);
  //echo $telefone_original." ";
  if(!empty($telefone)&&strlen($telefone)>7&&(substr($telefone,0,1)>7)){
	  //echo " $telefone";	
	  //
	  $info[] = 'x,'."$telefone,\ \n";
  }
  }
				
}
$info[] = "}";
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