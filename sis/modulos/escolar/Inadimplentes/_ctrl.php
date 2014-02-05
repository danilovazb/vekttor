<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	if(empty($id)){
	$aluno=mysql_fetch_object(mysql_query("SELECT * FROM escolar_alunos_inadimplentes WHERE cliente_fornecedor_id_responsavel='".$_POST['busca_id_aluno']."'"));
	}	
	if(empty($aluno)){
		manipulaInadimplente($_POST,$vkt_id,$id);
	}else{
		alert("O aluno já é um inadimplente");
	}
}

if($_POST['action']=='Excluir'){
	excluiInadimplente($_POST['inadimplente_id']);
}

if($id>0){
	/*$inadimplente=mysql_fetch_object(mysql_query($t="SELECT a.*,ab.* FROM escolar_alunos a, escolar_alunos_inadimplentes ab WHERE a.id='$id' and a.id=ab.aluno_id LIMIT 1"));*/
	$inadimplente=mysql_fetch_object(mysql_query($t="SELECT cf.*,ab.*, cf.id as responsavel_id, ab.id as inadimplente_id FROM cliente_fornecedor cf, escolar_alunos_inadimplentes ab 
	WHERE cf.id=ab.cliente_fornecedor_id_responsavel AND ab.vkt_id='$vkt_id' AND cf.id='$id'"));
	//echo $t;
}
if($_POST['action'] == "Importar"){
		Importar();
}