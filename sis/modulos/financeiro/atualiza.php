<?
// configuração inicial do sistema
include("../../_config.php");
include("../../_functions_base.php");

$retornaNumeros=mysql_query($trace="
SELECT id FROM financeiro_orcamento_centro WHERE centro_plano_id='{$_GET[id]}' AND mes='{$_GET[mes]}' AND ano='{$_GET[ano]}' 
");
$valor=str_replace(',','.',str_replace('.','',$_GET[valor]));
if(mysql_num_rows($retornaNumeros)>0){$id=mysql_fetch_object($retornaNumeros);$acao = "UPDATE"; $sql_fim = " WHERE id ='{$id->id}' ";}
else{$acao=" INSERT INTO ";}

$sql=" 
$acao 
financeiro_orcamento_centro 
SET 
	cliente_id='{$_SESSION[usuario]->cliente_vekttor_id}', centro_plano_id='{$_GET[id]}', ano='{$_GET[ano]}', mes='{$_GET[mes]}', valor='$valor'
$sql_fim 
";
mysql_query($sql) or die(mysql_error());
echo $sql;
?>