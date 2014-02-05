<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];



//Cadastra Registro
if($_POST['action']=='Salvar'&&empty($id)){
	//cadastraEmpreendimento($nome,$tipo,$orcamento,$inicio,$fim,$obs)
	cadastraDisponibilidade_tipo($_GET[empreendimento_id],$_POST['nome'],$_POST['descricao'],$_POST['valor'],$_POST['area_privativa'],$_POST['fracao_ideal']);
}
//Altera Registro
if($_POST['action']=='Salvar'&&isset($id)){
	alteraDisponibilidade_tipo($id,$_GET[empreendimento_id],$_POST['nome'],$_POST['descricao'],$_POST['valor'],$_POST['area_privativa'],$_POST['fracao_ideal']);
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($id)){
	
	excluiDisponibilidade_tipo($id);
}
//Pega informações
if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade_tipo WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Dispobibilidade",'Exibe','disponibilidade_tipo',$id);
}
if($_GET[empreendimento_id]>0){
	$empreendimento=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$_GET[empreendimento_id]."' LIMIT 1"));
}

?>