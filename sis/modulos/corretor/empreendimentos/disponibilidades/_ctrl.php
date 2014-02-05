<?
//Ações do Formulário

//Recebe ID
if($_POST['id']){$id=$_POST['id'];}
if($_GET['id']){$id=$_GET['id'];}



//Cadastra Registro
if($_POST['action']=='Salvar'&&empty($id)){
	//cadastraEmpreendimento($nome,$tipo,$orcamento,$inicio,$fim,$obs)
	cadastraDisponibilidade($_GET[empreendimento_id],$_POST['disponibilidade_tipo_id'],$_POST['identificacao'],$_POST['obs'],$_POST['valor']);
	/*echo "<script>location='?tela_id=66&empreendimento_id=$_GET[empreendimento_id]'</script>";*/
	exit();
}
//Altera Registro
if($_POST['action']=='Salvar'&&isset($id)){
	alteraDisponibilidade($id,$_GET[empreendimento_id],$_POST['disponibilidade_tipo_id'],$_POST['identificacao'],$_POST['obs'],$_POST['valor']);
	/*echo "<script>location='?tela_id=66&empreendimento_id=$_GET[empreendimento_id]'</script>";*/
	exit();
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($id)){
	
	excluiDisponibilidade($id);
}
//Pega informações
if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Dispobibilidade",'Exibe','disponibilidade_tipo',$id);
}
if($r->disponibilidade_tipo_id>0){
	$disponibilidade_tipo=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade_tipo WHERE id='".$r->disponibilidade_tipo_id."' LIMIT 1"));
}
if($_GET[empreendimento_id]>0||$r->empreendimento_id>0){
	if($r->empreendimento_id>0){
		$empreendimento_id= $r->empreendimento_id;
	}else{
		$empreendimento_id= $_GET[empreendimento_id];
	}
	$empreendimento = mysql_fetch_object(mysql_query($trace="SELECT * FROM empreendimento WHERE id='$empreendimento_id'"));
}
?>