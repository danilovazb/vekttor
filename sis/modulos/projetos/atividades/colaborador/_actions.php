<?
include("../../../../_config.php");
// funçoes base do sistema
include("../../../../_functions_base.php");
// funçoes do modulo empreendimento
include("_function_colaborador.php");

print_r($_GET);
	if($usuario_id<1){
		alert('Você Precisa Estar Logado');
		echo  "<script>top.location='../../../../../'</script>";
		exit();	
	}	

if($_GET['action']== 'starta'&&$_GET['atividade_id']>0){
	starta($_GET['atividade_id']);
	exit();
}
if($_GET['action']== 'pausa'&&$_GET['atividade_id']>0){
	pausa($_GET['atividade_id']);
	exit();
}
if($_GET['action']== 'conclui_atividade' &&$_GET['atividade_id']>0){
	echo "entrou<br>";
	conclui_atividade($_GET['atividade_id']);
	exit();
}

if($_GET['action']== 'ativa_atividade' &&$_GET['atividade_id']>0){
	echo "entrou<br>";
	ativa_atividade($_GET['atividade_id']);
	exit();
}

?>