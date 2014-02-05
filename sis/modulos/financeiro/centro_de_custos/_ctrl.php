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
					$_POST['action']);
	if($retorno!='ok'){
		echo "<script>alert('Erro $retorno')</script>";	
	}
}
//Pega informações
if($id>0){
	$obj=mysql_fetch_object(mysql_query("SELECT * FROM $tabela WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Conta",'Exibe',$tabela,$id);
}

?>