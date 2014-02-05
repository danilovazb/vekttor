<?php
date_default_timezone_set('America/Manaus');

include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
	
	$id_demissao = $_GET['id'];
	$sql_demissao = mysql_fetch_object( mysql_query(" SELECT * FROM rh_funcionario_demitidos WHERE id = '$id_demissao' "));
	
	
	/*Variaveis globais*/
	 $TotalVerbasRescisorias = 0;
	 $TotalDeducoes = 0;
	 $ValorRescisorioLiquido = 0;
	 $funcionario_id = $_GET['funcionario'];
	 $ano = date("Y"); 
	/*.:FERIADOS:.*/
	 $todos_feriados = mysql_query("SELECT * FROM rh_feriado WHERE vkt_id = $vkt_id ");
	
	/*
	* @ Funcao para os DOMINGOS e SABADOS
	*/
	/*function NUMSabDom($mes,$ano ) {
		$numDiasFev = (date('L', mktime(0, 0, 0, $mes, 1, $ano)) == '1') ? 29 : 28;
		$numDiasMeses = array(1 => 31, 2 => $numDiasFev, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);

		for ( $i = date( 'N', mktime( 0, 0, 0, $mes, 1, $ano ) ), $j = 0, $numSab = 0, $numDom = 0; $j < $numDiasMeses[$mes]; $j++, $i++ ) {
			$i = ($i > 7) ? 1 : $i;
			if ( $i == '6' ) { $numSab++; } elseif ( $i == '7' ) { $numDom++; }
		}
		return array('sab' => $numSab, 'dom' => $numDom, 'ano' => $ano, 'mes' => $mes);
	}*/
	
	
	
	/****************** DADOS DO FUNCIONARIO **********************/
	$dados_funcionario = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$funcionario_id' AND vkt_id='$vkt_id'"));
	$salario_base      = $dados_funcionario->salario;
	$NomeFuncionario = utf8_encode($dados_funcionario->nome);
	$Endereco        = utf8_encode($dados_funcionario->endereco)." Nº. $dados_funcionario->casa_numero";
	$Bairro          = utf8_encode($dados_funcionario->bairro);
	$Municipio       = utf8_encode($dados_funcionario->cidade);
	$Periculosidade  = $dados_funcionario->adicional_periculosidade; // VAI FICAR
	$PisPasep        = $dados_funcionario->pis;
	$Insalubridade   = $dados_funcionario->adicional_insalubridade; 
	$PensaoAlimenticiaTRCT = $dados_funcionario->pensao_alimenticia_trct;
	$uf_morando         = $dados_funcionario->estado;
	$cep_funcionario         = $dados_funcionario->cep;
	$car_pro_numero = $dados_funcionario->carteira_profissional_numero;
	$car_pro_serie = $dados_funcionario->carteira_profissional_serie;
	$car_pro_estado = $dados_funcionario->carteira_profissional_estado_emissor;
	$funcionario_cpf = $dados_funcionario->cpf;
	list($nascimento_ano,$nascimento_mes,$nascimento_dia) = explode("-",$dados_funcionario->data_nascimento);
	$func_nome_mae = $dados_funcionario->filiacao_mae;
	$cod_sindicato = $dados_funcionario->cod_sindicato;
	$func_cnpj_sindicato = $dados_funcionario->cnpj_sindicato;
	$func_sindicato = $dados_funcionario->sindicato;
	$func_pensao_alimenticia_fgts = $dados_funcionario->pensao_alimenticia_fgts;
	$func_categoria_trabalhador = $dados_funcionario->categoria;
	
	/********** Data de Admissao **********/
	list($AnoAdmissao,$MesAdmissao,$DiaAdmissao) = explode("-",$dados_funcionario->data_admissao);
	$DataAdmissao = $dados_funcionario->data_admissao; 
	
	/***************** DADOS DA EMPRESA ********************/
	  $empresa = mysql_fetch_object(mysql_query($t="SELECT *,cliente.id AS id_empresa FROM cliente_fornecedor AS cliente JOIN rh_empresas AS empresa ON empresa.cliente_fornecedor_id = cliente.id WHERE cliente.id='".$dados_funcionario->empresa_id."' AND cliente.cliente_vekttor_id = '$vkt_id' "));
	  $Empresa_id = $empresa->id_empresa;
	
	/******** PESQUISA NA FOLHA DE PAGAMENTO ************/
			$SubTotalValor = mysql_fetch_object(mysql_query($f=" SELECT * FROM rh_folha_funcionarios WHERE vkt_id = '$vkt_id' AND funcionario_id = '$funcionario_id' AND empresa_id = '$Empresa_id' "));
			//$salario_base = $SubTotalValor->sub_total_valor;	
	
	/******************* DADOS DA DEMISSAO ***********************/
	$demissao = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario_demitidos WHERE vkt_id='$vkt_id' AND funcionario_id='".$dados_funcionario->id."' 
	AND empresa_id='$dados_funcionario->empresa_id' ORDER BY id DESC LIMIT 1"));
	$horas_extras_50  = $demissao->horas_extras_50;
	$horas_extras_100 = $demissao->horas_extras_100;
	//$Comissao         = $demissao->comissao;
	$Gorjeta          = $demissao->gorjeta;
	$DataDemissao     = $demissao->data_demissao;
	$Gratificacao     = $demissao->gratificacao;
	$QtdAdicionalNoturno 	      = $demissao->qtd_adicional_noturno;
	$ano_decimo_terceiro_atrasado = $demissao->ano_decimo_terceiro_atrasado;
	$mes_decimo_terceiro_atrasado = $demissao->mes_decimo_terceiro_atrasado;
	$AvisoPrevioIndenizado        = $demissao->aviso_previo_indenizado;
	$TipoDemissao                 = $demissao->tipo_demissao;
	$AdiantamentoSalarial         = $demissao->adiantamento_salarial;
	$AdiantamentoDecimo           = $demissao->adiantamento_decimo_salario;
	$EmprestimoConsignado         = $demissao->emprestimo_consignacao;
	$OutrosDescontos              = $demissao->outro_desconto;
	$CodAfastamento               = $demissao->cod_afastamento;
		/*.: Tipo de Demissao :.*/
		if($demissao->tipo_demissao == "demissao_com_justa_causa"){
			$CausaAfastamento = "Demiss&atilde;o com justa causa";
		}
		if($demissao->tipo_demissao == "pedido_demissao"){
			$CausaAfastamento = "Pedido de demiss&aring;o";
		}
		if($demissao->tipo_demissao == "demissao_sem_justa_causa"){
			$CausaAfastamento = "Demiss&atilde;o sem justa causa";
		}
		if($demissao->tipo_demissao == "fim_contrato"){
			$CausaAfastamento = "T&eacute;rmino de contrato";
		}
		
	
	 /*.: DATA AFASTAMENTO :.*/
	 list($AnoAfastamento,$MesAfastamento,$DiaAfastamento) = explode("-",$demissao->data_demissao);
	 $data_afastamento = explode("-",$demissao->data_demissao); 
	 $DataAfastamento = $data_afastamento[2].".".$data_afastamento[1].".".$data_afastamento[0];
	 
	  /*************.: DATA AVISO PREVIO :.****************/
	  $MesAvisoPrevio; /*: Mes do Aviso Previo :*/
	  list($AnoAvisoPrevio,$MesAvisoPrevio,$DiaAvisoPrevio) = explode("-",$demissao->data_aviso_previo);
	  $DataAvisoPrevio = $demissao->data_aviso_previo;
	
	 /*.: Informações importantes para o calculo do DSR :.*/
	  $FeriadosAvisoPrevio = mysql_query(" SELECT * FROM rh_feriado WHERE vkt_id = $vkt_id AND mes = '$MesAvisoPrevio' "); 
	  $QtdFeriadosAvisoPrevio =  mysql_num_rows($FeriadosAvisoPrevio);
	  
	  //$QtdFeriadosAvisoPrevio = mysql_result(mysql_query(" SELECT COUNT(id) AS qtd_feriados FROM rh_feriado WHERE vkt_id = $vkt_id AND mes = '$MesAvisoPrevio' "),0,0);
	  
	  if($MesAvisoPrevio > 0){
	  	$qtd_dias_mes_aviso_previo = cal_days_in_month(CAL_GREGORIAN,$MesAvisoPrevio,$ano); /*: Quantidade de dias do MES do Aviso Previo:*/
	  }
	  
	  $ArrayNumDom = NUMSabDom($MesAvisoPrevio*1,$ano );
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
			
		   //echo " Descanso: ".$DiasDescanso."<br/>";
		   //echo " Uteis: ".$DiasUteis;		
	
	  /***************.: SALARIO FAMILIA :.***************/
	  	/* Valor do Beneficio */
	  $ValorBeneficio = @mysql_result(mysql_query($g="SELECT valor_beneficio FROM rh_salario_familia WHERE '".$salario_base."' BETWEEN valor_minimo AND valor_maximo"),0,0);
	  	/* SQL Dependente */
	  $sqlDependente = mysql_query($d=" SELECT * FROM rh_funcionario_dependentes WHERE funcionario_id = '$funcionario_id' AND vkt_id = '$vkt_id' AND grau_parentesco = 'filho'");
	  $Beneficio = 0;
	  	while($dependente=mysql_fetch_object($sqlDependente)){
			$idade = Idade($dependente->data_nascimento);
			if($idade <= 14){
			   $Beneficio += $ValorBeneficio; 
			}
		}
	/*********** CALCULO FERIAS PROPORCIONAIS ************/
	  $meses = mysql_result(mysql_query($tpy="SELECT TIMESTAMPDIFF(MONTH, '$dados_funcionario->data_admissao','$demissao->data_demissao')"),0,0);
      $AnosFeriasProporcional = mysql_result(mysql_query("SELECT TIMESTAMPDIFF(YEAR, '$dados_funcionario->data_admissao','$demissao->data_demissao')"),0,0);
	  //echo "<br/>".$meses."";
	  $ferias_proporcional = ($meses+1)-($AnosFeriasProporcional*12);
	  
	  //$array_pro_dec = DiferencaData($dados_funcionario->data_admissao,$demissao->data_demissao);
	  //print_r($array_pro_dec);
	
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
			$InicioUltimaFerias =  dataUsaToBr($DataAdmissao);
			$InicioFeriasPendente = $InicioUltimaFerias;
			list($anoInicio,$mesInicio,$diaInicio) = explode('-', $DataAdmissao);
			$time = mktime(0, 0, 0, $mesInicio, $diaInicio, $anoInicio);
			$InicioFeriasPendente =  strftime('%d/%m/%Y', $time);
			//echo "<br/>".$InicioFeriasPendente;
			
			/* Fim de Ferias Pendente */	
			list($diaFim, $mesFim, $anoFim) = explode('/', $InicioFeriasPendente);
			$timeFim = mktime(0, 0, 0, $mesFim+12, $diaFim, $anoFim);
			$FimFeriasPendente =  strftime('%d/%m/%Y', $timeFim);   
	  }
	  
	  
	  $Qtd_Ferias_Gozadas = mysql_result(mysql_query($fg=" SELECT COUNT(id) FROM rh_ferias WHERE vkt_id = '$vkt_id' AND funcionario_id = '$funcionario_id' AND empresa_id = '$Empresa_id'"),0,0);
		
		//echo $fg."<br/>";
		$ResultadoDiferenca = DiferencaData($DataAdmissao,$DataAvisoPrevio);
		$FeriasPendentes    = $ResultadoDiferenca[0];
		$MesTrabalhado      = $ResultadoDiferenca[1];
		//echo $MesTrabalhado;
		
		/*========== testes ===========*/
		//print_r($ResultadoDiferenca);
		//$diferenca_dias = mysql_result(mysql_query($tt="SELECT TIMESTAMPDIFF(days, '$dados_funcionario->data_admissao','$demissao->data_demissao')"),0,0);
		//echo $tt;
		//$date1 = new DateTime($dados_funcionario->data_admissao);
		//$date2 = new DateTime($demissao->data_demissao);
		//$interval = $date1->diff($date2);
		//echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
		/*========== fim testes ===========*/
		
		
		/* Ferias Pendente */
		$FeriasVencidas = $FeriasPendentes - $Qtd_Ferias_Gozadas;
		//echo $FeriasVencidas;
		
		
		//echo "Ferias pendente: ".$FeriasVencidas."- Perido de <strong>".$InicioFeriasPendente."</strong> a <strong>".$FimFeriasPendente."</strong><br/>";
	
	/******** IRRF ********/
	
	$IRPF=mysql_fetch_object(mysql_query($a="SELECT percentual_aliquota,valor_deducao FROM rh_irpf WHERE '".$SubTotalValor->sub_total_valor."' BETWEEN valor_minimo AND valor_maximo "));
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sem título</title>
</head>
<style>
.page{
	 height: 842px;
     width: 870px;
     /*height: 842px;
     width: 595px;
	 /*margin-left: auto;
     margin-right: auto;*/
}
td{
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:1px solid #333;
	line-height:13px;
}
.xl108{
	color:black;
	font-weight:600;
	font-family:Arial, sans-serif;
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:normal;
}
.xl65{
	color:black;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	vertical-align:top;
	background:white;
	mso-pattern:black none;
	white-space:normal;
}
.xl66 {
	mso-style-parent:style0;
	color:black;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	background:white;
	mso-pattern:black none;
	white-space:normal;}
.xl133{
	mso-style-parent:style0;
	color:black;
	font-size:10.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	mso-pattern:black none;
	white-space:normal;
}
.xl144{
		text-align:left;
	vertical-align:top;	
}
.font-size-title{
	font-size:9pt;
}
.font-mini{
	font-size:9pt;
}
.negrito{
	font-weight:bold;
}
.maiuscula{ text-transform:uppercase;}
.table td{border-bottom:none;}
.TdTable{border-bottom:none;}
</style>
<body>
<div class="page" >
<table width="100%" style='border-collapse:collapse; position:relative; ' class="table">
 <!-- Linha 1 Header --> 
<tr>
  <td colspan="11" style="border:1px solid #333;" class="xl108 font-size-title" >TERMO DE RESCISÃO DE CONTRATO DE TRABALHO</td>
</tr>
 <!-- Linha 2 Header --> 
<tr>
  <td colspan="11" class="xl108 font-size-title" style="border-left:1px solid #333; border-right:1px solid #333" >IDENTIFICAÇÃO DO EMPREGADOR</td>
</tr>
  <!-- Linha 3 Título-->
  <tr>
    <td style="width:165px;"><div><span class="font-mini">01 CNPJ/CEI</span></div><div class="negrito font-mini">
    <? 
	if(!empty($empresa->cnpj_cpf)){
		echo $empresa->cnpj_cpf;
	}else{
		echo "&nbsp;";	
	}
	?>
    </div></td>
    <td><div><span class="font-mini">02 Razão Social/Nome</span></div><div class="negrito font-mini"><?
	  if(!empty($empresa->razao_social)){
		  echo utf8_encode($empresa->razao_social); 	
	  } else{
		  echo "&nbsp;";	
	  }
	?>
    </div></td>
  </tr>
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <tr>
    <td style="width:607px;"><div><span class="font-mini">03 Endereço (logradouro, nº, andar, apartamento)</span></div><div class="negrito font-mini">
    <?
	  if(!empty($empresa->endereco)){
	  	echo utf8_encode($empresa->endereco);
	  }else{
	  	echo "&nbsp;";	  
	  }
	?>
    </div></td>
    <td><div><span class="font-mini">04 Bairro</span></div><div class="negrito font-mini"><? if(!empty($empresa->bairro)){ echo $empresa->bairro;} else{ echo "&nbsp;";}?></div></td>
  </tr>
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <tr>
    <td style="width:165px;"><div><span class="font-mini">05 Município</span></div><div class="negrito font-mini"><?=$empresa->cidade?></div></td>
    <td style="width:103px;"><div><span class="font-mini">06 UF</span></div>
    <div class="negrito font-mini maiuscula"><? if(!empty($empresa->estado)){echo $empresa->estado;}else{ echo "&nbsp;";}?></div></td>
    <td style="width:115px;"><div><span class="font-mini">07 CEP</span></div><div class="negrito font-mini"><? if(!empty($empresa->cep)){echo $empresa->cep;}else{ echo "&nbsp;";}?></div></td>
    <td style="width:215px;"><div><span class="font-mini">08 CNAE</span></div><div class="negrito font-mini"><? if(!empty($empresa->cnae_principal)){echo $empresa->cnae_principal;}else{ echo "&nbsp;";}?></div></td>
    <td><div><span class="font-mini">09 CNPJ/CEI Tomadora/Obra</span></div><div class="negrito font-mini">&nbsp;</div></td>  
  </tr>
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <!-- -->
  <tr>
    <td colspan="11"  class="xl108 font-size-title" style="border-top:1px solid #333; border-left:1px solid #333;border-right:1px solid #333" >IDENTIFICAÇÃO DO TRABALHADOR</td>
   
  </tr>
  <!-- -->
  <tr>
    <td style="width:165px;"><div><span class="font-mini">10 PIS/PASEP</span></div><div class="negrito font-mini"> <?=$PisPasep?> &nbsp;</div></td>
    <td ><div><span class="font-mini" style="height:12.75pt;width:130pt">11 Nome</span></div><div class="negrito font-mini"> <?=$NomeFuncionario?> &nbsp;</div></td>
  </tr>
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <tr>
    <td style="width:608px;">
    	<div><span class="font-mini">12 Endereço (Logradouro, nº, andar, apartamento)</span></div>
    	<div class="negrito font-mini"> <?=$Endereco?> &nbsp;</div>
    </td>
    <td>
    	<div><span  class="font-mini">13 Bairro</span></div>
    	<div class="negrito font-mini"> <?=$Bairro?> &nbsp;</div> 
    </td>
  </tr>
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <tr>
    <td style=" width:165px;">
    	<div><span class="font-mini">14 Município</span></div>
        <div class="negrito font-mini"><?=$Municipio?> &nbsp;</div></td>
    <td style=" width:103px;">
    	<div><span class="font-mini">15 UF</span></div>
      <div class="negrito font-mini" style="text-transform:uppercase;"><?=$uf_morando?></div></td>
    <td style=" width:115px;">
    	<div><span class="font-mini">16 CEP</span></div>
      <div class="negrito font-mini"><?=$cep_funcionario?></div></td>
    <td colspan="2">
    	<div><span class="font-mini">17 Carteira de Trabalho (nº, série, UF)</span></div>
      <div class="negrito font-mini" style="text-transform:uppercase;"><?=$car_pro_numero." ".$car_pro_serie." ".$car_pro_estado?></div></td>
  </tr>
  <tr>
    <td>
   	  <div><span class="font-mini">18 CPF</span></div><div class="negrito font-mini"><?=$funcionario_cpf?></div></td>
    <td colspan="2">
    	<div><span class="font-mini">19 Data de nascimento</span></div>
   	  <div class="negrito font-mini"><?=$nascimento_dia.".".$nascimento_mes.".".$nascimento_ano;?></div></td>
    <td colspan="2">
    	<div><span class="font-mini">20 Nome da mãe</span></div>
   	  <div class="negrito font-mini"><?=$func_nome_mae?></div></td>
  </tr>
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <!-- -->
  <tr>
    <td colspan="11" class="xl108 font-size-title" style="border-top:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" >DADOS DO CONTRATO</td>
    
  </tr>
  <!-- -->
  <tr>
    <td class="xl144" style="width:388px;"><div><span class="font-mini">21 Tipo de Contrato</span></div><div class="negrito font-mini" style="padding-left:73px;">01</div></td>
    <td>
   	  <div><span class="font-mini">22 Causa do afastamento</span></div><div class="negrito font-mini"><?=$CausaAfastamento;?></div></td>
  </tr>
 </table>
 <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <tr>
    <td class="xl144" style="width:165px;"><div><span class="font-mini">23 Remuneração p/ fins rescisórios</span></div>
        <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;">
        <span style="float:left; margin-top:4px;">R$</span> 
        <span style="float:right;margin-top:4px"><?=moedaUsaToBr($salario_base);?></span></div></td>
    <td   class="xl144" style="width:220px;"><div><span class="font-mini">24 Data de admissão</span></div>
      <div class="negrito font-mini" style="text-align:center; margin-top:17px;"><? $data_adm = explode("-",$dados_funcionario->data_admissao); echo $data_adm[2].".".$data_adm[1].".".$data_adm[0];?></div></td>
    <td class="xl144" style="width:220px;"><div><span class="font-mini">25 Data do aviso prévio</span></div>
      <div class="negrito font-mini" style="text-align:center; margin-top:17px;"><?=$DiaAvisoPrevio.".".$MesAvisoPrevio.".".$AnoAvisoPrevio?></div></td>
    <td><div><span class="font-mini">26 Data de Afastamento</span></div>
    <div class="negrito font-mini" style="text-align:center; margin-top:17px;"><?=$DataAfastamento;?></div></td>
    
  </tr>
 
  <tr>
    <td>
    	<div><span class="font-mini">27 Cód. Afastamento</span></div>
      <div class="negrito font-mini" style="text-align:center;"><?
      	if(!empty($CodAfastamento)){
			echo $CodAfastamento;
		} else{
			echo "&nbsp;";	
		}
	  ?></div></td>
    <td class="xl144"  align="center">
    	<div><span class="font-mini" >28 Pensão Alimentícia (%)(TRCT)</span></div>
      <div class="negrito font-mini" style="text-align:center"><?
      	if(!empty($PensaoAlimenticiaTRCT)){
			echo "Sim";	
		} else{
			echo "N&atilde;o";
		}
	  ?></div></td>
    <td>
    	<div><span class="font-mini">29 Pensão alimentícia (%) (Saque FGTS)</span></div>
        <div class="negrito font-mini" style="text-align:center">
        	<?
            	if(!empty($func_pensao_alimenticia_fgts)){
					echo "Sim";
				} else{
					echo "Não";	
				}
			?>
        </div></td>
    <td><div><span class="font-mini">30 Categoria do Trabalhador</span></div>
      <div class="negrito font-mini" style="text-align:center"><? if(!empty($func_categoria_trabalhador)){ echo $func_categoria_trabalhador;} ?></div></td>
  </tr>
  </table>
 <table width="100%" style='border-collapse:collapse; position:relative;' >
  
  
  <tr>
    <td  class="TdTable" style="width:310px;">
    	<div><span class="font-mini">31 Código Sindical</span></div>
        <div class="negrito font-mini" style="text-align:center"><?=$cod_sindicato?>&nbsp;</div></td>
    <td  class="TdTable">
    	<div><span class="font-mini">32 CNPJ e Nome da Entidade Sindical Laboral</span></div>
        <div class="negrito font-mini"><?=$func_cnpj_sindicato." ".$func_sindicato?>&nbsp;</div></td>
      </tr>
  <!-- TABELA -->
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <tr>
    <td colspan="11" class="xl108 font-size-title" >DISCRIMINAÇÃO DAS VERBAS RESCISÓRIAS</td>
  </tr>
  <tr>
    <td colspan="11" class="xl108 font-size-title" >VERBAS RESCISÓRIAS</td>
  </tr>
  <tr>
    <td style="width:260px;"><span class="font-mini negrito">Rubricas</span></td>
    <td style="width:160px;" valign="top"><span class="font-mini negrito">Valor</span></td>
    <td style="width:200px;"><span class="font-mini negrito">Rubricas</span></td>
    <td style="width:150px;"><span class="font-mini negrito" style="width:116pt">Valor</span></td>
    <td style="width:150px;"><span class="font-mini negrito" style="width:116pt">Rubricas</span></td>
    <td style="width:150px;"><span class="font-mini negrito">Valor</span></td>
   
  </tr>
  <tr>
    <td class="font-mini">
    <?
    	if($demissao->saldo_dias_trabalho == "dia"){
	?>
    <span>50 Saldo de<font class="font6"> </font><font
  class="font10" style="color:#C30; font-weight:bold"><?=$demissao->qtd_dias_trabalhado?></font><font class="font7">/dias Salário (líquido de
  ____/faltas acrescidas do DSR)</font></span> 
  <? 	} else {
  ?>
  		<span>Saldo Dias Trabalhado <font class="font6"> </font> </span> 
  <?
  		}
  ?>
  <!--SALDO DIAS DE TRABLAHO -->
    </td>
    <td align="center">
    <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	//$SaldoSalario = (($salario_base/30)*$DiaAfastamento);
	//echo moedaUsaToBr($SaldoSalario);
	echo moedaUsaToBr($sql_demissao->saldo_dias_salario);
	$TotalVerbasRescisorias += ($sql_demissao->saldo_dias_salario);
	?></span> </div></td>
    <td class="xl144"><span class="font-mini">51 Comissões</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	echo moedaUsaToBr($sql_demissao->comissao);
	$TotalVerbasRescisorias += ($sql_demissao->comissao);
	?></span> </div></td>
    <td class="xl144"><span class="font-mini">52 Gratificações</span></td>
  <td>  <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<?
	echo moedaUsaToBr($sql_demissao->gratificacao);
	$TotalVerbasRescisorias += ($sql_demissao->gratificacao);
	?></span></div></td>
  </tr>
  <tr>
    <td><span class="font-mini" style="height:37.5pt;width:181pt">53 Adicional de Insalubridade</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<?
		if(!empty($sql_demissao->insalubridade)) {
			$total_insalubridade = ($salario_base*40)/100;
			echo moedaUsaToBr($sql_demissao->insalubridade);
			$TotalVerbasRescisorias += ($sql_demissao->insalubridade);
		} else{
			echo " - ";	
		}
	?></span></div></td>
    <td class="xl144"><span class="font-mini">54 Adicional de
    Periculosidade</span></td>
    <td>
    <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
		if(!empty($Periculosidade)) 
		echo $Periculosidade;
		$TotalVerbasRescisorias += ($Periculosidade);
	?></span></div></td>
    <td><span class="font-mini">55
    Adicional Noturno <? if(!empty($QtdAdicionalNoturno)){ echo "<strong>".$QtdAdicionalNoturno."</strong>";} else { echo "AA";}?> horas <strong>20</strong> %</span></td>
    <td> <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<?
	//$val_hora_normal = $salario_base/220;
	//echo moedaUsaToBr($val_hora);
	//$val_hora_noturna = ($val_hora_normal * 20)/100;
	/*=========================*/
	//$val_3 = ($val_hora_normal * 50)/100;
	/*=========================*/
	//$val_4 = ($val_hora_normal + $val_hora_noturna + $val_3);
	/*=========================*/
	//$val_adicional_noturno = ($val_4 * $QtdAdicionalNoturno);
	//$AdicionalNoturno = (((($salario_base/220)*$QtdAdicionalNoturno)*1.5)*0.2); formula anterior
	//echo moedaUsaToBr($AdicionalNoturno);
	echo moedaUsaToBr($sql_demissao->adicional_noturno);
	$TotalVerbasRescisorias += ($sql_demissao->adicional_noturno);
	
	?></span></div></td>
  </tr>
  <tr>
    <td><span class="font-mini">56 Horas Extras <? if(!empty($horas_extras_50)){ echo "<strong>".$horas_extras_50."</strong>"; } else { echo "___"; } ?> horas___50%</span></td>
    <td>
    <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<?
	//$val_horas_50 = ((($salario_base/220)*$horas_extras_50) * 1.5);
     echo moedaUsaToBr($sql_demissao->valor_horas_extra_50);
	 //echo "<br>".($val_horas_50);
	$TotalVerbasRescisorias += ($sql_demissao->valor_horas_extra_50);
	
	?></span></div></td>
    <td class="xl144"><span class="font-mini">57 Gorjetas</span></td>
    <td> <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<?
    echo moedaUsaToBr($sql_demissao->gorjeta);
	$TotalVerbasRescisorias += ($sql_demissao->gorjeta);
	?></span></div></td>
    <td class="xl144"><span class="font-mini" style="border-left:none;width:116pt">58
  Descanso (DSR) Semanal Remunerado</span></td>
    <td>
    <!--<div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">-->
	<?
  	 /* Descanso (DSR) Semanal Remunerado */
	 /*if($TipoDemissao != "pedido_demissao"){
		 echo $CausaAfastamento;
		 if($DiasUteis > 0){
			$DSRSemanalDescanso = (($SaldoSalario/$DiasUteis) * $DiasDescanso);
			echo moedaUsaToBr($DSRSemanalDescanso);
			$TotalVerbasRescisorias += $DSRSemanalDescanso;
		 }
	 } else{
		 echo "-";	 
	}*/
	 
	?><!--</span></div>--></td>
  </tr>
  <tr>
    <td><span class="font-mini">56 Horas Extras <? if(!empty($horas_extras_100)){ echo "<strong>".$horas_extras_100."</strong>";} else {echo "___";} ?> horas___ 100%</span></td>
    <td>
    <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<?
    //$val_horas_100 = ((($salario_base/220)*$horas_extras_100) * 2);
	echo moedaUsaToBr($sql_demissao->valor_horas_extra_100);
	$TotalVerbasRescisorias += ($sql_demissao->valor_horas_extra_100);
	?></span> </div></td>
    <td class="xl144"><span class="font-mini"></span></td>
    <td>&nbsp;</td>
    <td class="xl144"><span class="font-mini" style="border-left:none;width:116pt"></span></td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td><span class="font-mini">59 Reflexo do “DSR” sobre o Salário Variável</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right"><? 
		  /*Resultado*/
		  if($DiasUteis > 0){
			//$SomaHoras = $val_horas_50 + $val_horas_100 + $val_adicional_noturno + $Comissao;
			//$DSR = (($SomaHoras/$DiasUteis) * $DiasDescanso);
			echo moedaUsaToBr($sql_demissao->dsr_salario_variavel);
			$TotalVerbasRescisorias += ($sql_demissao->dsr_salario_variavel); 
		  }
	?></span> </div></td>
    <td class="xl144"><span class="font-mini">60 Multa Art. 477, §8º/CLT</span></td>
    <td> - </td>
    <td><span class="font-mini" style="border-left:none;width:116pt">61
  Multa Art. 479/CLT</span></td>
    <td> - </td>
    
  </tr>
  <tr>
    <td class="xl144"><span class="font-mini">62 Salário-Família</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	echo moedaUsaToBr($sql_demissao->valor_salario_familia);
	$TotalVerbasRescisorias += ($sql_demissao->valor_salario_familia);
	?></span> </div></td>
    <td><span class="font-mini">63 13º Salário Proporcional <font class="font10"><strong>
	<?
	if($TipoDemissao == "fim_contrato"){
		echo $demissao->decimo_proporcional;
	} else{
		echo $demissao->decimo_proporcional; 	
	}
	
	?></strong></font><font
  class="font7">/12avos</font></span></td>
    <td align="center">
    <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left">R$</span> <span style="float:right">
    <?
    /* 13º Salário Proporcional */ 
	 
	 echo moedaUsaToBr($sql_demissao->val_decimo_proporcional);
	 $TotalVerbasRescisorias += ($sql_demissao->val_decimo_proporcional);
	?>
    </span></div></td>
    <td><span class="font-mini" style="border-left:none;width:116pt">64
  13º Salário Exercício <? 
  if(!empty($ano_decimo_terceiro_atrasado)){ 
  	echo $ano_decimo_terceiro_atrasado;
   }else
   	{ echo " AAAA ";} 
   if(!empty($mes_decimo_terceiro_atrasado)){ 
   	echo " ".$mes_decimo_terceiro_atrasado;
	}else{echo " ___";}?>/12 avos</span></td>
    <td> <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;">
    <span style="float:left"><? if(!empty($ano_decimo_terceiro_atrasado)) {echo "R$";}?></span> <span style="float:right">
	<? 
	/* 13º Salário Exercício */
	if(!empty($ano_decimo_terceiro_atrasado) and !empty($mes_decimo_terceiro_atrasado)){
		
		//$DecimoSalarioExercicio = (($salario_base/12)*$mes_decimo_terceiro_atrasado); 
		echo moedaUsaToBr($sql_demissao->decimo_salario_exercicio);
		//echo "<br/>".$DecimoSalarioExercicio;
		$TotalVerbasRescisorias += ($sql_demissao->decimo_salario_exercicio);
	}
	
	?></span></div></td>
  </tr>
  <tr>
    <td class="xl144">
    <span class="font-mini">65 Férias Proporcionais <font class="font10" ><strong><?=$demissao->ferias_proporcional?></strong></font><font
  class="font7">/12 avos</font></span></td>
    <td align="center">
    	<div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left">R$</span> 
        <span style="float:right">
		<?
		//$ValFeriasProporcionais = (($salario_base/12)*$MesTrabalhado*1);
		echo moedaUsaToBr($sql_demissao->valor_ferias_proporcional);
		$TotalVerbasRescisorias += ($sql_demissao->valor_ferias_proporcional);
		?>
        </span></div></td>
    <td><span class="font-mini" >66
  Férias Vencidas Per. Aquisitivo 
  <? 
  	if($FeriasVencidas > 0){ 
		echo "<strong>".$InicioFeriasPendente."</strong>"." a <strong>".$FimFeriasPendente."</strong>";
	} else{
		echo " dd/mm/aaaa a dd/mm/aaaa " ;
	} 
  ?><span
  style="mso-spacerun:yes">&nbsp; </span> 
    <? 
  		/*if($FeriasVencidas > 0){	
			if(!empty($MesTrabalhado)){ echo $MesTrabalhado; }else {echo "__"; } 
		} else{
			echo "__";	
		}*/
		
	?>12/12avos</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;">
    <span style="float:left">R$</span> <span style="float:right">
	<?
    	if($FeriasVencidas > 0){
			/*$UmTerco = ($salario_base/3);
			$TotalFerias = $UmTerco + $salario_base;
			$TotalGeralFerias = $TotalFerias;
			/*if(!empty($MesTrabalhado)){
				$UmDozeAvos = ($TotalFerias/12);
				$TotalMesTrabalhado = ($UmDozeAvos*$MesTrabalhado);				
				$TotalGeralFerias = $TotalMesTrabalhado + $TotalFerias; 
			 }*/
			if(!empty($FeriasVencidas)){
				echo moedaUsaToBr($sql_demissao->valor_ferias_vencidas);
				$TotalVerbasRescisorias += ($sql_demissao->valor_ferias_vencidas);	
			}
		} else{
			echo "-";	
		}
	?> </span></div></td>
    <td class="xl144"><span class="font-mini" style="width:116pt">68 <font class="font-mini">1/3</font><font class="font-mini"><span
  style="mso-spacerun:yes">&nbsp;</span>Constitucional de Férias</font></span>
    </td>
    <td align="center"><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;">
    <span style="float:left">R$</span> <span style="float:right">
	<?
    	//$ConstitucionalFerias = ($ValFeriasProporcionais/3);
		echo moedaUsaToBr($sql_demissao->valor_constitucional_ferias);
		$TotalVerbasRescisorias += ($sql_demissao->valor_constitucional_ferias);	
	?>
    </span></div></td>
  </tr>
  <tr>
    <td><span class="font-mini" style="height:15.0pt;
  width:181pt">69 Aviso-Prévio Indenizado</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	if($TipoDemissao == "demissao_com_justa_causa"){
		echo moedaUsaToBr($salario_base);
		$TotalVerbasRescisorias += ($salario_base);	
	}else{
		echo " - ";	
	}
	?></span></div></td>
    <td><span class="font-mini" style="width:149pt">70 13º Salário
  (Aviso-Prévio Indenizado)</span></td>
    <td> - </td>
    <td><span class="font-mini" style="border-right:.5pt solid black;
  width:116pt">71 Férias (Aviso-Prévio Indenizado)</span></td>
    <td></td>
   
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="font-mini">TOTAL RESCISÓRIO<br/> BRUTO</span></td>
    <td align="center">
    <div class="negrito font-mini"> R$ <?=moedaUsaToBr($TotalVerbasRescisorias);?></div>
    </td>
    
  </tr>
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <!-- -->
  <tr>
    <td colspan="11" class="xl108 font-size-title" >DEDUÇÕES</td>
  </tr>
  <!-- -->
  <tr>
    <td style="width:260px;"><span class="negrito font-mini">Desconto</span></td>
    <td style="width:160px;"><span class="negrito font-mini">Valor</span></td>
    <td style="width:200px;"><span class="negrito font-mini">Desconto</span></td>
    <td style="width:150px;"><span class="negrito font-mini">Valor</span></td>
    <td style="width:150px;"><span class="negrito font-mini">Desconto</span></td>
    <td style="width:150px;"><span class="negrito font-mini">Valor</span></td>
  </tr>
  <tr>
    <td class="xl144"><span class="font-mini">100 Pensão Alimentícia</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	  
	  echo moedaUsaToBr($sql_demissao->pensao_alimenticia);
	   $TotalDeducoes += $sql_demissao->pensao_alimenticia;
	  /*$PensaoAlimenticia = (($salario_base*$PensaoAlimenticiaTRCT)/100);
	  if(!empty($PensaoAlimenticia)){
		 $TotalDeducoes += $PensaoAlimenticia;
		 echo moedaUsaToBr($PensaoAlimenticia);  
	  } else{
		echo " - ";
	  }*/
	  
	?></span> </div></td>
    <td class="xl144">
    	<span class="font-mini">101 Adiantamento Salarial</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	  echo moedaUsaToBr($sql_demissao->adiantamento_salarial);
	  $TotalDeducoes += $sql_demissao->adiantamento_salarial; 
	  /*if(!empty($AdiantamentoSalarial)){
		 $TotalDeducoes += $AdiantamentoSalarial; 
		 echo moedaUsaToBr($AdiantamentoSalarial);  
	  } else{
		echo " - ";
	  }*/
	  
	?></span> </div></td>
    <td class="xl144">
    	<span class="font-mini">102 Adiantamento de 13º Salário</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	  if(!empty($sql_demissao->adiantamento_decimo_salario)){
	  	echo moedaUsaToBr($sql_demissao->adiantamento_decimo_salario);
	  	$TotalDeducoes += $sql_demissao->adiantamento_decimo_salario;
	  }
	  /*if(!empty($AdiantamentoDecimo)){
		$TotalDeducoes += $AdiantamentoDecimo;
		echo moedaUsaToBr($AdiantamentoDecimo);  
	  } else{
		echo " - ";
	  }*/
	  
	?></span> </div></td>
  </tr>
  <tr>
    <td class="xl144">
    	<span class="font-mini" style="height:24.0pt;width:181pt">103 Aviso-Prévio Indenizado</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
		$TotalDeducoes += $sql_demissao->aviso_previo_indenizado_2;
		echo moedaUsaToBr($sql_demissao->aviso_previo_indenizado_2);  
	   
	?></span></div></td>
    <td class="xl144">
    	<span class="font-mini" style="border-left:none;width:149pt">104 Indenização Art. 480/CLT</span></td>
    <td>&nbsp;</td>
    <td class="xl144">
    	<span class="font-mini" style="border-top:none;width:116pt">105 Empréstimo
  em Consignação</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	  if(!empty($sql_demissao->emprestimo_consignacao)){
		  echo moedaUsaToBr($sql_demissao->emprestimo_consignacao);
		  $TotalDeducoes += $sql_demissao->emprestimo_consignacao;
	  }
	  
	  /*if(!empty($EmprestimoConsignado)){
		$TotalDeducoes += $EmprestimoConsignado;
		echo moedaUsaToBr($EmprestimoConsignado);  
	  } else{
		echo " - ";  
	  }*/
	?></span></div></td>
    
  </tr>
  <tr>
    <td class="xl144">
    	<span class="font-mini" style="height:15.0pt;width:181pt">112.1 Previdência Social</span></td>
    <td align="center">
    <div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> 
    <span style="float:right">
    <? 
		if(!empty($sql_demissao->previdencia_social)){
			echo $sql_demissao->previdencia_social;
			$TotalDeducoes += $sql_demissao->previdencia_social;
		}		
		/*$PrevidenciaSocial = (($TotalVerbasRescisorias - $DecimoTerceiroProporcional) * 8)/100;
		if(!empty($PrevidenciaSocial)){
			$TotalDeducoes += $PrevidenciaSocial;
			echo moedaUsaToBr($PrevidenciaSocial);	
		}*/
	?>
   <!-- 44,23-->
    </span></div></td>
    <td>
    	<span class="font-mini" style="border-left:none;width:149pt">112.2 Previdência Social &#8211; 13º Salário</span></td>
    <td align="center"><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left">R$</span> 
    <span style="float:right">
	<?
    	if(!empty($sql_demissao->previdencia_social_decimo)){
			echo moedaUsaToBr($sql_demissao->previdencia_social_decimo);
			$TotalDeducoes += $sql_demissao->previdencia_social_decimo; 
		}
		/*$PrevidenciaSocialDecimo =  ($DecimoTerceiroProporcional*8)/100;
		if(!empty($PrevidenciaSocialDecimo)){
			$TotalDeducoes += $PrevidenciaSocialDecimo;
			echo moedaUsaToBr($PrevidenciaSocialDecimo);	
		}*/
	?><!--20,73--></span></div></td>
    <td class="xl144">
    	<span class="font-mini" style="border-top:none;width:116pt">114.1 IRRF</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
	<? 
	 
	 
	 if(!empty($sql_demissao->irrf)){
		 echo moedaUsaToBr($sql_demissao->irrf);
		 $TotalDeducoes += $sql_demissao->irrf; 
	 }
	 /* CALCULO */
	 //echo "alicota: ".$IRPF->percentual_aliquota." ".$IRPF->valor_deducao;
	/*$IRPF = ((($TotalVerbasRescisorias-$DecimoTerceiroProporcional)*$IRPF->percentual_aliquota)/100)-$IRPF->valor_deducao;
	if(!empty($IRPF)){
		$TotalDeducoes += $IRPF;
		echo moedaUsaToBr($IRPF);	
	} else{
		echo "-";	
	}*/
	?></span></div></td>
   
  </tr>
  <tr>
    <td class="xl144">
    	<span class="font-mini" style="height:15.0pt;width:181pt">114.2 IRRF sobre 13º Salário</span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
    <? 
	
	if(!empty($sql_demissao->irrf_sobre_decimo)){
		echo moedaUsaToBr($sql_demissao->irrf_sobre_decimo);
		$TotalDeducoes += $sql_demissao->irrf_sobre_decimo;
	}
	
	/* CALCULO */
	/*$IRPFDecimo = (($DecimoTerceiroProporcional*$IRPF->percentual_aliquota)/100 )-$IRPF->valor_deducao;
	if(!empty($IRPFDecimo)){
		$TotalDeducoes += $IRPFDecimo;
		echo moedaUsaToBr($IRPFDecimo);	
	} else{
		echo "-";	
	}*/
	?>
    </span></div></td>
    <td class="xl144">
    	<span class="font-mini" style="border-left:none;width:149pt">114.3 &#8211; IRRF sobre Participação nos
  Lucros<span style="mso-spacerun:yes">&nbsp;</span></span></td>
    <td>&nbsp;</td>
    <td class="xl144">
    	<span class="font-mini" style="width:116pt">115 &#8211; Outros Descontos<span style="mso-spacerun:yes">&nbsp;</span></span></td>
    <td><div class="negrito font-mini" style="padding-left:6px; padding-right:6px;"><span style="float:left;">R$</span> <span style="float:right">
    <? 
		
		if(!empty($sql_demissao->outro_desconto)){
			echo moedaUsaToBr($sql_demissao->outro_desconto); 
			$TotalDeducoes += $sql_demissao->outro_desconto;
	    }
		//echo moedaUsaToBr($OutrosDescontos);
		//$TotalDeducoes += $OutrosDescontos;
	?>
    </span></div></td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    	<span class="font-mini" style="border-top:none;width:116pt">TOTAL DAS<br/>
  DEDUÇÕES</span></td>
    <td  align="center"><div class="negrito">R$ <?=moedaUsaToBr($TotalDeducoes)?></div></td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    	<span class="font-mini" style="border-top:none;width:116pt">VALOR
  RESCISÓRIO LÍQUIDO</span></td>
    <td align="center">
    <div class="negrito">R$ 
    <?
	$ValorRescisorioLiquido = ($TotalVerbasRescisorias - $TotalDeducoes);
	echo moedaUsaToBr($ValorRescisorioLiquido);
	?>
    </div></td>
   
  </tr>
  </table>
  <!-- -->
  <table width="100%" style='border-collapse:collapse; position:relative;' class="table">
  <tr>
    <td colspan="12" class="xl108 font-size-title" >FORMALIZAÇÃO DA RESCISÃO</td>
  </tr>
  <tr>
    <td class="xl144" style="width:360px;"><span class="font-mini" style="height:15.0pt;">150 Local e data do recebimento</span></td>
    <td class="xl144" ><div><span class="font-mini">151 Carimbo e assinatura do empregador ou preposto</span></div><div class="negrito" style="margin-top:10px;"> &nbsp;</div></td>
  </tr>
  <tr>
    <td><div><span class="font-mini">152 Assinatura do trabalhador</span></div><div class="negrito" style="margin-top:10px;">&nbsp;</div></td>
    <td class="xl144" ><span class="font-mini">153 Assinatura do responsável legal do trabalhador</span></td>
  </tr>
  
  </table>
  <table width="100%" style='border-collapse:collapse; position:relative; ' class="table">
  <tr>
    <td style="width:360px;" class="xl144" >
    <div><span class="font-mini"> 154 HOMOLOGAÇÃO</span></div>
    <div><span style="font-size:8pt;" >Foi prestada, gratuitamente,
  assistência ao trabalhador, nos termos do art. 477, § 1º, da Consolidação das
  Leis do Trabalho&#8211;CLT, sendo comprovado, neste ato, o efetivo pagamento
  das verbas rescisórias acima especificadas.</span></div>
  <div style="margin-top:10px;"></div></td>
    <td class="xl144" rowspan="3"><span class="font-mini" >155 Digital do Trabalhador</span></td>
    <td class="xl144" rowspan="3"><span class="font-mini">156 Digital do responsável legal</span></td>
  </tr>
 

  <tr>
    <td class="xl144"><div><span class="font-mini">Local e data</span></div><div class="negrito" style="margin-top:8px;">&nbsp;</div></td>  
  </tr>
   </table>
 <table width="100%" style='border-collapse:collapse; position:relative;'>
  <tr>
    <td style="width:360px;"  class="xl144"><span class="font-mini" style="height:15.0pt;width:332pt">Carimbo e assinatura do assistente</span></td>   
    
    <td class="xl144" rowspan="2"><div><span class="font-mini" style="width:441pt">158 Recepção pelo Banco (data e carimbo)</span></div><div class="negrito">&nbsp;</div></td>
  </tr>
  <tr>
    <td >
    <div><span class="font-mini" style="height:30.0pt;width:332pt">157
  Identificação do órgão homologador</span></div><div style="margin-top:28px;"></div></td>
  </tr>
  
  <!-- -->
  <tr>
    <td colspan="12" class="xl108 font-size-title"  >
    <div>A ASSISTÊNCIA NO ATO DA RESCISÃO CONTRATUAL É GRATUITA.</div>
    <div style="text-align:left; font-size:8.2pt;"><span  style=" font-weight:100;">Pode o trabalhador iniciar ação judicial quanto
  aos créditos resultantes das relações de trabalho até o limite de dois anos
  após a extinção do contrato de trabalho (Inc. XXIX, Art, 7º da Constituição
  Federal/1988).</span></div>
    </td>
    
  </tr>
</table>
</div>
<div style="margin-top:100px; clear:both;"></div>
</body>
</html>