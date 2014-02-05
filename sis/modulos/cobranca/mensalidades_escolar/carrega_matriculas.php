<?
require '../../../_config.php';
require '../../../_functions_base.php';
if($_GET['action']=='contagem'&&$_GET['periodo_id']>0){
	$de=dataBrToUsa($_GET['de']);
	$a=dataBrToUsa($_GET['a']);
	$periodo_id=$_GET['periodo_id'];
	
	$matriculas_q=mysql_query("SELECT * FROM escolar2_matriculas as em, escolar2_turmas as et WHERE em.vkt_id='$vkt_id' AND et.id=em.turma_id AND et.periodo_letivo_id='$periodo_id'");
	$qtd_matriculas=mysql_num_rows($matriculas_q);
	
	echo mysql_error();
	/*
	1 seleciona da inico, fim e periodo
	
	exibe os campos com as sdatas 
	
	*/
	echo utf8_encode("Alunos Matriculados no periodo selecionado: ").$qtd_matriculas.'<br/>';
	$qtd_boletos=0;
	$posicao_aluno=0;
	$mes_inicio=mysql_result(mysql_query("SELECT MONTH('$de')"),0,0);
	$ano_inicio=mysql_result(mysql_query("SELECT YEAR('$de')"),0,0);
	$mes_fim=mysql_result(mysql_query("SELECT MONTH('$a')"),0,0);
	$ano_fim=mysql_result(mysql_query("SELECT YEAR('$a')"),0,0);
	if(strlen($mes_fim)==1){
		$mes_fim='0'.$mes_fim;
	}
	if(strlen($mes_inicio)==1){
		$mes_inicio='0'.$mes_inicio;
	}
	$soma_mes=0;
	$dif=mysql_result(mysql_query($a="SELECT PERIOD_DIFF('{$ano_fim}{$mes_fim} ','{$ano_inicio}{$mes_inicio}')"),0,0);
	$data_mes=mysql_result(mysql_query("SELECT DATE_ADD('$de', INTERVAL $soma_mes MONTH)"),0);
	$xy=0;
	echo "<div>";
	while($soma_mes<=$dif)
	{	
		$data=mysql_result(mysql_query("SELECT DATE_ADD('$data_mes', INTERVAL $soma_mes MONTH)"),0,0);
		$w=mysql_result(mysql_query("SELECT DATE_FORMAT('$data','%w')"),0,0);
		echo utf8_encode("<div class='info_data'><input class='escolhe_data' calendario='1' id='$xy'  type='text' name='vencimentos[]' value='".dataUsaToBr($data)."' style='width:90px;'/> <span class='dia_extenso'>".$semana_extenso[$w]."</span></div>");
		$soma_mes++;
		$xy++;
	}
	echo "</div>";
}
?>