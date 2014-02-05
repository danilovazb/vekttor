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

$q=mysql_query("SELECT *,
				c.id as cliente_id,
				date_format(data_hora_inicio,'%d/%m/%y') as dt, 
				date_format(data_hora_inicio,'%Y') as ano,
				date_format(data_hora_inicio,'%m') as mes,
				date_format(data_hora_inicio,'%d') as dia,
				aa.nome as nomeagenda
				FROM 
					agenda_agendamento as a,
					cliente_fornecedor as c,
					agenda as aa
				WHERE 
					a.vkt_id='$vkt_id' 
				AND 
					a.cliente_id=c.id
				AND
					a.agenda_id=aa.id
				AND 
					razao_social LIKE '%$_GET[busca_auto_complete]%' 
				ORDER BY 
					a.id DESC  
				LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	$data = dataUsaToBr("$r->data_hora_inicio");
	echo urlencode("$r->cliente_id|$r->razao_social|$r->dt|$r->agenda_id|$r->nomeagenda|$r->ano|".($r->mes-1)."|$r->dia\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 