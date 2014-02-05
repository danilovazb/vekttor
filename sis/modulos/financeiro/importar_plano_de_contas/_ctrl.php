<?
//Aчѕes do Formulсrio

//Recebe ID
$tabela = 'financeiro_centro_custo_modelo';
$plano_ou_centro = 'plano';

if($_GET['id_grupo'])$id_grupo=$_GET['id_grupo'];



if($_POST['action']=="Realizar Importaчуo"){
	if($_POST['modelo_id']>0){
		importarPlanoDeContas($_POST);
	}else{
		alert("Escolha um modelo de plano de contas");
	}
	
}

//Pega informaчѕes do modelo
if($id_grupo>0){
	$modelo_grupo=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo_modelo_grupo WHERE id ='$id_grupo'"));
	$select[$modelo_grupo->id]="selected='selected'";
	$editar_show="block";
}else{
	$editar_show="none";
}


?>