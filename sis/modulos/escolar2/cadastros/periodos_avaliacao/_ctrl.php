<?
if($_GET['id']>0){$periodo_id=$_GET['id'];}
if($_POST['id']>0){$periodo_id=$_POST['id'];}
if($_GET['unidade_id']>0){$unidade_id=$_GET['unidade_id'];}


if($_POST['action']=="Salvar"){
	manipulaPeriodoAvaliacao($_POST);
}

if($_POST['action']=="Salvar Cálculo"){
	manipulaCalculo($_POST);
}

if($_POST['action']=="Excluir"){
	deletaPeriodoAvaliacao($_POST['id']);
}

if($periodo_id>0){
	$periodo=mysql_fetch_object(mysql_query($a="SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' AND id='$periodo_id'"));
	
	 if( !empty($_GET["unidade_id"]) ) {
		 $unidade_id = $_GET["unidade_id"];
		 $array_av = dados_avaliacao($periodo_id,$unidade_id);
	 }
}

	

