<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}
//echo $id;
if($_POST['action']=='Salvar'){
	manipulaResponsavel($_POST,$vkt_id,$id);
}

if($_POST['action']=='Excluir'){
	excluiResponsavel($id);
}

if($id>0){
	$responsavel=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$id."' AND cliente_vekttor_id='$vkt_id' LIMIT 1"));
	
	$matricula = mysql_query($sm=" SELECT * FROM escolar_matriculas WHERE responsavel_id = '$responsavel->id' "); 
	//salvaUsuarioHistorico("Formulário - Cliente","Excluiu o ID $cliente_fornecedor_id");
}