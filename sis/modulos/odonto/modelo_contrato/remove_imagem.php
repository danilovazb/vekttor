<?php
include("../../../_config.php");
include("../../../_functions_base.php");

$id = $_POST['id'];

$extensao = mysql_fetch_object(mysql_query("SELECT extensao FROM modelo_contrato_imagens WHERE id='$id'"));

mysql_query("DELETE FROM modelo_contrato_imagens WHERE id='$id'");
unlink("../../../../../upload/odonto/imagens_contrato/$id.$extensao->extensao");
echo $id;
?>