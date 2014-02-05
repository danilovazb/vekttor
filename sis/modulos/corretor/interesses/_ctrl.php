<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];
if($_POST['interacao_status'])$interacao_status=$_POST['interacao_status'];
if($_GET['interacao_status'])$interacao_status=$_GET['interacao_status'];

if(!$interacao_status)$interacao_status=0;

//Pega informações

if($_POST['action']=='Salvar'&&empty($id)){
	
	$cadastra=cadastraInteresse($_POST,$_POST['interesse_regioes'],$vkt_id);
	
}

if($_POST['action']=='Salvar'&&isset($id)){
	//echo "Interesse regioes: ".$_POST['interesse_regioes'];
	$cadastra=alteraInteresse($_POST['id'],$_POST,$_POST['interesse_regioes']);
	
}

if($_POST['action']=='Excluir'&&isset($id)){
	
	$cadastra=excluiInteresse($_POST['id']);
	
}

if($id>0){
	$r=mysql_fetch_object(mysql_query($t="SELECT * FROM interesse WHERE id='".$id."' LIMIT 1"));
	//echo $t;
	salvaUsuarioHistorico("Formulário - Interesse",'Exibe','interesse',$id);
}
?>