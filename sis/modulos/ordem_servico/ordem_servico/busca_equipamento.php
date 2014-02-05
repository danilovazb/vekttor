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

$q=mysql_query("SELECT * FROM aluguel_equipamentos WHERE descricao LIKE '%$_GET[busca_auto_complete]%' AND vkt_id='$vkt_id' LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	$valor_aluguel = moedaUsaToBr($equipamento->vlr_aluguel);
					
	$disponivel  = mysql_fetch_object(mysql_query("SELECT COUNT(id) as disponivel FROM aluguel_equipamentos_itens WHERE equipamento_id = '$r->id' AND status = '1'"));
	$total_equipamento = mysql_fetch_object(mysql_query("SELECT COUNT(id) as total FROM aluguel_equipamentos_itens WHERE equipamento_id = '$r->id' "));
	
	echo urlencode("$r->id|$r->descricao|$disponivel->disponivel|$total_equipamento->total|$r->periodo|$r->vlr_aluguel|$r->fabricante\n");
	
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 