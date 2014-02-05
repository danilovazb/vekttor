<?
$backupFile =$_GET['file'];
header("Content-Type: application/unknown"); 
header("Content-Length: $tamanho");
header("Content-Disposition: attachment; filename=$backupFile"); 
// abrir e enviar o arquivo
$fp = fopen("$backupFile", "r"); 
fpassthru($fp);
fclose($fp);
