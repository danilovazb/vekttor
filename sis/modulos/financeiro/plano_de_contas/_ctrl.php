<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];



//Cadastra Registro
if(isset($_POST['action'])){
	$retorno = gerencia_centro_de_custo(
					$_POST['ordem'],
					$_POST['nome'],
					$_POST['descricao'],
					$_POST['centro_custo_id'],
					$_POST['plano_ou_centro'],
					$id,
					$_POST['action'],
					$_POST['visualiza_soma']);
	if($retorno!='ok'){
		echo "<script>alert('Erro $retorno')</script>";	
	}
}
//Pega informações
if($id>0){

	$obj=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo WHERE id='".$id."' LIMIT 1"));
//	print_r($obj);
	salvaUsuarioHistorico("Formulário - Conta",'Exibe',$tabela,$id);
}

?>