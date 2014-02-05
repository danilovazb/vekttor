<?
//Empreendimento
function novaVenda(){
	global $vkt_id;
	/*
	1 - Cadastra novo Contrato
	2 - Altera statutus do empreendimento para pre-venda e para quem vendeu
	3 - de acordo com a negociação id
		cria boleto de entrada
		cria os boletos da  contrutora (mensal Semestral ou anual)
	*/	
	global $login_id;
	mysql_query("UPDATE disponibilidade SET situacao='1' WHERE id='{$_POST[disponibilidade_id]}' ");
	$venda_q=mysql_query($trace="
				INSERT INTO contrato SET
				cliente_fornecedor_id='".$_POST[cliente_id]."',
				vkt_id='$vkt_id',
				disponibilidade_id='".$_POST[disponibilidade_id]."',
				empreendimento_id='".$_POST[empreendimento_id]."',
				negociacao_id='".$_POST[negociacao_id]."',
				corretor_id='".$_POST[corretor_id]."',
				data_criado=NOW(),
				usuario_id='$login_id',
				data_primeiro_pagamento='".dataBrToUsa($_POST[data_primeiro_pagamento])."',
				data_fechamento=NOW(),
				valor='".moedaBrToUsa($_POST[valor])."',
				valor_comissao='".moedaBrToUsa($_POST[valor_comissao])."',
				valor_contrato='".moedaBrToUsa($_POST[contrato])."',
				comissao_valor_parcela='".moedaBrToUsa($_POST[comissao_valor_parcela])."',
				
				ato_valor='".moedaBrToUsa($_POST[valor_ato])."',
				ato_parcelas='".$_POST[ato_parcelas]."',
				ato_juros='".moedaBrToUsa($_POST[ato_juros])."',
				ato_valor_parcela='".moedaBrToUsa($_POST[ato_valor_parcela])."',
				
				anuais_valor='".moedaBrToUsa($_POST[anuais_total])."',
				anuais_parcelas='".$_POST[anuais_parcelas]."',
				anuais_juros='".moedaBrToUsa($_POST[anuais_juros])."',
				anuais_valor_parcela='".moedaBrToUsa($_POST[anuais_valor_parcelas])."',
				
				semestrais_valor='".moedaBrToUsa($_POST[semestrais_total])."',
				semestrais_parcelas='".$_POST[semestrais_parcelas]."',
				semestrais_juros='".moedaBrToUsa($_POST[semestrais_juros])."',
				semestrais_valor_parcelas='".moedaBrToUsa($_POST[semestrais_valor_parcelas])."',
				
				mensais_valor='".moedaBrToUsa($_POST[mensais_total])."',
				mensais_parcelas='".$_POST[mensais_parcelas]."',
				mensais_juros='".moedaBrToUsa($_POST[mensais_juros])."',
				mensais_valor_parcelas='".moedaBrToUsa($_POST[mensais_valor_parcelas])."',
				
				chave_valor='".moedaBrToUsa($_POST[valor_chave])."',
				chave_parcelas='".$_POST[chave_parcelas]."',
				chave_juros='".moedaBrToUsa($_POST[chave_juros])."',
				chave_valor_parcelas='".moedaBrToUsa($_POST[chave_valor_parcelas])."',
				
				banco_valor='".moedaBrToUsa($_POST[valor_banco])."',
				banco_parcelas='".$_POST[banco_parcelas]."',
				banco_juros='".moedaBrToUsa($_POST[banco_juros])."',
				banco_valor_parcela='".moedaBrToUsa($_POST[banco_valor_parcelas])."',
				
				situacao='1'");
				
					//echo $trace.'<br>';
					echo mysql_error();
		$contrato_id=mysql_insert_id();
		if($venda_q){
		//echo $t;
		$data_inicio_pagamento = dataBrToUsa($_POST[data_primeiro_pagamento]);
		// entrada
		for($i=0;$i<$_POST[ato_parcelas];$i++){
			
			mysql_query($at="INSERT INTO faturas SET
			contrato_id='$contrato_id',
			cliente_id='$_POST[cliente_id]',
			disponibilidade_id='$_POST[disponibilidade_id]',
			tipo='ato',
			descricao='Ato conforme contrato Nº.$contrato_id  $i/$_POST[ato_parcelas]',
			data_criacao=now(),
			data_vencimento= DATE_ADD('$data_inicio_pagamento', INTERVAL $i MONTH),
			vkt_id='$vkt_id',
			valor='".moedaBrToUsa($_POST[parcela_ato][$i])."',
			situacao='0'");
		}
		
		//adiciona parcelas do pagamento da comissão
		for($i=0;$i<$_POST[ato_parcelas];$i++){
			
			mysql_query($at="INSERT INTO faturas_comissao SET
			contrato_id='$contrato_id',
			descricao='Comissão conforme contrato Nº.$contrato_id  $i/$_POST[ato_parcelas]',
			data_criacao=now(),
			data_vencimento= DATE_ADD('$data_inicio_pagamento', INTERVAL $i MONTH),
			vkt_id='$vkt_id',
			valor='".moedaBrToUsa($_POST[parcela_comissao][$i])."',
			situacao='0'");
			echo mysql_error();
		}
		
		
		for($i=1;$i<$_POST[anuais_parcelas];$i++){
			mysql_query($a="INSERT INTO faturas SET
			contrato_id='$contrato_id',
			cliente_id='$_POST[cliente_id]',
			disponibilidade_id='$_POST[disponibilidade_id]',
			tipo='anual',
			descricao='Parcela Anual conforme contrato Nº.$contrato_id  $i/$_POST[anuais_parcelas]',
			data_criacao=now(),
			vkt_id='$vkt_id',
			data_vencimento=DATE_ADD('$data_inicio_pagamento', INTERVAL $i YEAR),
			valor='".moedaBrToUsa($_POST[anuais_valor_parcelas])."',
			situacao='0'");
		}
		
		// parcelas
		$semestres=$_POST[semestrais_parcelas];
		$parcela=1;
		for($i=1;$i<=$semestres;$i++){
			
			$mes_a_mais=($i*6);
			$conflitou_q=mysql_query($c="SELECT * FROM faturas WHERE contrato_id='$contrato_id' AND cliente_id='{$_POST[cliente_id]}' AND disponibilidade_id='{$_POST[disponibilidade_id]}'
			AND data_vencimento=DATE_ADD('$data_inicio_pagamento', INTERVAL $mes_a_mais MONTH) ");
			
			$conflitou=mysql_fetch_object($conflitou_q);
			if($conflitou->id>0){
				$semestres++;
			}else{
			
			@mysql_query($t="INSERT INTO faturas  SET
				contrato_id='$contrato_id',
				cliente_id='$_POST[cliente_id]',
				disponibilidade_id='$_POST[disponibilidade_id]',
				tipo='semestral',
				descricao='Parcela Semestral conforme contrato Nº.$contrato_id $parcela/$_POST[semestrais_parcelas]  ',
				data_criacao=now(),
				vkt_id='$vkt_id',
				data_vencimento=DATE_ADD('$data_inicio_pagamento', INTERVAL $mes_a_mais MONTH),
				valor='".moedaBrToUsa($_POST[semestrais_valor_parcelas])."',
				situacao='0'");
				$parcela++;
			}
				
			
		}
		unset($conflitou);
		
		// entrada
		
		$meses=$_POST[mensais_parcelas];
		$parcela=1;
		for($i=1;$i<=$meses; $i++){
			
			$mes_a_mais=$i;
			$conflitou_q=mysql_query("SELECT * FROM faturas WHERE contrato_id='$contrato_id' AND cliente_id='{$_POST[cliente_id]}' AND disponibilidade_id='{$_POST[disponibilidade_id]}'
			AND data_vencimento=DATE_ADD('$data_inicio_pagamento', INTERVAL $i MONTH) ");
			$conflitou=mysql_fetch_object($conflitou_q);
		
			if($conflitou->id>0){
				$meses++;
			}else{
			
			@mysql_query($x="INSERT INTO faturas  SET
			contrato_id='$contrato_id',
			cliente_id='$_POST[cliente_id]',
			disponibilidade_id='$_POST[disponibilidade_id]',
			tipo='mensal',
			descricao='Parcela Mensal conforme contrato Nº.$contrato_id  $parcela/$_POST[mensais_parcelas]',
			data_criacao=now(),
			vkt_id='$vkt_id',
			data_vencimento=DATE_ADD('$data_inicio_pagamento', INTERVAL $mes_a_mais MONTH),
			valor='".moedaBrToUsa($_POST[mensais_valor_parcelas])."',
			situacao='0'");
			$parcela++;
			}
		}
		$contrato=mysql_fetch_object(mysql_query("SELECT * FROM contrato WHERE id='$contrato_id' LIMIT 1"));
		$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='".$contrato->disponibilidade_id."' LIMIT 1"));
		$empreendimento=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$disponibilidade->empreendimento_id."' LIMIT 1"));
		mysql_error();
		echo $empreendimento->fim;
		for($i=0;$i<$_POST[chave_parcelas];$i++){
			
			mysql_query("insert into faturas SET
			contrato_id='$contrato_id',
			cliente_id='$_POST[cliente_id]',
			disponibilidade_id='$_POST[disponibilidade_id]',
			descricao='Chave Conforme conforme contrato Nº.$contrato_id',
			data_criacao=now(),
			tipo='chave',
			vkt_id='$vkt_id',
			data_vencimento='{$empreendimento->fim}',
			valor='".moedaBrToUsa($_POST[chave_valor_parcelas])."',
			situacao='0' ");
			
		}
		
		
		salvaUsuarioHistorico("Formulário - Contrato",'cadastrou','contrato',mysql_insert_id());
		echo "<script>location='?tela_id=171&id=$contrato_id'</script>";
		exit();
		
		return 1;
	}
	
	return 0;
}



function alteraContrato($id,$nome,$tipo,$orcamento,$inicio,$fim,$obs){
	/*
	somente enquanto está em pré-venda
	
	*/
}

function excluiContrato($id){
	
	$negociacao=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE empreendimento_id='".$id."' LIMIT 1"));
	if($negociacao->id>0)return 0;
	$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE empreendimento_id='".$id."' LIMIT 1"));
	if($disponibilidade->id>0)return 0;
	
	if($id>0){
		salvaUsuarioHistorico("Formulário - Empreendimento",'deletou','empreendimento',$id);
		mysql_query("
					DELETE FROM empreendimento
					WHERE id='".$id."'
					");

		return 1;
	}
	
	return 0;
}
?>