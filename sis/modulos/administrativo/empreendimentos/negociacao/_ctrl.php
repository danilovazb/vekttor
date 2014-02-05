<?
//Aчѕes do Formulсrio

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];
if($_GET['disponibilidade_tipo_id']){$disponibilidade_tipo_id=$_GET['disponibilidade_tipo_id'];}
if($_POST['disponibilidade_tipo_id']){$disponibilidade_tipo_id=$_POST['disponibilidade_tipo_id'];}
//print_r($_POST);

//Cadastra Registro
if($_POST['action']=='Salvar'&&empty($id)){
	//cadastraEmpreendimento($nome,$tipo,$orcamento,$inicio,$fim,$obs)
	cadastraNegociacao($_GET['empreendimento_id'], $disponibilidade_tipo_id,$_POST);
}
//Altera Registro
if($_POST['action']=='Salvar'&&isset($id)){
	alteraNegociacao($id,$_GET['empreendimento_id'],$_POST);
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($id)){
	
	excluiNegociacao($id);
}
//Pega informaчѕes
if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulсrio - Negociaчуo",'Exibe','negociacao',$id);
}
if($_GET[empreendimento_id]>0||$r->empreendimento_id>0){
	if($r->empreendimento_id>0){
		$empreendimento_id=$r->empreendimento_id;
	}else{
		$empreendimento_id=$_GET[empreendimento_id];
	}
	$empreendimento=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$empreendimento_id."' LIMIT 1"));
}

?>