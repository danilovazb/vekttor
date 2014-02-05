<?php
/* FUNCOES PARA OS CALCULOS DA RESCISAO */
	
	
	function PrejecaoDias($dias){
		if($dias < 365)
			return 0;
	}
	
	function ProjecaoAno($ano){
		return $ano * 3;
	}
	
	/* Traz o dia da semana para qualquer data informada*/
	function DiaDaSemana($data) {  
		$dia =  substr($data,0,2);
		$mes =  substr($data,3,2);
		$ano =  substr($data,6,9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana){  
				case"0": $diasemana = "Domingo";	   break;  
				case"1": $diasemana = "Segunda-Feira"; break;  
				case"2": $diasemana = "Terça-Feira";   break;  
				case"3": $diasemana = "Quarta-Feira";  break;  
				case"4": $diasemana = "Quinta-Feira";  break;  
				case"5": $diasemana = "Sexta-Feira";   break;  
				case"6": $diasemana = "Sábado";		break;  
			 }
		return $diasemana;
	}
	
	/*FUNCAO PARA IDADE */
	function Idade($nascimento){
		// Separa em dia, mês e ano
		list($ano, $mes, $dia) = explode('-', $nascimento);
		// Descobre que dia é hoje e retorna a unix timestamp
		$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		// Descobre a unix timestamp da data de nascimento do fulano
		$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
		// Depois apenas fazemos o cálculo já citado :)
		$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
		/* return */
		return $idade;	
	}
	/* FUNCAO PARA DIFERENÇA DE DATA */
	function DiferencaData($startDate, $endDate) { 
		 $startDate = strtotime($startDate); 
         $endDate   = strtotime($endDate); 
            if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) 
                return false; 
                
            $years = date('Y', $endDate) - date('Y', $startDate); 
            
            $endMonth = date('m', $endDate); 
            $startMonth = date('m', $startDate); 
            
            // Calculate months 
            $months = $endMonth - $startMonth; 
            if ($months < 0)  { 
                $months += 12; 
                $years--; 
            } 
            if ($years < 0) 
                return false; 
            
            // Calculate the days 
                        $offsets = array(); 
                        if ($years > 0) 
                            $offsets[] = $years . (($years == 1) ? ' year' : ' years'); 
                        if ($months > 0) 
                            $offsets[] = $months . (($months == 1) ? ' month' : ' months'); 
                        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now'; 

                        $days = $endDate - strtotime($offsets, $startDate); 
                        $days = date('z', $days); 
						//
						//$r =  strtotime($endDate);  
                        
            return array($years, $months, $days); 
	} 
	/*
	* @ Funcao para os DOMINGOS e SABADOS
	*/
	function NUMSabDom($mes,$ano ) {
		$numDiasFev = (date('L', mktime(0, 0, 0, $mes, 1, $ano)) == '1') ? 29 : 28;
		$numDiasMeses = array(1 => 31, 2 => $numDiasFev, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);

		for ( $i = date( 'N', mktime( 0, 0, 0, $mes, 1, $ano ) ), $j = 0, $numSab = 0, $numDom = 0; $j < $numDiasMeses[$mes]; $j++, $i++ ) {
			$i = ($i > 7) ? 1 : $i;
			if ( $i == '6' ) { $numSab++; } elseif ( $i == '7' ) { $numDom++; }
		}
		return array('sab' => $numSab, 'dom' => $numDom, 'ano' => $ano, 'mes' => $mes);
	}
/*================================= CADASTRO NO BANCO DE DADOS =====================================*/
  
  function manipulaDemissao($dados,$vkt_id){
	  
	  if($dados[id]<=0){
		  $inicio="INSERT INTO";$fim="";
	  }else{
		  $inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	  }
	  
	   /*Variaveis globais*/
	   $TotalVerbasRescisorias = 0;
	   $TotalDeducoes = 0;
	   $ValorRescisorioLiquido = 0;
	   $ano = date("Y"); 
	  
	   /*.:FERIADOS:.*/
	   $todos_feriados = mysql_query("SELECT * FROM rh_feriado WHERE vkt_id = $vkt_id ");
	   
	   /*.:DADOS DO FUNCIONARIO:.*/
	   $funcionario = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$dados[funcionario_id]' AND vkt_id='$vkt_id'"));
		
		$salario_base   = $funcionario->salario;
		$dados['periculosidade'] = $funcionario->adicional_periculosidade;
		$pensao_alimenticiaTRCT  = $funcionario->pensao_alimenticia_trct;
		
		/* caso tenha alteração de sálario */
		$alteracao_salario=mysql_query($a="SELECT salario FROM rh_alteracao_salario WHERE funcionario_id='".$funcionario->id."' ORDER BY data DESC" );
		$alteracao_salario_qtd=mysql_num_rows($alteracao_salario);
		if(!empty($alteracao_salario_qtd)){
			$salario_base=mysql_result($alteracao_salario,0);
		} 
			
	   /*.:DATA, MES ANO DIA ADMISSAO:.*/
	   $data_admissao = $funcionario->data_admissao; 
	   list($ano_admissao,$mes_admissao,$dia_admissao) = explode("-",$funcionario->data_admissao);
	  
	   /*.:DADOS DA EMRPESA:.*/
		$empresa = mysql_fetch_object(mysql_query($t="SELECT *,cliente.id AS id_empresa FROM cliente_fornecedor AS cliente JOIN rh_empresas AS empresa ON empresa.cliente_fornecedor_id = cliente.id WHERE cliente.id='".$funcionario->empresa_id."' AND cliente.cliente_vekttor_id = '$vkt_id' "));
		$empresa_id = $empresa->id_empresa;
		
			/******** PESQUISA NA FOLHA DE PAGAMENTO ************/
			$SubTotalValor = mysql_fetch_object(mysql_query($f=" SELECT * FROM rh_folha_funcionarios WHERE vkt_id = '$vkt_id' AND funcionario_id = '$dados[funcionario_id]' AND empresa_id = '$empresa_id' ")); 
		
		/*.:===== DADOS DA DEMISSAO =======:.*/
	 
	    /*.: Data Afastamento :.*/
	    list($dia_afastamento,$mes_afastamento,$ano_afastamento) = explode("/",$dados['data_demissao']);
	    $data_demissao = $ano_afastamento."-".$mes_afastamento."-".$dia_afastamento;
	   
	    /*.: Data Aviso Previo :.*/
		
		list($dia_avisoPrevio,$mes_avisoPrevio,$ano_avisoPrevio) = explode("/",$dados['data_aviso_previo']);
		$data_aviso_previo = $ano_avisoPrevio."-".$mes_avisoPrevio."-".$dia_avisoPrevio;
	   
	    /*.: Informações importantes para o calculo do DSR :.*/
		$FeriadosAvisoPrevio = mysql_query(" SELECT * FROM rh_feriado WHERE vkt_id = $vkt_id AND mes = '$mes_avisoPrevio' "); 
		$QtdFeriadosAvisoPrevio =  mysql_num_rows($FeriadosAvisoPrevio);
	  
	    if($mes_avisoPrevio > 0){
	  		$qtd_dias_mes_aviso_previo = cal_days_in_month(CAL_GREGORIAN,$mes_avisoPrevio,$ano); /*: Quantidade de dias do MES do Aviso Previo:*/
	 	}
		
		
		$ArrayNumDom = NUMSabDom($mes_avisoPrevio*1,$ano );
	    $QtdDomingo =  $ArrayNumDom['dom'];  /*: Quantidade de Domingos do MES de Aviso Previo :*/
	  
	   $QtdFeriados = $QtdFeriadosAvisoPrevio;
		  //echo $QtdFeriados;
		  while($feriados = mysql_fetch_object($FeriadosAvisoPrevio)){
			  $DiaSemana = DiaDaSemana("$feriados->dia/$feriados->mes/$ano");
				if($DiaSemana == "Domingo"){
				   $QtdFeriados = ($QtdFeriados - 1);
				}   
		   }
		   $DiasDescanso = $QtdFeriados + $QtdDomingo; 				 
	       $DiasUteis = $qtd_dias_mes_aviso_previo - $DiasDescanso;
	  	
	  /***************.: SALARIO FAMILIA :.***************/
	  	/* Valor do Beneficio */
	  $ValorBeneficio = @mysql_result(mysql_query($g="SELECT valor_beneficio FROM rh_salario_familia WHERE '".$salario_base."' BETWEEN valor_minimo AND valor_maximo"),0,0);
	  	/* SQL Dependente */
	  $sqlDependente = mysql_query($d=" SELECT * FROM rh_funcionario_dependentes WHERE funcionario_id = '$dados[funcionario_id]' AND vkt_id = '$vkt_id' AND grau_parentesco = 'filho'");
	  $Beneficio = 0;
	  	while($dependente=mysql_fetch_object($sqlDependente)){
			$idade = Idade($dependente->data_nascimento);
			if($idade <= 14){
			   $Beneficio += $ValorBeneficio; 
			}
		}
		if(!empty($Beneficio)){
			$salario_familia_beneficio = number_format($Beneficio,2);
		}
		
		/* CALCULO FERIAS PROPORCIONAIS */
		  $meses = mysql_result(mysql_query($tpy="SELECT TIMESTAMPDIFF(MONTH, '$data_admissao','$data_demissao')"),0,0);
		  $AnosFeriasProporcional = mysql_result(mysql_query("SELECT TIMESTAMPDIFF(YEAR, '$data_admissao','$data_demissao')"),0,0);
		  //echo "<br/>".$meses."";
		  $ferias_proporcional = ($meses+1)-($AnosFeriasProporcional*12);
		  
		/***************** FÉRIAS VENCIDAS *****************/
	  
	  	$Periodo_Aquisicao_Ferias = mysql_fetch_object(mysql_query($ty=" SELECT * FROM rh_ferias WHERE vkt_id = '$vkt_id' AND funcionario_id = '$funcionario_id' ORDER BY id DESC"));
	  
		  if(!empty($Periodo_Aquisicao_Ferias->id)){
			$InicioUltimaFerias = dataUsaToBr($Periodo_Aquisicao_Ferias->data_inicio_aquisicao);
			$FimUltimaFerias    = dataUsaToBr($Periodo_Aquisicao_Ferias->data_fim_aquisicao);
			
				/* Inicio Ferias Pendente */
				list($diaInicio, $mesInicio, $anoInicio) = explode('/', $FimUltimaFerias);
				$time = mktime(0, 0, 0, $mesInicio+12, $diaInicio, $anoInicio);
				$InicioFeriasPendente =  strftime('%d/%m/%Y', $time);
				//echo $InicioFeriasPendente;
			
				/* Fim de Ferias Pendente */	
				list($diaFim, $mesFim, $anoFim) = explode('/', $InicioFeriasPendente);
				$timeFim = mktime(0, 0, 0, $mesFim, $diaFim+30, $anoFim);
				$FimFeriasPendente =  strftime('%d/%m/%Y', $timeFim);
			
		  } // 01-01-2011 
		  else{
				/* Inicio Ferias Pendente */
				$InicioUltimaFerias =  dataUsaToBr($data_admissao);
				$InicioFeriasPendente = $InicioUltimaFerias;
				list($anoInicio,$mesInicio,$diaInicio) = explode('-', $data_admissao);
				$time = mktime(0, 0, 0, $mesInicio, $diaInicio, $anoInicio);
				$InicioFeriasPendente =  strftime('%d/%m/%Y', $time);
				//echo "<br/>".$InicioFeriasPendente;
				
				/* Fim de Ferias Pendente */	
				list($diaFim, $mesFim, $anoFim) = explode('/', $InicioFeriasPendente);
				$timeFim = mktime(0, 0, 0, $mesFim+12, $diaFim, $anoFim);
				$FimFeriasPendente =  strftime('%d/%m/%Y', $timeFim);   
		  }
	 
	    $Qtd_Ferias_Gozadas = mysql_result(mysql_query($fg=" SELECT COUNT(id) FROM rh_ferias WHERE vkt_id = '$vkt_id' AND funcionario_id = '$funcionario_id' AND empresa_id = '$Empresa_id'"),0,0);
		
		$ResultadoDiferenca = DiferencaData($data_admissao,$data_aviso_previo);
		$FeriasPendentes    = $ResultadoDiferenca[0];
		$MesTrabalhado      = $ResultadoDiferenca[1];			
		
		/* Ferias Pendente */
		//$FeriasVencidas = $FeriasPendentes - $Qtd_Ferias_Gozadas;
		$FeriasVencidas=0;
		//echo $FeriasVencidas;
		
		/******** IRRF ********/
		$IRPF=mysql_fetch_object(mysql_query($a="SELECT percentual_aliquota,valor_deducao FROM rh_irpf WHERE '".$salario_base."' BETWEEN valor_minimo AND valor_maximo "));
	  
/*=============================================== VALORES REAIS PARA RESCISAO ==========================================================*/
	   $total_verbas_rescisoria = 0;
	  
	  // SALDO DE DIAS SALARIO 50
	  	if(!empty($dados['mes_inteiro'])){
			//$saldo_dias_salario = number_format(((($salario_base/30)*30)),2);
			$val_saldo_dias_salario = (($salario_base/30)*30);
		} else {
			//$saldo_dias_salario = number_format(((($salario_base/30)*$dados['dias'])),2);
			$val_saldo_dias_salario = (($salario_base/30)*$dados['dias']);	
		}
	  	
		$total_verbas_rescisoria += $val_saldo_dias_salario;
	  
	  // COMISSAO 51
	  	$comissao = $dados['comissao'];
		$total_verbas_rescisoria += $comissao;
	  
	  // GRATIFICAÇÃO
	  	$gratificacao = $dados['gratificacao'];
	    $total_verbas_rescisoria += $gratificacao;
	  
	  // INSALUBRIDADE
	  	if(!empty($funcionario->adicional_insalubridade)){
	  		$insalubridade = number_format((($salario_base*40)/100),2);
		}
		//$total_verbas_rescisoria += $insalubridade;
		
	  // PERICULOSIDADE
	  	$periculosidade = $dados['periculosidade'];
	  	$total_verbas_rescisoria += $periculosidade;
		
	  // ADICIONAL NOTURNO
	  	  $val_hora_normal = $salario_base/220;
		  /**/
		  $qtd_adicional_noturno = ($dados['adicional_noturno']);
		  /**/
		  $val_hora_noturna = ($val_hora_normal * 20)/100;
		  /**/
		  $val_3 = ($val_hora_normal * 50)/100;
		  /**/
		  $val_4 = ($val_hora_normal + $val_hora_noturna + $val_3);
		  /**/
		  $valor_adicional_noturno = number_format($val_4 * $qtd_adicional_noturno,2);
		  $total_verbas_rescisoria += $valor_adicional_noturno;
		  //echo " adici: ".$valor_adicional_noturno;	  
	  
	  // VALOR HORAS EXTRAS 50
	  $valor_horas_extras_50 = number_format((((($salario_base/220)*$dados['horas_extras_50']) * 1.5)),2);
	  $total_verbas_rescisoria += $valor_horas_extras_50;
	  
	  // GORJETA
	  	$gorjeta = $dados['gorjeta'];
	    $total_verbas_rescisoria += $gorjeta;
	  
	  // DESCANSO (DSR) SEMANAL REMUNERADO
	  	/*@*/
	  
	  // VALOR HORAS EXTRAS 100
	  	$valor_horas_extras_100 = number_format(((($salario_base/220)*$dados['horas_extras_100']) * 2),2);
	    $total_verbas_rescisoria += $valor_horas_extras_100;
	  
	  //  REFLEXO DO “DSR” sobre o Salário Variável
		  if($DiasUteis > 0){
			$SomaHoras = $valor_horas_extras_50 + $valor_horas_extras_100 + $valor_adicional_noturno + $comissao;
			$dsr = number_format((($SomaHoras/$DiasUteis) * $DiasDescanso),2); 
			$total_verbas_rescisoria += $dsr;	
			//echo "- dsr: ".$dsr;
		  }
	  // SALARIO FAMILIA
	     $total_verbas_rescisoria += $salario_familia_beneficio;
	  // 13º SALÁRIO PROPORCIONAL
	  
		$DecimoTerceiroProporcional = 0;
		if($dados['tipo_demissao'] == "fim_contrato"){
			
			$DecimoTerceiroProporcional = number_format((($salario_base/12)*$dados['decimo_proporcional']),2);
		
		} else{
			
			$DecimoTerceiroProporcional = number_format((($salario_base/12)*$dados['decimo_proporcional']),2);
		}
		
	 	$total_verbas_rescisoria += $DecimoTerceiroProporcional; 
	  
	  // 13º SALÁRIO EXERCÍCIO
	  	if(!empty($dados['ano_decimo_terceiro_atrasado']) and !empty($dados['mes_decimo_terceiro_atrasado'])){
			$decimo_salario_exercicio = number_format((($salario_base/12)*$dados['ano_decimo_terceiro_atrasado']),2); 
			//$total_verbas_rescisoria += ($decimo_salario_exercicio);
		}
		//FÉRIAS PROPORCIONAIS
			$val_ferias_proporcionais = (($salario_base/12)*$dados['ferias_proporcional']);
			$total_verbas_rescisoria += $val_ferias_proporcionais;
		
		// FÉRIAS VENCIDAS
		if($FeriasVencidas > 0){
			echo  'entrou em ferias vencidas';
			$UmTerco = ($salario_base/3);
			
			$TotalFerias = $UmTerco + $salario_base;
			$valor_ferias_vencidas = number_format($TotalFerias,2,".","");
			$total_verbas_rescisoria +=  $valor_ferias_vencidas;
			//echo "ferias vencidas: ".$valor_ferias_vencidas;
			
		}
		// CONSTITUCIONAL DE FÉRIAS 
			$constitucional_ferias = number_format(($val_ferias_proporcionais/3),2);
			$total_verbas_rescisoria += $constitucional_ferias;
		
		// AVISO PREVIO INDENIZADO 1
			if($dados['tipo_demissao'] == "demissao_com_justa_causa"){
				if($dados['cumprir_aviso_previo']=='sim'){
					$aviso_previo_indenizado_1 = 0;  
				}else{
					$aviso_previo_indenizado_1 = $salario_base;  					
				}
					$total_verbas_rescisoria += 	$aviso_previo_indenizado_1;
				if($dados['cumprir_aviso_previo']=='sim'){
					$aviso_previo_indenizado_2 = 0;  
				}else{
					$aviso_previo_indenizado_2 = $salario_base;  					
				}
			}
			
			//echo "Total: ".$total_verbas_rescisoria;
			//echo (@array_sum($total_verbas_rescisoria));
			
/*========================================== DEDUÇÕES ====================================================*/

		// PENSAO ALIMENTICIA
			$val_pensao_alimenticia = moedaBrToUsa(($salario_base*$pensao_alimenticiaTRCT)/100);
		// ADIANTAMENTO SALARIAL
			$adiantamento_salarial = $dados['adiantamento_salarial'];
		// ADIANTAMENTO DECIMO TERCEIRO
			$adiantamento_decimo = $dados['adiantamento_decimo'];
		// AVISO PREVIO INDENIZADO 2
			if($dados['tipo_demissao'] == "pedido_demissao"){
				if($dados['cumprir_aviso_previo']=='sim'){
					$aviso_previo_indenizado_2 = 0;  
				}else{
					$aviso_previo_indenizado_2 = $salario_base;  					
				}
	  		}
		
		// PREVIDENCIA SOCIAL
		
		$saldo_menos_decimo=($total_verbas_rescisoria - $DecimoTerceiroProporcional);
		
		$inss=mysql_fetch_object(mysql_query($a="SELECT * FROM rh_inss WHERE ('".$saldo_menos_decimo."' BETWEEN valor_minimo AND valor_maximo) OR ('".$saldo_menos_decimo."'>valor_maximo) ORDER BY id DESC LIMIT 1 "));
		if($saldo_menos_decimo>$inss->valor_maximo){
			$previdencia_social=$inss->valor_maximo*$inss->valor_beneficio/100;
		}else{
			$previdencia_social=$saldo_menos_decimo*$inss->valor_beneficio/100;	
		}


		
		$previdencia_social = number_format($previdencia_social,2,".","");
		
		// PREVIDENCIA SOCIAL DECIMO
		$inss=mysql_fetch_object(mysql_query($a="SELECT * FROM rh_inss WHERE ('".$DecimoTerceiroProporcional."' BETWEEN valor_minimo AND valor_maximo) OR ('".$DecimoTerceiroProporcional."'>valor_maximo) ORDER BY id DESC LIMIT 1 "));


		if($DecimoTerceiroProporcional>$inss->valor_maximo){
			$previdencia_social_decimo=$inss->valor_maximo*$inss->valor_beneficio/100;
		}else{
			$previdencia_social_decimo=$DecimoTerceiroProporcional*$inss->valor_beneficio/100;	
		}
	 	$previdencia_social_decimo =  $previdencia_social_decimo;
		// IRRF 
		$valor_irpf = number_format((((($total_verbas_rescisoria-$DecimoTerceiroProporcional)*$IRPF->percentual_aliquota)/100)-$IRPF->valor_deducao),2);
		
		// IRRF SOBRE DECIMO TERCEIRO
		$IRPFDecimo = number_format((($DecimoTerceiroProporcional*$IRPF->percentual_aliquota)/100 )-$IRPF->valor_deducao,2);
		
		
		
		
		//
		if(!empty($dados["mes_inteiro"])){
			$saldo_dias_trabalho = "mes";	
		} else {
			$saldo_dias_trabalho = "dia";	
		}
		
	  mysql_query($t="$inicio rh_funcionario_demitidos SET
		  vkt_id='$vkt_id',
		  empresa_id='$dados[empresa_id]',
		  funcionario_id='$dados[funcionario_id]',
		  data_demissao ='".DataBrToUsa($dados[data_demissao])."',
		  aviso_previo_indenizado = '$dados[aviso_previo_indenizado]',
		  
		  saldo_dias_salario      = '".($val_saldo_dias_salario)."',
		  comissao 				  = '".moedaBrToUsa($comissao)."',
		  gratificacao 			  = '".moedaBrToUsa($gratificacao)."',
		  insalubridade           = '$insalubridade',
		  adicional_noturno 	  = '".($valor_adicional_noturno)."',
		  qtd_adicional_noturno   = '$qtd_adicional_noturno',
		  valor_horas_extra_50    = '".($valor_horas_extras_50)."',
		  gorjeta 				  = '".moedaBrToUsa($gorjeta)."',
		  valor_horas_extra_100   = '".($valor_horas_extras_100)."',
		  dsr_salario_variavel    = '".($dsr)."',
		  valor_salario_familia   = '".($salario_familia_beneficio)."',
		  val_decimo_proporcional = '".($DecimoTerceiroProporcional)."',
		  decimo_proporcional     = '$dados[decimo_proporcional]',
		  
		  decimo_salario_exercicio = '".moedaBrToUsa($decimo_salario_exercicio)."',
		  valor_ferias_proporcional = '".($val_ferias_proporcionais)."',
		  ferias_proporcional       = '$dados[ferias_proporcional]',
		  valor_ferias_vencidas     = '".($valor_ferias_vencidas)."',
		  valor_constitucional_ferias = '".($constitucional_ferias)."',
		  aviso_previo_indenizado_1   = '".moedaBrToUsa($aviso_previo_indenizado_1)."',
		  pensao_alimenticia          = '".moedaBrToUsa($val_pensao_alimenticia)."',
		  adiantamento_salarial       = '".moedaBrToUsa($adiantamento_salarial)."',
		  adiantamento_decimo_salario = '".moedaBrToUsa($adiantamento_decimo)."', 
		  aviso_previo_indenizado_2   = '".moedaBrToUsa($aviso_previo_indenizado_2)."',
		  emprestimo_consignacao      = '".moedaBrToUsa($dados['emprestimo_consignado'])."', 
		  previdencia_social          = '".($previdencia_social)."',
		  previdencia_social_decimo   = '".($previdencia_social_decimo)."',
		  irrf                        = '".($valor_irpf)."',
		  irrf_sobre_decimo           = '$IRPFDecimo',
		  saldo_fgts='".MoedaBrToUsa($dados[saldo_fgts])."',
		  tipo_demissao='$dados[tipo_demissao]',
		  
		  horas_extras_50 			= '$dados[horas_extras_50]',
		  horas_extras_100 			= '$dados[horas_extras_100]',
		  data_aviso_previo 		= '".dataBrToUsa($dados['data_aviso_previo'])."',
		  cod_afastamento 			= '$dados[codigo_afastamento]',
		 
		
		  descanso_dsr 				= '".moedaBrToUsa($dados['descanso_dsr'])."',
		  mes_decimo_terceiro_atrasado = '$dados[mes_decimo_terceiro_atrasado]',
		  ano_decimo_terceiro_atrasado = '$dados[ano_decimo_terceiro_atrasado]',
		  multa_477 				   = '".moedaBrToUsa($dados['multa_artigo_477'])."',
		  
		 
		  outro_desconto              = '".moedaBrToUsa($dados['outro_desconto'])."',
		  cumprir_aviso_previo        = '$dados[cumprir_aviso_previo]',
		  motivo                      = '$dados[motivo]',
		  saldo_dias_trabalho         = '$saldo_dias_trabalho',
		  qtd_dias_trabalhado         = '$dados[dias]'
		  $fim ");
		  if($dados[id]>0){
			$ultimo= $dados[id];
		  }else{
	  		$ultimo = mysql_insert_id();
		  }
	  //alert($t);
	  mysql_query($t="update rh_funcionario SET status='demitidos' WHERE id='$dados[funcionario_id]'");
	  
	  echo "<script>location='modulos/rh/demissao_funcionario/rescisao.php?funcionario=".$dados[funcionario_id]."&id=".$ultimo. "'</script>";
	  exit();
		  //echo mysql_error();
		  //echo "window.open('modulos/rh/demissao_funcionario/form.php?id=".$ultimo."&empresa1id=".$dados['empresa_id']."'";
		  //echo "<script> window.open('modulos/rh/demissao_funcionario/form.php?id=".$ultimo."&empresa1id=".$dados['empresa_id']."','carregador')script>";
  }

function excluiDemissao($dados,$vkt_id){
	mysql_query($t="DELETE FROM rh_funcionario_demitidos WHERE id='$dados[id]'");
	mysql_query($t="update rh_funcionario SET status='admitidos' WHERE id='$dados[funcionario_id]'");
	
}

?>