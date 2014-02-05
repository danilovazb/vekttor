<?
// preliminares

if(isset($_GET[inicio])){
	$mes_inicio= $_GET['inicio'];
	$quantidade_meses	= $_GET['meses'];
	
	$mostr_centro_ou_plano = 'plano';
}else{
	$mes_inicio= date('m/Y');
	$quantidade_meses	= 6;
	
	$mostr_centro_ou_plano = 'plano';
}

// Obrigacoes

$ano_mes_inicio= $mes_inicio;
$quantidade_meses	= $quantidade_meses;

$quebra_mes_inicio= explode('/',$ano_mes_inicio);

$mes_inicio = $quebra_mes_inicio[0];
$ano_inicio = $quebra_mes_inicio[1];

$data_inicio ="$ano_inicio".'-'.$mes_inicio.'-'.'01';

$ano_mes_fim = mysql_result(mysql_query($trace="SELECT date_format(date_add('$data_inicio', INTERVAL $quantidade_meses MONTH),'%m/%Y')"),0,0);


$quebra_mes_fim= explode('/',$ano_mes_fim);

$mes_fim = $quebra_mes_fim[0];
$ano_fim = $quebra_mes_fim[1];


$data_fim =mysql_result(mysql_query($trace="SELECT  LAST_DAY('$ano_fim"."-$mes_fim"."-01')"),0,0);

$mostr_centro_ou_plano = $mostr_centro_ou_plano;



///// Dados basicos


$planos_receber = lista_movimentos_nas_funcioes('receber',$data_inicio,$data_fim,'');
	
$planos_pagar = lista_movimentos_nas_funcioes('pagar',$data_inicio,$data_fim,'');



?>