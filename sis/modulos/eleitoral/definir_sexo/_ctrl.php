<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	manipulaColaborador($_POST,$vkt_id,$id);
}

if($_POST['action']=='Excluir' && $id>0){
	deletaColaborador($id);
}
if($id>0){
	$colaborador=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_colaboradores WHERE id='$id'"));
	$dependentes_q=mysql_query("SELECT * FROM eleitoral_dependentes_colaboradores WHERE colaborador_id='$id'");
	$politicos_q=mysql_query($s="
	SELECT 
		ep.id as id, ep.nome as nome, ep.cargo as cargo, ec.nome as coligacao, epa.sigla as partido
	FROM 
		eleitoral_intencoes_voto as eiv, eleitoral_politicos ep, eleitoral_partidos as epa, eleitoral_coligacoes as ec 
	WHERE 
		eiv.colaborador_id='$id' AND 
		ep.id=eiv.politico_id AND
		epa.id=ep.partido_id AND
		ec.id=ep.coligacao_id
		");
	$profissao=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_profissoes WHERE id='$eleitor->profissao_id'"));
}