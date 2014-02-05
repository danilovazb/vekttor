<?
//Includes
// configuração inicial do sistema
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_financeiro.php");

if($_GET['movimento_id'] && $_GET['tipo'] && $_GET['extencao']){
	financeiro_remove_arquivos($_GET['movimento_id'],$_GET['tipo'] ,$_GET['extencao']);
}

?>
