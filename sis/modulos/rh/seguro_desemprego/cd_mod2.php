<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

$funcionario = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE id=".$_GET['funcionario_id']));

$telefone1 = str_replace("(","",$funcionario->telefone1);
$telefone1 = str_replace(")","",$telefone1);
$telefone1 = str_replace("-","",$telefone1);
//$telefone1 = substr($telefone1,2);

$telefone2 = str_replace("(","",$funcionario->telefone2);
$telefone2 = str_replace(")","",$telefone2);
$telefone2 = str_replace("-","",$telefone2);
//$telefone2 = substr($telefone2,2);

$cpf = str_replace(".","",$funcionario->cpf);
$cpf = str_replace("-","",$cpf);

if($funcionario->sexo=="masculino"){
	$sexo = 1;
}else{
	$sexo = 2;
}

//------------------------------------------------------------------

$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id=".$funcionario->empresa_id));

$cnpj = str_replace(".","",$cliente_fornecedor->cnpj_cpf);
$cnpj = str_replace("/","",$cnpj);
$cnpj = str_replace("-","",$cnpj);

//------------------------------------------------------------------

$demissao = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario_demitidos WHERE funcionario_id=".$_GET['funcionario_id']));

$data_admissao = explode("-",$funcionario->data_admissao);
$data_nascimento = explode("-",$funcionario->data_nascimento);
$data_demissao = explode("-",$demissao->data_demissao);

//------------------------------------------------------------------

$meses_trabalhados = mysql_fetch_object(mysql_query(
"
SELECT 
	DATEDIFF('$demissao->data_demissao','$funcionario->data_admissao')/30 as meses		
FROM 
	rh_funcionario_demitidos rh_fd,
	rh_funcionario rh_f
WHERE
	rh_fd.funcionario_id = rh_f.id AND
	rh_f.id = '$funcionario->id'
ORDER BY
	rh_fd.id DESC
LIMIT 1
"
));

$meses_trabalhados = $meses_trabalhados->meses;
if($meses_trabalhados > 36){
	$meses_trabalhados = 36;
}
//---------------------------------------------------------------------------

//------------------------------------------------------------------

$antepenultimo_salario = mysql_fetch_object(mysql_query($t="SELECT 
															* 
														FROM
															rh_folha_empresa rh_fe,  
															rh_folha_funcionarios  rh_ff
														WHERE 
															rh_ff.rh_folha_id = rh_fe.id AND
															rh_ff.funcionario_id='$funcionario->id' AND
															rh_ff.empresa_id='$cliente_fornecedor->id' 											
														ORDER BY rh_ff.id DESC 
														LIMIT 3,3"));
														//echo $t." ".mysql_error();

$penultimo_salario = mysql_fetch_object(mysql_query("SELECT 
															* 
														FROM
															rh_folha_empresa rh_fe,  
															rh_folha_funcionarios  rh_ff
														WHERE 
															rh_ff.rh_folha_id = rh_fe.id AND
															rh_ff.funcionario_id='$funcionario->id' AND
															rh_ff.empresa_id='$cliente_fornecedor->id' 											
														ORDER BY rh_ff.id DESC 
														LIMIT 2,2"));

$ultimo_salario = mysql_fetch_object(mysql_query(
									"SELECT 
															* 
														FROM
															rh_folha_empresa rh_fe,  
															rh_folha_funcionarios  rh_ff
														WHERE 
															rh_ff.rh_folha_id = rh_fe.id AND
															rh_ff.funcionario_id='$funcionario->id' AND
															rh_ff.empresa_id='$cliente_fornecedor->id' 											
														ORDER BY rh_ff.id DESC 
														LIMIT 1,1"));
										
$soma_salarios = $antepenultimo_salario->saldo_a_receber_salario+$penultimo_salario->saldo_a_receber_salario+$ultimo_salario->saldo_a_receber_salario;

//-----------------------------------------------------------------------

$modelo=$_GET['modelo'];
if($modelo=='seguro_desemprego'){
	require"cd.php";
	exit();
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>emissao</title>
<style type="text/css">
<!--
body {		background-repeat:no-repeat;	font-family:"Lucida Console","Lucida Sans Unicode", "Lucida Grande", sans-serif;	font-size:14px;	letter-spacing:2.2mm;	word-spacing:normal;}
div{position:absolute;}

#nome{
	top:92px;
	left:32px;
}
#nomeMae{
	top:138px;
	left:32px;
}
#endereco{
	top:183px;
	left:32px;
}

#complemento{
	top:227px;
	left:30px;
}
#cep{
	top:226px;
	left:319px;
}
#uf{
	top:226px;
	left:491px;
}
#telefone{
	top:225px;
	left:541px;
}

#PIS{
	top:279px;
	left:30px;
}
#carteira{
	top:279px;
	left:272px;
}
#carteira_n{
	top:279px;
	left:440px;
}
#carteira_s{
	top:279px;
	left:390px;
}
#CPF{
	top:279px;
	left:524px;
}

#tipo{
	top:347px;
	left:115px;
}
#cnpj{
	top:346px;
	left:150px;
}
#ativEconomica{
	top:348px;
	left:420px;
}

#CBO{
	top:400px;
	left:31px;
}
#cboDescricao{
	top:400px;
	left:152px;
}

#emissao{
	top:480px;
	left:30px;
}
#dispensa{
	top:480px;
	left:171px;
}
#sexo{
	top:480px;
	left:376px;
}
#instrucao{
	top:480px;
	left:455px;
}
#nascimento{
	top:480px;
	left:514px;
}
#horas_trabalhadas{
	top:480px;
	left:644px;
}

#mes{
	top:528px;
	left:29px;
}
#antepenutimoSalario{
	top:528px;
	left:72px;
}
#mes2{
	top:528px;
	left:265px;
}
#penultimoSalario{
	top:528px;
	left:309px;
}
#mes3{
	top:528px;
	left:488px;
}
#utimoSalario{
	top:528px;
	left:530px;
}
#somaSalarios{
	top:577px;
	left:32px;
}
#bancario{
	top:576px;
	left:263px;
}
#mesesTrabalhados{
	top:576px;
	left:664px;
}
#recebeuSalario{
	top:618px;
	left:199px;
}
#avisoPrevio{
	top:617px;
	left:404px;
}
#pisPazepNit2{
	top:886px;
	left:17px;
}
#nome2{
	top:927px;
	left:18px;
}
-->
</style></head>

<body style=" margin:0px; padding:0px;">
<img src="bg2.png" style="width:189mm; background:0px; background:#FFF; " />
<div id='nome'><?=$funcionario->nome?></div>
	<div id='nomeMae'><?=$funcionario->filiacao_mae?></div>
	<div id='endereco'><?=$funcionario->endereco?></div>
	<div id='complemento'><?=$complemento?></div>
	<div id='cep'><?=$funcionario->cep?></div>
	<div id='uf'><?=$funcionario->estado?></div>
<div id='telefone' ><?=$telefone1?></div>
<div id='PIS'><?=$funcionario->pis?></div>
	<div id='carteira'><?=$funcionario->carteira_profissional_numero?></div>
	<div id='carteira_n'><?=$funcionario->carteira_profissional_estado_emissor?></div>
	<div id='carteira_s'><?=$funcionario->carteira_profissional_serie?></div>
<div id='CPF' ><?=$cpf?></div>
<div id='tipo'>1</div>
	<div id='cnpj' ><?=$cnpj?></div>
	<div id='ativEconomica'><?=$atividade?></div>
<div id='CBO'><?=$funcionario->cbo?></div>
<div id='cboDescricao'><?=$funcionario->cargo?></div>
<div id='emissao'><?=$data_admissao[2].$data_admissao[1].substr($data_admissao[0],2);?></div>
	<div id='dispensa'><?=$data_admissao[2].$data_admissao[1].substr($data_admissao[0],2);?></div>
	<div id='sexo'><?=$sexo?></div>
	<div id='instrucao'><?=$funcionario->grau_instrucao?></div>
	<div id='nascimento'><?=$data_nascimento[2].$data_nascimento[1].substr($data_nascimento[0],2);?></div>
	<div id='horas_trabalhadas'><?=$horas?></div>
<div id='mes'><?=$mes_extenso[$antepenultimo_salario->mes]?></div>
	<div id='antepenutimoSalario'><?=DataUsaToBr($antepenultimo_salario->saldo_a_receber_salario)?></div>
	<div id='mes2'><?=$mes_extenso[$penultimo_salario->mes]?></div>
	<div id='penultimoSalario'><?=DataUsaToBr($penultimo_salario->saldo_a_receber_salario)?></div>
	<div id='mes3'><?=$mes_extenso[$ultimo_salario->mes]?></div>
<div id='utimoSalario'><?=DataUsaToBr($ultimo_salario->saldo_a_receber_salario)?></div>
	<div id='somaSalarios'><?=$soma_salarios?></div>
	<div id='bancario'><?=$banco.$agencia?></div>
	<div id='mesesTrabalhados'><?=$meses_trabalhados?></div>
	<div id='recebeuSalario'><?=$recebeu?></div>
	<div id='avisoPrevio'><?=$aviso?></div>
    <? if($pagina==1){ ?>
<div id='pisPazepNit2' ><?=$funcionario->pis?></div>
	<div id='nome2'><?=$funcionario->nome?></div>
	<?
    }
	?>

</div></body>
</html>
