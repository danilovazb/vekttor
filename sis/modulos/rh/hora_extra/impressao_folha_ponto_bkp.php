<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	global $vkt_id;
	//id do funcionario
	
	$mes        = $_GET['mes']+1;
	if($mes<10){$mes='0'.$mes;}	
	$ano        = $_GET['ano'];
	$empresa_id = $_GET['empresa_id'];
	$dias_semana = array("domingo", "segunda", "terça", "quarta", "quinta", "sexta", "sabado");
	$cliente_fornecedor = mysql_fetch_object(mysql_query($t=
		"SELECT 
			* 
		FROM
			cliente_fornecedor
		WHERE 
		id='$empresa_id'"));
	$empresa1=mysql_fetch_object(mysql_query("SELECT * FROM rh_empresas WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$empresa_id' LIMIT 1"));
	$configuracao=mysql_fetch_object(mysql_query("SELECT * FROM rh_folha_ponto_configuracao WHERE vkt_id='$vkt_id' AND empresa_id='$empresa1->id' LIMIT 1"));
	$dia_abertura=$configuracao->dia_abertura;
	if($dia_abertura<10){$dia_abertura='0'.$dia_abertura;}
?>

<style>
body{ }
.container{ margin:0 auto; width:960px; background:#FFF;}
table{ border-collapse:collapse; border:1px solid #666; }
.table-none-border-bottom{ border-bottom:none;}
.table-none-border-top{ border-top:none;} 
table tr td{ border:1px dotted #000;font-family:Arial, Helvetica, sans-serif; font-size:11pt;}
table tr th{ font-family:Arial, Helvetica, sans-serif; font-size:11pt; background:#F5F5F5; padding:3px;}
table th.sub-titulo{border-left:1px dotted #000;}
td p{ font-size:10pt; font-family:Arial, Helvetica, sans-serif; padding:3px;}
.text-right{ text-align:right;}
.text-left{ text-align:left;}
.text-center{ text-align:center;}
.text-mini{ font-size:8pt; }
.text-small{ font-size:10pt;}
.text-normal{ font-size:12pt;}

.td1-mini{ width:25px;}
.td1-small{ width:55px;}
.td1{ width:76px;}
.td1-large{ width:95px;}

.td2-small{ width:128px;}
.td2{ width:160px;}
.td3{ width:276px;}
.td4{ width:340px;}
.offset1{ padding-left:15px;}
.offset2{ padding-left:30px; }
.offset3{ padding-left:45px;}
.offset1-right{ padding-right:12px;}

.titulo1{ font-weight:bold; font-size:16px; font-family:Arial, Helvetica, sans-serif;}
.titulo2{ font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif;}
</style>
<?php
	//while empresas
	//while($cliente = mysql_fetch_object($cliente_fornecedor)){
		 
		$funcionarios = mysql_query("SELECT * FROM rh_funcionario WHERE empresa_id = '$cliente_fornecedor->id' AND vkt_id='$vkt_id' AND status='admitidos' ORDER BY nome");
		
		if(!mysql_num_rows($funcionarios)>0){
			echo "Não Há Funcionários Nesta Empresa";
		}else{
		
		while($funcionario = mysql_fetch_object($funcionarios)){
			
			$adiantamento = mysql_fetch_object(mysql_query(
				$t="SELECT * FROM
					rh_folha_funcionarios rhff,
					rh_folha_empresa rhfe
				WHERE
					rhff.rh_folha_id = rhfe.id AND
					rhfe.mes = '$mes' AND
					rhfe.ano = '$ano' AND
					rhff.funcionario_id = '$funcionario->id'"
			));
			
			$cont_hora_extra=0;$cont_adicional_noturno=0;
			$salario_atual = mysql_fetch_object(mysql_query("SELECT * FROM rh_alteracao_salario WHERE funcionario_id='$funcionario->id' ORDER BY id DESC LIMIT 1"));
			$salario_atual = $salario_atual->salario;
			$valor_hora = $salario_atual/220;
			$valor_hora_extra_50 =  $valor_hora * 1.5;
			$valor_hora_extra_100 = $valor_hora_extra_50;
			$valor_hora_adicional_noturno = $valor_hora+($valor_hora*0.3);
			if(!$salario_atual>0){
				$salario_atual = $funcionario->salario;
			}
				
?>
	<div class="container">
		<table width="100%" class="table-none-border-bottom">
        	<tr>
            	<td class="td3 text-center" rowspan="2"><img src="../../vekttor/clientes/img/<?=$vkt_id?>.png"></td>
                <td class="td4 text-center titulo1" colspan="2"> FOLHA DE PONTO  </td>
            </tr>
            
            <tr>
            	<td class="text-center" colspan="2"> <p class="text-mini"> <?=$cliente_fornecedor->razao_social?> <br/> CNPJ: <?=$cliente_fornecedor->cnpj_cpf?> <br/> <?=$cliente_fornecedor->endereco?> - 
				<?=$cliente_fornecedor->bairro?>  _ CEP: <?=$cliente_fornecedor->cep?> - <?=$cliente_fornecedor->cidade?> - <?=strtoupper($cliente_fornecedor->cidade)?>  </p> </td>
            </tr>
            <tr>
            	<td class="text-right text-mini offset1-right">NOME DO COLABORADOR:</td>
                <td class="text-center titulo2" colspan="2"><?=$funcionario->nome?></td>
            </tr>
            
            <tr>
            	<td class="text-right text-mini offset1-right">FUNÇÃO:</td>
                <td class="td3 text-center"> <?=$funcionario->cargo?> </td>
                <td class="text-left offset2 text-mini"> INTERVALO: <?=$funcionario->duracao_intervalo?> </td>
            </tr>
            
             <tr>
            	<td class="text-right text-mini offset1-right">
                	<?php
						$dias_no_mes = cal_days_in_month(CAL_GREGORIAN,$mes,$ano);
						
						$ultimo_dia_mes_configuracao=$configuracao->dia_abertura-1;
												
						if($ultimo_dia_mes_configuracao>$dias_no_mes){
							$ultimo_dia_mes=$dias_no_mes;
						}else{
							$ultimo_dia_mes=$ultimo_dia_mes_configuracao;
						}
						//echo $ultimo_dia_mes."<br>";
						if($dia_abertura==1){
							//$adicao_data=" AND DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)";
							//$ultima_data_fechamento=mysql_result(mysql_query("SELECT DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)"),0);
							$ultima_data_fechamento=$ano."-".$mes."-".date("t");
							$ultimo_dia_mes = date("t");
						}elseif($dia_abertura>1){
							$adicao_data=" AND DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)";
							$ultima_data_fechamento=mysql_result(mysql_query("SELECT DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)"),0);
						}
									 	
					?>
                	PERÍODO:
				</td>
                <td><?="$dia_abertura/".$mes."/".$_GET['ano']." à ".dataUsaToBr($ultima_data_fechamento);?></td>
                <td class="text-left offset2 text-mini"> JORNADA: <?=$funcionario->hora_inicio_expediente?> às <?=$funcionario->hora_fim_expediente?></td>
            </tr>
            
        </table>
        
        <table width="100%" class="table-none-border-top">
        	<tr>
            	<th class="text-small sub-titulo" colspan="3" >DATA</th>
                <th class="text-small sub-titulo td2-small">ENTRADA</th>
                <th class="text-small sub-titulo" colspan="2">INTERVALO</th>
                <th class="text-small sub-titulo td1">SAÍDA</th>
                <th class="text-small sub-titulo td1">TOTAL</th>
                <th class="text-small sub-titulo">ASSINATURA</th>
            </tr>
            
            <?php 
			
			//foreach( $dias_semana as $key => $value){
				
				
				
				
				$horas_extras = mysql_query($a="SELECT * FROM rh_hora_extra WHERE funcionario_id = '$funcionario->id' and vkt_id='$vkt_id' AND data BETWEEN '$ano-$mes-$dia_abertura' AND '$ultima_data_fechamento' ORDER BY data ASC");
				$qtd_horas_extras = mysql_num_rows($horas_extras);
				//alert($a);
				if($qtd_horas_extras>0){
				//verifica se o saldo é maior que zero
				//e se a hora extra é de 50 ou cem 100%  
					while($hora_extra = mysql_fetch_object($horas_extras)){
					/* verifica se o funcionário está em férias no período selecionado */
					  $ferias = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_ferias WHERE funcionario_id = '$funcionario->id' AND $hora_extra->data BETWEEN data_inicio AND data_fim "));
					  if($ferias->id>0){
						$emferias = "X";
					  }
					  $diadasemana = mysql_fetch_object(mysql_query($t="SELECT DAYOFWEEK('$hora_extra->data') as dia_semana"));
					  $diadasemanaextenso = $semana_extenso[$diadasemana->dia_semana-1];
					  $diadasemana = $semana_abreviado[$diadasemana->dia_semana-1];
					  
					 					  
					  $total_hora1 = mysql_fetch_object(mysql_query($t="SELECT TIMEDIFF('$hora_extra->hora_saida_almoco','$hora_extra->hora_entrada') as total"));						 
					  
					  if($hora_extra->hora_saida<$hora_extra->hora_retorno_almoco){
						$total_tarde = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('24:00:00','$hora_extra->hora_retorno_almoco') as total"));
						$total_hora2 = mysql_fetch_object(mysql_query($t="SELECT ADDTIME('$total_tarde->total','$hora_extra->hora_saida') as total"));
						
					  }else{
					  	$total_hora2 = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('$hora_extra->hora_saida','$hora_extra->hora_retorno_almoco') as total"));						 
					  }
					  
					  if($total_hora2->total < 0){
	
						$total_hora2->total*=(-1);
	
					  }
					  
					  $hora_total = mysql_fetch_object(mysql_query($t="SELECT ADDTIME('$total_hora1->total','$total_hora2->total') as total"));
					  
					   
					  
					  if($hora_extra->saldo_horas>0&&$hora_extra->hora_extra_100=='0'){
						 
						 $porcentagem_extra = 1.5;
						   
					  }else if($hora_extra->saldo_horas>0&&$hora_extra->hora_extra_100=='1'){
					  
						  $porcentagem_extra = 1;
					  
					  }
					
					 
					  
					  			 	
					 					  
					  if($porcentagem_extra>0){
					  	$valor_hora_extra_dia = $valor_hora*$hora_extra->saldo_horas*$porcentagem_extra;
						$valor_hora_extra_total+=$valor_hora_extra_dia;
						$qtd_hora_extra = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('$hora_total->total','08:00') as total"));
						$hora_extra_funcionario[$cont_hora_extra]['data'] = $hora_extra->data;
						$hora_extra_funcionario[$cont_hora_extra]['inicio'] = $funcionario->hora_fim_expediente;
						$hora_extra_funcionario[$cont_hora_extra]['fim'] = $hora_extra->hora_saida;
						$hora_extra_funcionario[$cont_hora_extra]['total'] = $qtd_hora_extra->total; 
						$hora_extra_funcionario[$cont_hora_extra]['dia_semana'] =$diadasemanaextenso;
						$hora_extra_funcionario[$cont_hora_extra]['porcentagem'] =$hora_extra->hora_extra_100;
						
					  	$cont_hora_extra++;
					  }
					  
					  if($hora_extra->adicional_noturno>0){
					  	$valor_adicional_noturno = ($valor_hora_extra_dia)+($valor_hora_extra_dia*0.3);
						$valor_total_adicional_notuno+=$valor_adicional_noturno;
						if($hora_extra->hora_saida>22&&$hora_extra->hora_saida<24){
							$qtd_adicional_noturno = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('$hora_extra->hora_saida','22:00') as total"));
						}else if($hora_extra->hora_saida>0&&$hora_extra->hora_saida<=5){
							$qtd_adicional_noturno = mysql_fetch_object(mysql_query("SELECT ADDTIME('$hora_extra->hora_saida','2:00') as total"));
						}
						
						$adicional_noturno_funcionario[$cont_adicional_noturno]['data'] = $hora_extra->data;
						$adicional_noturno_funcionario[$cont_adicional_noturno]['inicio'] = "22:00";
						$adicional_noturno_funcionario[$cont_adicional_noturno]['fim'] = $hora_extra->hora_saida;
						$adicional_noturno_funcionario[$cont_adicional_noturno]['qtd'] = $qtd_adicional_noturno->total;
						$adicional_noturno_funcionario[$cont_adicional_noturno]['valor'] = $valor_adicional_noturno;
						
						$cont_adicional_noturno++;					  
					  }
					  
					  $h=0;
					  
					  if(strtotime($hora_extra->data)>strtotime($_GET['ano']."-$mes-".$dia_abertura)&&$h==0){
					  	
						$inicio = $dia_abertura;
						$fim=cal_days_in_month(CAL_GREGORIAN,$mes,$ano);
						if($inicio==1){
							$fim=substr($hora_extra->data,8,2)-1;
						}
																		
						for($i=$inicio;$i<=$fim;$i++){
							
							$dia=$i;
							if($i<10&&$i!=$dia_abertura){
								$dia="0".$dia;
							}
							$diadasemana2 = mysql_fetch_object(mysql_query($t="SELECT DAYOFWEEK('$ano-$mes-$dia') as dia_semana"));
					  		$diadasemanaextenso2 = $semana_extenso[$diadasemana2->dia_semana-1];
					  		$diadasemana2 = $semana_abreviado[$diadasemana2->dia_semana-1];
						
			?>
            			<tr>
            				<td class="text-mini td1-mini"></td>
                			<td class="text-mini text-center td1-small" ><?php if($ferias->id>0){ echo "Em Férias";}else{ echo $dia."/".$mes_abreviado[$mes-1];}?></td>
                			<td class="text-mini td1-small text-center" ><?=$diadasemana2?></td>
                
                			<td class="text-small text-center"></td>
                
                			<td class="text-small text-center td1-large"></td>
                			<td class="text-small text-center td1-large"></td>
                
                			<td class="text-small text-center"></td>
                			<td class="text-small text-center"></td>
                			<td class="text-small text-center"></td>
            			</tr>
            <?php
					 		if($i==cal_days_in_month(CAL_GREGORIAN,$mes,$ano)){
							
								$i=0;
								$mes++;
								$fim=substr($hora_extra->data,8,2)-1;								
							}
						}
						$h++;
					 }
			?>
            <tr>
            	<td class="text-mini td1-mini"></td>
                <td class="text-mini text-center td1-small" ><?php if($ferias->id>0){ echo "Em Férias";}else{ echo substr($hora_extra->data,8,2)."/".$mes_abreviado[substr($hora_extra->data,5,2)-1];}?></td>
                <td class="text-mini td1-small text-center" ><?=$diadasemana?></td>
                
                <td class="text-small text-center"><?=substr($hora_extra->hora_entrada,0,5)?></td>
                
                <td class="text-small text-center td1-large"><?=substr($hora_extra->hora_saida_almoco,0,5)?></td>
                <td class="text-small text-center td1-large"><?=substr($hora_extra->hora_retorno_almoco,0,5)?></td>
                
                <td class="text-small text-center"><?=substr($hora_extra->hora_saida,0,5)?></td>
                <td class="text-small text-center"><?=substr($hora_total->total,0,5)?></td>
                <td class="text-small text-center"><?php if($hora_extra->falta_integral=='1'){ echo "FALTA";}else if($hora_extra->falta_justificada=='1'){echo "FALTA JUSTIFICADA";}?></td>
            </tr>
            <?php
						$ultima_data = substr($hora_extra->data,8,2);
						
						$ultima_data_completa=$hora_extra->data;
					}//while hora_extra
				$dias_a_mais=mysql_result(mysql_query($x="SELECT DATEDIFF('$ultima_data_fechamento','$ultima_data_completa')"),0);
				
				//echo "U: $ultima_data | $ultimo_dia_mes | $ultima_data_fechamento | $mes";				
				//if($ultima_data<$ultimo_dia_mes){
											 
					for($i=1;$i<=$dias_a_mais;$i++){
						
						$dia=$i;
						if($i<10){
				 			$dia='0'.$dia;
				 		}
						//$mes = $_GET['mes'];
						$data=mysql_result(mysql_query("SELECT DATE_ADD('$ultima_data_completa', INTERVAL $i DAY)"),0);
						$dia_atual=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$ultima_data_completa', INTERVAL $i DAY),'%d')"),0);
						$mes_atual=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$ultima_data_completa', INTERVAL $i DAY),'%m')"),0);
					 	//$data = $_GET['ano']."-".$mes."-".$dia;
					 	$diadasemana = mysql_fetch_object(mysql_query($t="SELECT DAYOFWEEK('$data') as dia_semana"));
						
					 	$diadasemana = $semana_abreviado[$diadasemana->dia_semana-1];
			?>
             <tr>
            	<td class="text-mini td1-mini"></td>
                <td class="text-mini text-center td1-small" ><?=$dia_atual."/".$mes_abreviado[$mes_atual-1]?> </td>
                <td class="text-mini td1-small text-center" ><?=$diadasemana?></td>
                
                <td class="text-small text-center"></td>
                
                <td class="text-small text-center td1-large"></td>
                <td class="text-small text-center td1-large"></td>
                
                <td class="text-small text-center"></td>
                <td class="text-small text-center"></td>
                <td class="text-small text-center"></td>
            </tr>	
            <?php
					}
				//}
				}else{
					$dias_a_mais=mysql_result(mysql_query($o="SELECT DATEDIFF('$ultima_data_fechamento','$ano-$mes-$dia_abertura')"),0);
					//alert($o);
					 for($i=0;$i<=$dias_a_mais;$i++){
						 //$mes = $_GET['mes'];
						$data=mysql_result(mysql_query("SELECT DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL $i DAY)"),0);
						$dia_atual=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL $i DAY),'%d')"),0);
						$mes_atual=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL $i DAY),'%m')"),0);
					 	//$data = $_GET['ano']."-".$mes."-".$dia;
					 	$diadasemana = mysql_fetch_object(mysql_query($t="SELECT DAYOFWEEK('$data') as dia_semana"));
						
					 	$diadasemana = $semana_abreviado[$diadasemana->dia_semana-1];
						 
				 		$dia=$i;
				 		if($i<10){
				 			$dia='0'.$dia;
				 		}
						//$mes = $_GET['mes'];
						/*if($_GET['mes']<10){
				 			$mes='0'.$_GET['mes'];
				 		}*/
						
						 //$data = $_GET['ano']."-".$mes."-".$dia;
						 $diadasemana = mysql_fetch_object(mysql_query($t="SELECT DAYOFWEEK('$data') as dia_semana"));
					 
						 $diadasemana = $semana_abreviado[$diadasemana->dia_semana-1];
			?>
            <tr>
            	<td class="text-mini td1-mini"></td>
                <td class="text-mini text-center td1-small" ><?=$dia_atual."/".$mes_abreviado[$mes_atual-1]?></td>
                <td class="text-mini td1-small text-center" ><?=$diadasemana?></td>
                
                <td class="text-small text-center"><?=$emferias?>&nbsp;</td>
                
                <td class="text-small text-center td1-large"><?=$emferias?>&nbsp;</td>
                <td class="text-small text-center td1-large"><?=$emferias?>&nbsp;</td>
                
                <td class="text-small text-center"><?=$emferias?>&nbsp;</td>
                <td class="text-small text-center"><?=$emferias?>&nbsp;</td>
                <td class="text-small text-center"><?=$emferias?></td>
            </tr>
            	<?php
					 }//for
				?>
        </table>
       	<br><br>
	   <?php 
	   		
	   }//else ?>
</div>
<?php
	if(!$qtd_horas_extras>0){
?>
<div style="page-break-after:always"></div>

<?php
	}
		if(mysql_num_rows($horas_extras)>0){
			
			include('impressao_hora_extra.php');
			echo "<div style=\"page-break-after:always\"></div>";
			include('impressao_adicional_noturno.php');
			include('impressao_hora_domingo.php');
			include('impressao_recibo.php');
			echo "<div style=\"page-break-after:always\"></div>";
		}
	}
	
	}
?>
