<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

$produto_grupo = $_POST['produto_grupo'];

$produtos = mysql_query("SELECT * FROM produto WHERE produto_grupo_id='$produto_grupo' ORDER BY nome");
$select = "<select name='produto_id' id='produto_id' style='width:150px;'>";

while($produto = mysql_fetch_object($produtos)){
	$select.="<option value='$produto->id'>".utf8_encode($produto->nome)."</option>";
}
$select.= "</select>";
echo $select;
?>