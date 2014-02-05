<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = Mário Flávios JR
@r1 = 29/01/1983
@r2 = 10/10/2010




	 vkt_id                 = '$vkt_id',
	 codigo_interno         = '".$dados['codigo_interno'][$i]."',
	 nome 					= '".$dados['nome'][$i]."',
	 data_nascimento		= '".dataBrToUsa($dados['data_nascimento'][$i])."',
	 endereco				= '".$dados['endereco'][$i]."',
	 bairro					= '".$dados['bairro'][$i]."',
	 escolaridade			= '".$dados['escolaridade'][$i]."',
	 profissao				= '".$dados['profissao'][$i]."',
	 complemento			= '".$dados['complemento'][$i]."',
	 telefone1				= '".$dados['telefone1'][$i]."',
	 telefone2				= '".$dados['telefone2'][$i]."',
	 cep					= '".$dados['cep'][$i]."',
	 cidade					= '".$dados['cidade'][$i]."',
	 uf						= '".$dados['uf'][$i]."',
	 rg						= '".$dados['rg'][$i]."',
	 rg_dt_expedicao		= '".dataBrToUsa($dados['rg_dt_expedicao'][$i])."',
	 cpf					= '".$dados['cpf'][$i]."',
	 email					= '".$dados['email'][$i]."',
	 responsavel_id         = '".$responsavel_id."'

*/

include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=

$q=mysql_query("SELECT *,	a.data_nascimento,
		(YEAR(CURDATE())-YEAR(a.data_nascimento))
		- (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5))
		AS age
 FROM escolar_alunos as a WHERE a.vkt_id ='$vkt_id' AND (a.nome  like '%$_GET[busca_auto_complete]%' OR a.cpf like '%$_GET[busca_auto_complete]%') LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->nome|$r->id|".dataUsaToBr($r->data_nascimento)."|$r->age|$r->endereco|$r->bairro|$r->escolaridade|$r->profissao|$r->complemento|$r->telefone1|$r->telefone2|$r->cep|$r->uf|$r->rg|$r->rg_dt_expedicao|$r->cpf|$r->email|$r->cidade|$r->senha\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre em Clinte ou Fornecedor||\n");
}
?> 