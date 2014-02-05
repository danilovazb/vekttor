<?
function gerarBoletos($dados){
	global $vkt_id,$login_id;
	$vencimentos=$dados['vencimentos'];
	$periodo_id=$dados['periodo_id'];
	
	$matriculas_q=mysql_query($t="
	SELECT
		em.id as id, et.valor_mensalidade as valor, ea.nome as aluno, es.nome as curso, cf.razao_social as responsavel, cf.id as responsavel_id, eu.conta_id as conta_id, eu.centro_custo_id as centro_custo_id, eu.plano_conta_id as plano_conta_id, ee.nome as ensino
	FROM 
		escolar2_turmas as et, escolar2_unidades as eu, escolar2_series as es, escolar2_ensino as ee, escolar2_matriculas as em, escolar2_alunos as ea, cliente_fornecedor as cf
	WHERE 
		et.vkt_id='$vkt_id' AND et.periodo_letivo_id='$periodo_id' 
	AND 
		em.turma_id=et.id
	AND 
		em.pago='1'
	AND
		ea.id=em.aluno_id
	AND
		cf.id=em.responsavel_id
	AND
		eu.id=et.unidade_id
	AND
		es.id=et.serie_id
	AND
		ee.id = es.ensino_id
		 ");

	$qtd_matriculas=mysql_num_rows($matriculas_q);
	
	$qtd_boletos=0;
	$matriculas=array();
	$cont=0;
	mysql_query("INSERT INTO cobrancas_escolar SET vkt_id='$vkt_id',datahora_gerada=NOW(), usuario_id='".$login_id."'");
	$cobranca_id=mysql_insert_id();
	
	while($matricula=mysql_fetch_object($matriculas_q)){
		/*
		$conta = mysql_fetch_object(mysql_query($o="SELECT * FROM escolar_cursos_unidades_contas WHERE curso_id='{$matricula->curso_id}' 
		AND unidade_id='{$matricula->escola_id}' AND vkt_id='$vkt_id'"));
		$aluno=mysql_fetch_object(mysql_query("SELECT * FROM escolar_alunos WHERE id='{$matricula->aluno_id}'"));
		$curso=mysql_fetch_object(mysql_query("SELECT * FROM escolar_cursos WHERE id='$matricula->curso_id'"));
		$responsavel=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id ='$matricula->responsavel_id' "));
		*/
		$parcela=1;
		$total_parcelas=count($vencimentos);
		$cont_boletos=0;
		$matriculas[$cont]['aluno']=$matricula->aluno;
		$matriculas[$cont]['curso']=$matricula->curso;
		$matriculas[$cont]['responsavel']=$matricula->responsavel;
		$matriculas[$cont]['boletos']=array();
		$boletos=array();
		?>
        <table style="margin-bottom:20px;" width="100%" cellpadding="3" cellspacing="0" border="black">
        <tbody>
        <tr>
        	<td width="200">Aluno: <?=$matricula->aluno?></td><td width="200">Curso: <?=$matricula->curso?></td><td>Responsável: <?=$matricula->responsavel?> <?=$matricula->responsavel_id?></td>
        
        <?
		
		for($i=0;$i<$total_parcelas;$i++){
			//$mes=mysql_result(mysql_query("SELECT MONTH(DATE_ADD('$primeiro_vencimento', INTERVAL $soma_mes MONTH))"),0);	
			//$data_mes=mysql_result(mysql_query("SELECT DATE_ADD('$primeiro_vencimento', INTERVAL $soma_mes MONTH)"),0);
			
			$data_mes=dataBrToUsa($vencimentos[$i]);
			$data_q=mysql_query("SELECT DATE_FORMAT('$data_mes','%m') as mes, DATE_FORMAT('$data_mes','%Y') as ano ");
			$mes=mysql_result($data_q,0,0);
			$ano=mysql_result($data_q,0,1);
			//verifica se já existe boleto lançado nesse mês para essa matrícula
			$verifica_boleto=mysql_result(mysql_query($x="SELECT COUNT(*) FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND internauta_id='{$matricula->responsavel_id}' AND origem_tipo='Mensalidade escolar' AND doc='{$matricula->id}' AND MONTH(data_vencimento) = MONTH('$data_mes')  "),0);
			//AND valor_cadastro='{$matricula->valor}'
			
			if($verifica_boleto<1){
				mysql_query($a="INSERT INTO 
				financeiro_movimento 
				SET cliente_id='$vkt_id', conta_id='{$matricula->conta_id}', internauta_id='{$matricula->responsavel_id}', data_registro=NOW(), data_vencimento='$data_mes', ano_mes_referencia='$mes/$ano', descricao='Escolar parcela $parcela de $total_parcelas', nota='Parcela referente à mensalidade escolar do aluno {$matricula->aluno} cursando {$matricula->ensino}, {$matricula->curso} ', forma_pagamento='4', valor_cadastro='{$matricula->valor}', tipo='receber', status='0', doc='$matricula->id', origem_tipo='Mensalidade escolar', origem_id='$cobranca_id', movimentacao='fisico' ");
				$movimento_id=mysql_insert_id();
				mysql_query($b="INSERT INTO financeiro_centro_has_movimento SET movimento_id='$movimento_id', plano_id='{$matricula->centro_custo_id}', valor='{$matricula->valor}'");
				//echo 'centro de custo '.$b.'<br/>';
				mysql_query($c="INSERT INTO financeiro_plano_has_movimento SET movimento_id='$movimento_id', plano_id='{$matricula->plano_conta_id}', valor='{$matricula->valor}'");
				//echo 'plano de conta '.$c.'<br/>';
				$matriculas[$cont]['boletos'][$cont_boletos]['descricao']="Parcela $parcela de $total_parcelas";
				$matriculas[$cont]['boletos'][$cont_boletos]['vencimento']=dataUsaToBr($data_mes);
				$matriculas[$cont]['boletos'][$cont_boletos]['valor']="Parcela $parcela de $total_parcelas";
				//echo "-----------------------------<br/>";
			}
			$parcela++;
		}
		?>
       <td><?=$parcela-1?> parcelas de $R<?=moedaUsaToBr($matricula->valor)?></td>
        </tr>
        </tbody>
        </table>
        <?
	}
	return $matriculas;
}

?>
