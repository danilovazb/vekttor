<?
include("../../../_config.php");
mysql_query("UPDATE financeiro_movimento SET autorizado='{$_GET[autoriza]}' WHERE id='{$_GET[id]}'");

?>