<?php
include("../../../_config.php");

define('DIR_DOWNLOAD', 'arquivos_clientes/'); // Aqui vale qualquer coisa :)
     
$extensao = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor_arquivo WHERE id='".$_GET['documento_id']."'"));
$arquivo  = $extensao->id.".".$extensao->localizacao;
//echo $arquivo;

//if (stripos($arquivo, './') !== false || stripos($arquivo, '../') !== false || !file_exists($arquivo))
  // exit('Operaзгo nгo permitida.');
 
   $arquivo = DIR_DOWNLOAD.$arquivo; // Aqui a gente sу junta o diretуrio com o nome do arquivo
 
   header('Content-type: octet/stream');
   header('Content-disposition: attachment; filename="'.basename($arquivo).'";');
   header('Content-Length: '.filesize($arquivo));
   readfile($arquivo);
   exit;
?>