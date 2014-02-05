<?php
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

if($_GET['acao'] == "aluno"){

	$q=mysql_query("SELECT *, matricula.id AS matricula_id, aluno.nome AS aluno_nome FROM escolar_alunos AS aluno 
					JOIN escolar_matriculas AS matricula ON aluno.id = matricula.aluno_id
					WHERE (aluno.nome like '%$_GET[busca_auto_complete]%' OR matricula.id like '%$_GET[busca_auto_complete]%') AND matricula.vkt_id = '$vkt_id'  LIMIT 15");
	$i=0;
	while($r= mysql_fetch_object($q)){
		$valor = moedaUsaToBr($r->valor);
		echo urlencode("$r->matricula_id|$r->aluno_nome|$valor|\n");
		$i++;
	}
	if($i==0){
		echo urlencode("Não Encontrado|0|0\n");
	}
}
?> 