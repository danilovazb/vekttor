<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = Mário Flávios JR
@r1 = 29/01/1983
@r2 = 10/10/2010

*/

include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento


	$filtra_clientes= " AND usuario_id='$login_id' ";
$q=mysql_query($s="SELECT * FROM cliente_fornecedor WHERE (razao_social  like '%$_GET[busca_auto_complete]%' OR cnpj_cpf like '%$_GET[busca_auto_complete]%') AND tipo='Cliente' $filtra_clientes ");
//echo "$s|\n";
//echo urlencode($s);

while($r= mysql_fetch_object($q)){
	echo urlencode("$r->razao_social $vkt_id|$r->id|$r->cnpj_cpf\n");
}

?> 