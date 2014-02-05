<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = Mário Flávios JR
@r1 = 29/01/1983
@r2 = 10/10/2010

*/

include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=
global $vkt_id;

if($_GET['acao']=='funcionario'){
	$q=mysql_query($t="SELECT f.id, f.nome, f.cpf as identificacao, cf.razao_social FROM 
							rh_funcionario f,
							cliente_fornecedor cf
						WHERE 
							f.empresa_id = cf.id AND
							(f.nome LIKE '%$_GET[busca_auto_complete]%' OR 
							cpf LIKE '%$_GET[busca_auto_complete]%') AND 
							f.vkt_id='$vkt_id' LIMIT 15");
}
if($_GET['acao']=='cargo'){
	if($_GET['empresa_id']>0){
		$filtro = "AND (empresa_id='".$_GET['empresa_id']."' OR empresa_id='0')";
	}else{
		$filtro = "AND empresa_id='0'";
	}
	$q=mysql_query($t="SELECT id, cargo as nome, cbo as identificacao FROM cargo_salario WHERE (cargo LIKE '%$_GET[busca_auto_complete]%' OR cbo LIKE '%$_GET[busca_auto_complete]%') AND vkt_id='$vkt_id' $filtro LIMIT 15");
	
}
if($_GET['acao']=='empresa'){
	$q=mysql_query($t="SELECT cf.id as id, razao_social as nome, cnpj_cpf as identificacao FROM 
		rh_empresas re,
		cliente_fornecedor cf 
	WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cliente_vekttor_id='$vkt_id' AND
		tipo_cadastro='Jurídico' AND 
		(razao_social like '%$_GET[busca_auto_complete]%')
		LIMIT 15");
	
}
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->id|$r->nome|$r->identificacao|$r->razao_social|\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 