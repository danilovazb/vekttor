<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];
if($_GET['id_grupo'])$id_grupo=$_GET['id_grupo'];




//Cadastra Registro
if(isset($_POST['action'])&&$_POST['plano_ou_centro']!=''){
	$retorno = gerencia_centro_de_custo(
					$_POST['ordem'],
					$_POST['nome'],
					$_POST['descricao'],
					$_POST['centro_custo_id'],
					$_POST['plano_ou_centro'],
					$id,
					$_POST['action'],
					$_POST['visualiza_soma'],
					$_POST['modelo_grupo_id'],
					$_POST['visualiza_soma']);
	if($retorno!='ok'){
		echo "<script>alert('Erro $retorno')</script>";	
	}
}
//Pega informações
if($id_grupo>0){
	$modelo_grupo=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo_modelo_grupo WHERE id ='$id_grupo'"));
	$select[$modelo_grupo->id]="selected='selected'";
	$editar_show="block";
}else{
	$editar_show="none";
}

if($id>0){

	$obj=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo_modelo WHERE id='".$id."' LIMIT 1"));
	$modelo_grupo=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo_modelo_grupo WHERE id ='$obj->modelo_grupo_id'"));
//	print_r($obj);
	salvaUsuarioHistorico("Formulário - Conta",'Exibe',$tabela,$id);
}

?>