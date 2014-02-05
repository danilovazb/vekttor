<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	$eleitor_id = manipulaEleitor($_POST,$vkt_id,$id,$via_site);
}

if($_POST['action']=='Excluir' && $id>0){
	deletaEleitor($id);
}

if($_GET['acao']=='conta_eleitores'){
	include("../../../_config.php");
	include('_function.php');
	$count_eleitores = select_eleitores($_GET);
	//echo $count_eleitores;
	echo mysql_num_rows($count_eleitores);
	exit();
}

if($_POST['action']=='Exportar'){
	$eleitores = select_eleitores($_POST);
	exportar_eleitores($eleitores,$_POST);
}


if($id>0){
	$eleitor=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_eleitores WHERE id='$id'"));
	$dependentes_q=mysql_query("SELECT * FROM eleitoral_dependentes WHERE eleitor_id='$id'");
	$politicos_q=mysql_query($s="
	SELECT 
		ep.id as id, ep.nome as nome, ep.cargo as cargo, ec.nome as coligacao, epa.sigla as partido
	FROM 
		eleitoral_intencoes_voto as eiv, eleitoral_politicos ep, eleitoral_partidos as epa, eleitoral_coligacoes as ec 
	WHERE 
		eiv.eleitor_id='$id' AND 
		ep.id=eiv.politico_id AND
		epa.id=ep.partido_id AND
		ec.id=ep.coligacao_id AND
		eiv.status='1'
		");
	$profissao=mysql_fetch_object(mysql_query($trace2="SELECT * FROM eleitoral_profissoes WHERE id='$eleitor->profissao_id'"));
}