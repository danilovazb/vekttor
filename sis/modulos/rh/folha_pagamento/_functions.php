<?


function qtdBrToUsa_($v){
	$v = str_replace(' ','',$v);
	$v = str_replace('.',',',$v);
	$v = str_replace(',','.',$v);
	return $v;
}

function qtdUsaToBr_($v){
	$v = $v*1;
	$v = str_replace('.',',',$v);
	return $v;
}

function dsr($mes,$ano){
	global $vkt_id;
	$mes=$mes+1;
	if($mes<10){
		$mes='0'.$mes;
	}
	$FeriadosAvisoPrevio = mysql_query($t=" SELECT * FROM rh_feriado WHERE vkt_id = $vkt_id AND mes = '".($mes)."' ");
	$QtdFeriadosAvisoPrevio = mysql_num_rows($FeriadosAvisoPrevio);
	$qtd_dias_mes_aviso_previo = cal_days_in_month(CAL_GREGORIAN,($mes),$ano); /*: Quantidade de dias do MES do Aviso Previo:*/
	$ArrayNumDom = NUMSabDom(($mes*1),$ano );
	$QtdDomingo =  $ArrayNumDom['dom'];  /*: Quantidade de Domingos do MES de Aviso Previo :*/
	$QtdFeriados=$QtdFeriadosAvisoPrevio;
	while($feriados = mysql_fetch_object($FeriadosAvisoPrevio)){
		$DiaSemana = DiaDaSemana("$feriados->dia/$feriados->mes/$ano");
		  if($DiaSemana == "Domingo"){
			 $QtdFeriados = ($QtdFeriados - 1);
		  }   
	}
    $DiasDescanso = $QtdFeriados + $QtdDomingo; 				 
    $DiasUteis = $qtd_dias_mes_aviso_previo - $DiasDescanso;
	return array('DiasDescanso'=>$DiasDescanso,'DiasUteis'=>$DiasUteis);
}

function adicionaFuncionarios($folha_id,$empresa_id,$mes,$ano){
	global $vkt_id;
	
	$mes+=1;
	if($mes<10){
		$mes='0'.$mes;
	}
	//consulta o valor do salário família
	$q = mysql_query($t="SELECT * FROM 
					  	rh_funcionario
					  WHERE 
					  	empresa_id='".$empresa_id."' AND
						status != 'demitidos' AND
						vkt_id='$vkt_id'");
	while($r=mysql_fetch_object($q)){
		$horas_extras_100=0;
		$horas_extras_50=0;
		$filhos_q=mysql_query($a="SELECT COUNT(*) FROM rh_funcionario_dependentes WHERE funcionario_id='".$r->id."' AND CAST( (TO_DAYS('$ano"."-".$mes."-"."01') - TO_DAYS(data_nascimento)) as SIGNED) < 5114 ");
		
		//alert($a."<br>");
		$filhos=mysql_result($filhos_q,0);
		$data_contratacao = explode("-",$r->data_admissao);
		$ano_contratacao  = $data_contratacao[0];
		$mes_contratacao  = $data_contratacao[1];
		$horas_extras_q=mysql_query($x="SELECT SUM(saldo_horas) as horas, hora_extra_100 as eh_100 FROM rh_hora_extra WHERE funcionario_id='$r->id' AND empresa_id='$empresa_id' AND MONTH(data)='$mes' AND YEAR(data)='$ano'  GROUP BY hora_extra_100 ORDER BY hora_extra_100 ASC");
		
		if(mysql_num_rows($horas_extras_q)>0){
			while($h=mysql_fetch_object($horas_extras_q)){
				if($h->eh_100=='1'){$horas_extras_100=$h->horas;}elseif($h->eh_100=='0'){$horas_extras_50=$h->horas;}
			}	
		}else{
			$horas_extras_50='0';
			$horas_extras_100='0';
		}
		
		$valor_total_salario_familia=$qtd_salario_familia*$salario_familia->valor_beneficio;
		$alteracao_salario_q=mysql_query($a="SELECT salario FROM rh_alteracao_salario WHERE vkt_id='$vkt_id' AND funcionario_id='".$r->id."' ORDER BY data DESC" );
		
		
		$alteracao_salario_qtd=mysql_num_rows($alteracao_salario_q);
		
		if($alteracao_salario_qtd>0){$salario=mysql_result($alteracao_salario_q,0);}else{$salario=$r->salario;}
		
		if(($mes-1)==14){

			$folhas = mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd, SUM(base_calculo_inss) base_total FROM 
				rh_folha_funcionarios rh_f,
				rh_folha_empresa rh_e			
			WHERE 
				rh_f.rh_folha_id = rh_e.id AND
				rh_f.funcionario_id='".$r->id."' ORDER BY rh_f.id 
				AND rh_e.mes<12
				AND rh_e.ano=$ano
				DESC LIMIT 6"));
			
			//if($qtd_folha<6){
			$salario = $folhas->base_total/$folhas->qtd;
			
			//}
		}
		
		$adicional_noturno=($salario*$r->adicional_noturno)/100;
		$desconto_vale_transporte = $r->vale_transporte;
		
		
		
		//$salario+=$adicional_noturno;
		//caso seja  a parcela 1 do decimo terceiro
		if(($mes-1)==13){
			//se foi contratado neste ano
			if($ano_contratacao==date('Y')){
				//se foi contratado antes do mes 6
				$base_calculo_inss = (7-$mes_contratacao)*($salario/12);				
				$decimo_terceiro_proporcional = 7-$mes_contratacao;
			}else{
				$base_calculo_inss = $salario/2;
				$decimo_terceiro_proporcional = 6;
			}
			$desconto_vale_transporte='0';
		//caso seja  a parcela 2 do decimo terceiro
		}else if(($mes-1)==14){
				$desconto_vale_transporte='0';
			if($ano_contratacao==date('Y')){
				if($mes_contratacao<=5){
					$base_calculo_inss = $salario/2;
					$decimo_terceiro_proporcional = 6;
				
				}else{
					$base_calculo_inss = (13-$mes_contratacao)*($salario/12);
					$decimo_terceiro_proporcional = 13-$mes_contratacao;
					
				}
			}else{
				$base_calculo_inss = $salario/2;
				$decimo_terceiro_proporcional = 6;
			}
			
		}else if(($mes-1)==12){
			if($ano_contratacao==date('Y')){
				$base_calculo_inss= (13-$mes_contratacao)*($salario/12);
				$decimo_terceiro_proporcional = 13-$mes_contratacao;
			}else{
				$base_calculo_inss=$salario;
				$decimo_terceiro_proporcional = 12;
			}
			
		}else{
			$base_calculo_inss=$salario;
			$decimo_terceiro_proporcional = 12;
		}
		//alert($mes_contratacao." ".$ano_contratacao." ".$base_calculo_inss);
		
		 $ferias_sql = mysql_fetch_object(mysql_query($t="SELECT *
FROM `rh_ferias` WHERE  funcionario_id ='$r->id' AND month(data_inicio)=$mes AND YEAR(data_inicio)=$ano"));
		if($ferias_sql->id>0){$salario=$ferias_sql->salario_base+($ferias_sql->salario_base/3);}else{$salario=$salario;}
		
		
	mysql_query($a="
	INSERT INTO rh_folha_funcionarios 
	SET vkt_id='".$vkt_id."', empresa_id='".$empresa_id."', funcionario_id='".$r->id."', rh_folha_id='".$folha_id."', salario='$base_calculo_inss', salario_base='$base_calculo_inss', horas_trabalhadas='220:00:00', salario_familia_qtd='$filhos',porcentagem_insalubridade='$r->adicional_insalubridade',porcentagem_periculosidade='$r->adicional_periculosidade', horas_extras_horas_50=SEC_TO_TIME($horas_extras_50*3600),
	horas_extras_horas_100=SEC_TO_TIME($horas_extras_100*3600),salario_familia_valor='".$valor_total_salario_familia."',base_calculo_inss='$base_calculo_inss', decimo_terceiro_proporcional='$decimo_terceiro_proporcional', porcentagem_valetransporte='$desconto_vale_transporte'");
	}
}

function adicionaFolha($dados){
	global $vkt_id;
	global $usuario_id;
	$sql="INSERT INTO rh_folha_empresa SET vkt_id='".$vkt_id."', empresa_id='".$dados['empresa_id']."', mes='".$dados['mes']."', ano='".$dados['ano']."', status='em aberto', ultima_alteracao=NOW(), ultima_alteracao_login_id='".$usuario_id."' ";
	mysql_query($sql);
	$folha_id=mysql_insert_id();
	adicionaFuncionarios($folha_id,$dados['empresa_id'],$dados['mes'],$dados['ano']);
	echo "<script>location.href='?tela_id=441&folha_id=$folha_id'</script>";
}
function excluirFolha($folha_id,$empresa_id){
	global $vkt_id;
	mysql_query($a="DELETE FROM rh_folha_funcionarios WHERE vkt_id='$vkt_id' AND rh_folha_id='$folha_id' ");
	mysql_query($b="DELETE FROM rh_folha_empresa WHERE id='$folha_id' ");
}

function confirmarFolha($folha_id){
	global $vkt_id;
	mysql_query($b="UPDATE rh_folha_empresa SET status='fechada' WHERE id='$folha_id' ");
}

function formataHora($hora){
	if(substr_count($hora,':')==0){
		return $hora.':00:00';
	}
	if(substr_count($hora,':')==1){
		return $hora.':00';
	}
	if(substr_count($hora,':')==2){
		return $hora;
	}
}

function atualizaFolhaDePagamento($dados){
	global $vkt_id;
	
	/*** Formatação do tempo para somente horas ***/
	$trabalho=mysql_fetch_object(mysql_query($a="SELECT 
	TIME_TO_SEC('".formataHora($dados['horas_trabalhadas'])."')/3600 as horas_trabalhadas, 
	TIME_TO_SEC('".formataHora($dados['horas_trabalhadas_noite'])."')/3600 as horas_trabalhadas_noite,
	TIME_TO_SEC('".formataHora($dados['horas_extras_horas_50'])."')/3600 as horas_extras_50, 
	TIME_TO_SEC('".formataHora($dados['horas_extras_horas_100'])."')/3600 as horas_extras_100 "));
	//echo $a.'<br/>';
	
	/*** cálculo do valor da hora de trabalho do funcionário ***/
	$valor_hora=$dados['salario']/220;
	
	/*** cálculo do valor do total de horas trabalhadas ***/
	$salario=$dados['salario'];
	
	/// alterar salario base
	$salario_base=($valor_hora*$trabalho->horas_trabalhadas);
	$data_contratacao = explode("-",$r->data_admissao);
	$ano_contratacao  = $r->$data_contratacao[0];
	$mes_contratacao  = $r->$data_contratacao[1];
	echo "(($salario_base))";
	
	$valor_adicional_noturno_salario =$salario*$dados['adicional_noturno']/100;
	echo 	$valor_adicional_noturno_salario;
	/*** cálculo do valor = periculosidade + salário ***/
	$salario_base_extra=(($salario*$dados['pct_periculosidade']/100)+($salario*$dados['pct_insalubridade']/100)+($salario*$dados['adicional_noturno']/100))+$salario;
	$valor_periculosidade=$salario_base*$dados['pct_periculosidade']/100;
	$valor_insalubridade=$salario_base*$dados['pct_insalubridade']/100;
	
	/*** base de cálculo da hora extra ***/
	$base_calculo_hora_extra=($salario_base_extra/220);

	/*** cálculo do valor das horas extras trabalhadas ***/
	$valor_hora_extra_50=($base_calculo_hora_extra)*1.5*$trabalho->horas_extras_50;
	$valor_hora_extra_100=($base_calculo_hora_extra)*2*$trabalho->horas_extras_100;
	
	/*** cálculo do valor das horas do adicional noturno ***/
	$valor_hora_noturna=$base_calculo_hora_extra*0.2;
	$valor_adicional_noturno=($trabalho->horas_trabalhadas_noite*1.1428) * (($base_calculo_hora_extra*0.5)+$base_calculo_hora_extra+$valor_hora_noturna);
	
	/*** cálculo de dias úteis e dia de descanso ***/
	$uteis_descanso=dsr($dados['mes'],$dados['ano']);

    $DiasDescanso = $QtdFeriados + $QtdDomingo; 				 
    $DiasUteis = $qtd_dias_mes_aviso_previo - $DiasDescanso;
	/*** cálculo do DSR ***/
	$dsr=($valor_hora_extra_50+$valor_hora_extra_100+$valor_adicional_noturno)/$uteis_descanso['DiasUteis']*$uteis_descanso['DiasDescanso'];
	
	/*** cálculo do DSR sobre comissão ***/
	$dsr_comissao=(moedaBrToUsa($dados['comissao']))/$uteis_descanso['DiasUteis']*$uteis_descanso['DiasDescanso'];
	
	/*** cálculo do desconto das faltas ***/
	
	$valor_faltas=($salario_base_extra/30)*qtdBrToUsa_($dados['faltas']);
	
	$subtotal=$salario_base+$valor_hora_extra_100+$valor_hora_extra_50+$valor_adicional_noturno+moedaBrToUsa($dados['comissao'])+$dsr+$dsr_comissao+moedaBrToUsa($dados['gratificacao'])+$valor_insalubridade+$valor_periculosidade+$valor_adicional_noturno_salario;
	
	/*** cálculo do Salário Família ***/
	$salario_familia=mysql_fetch_object(mysql_query($a="SELECT * FROM rh_salario_familia WHERE '".$subtotal."' BETWEEN valor_minimo AND valor_maximo "));
	$qtd_salario_familia=$dados['filhos_salario_familia'];
	$valor_total_salario_familia=(($qtd_salario_familia*$salario_familia->valor_beneficio)/30)*(30-$dados['faltas']);// dividido por 30 * 30 - faltas
	
	
	/*** base de cálculo para deduçoes ***/
	$subtotal=$subtotal+$valor_total_salario_familia;
	//echo 'subtotal: '.$subtotal;
	
	/*** cálculo de INSS ***/
	$base_calculo_inss= $subtotal-$valor_faltas-$valor_total_salario_familia;
	$inss=mysql_fetch_object(mysql_query($a="SELECT * FROM rh_inss WHERE ('".$base_calculo_inss."' BETWEEN valor_minimo AND valor_maximo) OR ('".$base_calculo_inss."'>valor_maximo) ORDER BY id DESC LIMIT 1 "));
	if($subtotal>$inss->valor_maximo){
		$valor_inss=$inss->valor_maximo*$inss->valor_beneficio/100;
	}else{
		$valor_inss=$base_calculo_inss*$inss->valor_beneficio/100;	
	}
	
	/*
	base_calculo_irpf = $base_calculo_inss - $valor_inss
	base_calculo_fgts = bas_calculo_inss;
	*/

	/*** cálculo de IRPF (subtotal - inss) ***/
	$base_calculo_irpf=$base_calculo_inss-$valor_inss;
    $irpf=mysql_fetch_object(mysql_query($a="SELECT percentual_aliquota,valor_deducao FROM rh_irpf WHERE '".$base_calculo_irpf."' BETWEEN valor_minimo AND valor_maximo "));
    $valor_irpf = ($base_calculo_irpf*$irpf->percentual_aliquota)/100-$irpf->valor_deducao;
	
	/*** cálculo de FGTS ***/
	$fgts = $base_calculo_inss*0.08;
	
	
	$total_deducoes = $valor_faltas + moedaBrToUsa($dados['deducao_adiantamento']) + $valor_inss + $valor_irpf;
	
	
	/*** cálculo do valor líquido a receber ***/
	$saldo_a_receber=$base_calculo_inss-$valor_inss-$valor_irpf-moedaBrToUsa($dados['deducao_adiantamento'])+$valor_total_salario_familia;
	
	mysql_query($a="
	UPDATE rh_folha_funcionarios SET 
		salario='".$salario."',
		salario_base='".$salario_base."',
		porcentagem_periculosidade='".$dados['pct_periculosidade']."',
		valor_periculosidade='$valor_periculosidade',
		porcentagem_insalubridade='".$dados['pct_insalubridade']."',
		valor_insalubridade='$valor_insalubridade',
		horas_trabalhadas='".$dados['horas_trabalhadas'].":00',
		horas_trabalhadas_noite='".$dados['horas_trabalhadas_noite'].":00',
		valor_adicional_noturno='$valor_adicional_noturno',
		horas_extras_horas_50='".$dados['horas_extras_horas_50'].":00',
		horas_extras_horas_100='".$dados['horas_extras_horas_100'].":00',
		horas_extras_valor_50='".$valor_hora_extra_50."',
		horas_extras_valor_100='".$valor_hora_extra_100."',
		horas_extras_valor_total='".($valor_hora_extra_100+$valor_hora_extra_50)."',
		horas_extras_horas_total='".(moedaBrToUsa($dados['horas_extras_horas_50'])+moedaBrToUsa($dados['horas_extras_horas_100']))."',
		comissao='".moedaBrToUsa($dados['comissao'])."',
		gratificacao='".moedaBrToUsa($dados['gratificacao'])."',
		faltas='".qtdBrToUsa_($dados['faltas'])."',
		faltas_valor='".$valor_faltas."',
		deducao_adiantamento='".moedaBrToUsa($dados['deducao_adiantamento'])."',
		dsr_hora_extra='$dsr',
		dsr_comissao='$dsr_comissao',
		sub_total_valor='".$subtotal."',
		base_calculo_inss='$base_calculo_inss',
		porcentagem_inss='".$inss->valor_beneficio."',
		deducao_inss='".$valor_inss."',
		base_calculo_irpf='$base_calculo_irpf',
		porcentagem_irpf='".$irpf->percentual_aliquota."',
		deducao_irpf='".$valor_irpf."',
		porcentagem_fgts='8',
		fgts='$fgts',
		salario_familia_valor='".$valor_total_salario_familia."',
		total_deducoes='".$total_deducoes."',
		saldo_a_receber_salario='$saldo_a_receber',
		adicional_noturno='$dados[adicional_noturno]',
		valor_adiciona_noturno_salario='$valor_adicional_noturno_salario'
	WHERE id='".$dados['folha_funcionario_id']."'");
	//echo $a;
}

function trataTxt($var) {

	$var = strtolower($var);
	
	$var = preg_replace("[áàâãª]","a",$var);	
	$var = preg_replace("[éèê]","e",$var);	
	$var = preg_replace("[í]","e",$var);	
	$var = preg_replace("[óòôõº]","o",$var);	
	$var = preg_replace("[úùûü]","u",$var);	
	$var = str_replace("ç","c",$var);
	$var = str_replace("/","",$var);
	$var = str_replace("-","",$var);
	$var = str_replace(".","",$var);
	$var = str_replace(",","",$var);
	return $var;
}

function formata_cnpj($cnpj){
	$cnpj = str_replace("/","",$cnpj);
	$cnpj = str_replace(".","",$cnpj);
	$cnpj = str_replace("-","",$cnpj);

	return $cnpj;
}

function formata_campo($campo,$tamanho,$string,$posicao){
	//echo $posicao;
	if(strlen($campo)<$tamanho){
		$campo = str_pad($campo,$tamanho,$string,$posicao);
	}
	
	if(strlen($campo)>$tamanho){
		$campo = substr($campo,0,$tamanho);
	}
	return $campo;
}

//consulta o salário do indivíduo
function consulta_salario($funcionario_id){
	global $vkt_id;
	
	
	//consulta se houve alteração no salário
	$salario = mysql_fetch_object(mysql_query("SELECT id,salario FROM rh_alteracao_salario WHERE funcionario_id = '$funcionario_id' AND vkt_id='$vkt_id'"));

	if($salario->id<=0){
		$salario = mysql_fetch_object(mysql_query("SELECT id,salario FROM rh_funcionario WHERE id = '$funcionario_id' AND vkt_id='$vkt_id'"));	
	}
	
	return $salario->salario;
}
?>