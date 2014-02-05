<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];



//Cadastra Registro
if(isset($_POST['action'])){
	$retorno = gerencia_conta($id,$_POST['nome'],$_POST['comentario'],$_POST['preferencial'],$id,$_POST['action'],$_POST['agencia'],$_POST['agencia_digito'],$_POST['conta'],$_POST['conta_digito'],$_POST['tipo_boleto'],$_POST);
	if($retorno!='ok'){
		echo "<script>alert('Erro $retorno')</script>";	
	}
	salvaUsuarioHistorico("Formulário - Conta",'Exibe','financeiro_contas',$id);
}
//Pega informações
if($id>0){
	$conta=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_contas WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Conta",'Exibe','financeiro_contas',$id);
}

?>