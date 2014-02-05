<?php
// configuraчуo inicial do sistema
include("../../../_config.php");
// funчѕes base do sistema
include("../../../_functions_base.php");
$id = $_GET['id'];
$arquivo = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id='$id'"));
mysql_query("UPDATE servico SET extensao = '' WHERE id='$id'"); 
echo mysql_error();
unlink("fotos/$arquivo->id.$arquivo->extensao");
?>