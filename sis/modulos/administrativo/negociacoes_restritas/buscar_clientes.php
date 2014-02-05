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

if($_GET['negociacao_id']>0){
	$clientes;
	$neg_q=@mysql_query("SELECT * FROM negociacao_cliente WHERE negociacao_id ='{$_GET[negociacao_id]}'");
	while($neg=mysql_fetch_object($neg_q)){
		$clientes[]=$neg->cliente_id;
	}
	if(!empty($clientes)){
		$ids_fora = implode(',',$clientes);	
		$filtro_clientes=" AND id NOT IN ($ids_fora) ";
	}else{
		$filtro_clientes='';
	}
	
}

$q=mysql_query($oi="SELECT * FROM
 	cliente_fornecedor as cf
 WHERE 
 	(razao_social  like '%$_GET[busca_auto_complete]%' OR cnpj_cpf like '%$_GET[busca_auto_complete]%') 
AND tipo='Cliente'
AND cliente_vekttor_id='$vkt_id'
$filtro_clientes

");
//echo mysql_error();
//echo $oi.' - ';

while($r= mysql_fetch_object($q)){
	echo urlencode("$r->razao_social|$r->id|$r->cnpj_cpf\n");
}

?> 