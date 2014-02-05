<?php

	include('_config.php');
	$vkt_id='16';
	$c=1;
	$empresa = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));
	$conta_bradesco = mysql_fetch_object(mysql_query($t="SELECT * FROM financeiro_contas WHERE cliente_vekttor_id='$vkt_id' AND codigo_banco='237'"));
	
	$forma_pagamento = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id' AND nome='Boleto'"));
	
	$movimentacoes = mysql_query($t="SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND forma_pagamento='$forma_pagamento->id'");
	
	$identificacao_registro = "0";//tamanho 1 - tipo numérico
		$identificacao_servico  = "1";//tamanho 1 - tipo numérico
		$literal_remessa        = "REMESSA";//tamanho 1 - tipo alfanumérico
		$codigo_servico         = "01";
		$literal_servico        = str_pad("COBRANCA",15," ",STR_PAD_RIGHT);
		$codigo_empresa         = str_pad("01",20,"0",STR_PAD_RIGHT);
		$nome_empresa           = str_pad("$empresa->nome",30," ",STR_PAD_RIGHT);
		$numero_bradesco_camara = "237";
		$nome_banco             = str_pad("BRADESCO",15," ",STR_PAD_RIGHT);
		$data_arquivo           = date("dmy");
		$branco                 = str_pad(" ",8," ",STR_PAD_RIGHT);
		$identificacao_sistema  = "MX";
		$numero_sequencial_registro = str_pad($c,6,"0",STR_PAD_RIGHT);
		$c++;
		$infob[]=$identificacao_registro.$identificacao_servico.$literal_remessa.$codigo_servico.$literal_servico.$codigo_empresa.$nome_empresa.$numero_bradesco_camara.$nome_banco.$data_arquivo.$branco.$identificacao_sistema.$numero_sequencial_registro."\n";
	
	
	
	
	while($movimentacao=mysql_fetch_object($movimentacoes)){
		//Lay-out do Arquivo-Remessa - Registro de Transação - Tipo 1
		//Lay-out para Cobrança com Registro e sem Registro com Emissão de Papeleta pelo
		//Banco e pela Empresa
		
		//Identificação do registro - tamanho 1 - tipo numérico - conteudo = 1
		$infob[]=$identificacao_registro = "1";
		
		// Agência de Débito - tamanho 5 - tipo numérico
		$infob[]=$agencia_debito         = "00000";
		
		//Dígito da Agência de Débito
		$infob[]=$agencia_debito_digito  = "0";		 
		 
		$infob[]=$razao_conta_corrente   = "00000";
		
		$infob[]=$conta_corrente         = "0000000";
		
		$infob[]=$conta_corrente_digito  = "0";
		
		
		$codigo_carteira        = $conta_bradesco->_carteira;
		
		$codigo_agencia         = $conta_bradesco->agencia;
		$conta_corrente         = $conta_bradesco->conta.$conta_bradesco->digito;
		//
		$codigo_agencia_digito  = $conta_bradesco->agencia_digito;
		//
		$infob[]=$identificacao_empresa_cedente_banco = str_pad("0".$codigo_carteira.$codigo_agencia.$conta_corrente.$codigo_agencia_digito,17,"0",STR_PAD_LEFT);
		
		$infob[]=$numero_controle_participante        = str_pad(" ",25," ",STR_PAD_RIGHT);
		
		$infob[]=$codigo_banco_a_ser_debitado         = "237";
		
		$infob[]=$zeros                  = str_pad("0",5,"0",STR_PAD_RIGHT);
		
		//$identificacao_titulo_banco = "";
		$infob[]=$conferencia_nosso_numero = str_pad($movimentacao->id,11,0,STR_PAD_LEFT);	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
			
		//$conferencia_nosso_numero = "1900000000006";
		//$carteira = "19";
		$total=0;
		$tam_conferencia_nosso_numero = strlen($conferencia_nosso_numero);
		$array_fatores = array(2,7,6,5,4,3,2,7,6,5,4,3,2);
		for($i=0;$i<=$tam_conferencia_nosso_numero;$i++){
			$total+=$conferencia_nosso_numero[$i]*$array_fatores[$i];
		}
		
		$digito=(int)$total%11;
		
		if($digito==1){			
			$infob[]=$digito_auto_conferencia_nosso_numero="P";
		}elseif($digito==0){		
			$infob[]=$digito_auto_conferencia_nosso_numero=0;			
		}else{		
			$infob[]=$digito_auto_conferencia_nosso_numero=11-$digito;
		}
		
		$infob[]=$desconto_bonificacao_por_dia = str_pad("0",10,"0",STR_PAD_LEFT);
		
		$infob[]=$condicao_emissao_papeleta_cobranca = "2";
		
		$infob[]=$emite_papeleta_debito_automatico   = "N";
		
		$infob[]=$identificacao_operacao_banco       = str_pad(" ",10," ",STR_PAD_RIGHT);
		
		$infob[]=$indicador_rateio_credito           = " ";
		
		$infob[]=$enderecamento_debito_automatico    = "0";//1,2 ou diferente de 1 e 2
		
		$infob[]=$branco = "  ";
		
		//01..Remessa
		//02..Pedido de baixa
		//04..Concessão de abatimento
		//05..Cancelamento de abatimento concedido
		//06..Alteração de vencimento
		//07..Alteração do controle do participante
		//08..Alteração de seu número
		//09..Pedido de protesto
		//18..Sustar protesto e baixar Título
		//19..Sustar protesto e manter em carteira
		//31..Alteração de outros dados
		//35..Desagendamento do débito automático
		//68..Acerto nos dados do rateio de Crédito
		//69..Cancelamento do rateio de crédito. 		
		$infob[]=$identificacao_ocorrencia           = "01";
		
		if(empty($movimentacao->doc)){
			$infob[]=$numero_documento		= str_pad($movimentacao->id,10,0,STR_PAD_LEFT);	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
		}else{
			$infob[]=$numero_documento		= str_pad($movimentacao->doc,10,0,STR_PAD_LEFT);
		}
		
		$infob[]=$data_vencimento_titulo  = substr($movimentacao->data_vencimento,8).substr($movimentacao->data_vencimento,5,2).substr($movimentacao->data_vencimento,2,2);
				 
		$infob[]=$valor_titulo                       = str_pad(str_replace(".","",$movimentacao->valor_cadastro),13,"0",STR_PAD_LEFT);
				
		$infob[]=$banco_encarregado_cobranca         = "000";
		
		$infob[]=$agencia_depositaria                = "00000";
		
		$infob[]=$especie_titulo                     = "99";
		
		$infob[]=$identificacao                      = "A";
		
		$infob[]=$data_emissao_titulo                = substr($movimentacao->data_registro,8,2).substr($movimentacao->data_registro,5,2).substr($movimentacao->data_registro,2,2);
		
		$infob[]=$primeira_instruncao                = "08";
		
		$infob[]=$segunda_instruncao                 = "09";
		
		$infob[]=$valor_ser_cobrado_dia_atraso       = str_pad("0",13,"0",STR_PAD_RIGHT);
		
		$data_limite_concessao_desconto     = mysql_result(mysql_query($t="SELECT DATE_ADD('$movimentacao->data_registro', INTERVAL 30 DAY) as data_limite"),0,0);
		$infob[]=$data_limite_concessao_desconto     = str_pad(substr($data_limite_concessao_desconto,8,2).substr($data_limite_concessao_desconto,5,2).substr($data_limite_concessao_desconto,2,2),6,0,STR_PAD_LEFT);
				
		$infob[]=$valor_desconto                     = str_pad("0",13,"0",STR_PAD_RIGHT);
		
		$infob[]=$valor_iof                          = str_pad("0",13,"0",STR_PAD_RIGHT);
		
		$infob[]=$valor_abatimento                   = str_pad("0",13,"0",STR_PAD_RIGHT);
		
		$sacado = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$movimentacao->internauta_id'"));
		
		if($sacado->tipo_cadastro=="Jurídico"){
			$infob[]=$identificacao_tipo_inscricao   = "02";					
		}else{
			$infob[]=$identificacao_tipo_inscricao   = "01";
		}
		
		$numero_inscricao_sacado            = str_replace(".","",$sacado->cnpj_cpf);
		$numero_inscricao_sacado            = str_replace("-","",$numero_inscricao_sacado);
		$numero_inscricao_sacado            = str_replace("/","",$numero_inscricao_sacado);
		$infob[]=$numero_inscricao_sacado            = str_pad($numero_inscricao_sacado,14,"0",STR_PAD_RIGHT);
		
		$infob[]=$nome_sacado                        = str_pad(substr($sacado->razao_social,0,40),40," ",STR_PAD_RIGHT);
		
		$infob[]=$endereco_completo                  = str_pad(substr($sacado->endereco." ".$sacado->casa_numero.", ".$sacado->bairro."-".$sacado->cidade."/".$sacado->estado,0,40),40," ",STR_PAD_RIGHT);
		
		$infob[]=$primeira_mensagem                  = str_pad(" ",12," ",STR_PAD_RIGHT);
		
		$infob[]=$cep                                = str_pad(substr($sacado->cep,0,5),5,0,STR_PAD_RIGHT);
		
		$infob[]=$sufixo_cep                         = str_pad(substr($sacado->cep,6,3),3,0,STR_PAD_RIGHT);
		
		$infob[]=$sacador_avalista_segunda_mensagem  = str_pad(" ",60," ",STR_PAD_RIGHT);
		
		$infob[]=$numero_sequencial_registro         = str_pad($c,6,"0",STR_PAD_LEFT)."\n";
		$c++;
		//echo $infob[]"<br>";
	}
	
	if(sizeof($infob)>0){
		foreach($infob as $b){
			$info[] = $b;
		}
	
	
		$infos = implode("",$info);
		$infos = strtoupper($infos);
	
   		$file = "arquivo_caged.re";
		@unlink("$file");
		$handle = fopen($file, 'a');
		fwrite($handle,$infos);
		fclose($handle);

		$i =date("Ymdhis");
	
		header('Content-type: octet/stream');
    	header('Content-disposition: attachment; filename="'.basename($file).'";');
    	header('Content-Length: '.filesize($file));
    	readfile($file);
	
	//echo "<script>location='$file?$i'";
		exit();
	}
?>