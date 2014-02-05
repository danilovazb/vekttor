<?
//Negociação
/*
	$empreedimento_id,$nome,
	$porcentagem_entrada,$entrada_parcelas,$entrada_juros,
	$porcentagem_construtora,$construtora_parcelas,$construtora_juros,
	$porcentagem_banco,$banco_parcelas,$banco_juros,
	$obs
*/
function cadastraNegociacao($empreendimento_id,$disponibilidade_tipo_id,$dados){
	global $vkt_id;
	$negociacao_q= mysql_query($trace="
					INSERT INTO negociacao SET
						nome='{$dados[nome]}',
						empreendimento_id='".$empreendimento_id."',
						disponibilidade_tipo_id='".$dados['disponibilidade_tipo_id']."',
						vkt_id='$vkt_id',
						valor_total='".$dados['valor']."',
						
						comissao_porcentagem = '".moedaBrToUsa($dados['porcentagem_comissao'])."',
						comissao_valor='".moedaBrToUsa($dados['valor_comissao'])."',
						comissao_valor_parcela='".moedaBrToUsa($dados['comissao_valor_parcela'])."',
						contrato_valor='".$dados['contrato']."',
						
						ato_valor='".moedaBrToUsa($dados['valor_ato'])."',
							ato_porcentagem='".moedaBrToUsa($dados['porcentagem_ato'])."',
							ato_parcelas='".$dados['ato_parcelas']."',
							ato_juros='".moedaBrToUsa($dados['ato_juros'])."',
							ato_valor_parcela='".moedaBrToUsa($dados['ato_valor_parcela'])."',
						
						anuais_valor='".moedaBrToUsa($dados['anuais_total'])."',	
							anuais_porcentagem='".moedaBrToUsa($dados['porcentagem_anuais'])."',
							anuais_parcelas='".$dados['anuais_parcelas']."',
							anuais_juros='".moedaBrToUsa($dados['anuais_juros'])."',
							anuais_valor_parcela='".moedaBrToUsa($dados['anuais_valor_parcela'])."',
						
						semestrais_valor='".moedaBrToUsa($dados['semestrais_total'])."',	
							semestrais_porcentagem='".moedaBrToUsa($dados['porcentagem_semestrais'])."',
							semestrais_parcelas='".$dados['semestrais_parcelas']."',
							semestrais_juros='".moedaBrToUsa($dados['semestrais_juros'])."',
							semestrais_valor_parcela='".moedaBrToUsa($dados['semestrais_valor_parcela'])."',
						
						mensais_valor='".moedaBrToUsa($dados['mensais_total'])."',	
							mensais_porcentagem='".moedaBrToUsa($dados['porcentagem_mensais'])."',
							mensais_parcelas='".$dados['mensais_parcelas']."',
							mensais_juros='".moedaBrToUsa($dados['mensais_juros'])."',
							mensais_valor_parcela='".moedaBrToUsa($dados['mensais_valor_parcela'])."',
						
						chave_valor='".moedaBrToUsa($dados['valor_chave'])."',	
							chave_porcentagem='".moedaBrToUsa($dados['porcentagem_chave'])."',
							chave_parcelas='".$dados['chave_parcelas']."',
							chave_juros='".moedaBrToUsa($dados['chave_juros'])."',
							chave_valor_parcela='".moedaBrToUsa($dados['chave_valor_parcela'])."',
						
						banco_valor='".moedaBrToUsa($dados['valor_banco'])."',	
							banco_porcentagem='".moedaBrToUsa($dados['porcentagem_banco'])."',
							banco_parcelas='".$dados['banco_parcelas']."',
							banco_juros='".moedaBrToUsa($dados['banco_juros'])."',
							banco_valor_parcela='".moedaBrToUsa($dados['banco_valor_parcela'])."',
							
						restrito = '{$dados[restrito]}'
					");
		//echo $trace.'<br>'; echo mysql_error();
		if($negociacao_q){
			salvaUsuarioHistorico("Formulário - Negociacao",'cadastrou','negociacao',mysql_insert_id());
			return 1;
		}
	
	return 0;
}

function alteraNegociacao($id,$empreedimento_id,$dados){
	
	
		salvaUsuarioHistorico("Formulário - Negociação",'alterou','negociacao',$id);
		$negociacao_q=mysql_query($trace="
					UPDATE negociacao SET
						nome='{$dados[nome]}',
						empreendimento_id='".$empreedimento_id."',
						disponibilidade_tipo_id='".$dados['disponibilidade_tipo_id']."',
						valor_total='".moedaBrToUsa($dados['valor'])."',
						
						comissao_porcentagem = '".moedaBrToUsa($dados['porcentagem_comissao'])."',
						comissao_valor='".moedaBrToUsa($dados['valor_comissao'])."',
						comissao_valor_parcela='".moedaBrToUsa($dados['comissao_valor_parcela'])."',
						contrato_valor='".$dados['contrato']."',
						
						ato_valor='".moedaBrToUsa($dados['valor_ato'])."',
							ato_porcentagem='".moedaBrToUsa($dados['porcentagem_ato'])."',
							ato_parcelas='".$dados['ato_parcelas']."',
							ato_juros='".moedaBrToUsa($dados['ato_juros'])."',
							ato_valor_parcela='".moedaBrToUsa($dados['ato_valor_parcela'])."',
						
						anuais_valor='".moedaBrToUsa($dados['anuais_total'])."',	
							anuais_porcentagem='".moedaBrToUsa($dados['porcentagem_anuais'])."',
							anuais_parcelas='".$dados['anuais_parcelas']."',
							anuais_juros='".moedaBrToUsa($dados['anuais_juros'])."',
							anuais_valor_parcela='".moedaBrToUsa($dados['anuais_valor_parcela'])."',
						
						semestrais_valor='".moedaBrToUsa($dados['semestrais_total'])."',	
							semestrais_porcentagem='".moedaBrToUsa($dados['porcentagem_semestrais'])."',
							semestrais_parcelas='".$dados['semestrais_parcelas']."',
							semestrais_juros='".moedaBrToUsa($dados['semestrais_juros'])."',
							semestrais_valor_parcela='".moedaBrToUsa($dados['semestrais_valor_parcela'])."',
						
						mensais_valor='".moedaBrToUsa($dados['mensais_total'])."',	
							mensais_porcentagem='".moedaBrToUsa($dados['porcentagem_mensais'])."',
							mensais_parcelas='".$dados['mensais_parcelas']."',
							mensais_juros='".moedaBrToUsa($dados['mensais_juros'])."',
							mensais_valor_parcela='".moedaBrToUsa($dados['mensais_valor_parcela'])."',
						
						chave_valor='".moedaBrToUsa($dados['valor_chave'])."',	
							chave_porcentagem='".moedaBrToUsa($dados['porcentagem_chave'])."',
							chave_parcelas='".$dados['chave_parcelas']."',
							chave_juros='".moedaBrToUsa($dados['chave_juros'])."',
							chave_valor_parcela='".moedaBrToUsa($dados['chave_valor_parcela'])."',
						
						banco_valor='".moedaBrToUsa($dados['valor_banco'])."',	
							banco_porcentagem='".moedaBrToUsa($dados['porcentagem_banco'])."',
							banco_parcelas='".$dados['banco_parcelas']."',
							banco_juros='".moedaBrToUsa($dados['banco_juros'])."',
							banco_valor_parcela='".moedaBrToUsa($dados['banco_valor_parcela'])."',
							
						restrito = '{$dados[restrito]}'
					WHERE
						id='".$id."'
					");
					//echo $trace.mysql_error();
		if($negociacao_q){
			return 1;
		}
	
	return 0;
}

function excluiNegociacao($id){
	
	//$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE disponibilidade_tipo_id='".$id."' LIMIT 1"));
	$reservas=0;
	if($reservas==0){
		salvaUsuarioHistorico("Formulário - Negociação",'deletou','negociacao',$id);
		mysql_query("
					DELETE FROM negociacao
					WHERE id='".$id."'
					");
		return 1;
	}else{
		echo "<script>alert('Não Pode Deletar')</script>";	
	}
	
	return 0;
}
?>