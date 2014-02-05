<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_GET['cnpj_cpf']>0){
	$professor=verificaCPF($_GET['cnpj_cpf']);
	$professor->id='';
	if(empty($professor)){
		exit();
	}
}

if($_POST['action']=='Salvar'){
	$idusuario=ManipulaUsuario($_POST);

	
	if($idusuario>0){
		$idfornecedor=manipulaFornecedor($_POST,$idusuario);
		manipulaProfessor($idfornecedor,$idusuario,$id,$_POST);
	}
}

if($_POST['action']=='Excluir'){
	//Mudar o status do professor
	AtualizaProfessor($_POST,0,$id);
}

if($id>0){
	$professor=mysql_fetch_object(mysql_query($t="
	SELECT *,p.id as id,p.usuario_id as usuid, c.id as f_id FROM escolar_professor p 
	INNER JOIN cliente_fornecedor c ON p.cliente_fornecedor_id =c.id
	WHERE p.id='$id'
	"));
}
?>