<?
include("../../../_config.php");
// fun��es base do sistema
include("../../../_functions_base.php");
		mysql_query($trace="UPDATE projetos_atividades SET aprovado_pelo_responsavel='$_GET[responsal_aprovou]' WHERE id='$_GET[atividade_id]' ");
?>