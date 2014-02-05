<?php
//Includes
// configuraчуo inicial do sistema
include("../../../_config.php");
// funчѕes base do sistema
include("../../../_functions_base.php");

function select_eleitores($dados=NULL){
	global $vkt_id;
	/* Filtros */

if($dados['mes_aniversariante']>0){ $filtro_grupo =" AND MONTH(e.data_nascimento) = '".$dados['mes_aniversariante']."'";}
if($dados['grupo_social_id']>0){ $filtro_grupo =" AND e.grupo_social_id = '{$dados[grupo_social_id]}'";}
if($dados['regiao_id']>0){ $filtro_regiao =" AND e.regiao_id= '{$dados['regiao_id']}'";}
if($dados['bairro']>0){ $filtro_bairro=" AND e.bairro= '{$dados['bairro']}'";}
if($dados['profissao_id']>0){ $filtro_profissao=" AND e.profissao_id= '{$dados['profissao_id']}'";}
if($dados['sexo']=='m'){ $filtro_sexo=" AND e.sexo= 'masculino'";}
if($dados['sexo']=='f'){ $filtro_sexo=" AND e.sexo= 'feminino'";}
if(!empty($dados['cidade'])){ $filtro_cidade=" AND e.cidade= '{$dados['cidade']}'";}
if(!empty($dados['estado'])){ $filtro_estado=" AND e.estado= '{$dados['estado']}'";}
if(!empty($dados['cep_inicio'])&&!empty($dados['cep_fim'])){
	
	$filtro_cep = "AND e.cep BETWEEN '".$dados['cep_inicio']."' AND '".$dados['cep_fim']."'";

}else if(!empty($dados['cep_inicio'])){
	
	$filtro_cep = "AND e.cep >= '".$dados['cep_inicio']."'";
	
}

$eleitores_q=mysql_query($t="
SELECT 
	e.id,
	e.nome,
	e.data_nascimento,
	e.cep,
	e.endereco,
	e.bairro,
	e.cidade,
	e.estado,
	e.telefone1,
	e.telefone2
	$exibe_email 
	$exibe_endereco
	$exibe_tel
	
	
FROM 
	eleitoral_eleitores as e
WHERE 
	e.vkt_id='$vkt_id' AND
	endereco !='' AND
	endereco !='-' 
	AND	cidade !='' AND
	estado !='' AND
	cep !=''
$filtro_bairro
$filtro_grupo
$filtro_profissao
$filtro_regiao
$filtro_sexo
$filtro_cidade
$filtro_estado
$filtro_cep
");

//	echo mysql_error();
	//return $eleitores_q;
	return $eleitores_q;
}

if($_GET['acao']=='conta_eleitores'){
	
	$count_eleitores = select_eleitores($_GET);
	//echo $count_eleitores;
	echo mysql_num_rows($count_eleitores);
	exit();
}
if($_GET['acao']=='imprimir_etiqueta'){
	
	$eleitores = select_eleitores($_GET);
	
}

?>