<?php
class FolhadePagamento{
	
	var $inss;
	var $irpf;
	var $fgts;
	var $salario_familia;
	var $data_inicio_folha;
	var $data_fim_folha;
	var $base_fgts;
	var $base_inss;
	var $base_dsr;
	var $base_irrf;

	function dsr($mes,$ano){
		global $vkt_id;
		//$mes=$mes+1;
		if($mes<10){
			$mes='0'.$mes;
		}
		$FeriadosAvisoPrevio = mysql_query($t=" SELECT * FROM rh_feriado WHERE vkt_id = $vkt_id AND mes = '".($mes)."' ");
		$QtdFeriadosAvisoPrevio = mysql_num_rows($FeriadosAvisoPrevio);
		
		$qtd_dias_mes_aviso_previo = cal_days_in_month(CAL_GREGORIAN,$mes,$ano); /*: Quantidade de dias do MES do Aviso Previo:*/
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
	
	function periodo_folha_pagamento($dados){
		
		$mes = $dados['mes']+1;
		$ano = $dados['ano'];
		
		if($mes<10){
			$mes = "0".$mes;
		}
		
		$folha_configuracao = mysql_fetch_object(mysql_query($t="
			SELECT 
				rpc.* 
			FROM 
				rh_folha_ponto_configuracao rpc,
				rh_empresas rh_e,
				cliente_fornecedor cf
			WHERE
				rpc.empresa_id            =rh_e.id AND
				rh_e.cliente_fornecedor_id=cf.id AND
				cf.id='$dados[empresa_id]'
			"));//echo $t."<br>";
		$dia_abertura = $folha_configuracao->dia_abertura;
		$this->data_inicio_folha = $dia_abertura."/".$mes."/".$ano;
		
		if($dia_abertura==1){
				$adicao_data=" AND DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)";
				$this->data_fim_folha=mysql_result(mysql_query("SELECT DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)"),0);
							
		}elseif($dia_abertura>1){
				$adicao_data=" AND DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)";
				$this->data_fim_folha=mysql_result(mysql_query("SELECT DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)"),0);
		}
		$this->data_fim_folha = DataUsaToBr($this->data_fim_folha);				
				
	}
	
	function parcelas_venda($funcionario_id){
		$parcelas_venda = mysql_result(mysql_query($t="
			SELECT 
				SUM(valor_parcela) as total
			FROM
				rh_venda_funcionario rh_v,
				rh_venda_funcionario_parcela rh_fp
			WHERE
				rh_fp.venda_id = rh_v.id AND
				rh_v.funcionario_id='$funcionario_id' AND
				date_format(rh_fp.data_vencimento,'%Y-%m') = '".substr(DataBrToUsa($this->data_inicio_folha),0,7)."' 
			"),0,0);
			//echo $t."<br>";		
		return $parcelas_venda;
	}
	
	function parcelasVendaDescricao($funcionario_id){
		$vendas_ativas = mysql_query($t="
			SELECT 
				rh_v.*,rh_fp.valor_parcela as valor
			FROM
				rh_venda_funcionario rh_v,
				rh_venda_funcionario_parcela rh_fp
			WHERE
				rh_fp.venda_id = rh_v.id AND
				rh_v.funcionario_id='$funcionario_id' AND
				date_format(rh_fp.data_vencimento,'%Y-%m') = '".substr(DataBrToUsa($this->data_inicio_folha),0,7)."' 
				group by rh_fp.venda_id
			");
		$d = array();
		//	pr($t); echo "(($this->data_inicio_folha))".mysql_error();
		while($r= mysql_fetch_object($vendas_ativas)){
			$qtd_patcelas =  @mysql_result(mysql_query("SELECT count(*) FROM rh_venda_funcionario_parcela WHERE venda_id='$r->id' "),0,0);
			$qtd_patcelas_pagas =  @mysql_result(mysql_query("SELECT count(*) FROM rh_venda_funcionario_parcela WHERE venda_id='$r->id' AND date_format(data_vencimento,'%Y-%m') < '".substr(DataBrToUsa($this->data_inicio_folha),0,7)."' "),0,0)+1;

			$d[] = " $r->descricao $qtd_patcelas_pagas/$qtd_patcelas R$ $r->valor de R$ $r->valor_total";
		}	
		

		return $d;
	}
	
	function qtd_faltas($funcionario_id){
		/*$qtd_faltas = mysql_result(mysql_query($t="
			SELECT 
				SUM(falta_integral) as total
			FROM
				rh_hora_extra rh_e
			WHERE
				rh_e.funcionario_id = '$funcionario_id' AND
				rh_e.data BETWEEN '".DataBrToUsa($this->data_inicio_folha)."' AND '".DataBrToUsa($this->data_fim_folha)."' 
			"),0,0);*/
		//echo $t."<br>";	
		$faltas = mysql_query($t="
				SELECT 
					data, DATE_FORMAT( data, '%U' ) as semana
				FROM
					rh_hora_extra rh_e
				WHERE
					rh_e.funcionario_id = '$funcionario_id' AND
					rh_e.falta_integral='1' AND
					rh_e.data BETWEEN '".DataBrToUsa($this->data_inicio_folha)."' AND '".DataBrToUsa($this->data_fim_folha)."' ORDER BY data");
		
		
		$semanas_faltas=array();
		$numero_faltas =0;
		while($falta = mysql_fetch_object($faltas)){
			
			$semanas_faltas[$falta->semana] = $falta->semana;
			$numero_faltas++;
		}
		
		
		$qtd_faltas = (@count($semanas_faltas))+$numero_faltas;
		
		return $qtd_faltas;
		
	}
	
	function total_hora_extra_50($funcionario_id, $salario){
		global $vkt_id;
		
		$total_horas_50 = mysql_result(mysql_query($t="SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( hora_extra50 ) ) ) AS total_horas50 FROM 
		rh_hora_extra WHERE funcionario_id='$funcionario_id' AND data BETWEEN '".DataBrToUsa($this->data_inicio_folha)."' AND '".DataBrToUsa($this->data_fim_folha)."'"),0,0);
		
		//echo $t." ".$total_horas_50."<br>";
		
		$qtd_horas_decimal_50 = explode(":",$total_horas_50);
	  	$qtd_horas_decimal_50 = ($qtd_horas_decimal_50[0])+($qtd_horas_decimal_50[1]/60);
	  	$valor_reais_50 = round((($salario/220)*2)*$qtd_horas_decimal_50,2);
		
		return array("horas"=>$total_horas_50,"valor"=>$valor_reais_50);
	}
	
	function total_hora_extra_100($funcionario_id, $salario){
		global $vkt_id;
		
		$total_horas_100 = mysql_result(mysql_query($t="SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( hora_extra_100 ) ) ) AS total_horas_100 FROM 
		rh_hora_extra WHERE funcionario_id='$funcionario_id' AND data BETWEEN '".DataBrToUsa($this->data_inicio_folha)."' AND '".DataBrToUsa($this->data_fim_folha)."'"),0,0);
		
		$qtd_horas_decimal_100 = explode(":",$total_horas_100);
	  	$qtd_horas_decimal_100 = ($qtd_horas_decimal_100[0])+($qtd_horas_decimal_100[1]/60);
	  	$valor_reais_100 = round((($salario/220)*2)*$qtd_horas_decimal_100,2);
		
		return array("horas"=>$total_horas_100,"valor"=>$valor_reais_100);
		
	}
	
	function total_hora_noturna($funcionario_id, $salario){
		global $vkt_id;
		
		$total_horas_not = mysql_result(mysql_query($t="SELECT SUM(adicional_noturno) AS total_noturno FROM 
		rh_hora_extra WHERE funcionario_id='$funcionario_id' AND data BETWEEN '".DataBrToUsa($this->data_inicio_folha)."' AND '".DataBrToUsa($this->data_fim_folha)."'"),0,0);
				
		$horas_adicional_noturno = (int)($total_horas_not/60/60);
		if($horas_adicional_noturno<10){
			$horas_adicional_noturno = "0".$horas_adicional_noturno;
		}
		$minutos_adicional_noturno = ($total_horas_not/60%60);
		if($minutos_adicional_noturno<10){
			$minutos_adicional_noturno = "0".$minutos_adicional_noturno;
		}
		$adicional_noturno = $horas_adicional_noturno.":".$minutos_adicional_noturno;
		$qtd_horas_decimal_noturna = explode(":",$adicional_noturno);
		$qtd_horas_decimal_noturna = ($qtd_horas_decimal_noturna[0])+($qtd_horas_decimal_noturna[1]/60);
		
	  	$valor_hora_noturna  = (($salario/220)*0.2)+(($salario/220)*0.2);
		$valor_reais_noturna = round($valor_hora_noturna*$qtd_horas_decimal_noturna,2);
		
		//echo $qtd_horas_decimal_noturna." ".$adicional_noturno." ".$valor_hora_noturna." ".$valor_reais_noturna;exit();
		return array("horas"=>$adicional_noturno,"valor"=>$valor_reais_noturna);
		
	}
	
	function criafolha($dados){
		global $vkt_id;
		global $usuario_id;
		
		$sql=mysql_query("INSERT INTO rh_folha SET vkt_id='".$vkt_id."', 
		empresa_id='".$dados['empresa_id']."', mes='".$dados['mes']."', ano='".$dados['ano']."', status='em aberto', ultima_alteracao=NOW(), ultima_alteracao_login_id='".$usuario_id."' ");
		//echo mysql_error();
		
		$id = mysql_insert_id();
		
		$this->periodo_folha_pagamento($dados);
				
		return $id;
	}	
	
	function FuncionariosEmpresa($empresa_id,$funcionario_id){
		global $vkt_id;
		
		if($empresa_id>0){
			$filtro = " AND empresa_id='$empresa_id'";
		}
		
		if($funcionario_id>0){
			$filtro = " AND id='$funcionario_id'";
		}
		
		$funcionarios = mysql_query($t="SELECT * FROM 
					  	rh_funcionario
					  WHERE 
					  	status != 'demitidos' AND
						vkt_id='$vkt_id'
						$filtro");
						//echo $t."<br><br>";
	   
		$f=array();
		$c=0;
		while($funcionario=mysql_fetch_object($funcionarios)){
			$f[$c]=$funcionario;
			$c++;
		}
		return $f;
	}
	
	function adicionaFuncionariosFolha($folha_id, $funcionarios){
		global $vkt_id;
		
		foreach($funcionarios as $funcionario){
			$faltas=0;$adiantamento=0;
			$adiantamento+=$this->parcelas_venda($funcionario->id);
		
			if($adiantamento>0){
				$this->insereEventosFuncionarios($folha_id,$funcionario->id,'Adiantamento','obrigatorio','desconto',
												'sim',0,$adiantamento,$adiantamento,0,0,0,
												0,0);
			}
			
			$faltas+=$this->qtd_faltas($funcionario->id);
			
			if($faltas>0){
				$valor_faltas = $funcionario->salario/30*$faltas;
		
				$this->insereEventosFuncionarios($folha_id,$funcionario->id,'Faltas','obrigatorio','desconto',
												'sim',0,$faltas,$valor_faltas,0,0,0,
												0,0,0,0,'1');
			}
			
			$horas_50  = $this->total_hora_extra_50($funcionario->id, $funcionario->salario);
			
			
			//foreach($funcionarios as $funcionario){
		$this->insereEventosFuncionarios($folha_id,$funcionario_id->id,'Horas Extras 50%','obrigatorio','vencimento',
												'sim',0,$horas_50['horas'],$horas_50['horas'],1,1,1,
												0,0);
			
			$horas_100 = $this->total_hora_extra_100($funcionario->id, $funcionario->salario);
			
			//print_r($horas_100);
			
			$this->insereEventosFuncionarios($folha_id,$funcionario->id,'Horas Extras 100%','obrigatorio','vencimento',
												'sim',0,$horas_100['horas'],$horas_100['valor'],1,1,1,
												0,0);
			
			$horas_not = $this->total_hora_noturna($funcionario->id, $funcionario->salario);
			
			//print_r($horas_100);
			
			$this->insereEventosFuncionarios($folha_id,$funcionario->id,'Horas Noturnas','obrigatorio','vencimento',
												'sim',0,$horas_not['horas'],$horas_not['valor'],1,1,1,
												0,0);
			
			mysql_query($t="INSERT INTO 
							rh_folha_funcionario 
						SET 
							vkt_id='$vkt_id', 
							folha_id='$folha_id', 
							funcionario_id='".$funcionario->id."', 
							salario_base='".$funcionario->salario."',
							horas_trabalhadas='220:00:00',
							falta='$faltas',
							hora_50  = '".$horas_50['horas']."',
							hora_100 = '".$horas_100['horas']."',
							hora_noturno='".$horas_not['horas']."',
							adiantamento='$adiantamento'
			");
			
			//pr($horas_50);
			//pr($horas_100);
			//echo $t."<br>";
			//exit();
			
		}
	}
	
	
	function EventosObrigatorios($dados){
		
		$mes = $dados['mes']+1;
		$ano = $dados['ano'];
		
		mysql_query($t="DELETE FROM rh_folha_funcionarios_eventos WHERE tipo='obrigatorio' AND funcionario_id='$dados[funcionario_id]' AND folha_id='$dados[folha_id]'");
		$valor_faltas = $dados['salario']/30*$dados['faltas'];

		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'Faltas','obrigatorio','desconto',
												'sim',0,$dados['faltas'],$valor_faltas,0,0,0,0,0,0,0,'1');
		
		$hora_50 = $dados['horas_extras_horas_50'];
		$qtd_horas_decimal_50 = explode(":",$dados['horas_extras_horas_50']);
	  	$qtd_horas_decimal_50 = ($qtd_horas_decimal_50[0])+($qtd_horas_decimal_50[1]/60);
	  	$valor_reais_50 = round((($dados['salario']/220)*1.5)*$qtd_horas_decimal_50,2);
		
		//foreach($funcionarios as $funcionario){
		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'Horas Extras 50%','obrigatorio','vencimento',
												'sim',0,$hora_50,$valor_reais_50,1,1,1,
												0,0);
		
		$hora_100 = $dados['horas_extras_horas_100'];
		$qtd_horas_decimal_100 = explode(":",$dados['horas_extras_horas_100']);
	  	$qtd_horas_decimal_100 = ($qtd_horas_decimal_100[0])+($qtd_horas_decimal_100[1]/60);
	  	$valor_reais_100 = round((($dados['salario']/220)*2)*$qtd_horas_decimal_100,2);
		
		//foreach($funcionarios as $funcionario){
		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'Horas Extras 100%','obrigatorio','vencimento',
												'sim',0,$hora_100,$valor_reais_100,1,1,1,
												0,0);
		
		$hora_noturna = $dados['horas_trabalhadas_noite'];
		$qtd_horas_decimal_noturna = explode(":",$dados['horas_trabalhadas_noite']);
	  	$qtd_horas_decimal_noturna = ($qtd_horas_decimal_noturna[0])+($qtd_horas_decimal_noturna[1]/60);
	  	$valor_hora_noturna  = (($dados['salario']/220)*0.2)+(($dados['salario']/220)*0.2);
		$valor_reais_noturna = round($valor_hora_noturna*$qtd_horas_decimal_noturna,2);
		
		//foreach($funcionarios as $funcionario){
		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'Horas Noturnas','obrigatorio','vencimento',
												'sim',0,$hora_noturna,$valor_reais_noturna,1,1,1,
												0,0);
		
		$comissao = moedaBrToUsa($dados['comissao']);
		
		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'Comissão','obrigatorio','vencimento',
												'sim',0,$comissao,$comissao,1,1,1,
												0,0);
												
		$gratificacao = moedaBrToUsa($dados['gratificacao']);
		
		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'Gratificação','obrigatorio','vencimento',
												'sim',0,$gratificacao,$gratificacao,1,1,1,
												1,0);
		
		
		$adiantamento = moedaBrToUsa($dados['deducao_adiantamento']);
		$adiantamento+=$this->parcelas_venda($dados['funcionario_id']);
		
		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'Adiantamento','obrigatorio','desconto',
												'sim',0,$adiantamento,$adiantamento,0,0,0,
												0,0);
		
		
		/*** cálculo de dias úteis e dia de descanso ***/
		
		$uteis_descanso=$this->dsr($mes,$ano);
print_r($uteis_descanso);
		/*** cálculo do DSR ***/
		
		$dsr=($valor_reais_50+$valor_reais_100+$valor_reais_noturna)/$uteis_descanso['DiasUteis']*$uteis_descanso['DiasDescanso'];
		//echo "DSR: ($valor_reais_50+$valor_reais_100+$valor_reais_noturna)/$uteis_descanso[DiasUteis]*$uteis_descanso[DiasDescanso] <br>";
		/*** cálculo do DSR sobre comissão ***/
		$dsr_comissao=(moedaBrToUsa($dados['comissao']))/$uteis_descanso['DiasUteis']*$uteis_descanso['DiasDescanso'];	
		//echo "DSR: (moedaBrToUsa($dados[comissao]))/$uteis_descanso[DiasUteis]*$uteis_descanso[DiasDescanso] <br>";											
																							
		$dsr_total = $dsr + $dsr_comissao;
				
		$this->insereEventosFuncionarios($dados['folha_id'],$dados['funcionario_id'],'DSR','obrigatorio','vencimento',
												'sim',1,$dsr_total,$dsr_total,1,1,0,
												0,0);
		
		mysql_query($t="UPDATE rh_folha_funcionario SET obs='$dados[obs]',horas_trabalhadas='$dados[horas_trabalhadas]', hora_50='".$hora_50."', hora_100='".$hora_100."', hora_noturno='".$hora_noturna."', comissao=$comissao, gratificacao='$gratificacao', falta=$dados[faltas], adiantamento=$adiantamento
					WHERE folha_id='$dados[folha_id]' AND funcionario_id='$dados[funcionario_id]'");								
		
		//}
	}
	
	function selecionaEventosAdicionaisFuncionarios($folha_id, $funcionarios){
		global $vkt_id;
		
		foreach($funcionarios as $funcionario){

			mysql_query($t="DELETE FROM rh_folha_funcionarios_eventos WHERE tipo='adicional' AND funcionario_id='$funcionario->id' AND folha_id='$folha_id'");
			$eventos_funcionario =  mysql_query($t="SELECT * FROM rh_eventos WHERE vkt_id='$vkt_id' AND 
			((funcionario_id='$funcionario->id')
			OR
				cargo_id='$funcionario->cargo_id'
			)
			OR
			(
			empresa_id='$funcionario->empresa_id'
			OR
			(empresa_id='0' AND cargo_id='0' AND funcionario_id='0')
			)
			
			");
		
			while($evento_funcionario=mysql_fetch_object($eventos_funcionario)){
				
				
				$referencia = $evento_funcionario->valor;
				//$valor_real = $evento_funcionario->valor;
				
				/* 
					Flefson, vc tinha colocado $evento_funcionario->tipo no lugar de $evento_funcionario->forma_valor e me fudeu por bastante tempo.  
					e ainda tinha colocado $evento_funcionario->tipo=='percentual' no lugar de  "0" ou "1" 
					0=valor fixo
					1=porcentual
				*/
				if($evento_funcionario->forma_valor=='1'){
					$valor_real = $funcionario->salario*$evento_funcionario->valor/100;				
				}
				if($evento_funcionario->forma_valor=='0'){
					$valor_real = $evento_funcionario->valor;				
				}
				if($evento_funcionario->vencimento_ou_desconto=='vencimento'){
					$inss = '1';
					$fgts = '1';
					$irrf = '0';				
				}
				/* Descontar algum valor do mesmo evento que ficou pendente da ultima folha de pagamento */
				$desconto_mes_anterior = mf(mq("
				SELECT 
					id, saldo_devedor 
				FROM 
					rh_folha_funcionarios_eventos 
				WHERE 
					evento_id='$evento_funcionario->id' 
				AND 
					funcionario_id='$funcionario->id' 
				ORDER BY id DESC LIMIT 1"));
				$premio=$valor_real;
				if($desconto_mes_anterior->id>0){
					$premio=$valor_real-$desconto_mes_anterior->saldo_devedor;
				}
				
				
				$this->insereEventosFuncionarios(
					$folha_id,
					$funcionario->id,
					$evento_funcionario->nome,
					'adicional',
					$evento_funcionario->vencimento_ou_desconto,
					$evento_funcionario->tributado,
					$evento_funcionario->id,
					$referencia,
					$valor_real,
					$inss,
					$fgts,
					0,
					$irrf,
					0,
					$premio);
			}
		}
	
	}
	
	function selecionaLicencasFuncionarios($folha_id,$funcionarios){
		global $vkt_id;
		
		$folha=mysql_fetch_object(mysql_query($a="SELECT ano,mes FROM rh_folha WHERE id=$folha_id"));
		
		foreach($funcionarios as $funcionario){
			$licencas_funcionario =  mysql_query($t=
			"SELECT 
				*,
				(SELECT DATEDIFF(data_fim,data_inicio) FROM rh_licencas_funcionarios WHERE id=lf.id) as qtd_dias,
				MONTH(data_inicio) as mes_inicio,
				MONTH(data_fim)    as mes_fim
			FROM 
				rh_licencas_funcionarios lf,
				rh_licencas l
			WHERE 
				l.vkt_id='$vkt_id' AND
				l.id=lf.licenca_id AND 
				lf.funcionario_id='$funcionario->id' AND
				(MONTH(data_inicio)=NOW() OR MONTH(data_fim)=NOW())				
				");
				
			while($licenca_funcionario=mysql_fetch_object($licencas_funcionario)){
				
				//if()
				
				if($licenca_funcionario->remunerado='nao'){
					$vencimento_ou_desconto='desconto';
					$tributado             ='sim';
				}
				
				$valor_real = $funcionario->salario/30*$licenca_funcionario->qtd_dias;
				
				$this->insereEventosFuncionarios($folha_id,$funcionario->id,$licenca_funcionario->nome,$licenca_funcionario->tipo,$vencimento_ou_desconto,
											$tributado,$licenca_funcionario->id,$licenca_funcionario->qtd_dias,$valor_real,0,0,0,
											0,0);
			}
		}
	
	}
	
	function EventosCondicionaisFuncionarios($folha_id,$funcionarios){
		
		global $vkt_id;
		//print_r($funcionarios);
		foreach($funcionarios as $funcionario){
		//---------------IRRF----------------------------------------
		
			mysql_query($t="DELETE FROM rh_folha_funcionarios_eventos WHERE tipo='condicional' AND funcionario_id='$funcionario->id' AND folha_id='$folha_id'");
			
			$irrf = mysql_fetch_object(mysql_query($t="SELECT percentual_aliquota,(('".$this->base_irrf[$funcionario->id]."'-valor_deducao)*(percentual_aliquota/100)) as irrf FROM rh_irpf 
			WHERE '".$this->base_irrf[$funcionario->id]."' BETWEEN valor_minimo AND valor_maximo"));
		//	echo $t;
	//		echo $t." ".mysql_error()." ";
			$this->insereEventosFuncionarios($folha_id,$funcionario->id,'IRRF','condicional','desconto',
											'sim',0,$irrf->percentual_aliquota,$irrf->irrf,0,0,0,
											0,0); 		
			
	// innss 
		$this->calcula_inss($this->base_inss[$funcionario->id],$folha_id,$funcionario);
			
///// Salário  Familia
			//mes da folha de pagamento
			$ano_mes_folha=mysql_fetch_object(mysql_query($a="SELECT ano,mes FROM rh_folha WHERE id=$folha_id"));
			//echo $a."<br>";
			$filhos_q=mysql_result(mysql_query($a="SELECT COUNT(*) FROM rh_funcionario_dependentes WHERE funcionario_id='".$funcionario->id."' AND CAST( (TO_DAYS('$ano_mes_folha->ano"."-".$ano_mes_folha->mes."-"."01') - TO_DAYS(data_nascimento)) as SIGNED) < 5114 "),0,0);
			//echo $a."<br>";
			$salario_familia = @mysql_fetch_object(mysql_query($t="SELECT (valor_beneficio*$filhos_q) as salario_familia FROM rh_salario_familia WHERE ".$this->base_inss[$funcionario->id]." BETWEEN valor_minimo AND valor_maximo"));
			//echo $t."<br>";
			$this->insereEventosFuncionarios($folha_id,$funcionario->id,'Salário Família','condicional','vencimento',
											'sim',0,$filhos_q,$salario_familia->salario_familia,0,0,0,
											0,1);
											
			mysql_query($t="UPDATE rh_folha_funcionario SET total_inss='".$inss->inss."', irrf='$irrf->irrf'
					WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id'");	
					
		}
	}
	
	function insereEventosFuncionarios(
		$folha_id, 
		$funcionario_id, 
		$nome_evento,
		$tipo,
		$vencimento_ou_desconto,
		$tributado,
		$evento_id=0,
		$referencia,
		$valor_real,
		$inss=0,
		$fgts=0,
		$dsr=0,
		$irrf=0,
		$salario_familia=0,
		$premio=0,/* Acrescentei esse campo flefson */
		$desconto_mes_anterior=0,
		$valor_falta=0
		){
		global $vkt_id;
		
		
		
		
		/* acrescentei o parametro premio e desconto_mes_anterior*/
		mysql_query($t="INSERT INTO 
							rh_folha_funcionarios_eventos 
						SET 
							vkt_id                ='$vkt_id', 
							folha_id              ='$folha_id', 
							funcionario_id        ='".$funcionario_id."', 
							nome                  ='".$nome_evento."',
							tipo                  ='".$tipo."',        
							vencimento_ou_desconto='".$vencimento_ou_desconto."',
							tributaveis           ='".$tributado."',
							evento_id             ='".$evento_id."',
							referencia            ='".$referencia."',
							valor_real            ='".$valor_real."',
							premio				  ='".$valor_real."', 
							inss                  ='".$inss."',
							fgts                  ='".$fgts."',
							dsr                   ='".$dsr."',
							irrf                  ='".$irrf."',
							valor_falta			 ='".$valor_falta."',
							salario_familia       ='".$salario_familia."',						
							desconto_mes_anterior ='".$desconto_mes_anterior."' 
			");//echo $t."<br>";
			
				
	}
	
	function totais($folha_id,$funcionarios){
		
		foreach($funcionarios as $funcionario){
			
			$valor_faltas = mysql_result(mysql_query($t="SELECT SUM(valor_real) FROM rh_folha_funcionarios_eventos WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id' AND valor_falta='1'"),0,0);			

			$rh_funcionario_folha = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_folha_funcionario WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id'"));
			
			$total_desconto = mysql_result(mysql_query($t="SELECT SUM(valor_real) FROM rh_folha_funcionarios_eventos WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id' AND vencimento_ou_desconto='desconto' AND tributaveis='sim'"),0,0);
			//echo $t." ".$total_desconto."<br>";
			$total_adicional= mysql_result(mysql_query($t="SELECT SUM(valor_real) FROM rh_folha_funcionarios_eventos WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id' AND vencimento_ou_desconto='vencimento' AND tributaveis='sim'"),0,0);
			//echo $t." ".$total_adicional."<br>";
			$base_fgts      = mysql_result(mysql_query($t="SELECT SUM(valor_real) FROM rh_folha_funcionarios_eventos WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id' AND fgts='1' AND tributaveis='sim' AND vencimento_ou_desconto='vencimento' "),0,0)-$valor_faltas;
			$base_fgts     += $funcionario->salario;
			$this->base_fgts[$funcionario->id] = $base_fgts;
			$base_inss      = mysql_result(mysql_query($t="SELECT SUM(valor_real) FROM rh_folha_funcionarios_eventos WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id' AND inss='1' AND tributaveis='sim' AND vencimento_ou_desconto = 'vencimento'"),0,0)-$valor_faltas;
			$base_inss     += $funcionario->salario;
			$this->base_inss[$funcionario->id] = $base_inss;
		
			$valor_inss = $this->calcula_inss($this->base_inss[$funcionario->id],$folha_id,$funcionario);

			$this->base_dsr[$funcionario->id]      = mysql_result(mysql_query($t="SELECT SUM(valor_real) FROM rh_folha_funcionarios_eventos WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id' AND dsr='1' AND tributaveis='sim' AND vencimento_ou_desconto = 'vencimento'"),0,0);

						//echo $this->base_dsr[$funcionario->id];
			//echo $t."<br>";
			$this->base_irrf[$funcionario->id]     = $base_fgts-$valor_inss;

			$salario_liquido= $funcionario->salario-$total_desconto+$total_adicional;				
		
			mysql_query($t="UPDATE rh_folha_funcionario SET total_desconto='$total_desconto', total_adicional='$total_adicional', base_fgts='".$this->base_fgts[$funcionario->id]."',total_fgts=(".$this->base_fgts[$funcionario->id]."*0.08), 
			base_inss='".$this->base_inss[$funcionario->id]."',	base_irrf='".$this->base_irrf[$funcionario->id]."', salario_liquido='$salario_liquido' WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id'");
			//echo mysql_error();
			
		}		
	}
	
	function calcula_inss($base_inss,$folha_id,$funcionario){
/// calcula inss para calcular base de INSS

			$valor_beneficio = @mysql_fetch_object(mysql_query($t="SELECT valor_beneficio,valor_maximo FROM rh_inss WHERE $base_inss BETWEEN valor_minimo AND valor_maximo OR ($base_inss>valor_maximo) ORDER BY valor_beneficio DESC LIMIT 1"));
			if($base_inss>$valor_beneficio->valor_maximo){
				$base_inss = $valor_beneficio->valor_maximo;
				$this->base_inss[$funcionario->id]=$base_inss;
				
			}
			$valor_inss = $base_inss*($valor_beneficio->valor_beneficio/100);

			$this->insereEventosFuncionarios($folha_id,$funcionario->id,'INSS','condicional','desconto',
											'sim',0,$valor_beneficio->valor_beneficio,$valor_inss,0,0,0,
											1,0);
			return $valor_inss;

	}

	function CalculaDescontoCompartilhado($dados){
		$funcionarios = explode('|',$dados['funcionarios']);
		$funcionarios = array_filter($funcionarios);
		$f1=pr($funcionarios);
		$f='';
		$qtd_funcionario_evento=0;
		$valor_total = moedaBrToUsa($dados['valor_total']);
		$funcionario_paga_evento=array();
		$c=0;
		foreach($funcionarios as $funcionario){
			if($funcionario>0){
				
			  $funcionario_tem_evento = mysql_fetch_object(mysql_query(
				  $t="SELECT 
					  rh_fe.*
				  FROM 
					  rh_funcionario rh_f,
					  rh_eventos rh_e,
					  rh_folha_funcionarios_eventos rh_fe
				  WHERE
					  rh_fe.evento_id=rh_e.id AND
					   rh_e.regra_desconto='grupo' AND
					  rh_fe.funcionario_id='$funcionario' AND
					  rh_fe.folha_id='$dados[folha_id]'	
					  LIMIT 1	 
				"			  	
			  ));
			 $f1.=" $t \n";
			 if($funcionario_tem_evento->id>0){
				$funcionario_paga_evento[$c]=$funcionario_tem_evento;
				//$funcionario_paga_evento[$c]['valor_real']=$funcionario_tem_evento->valor_real;
			   	$qtd_funcionario_evento++;
				$c++;
			  }
			  			
			}
		}
		
		$desconto_grupo_funcionario = $valor_total/$qtd_funcionario_evento;
		
		mysql_query("UPDATE rh_folha_funcionarios_eventos SET saldo_devedor=valor_real-desconto+desconto_faltas, desconto_grupo='0', premio='0' WHERE folha_id='".$dados['folha_id']."'
		AND (valor_real-(desconto+desconto_faltas+desconto_grupo)) < 0;");
		
		$erro = mysql_error();
		
		foreach($funcionario_paga_evento as $fp){
			//$novo_valor    = $fp['valor_real'] - $desconto_grupo_funcionario;
			$saldo_devedor = $fp->valor_real-($fp->desconto + $fp->desconto_faltas + $desconto_grupo_funcionario); 
			if($saldo_devedor<0){
				$saldo_devedor*=-1;
				$fim_sql=", saldo_devedor='".$saldo_devedor."'";
			}
			mysql_query($t="UPDATE rh_folha_funcionarios_eventos SET desconto_grupo='$desconto_grupo_funcionario' $fim_sql WHERE id='".$fp->id."'");
			$f1.=$t."\n";
		}
						
		return $f1;
	}
}

function atualizaEventoFuncionario($dados){
	mysql_query($a="
	UPDATE 
		rh_folha_funcionarios_eventos
	SET 
		valor_real='{$dados['premio']}',
		desconto='{$dados['desconto']}',
		desconto_faltas='{$dados['desconto_faltas']}',
		desconto_grupo='{$dados['desconto_compartilhado']}',
		desconto_mes_anterior='{$dados['desconto_mes_anterior']}',
		saldo_devedor='{$dados['saldo_devedor']}'
	WHERE
		id='{$dados['evento_funcionario_id']}'
		")	;
		//echo $a;
}

function confirmarFolha($folha_id){
	global $vkt_id;
	mysql_query($b="UPDATE rh_folha SET status='fechada' WHERE id='$folha_id' ");
}

function excluirFolha($folha_id,$empresa_id){
	global $vkt_id;
	mysql_query($a="DELETE FROM rh_folha_funcionarios_eventos WHERE vkt_id='$vkt_id' AND folha_id='$folha_id' ");
	//echo $a."<br>";
	mysql_query($b="DELETE FROM rh_folha_funcionario WHERE folha_id='$folha_id' ");
	//echo $b."<br>";
	mysql_query($b="DELETE FROM rh_folha WHERE id='$folha_id'");
	//echo $b."<br>";
}