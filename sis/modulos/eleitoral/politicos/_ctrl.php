<?
//--------------------Vereador----------------------------------------------------------------
if(isset($_GET['idvereador'])){$idvereador=$_GET['idvereador'];}

if(isset($_POST['idvereador'])){$idvereador=$_POST['idvereador'];}

if($_POST['actionvereador']=='Salvar'){
	if($idvereador==0){
		CadastraVereador($_POST['nome'],$_POST['data_nascimento'],$_POST['partido_id'],
		$_POST['telefone1'],$_POST['telefone2'],$_POST['email'],
		$_POST['estado_civil'],$_POST['naturalidade'],$_POST['endereco'],
		$_POST['bairro'],$_POST['cidade'],$_POST['estado'],$_POST['cep'],
		$_POST['cargo'],$_POST['numero'],$_POST['slogan'],
		$_POST['coligacao_id'],$_POST["qtd_votos"],$vkt_id);
	}
	if($idvereador>0){
		AlteraVereador($_POST['nome'],$_POST['data_nascimento'],$_POST['partido_id'],
		$_POST['telefone1'],$_POST['telefone2'],$_POST['email'],
		$_POST['estado_civil'],$_POST['naturalidade'],$_POST['endereco'],
		$_POST['bairro'],$_POST['cidade'],$_POST['estado'],$_POST['cep'],
		$_POST['cargo'],$_POST['numero'],$_POST['slogan'],
		$_POST['coligacao_id'],$_POST["qtd_votos"],$idvereador);
	}
}
if($_POST['actionvereador']=='Excluir'){
	ExcluiVereador($idvereador);
}

if($idvereador>0){
	$vereador_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_politicos WHERE id='$idvereador'"));
	//echo $trace;
}
?>