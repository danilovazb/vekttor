<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	global $vkt_id;
	//id do funcionario
	
	$mes        = $_GET['mes'];
	//if($mes<10){$mes='0'.$mes;}	
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
	
	$qtd_dias_folha = mysql_fetch_object(mysql_query($t="
		SELECT DATEDIFF((SELECT ADDDATE('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)),'$ano-$mes-$dia_abertura') as qtd_dias"));
	//echo mysql_error()." ".$t." ".$qtd_dias_folha->qtd_dias;exit();
	
	if($dia_abertura<10){$dia_abertura='0'.$dia_abertura;}
	
?>

<style>
body{ }
.container{ margin:0 auto; width:960px; background:#FFF;}
table{ border-collapse:collapse; border:1px solid #666; }
#tbs{ border:0}
#tbs tr td{ border:0}
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

.td1-mini{ width:25px; height:30px;}
.td1-small{ width:55px;}
.td1{ width:76px;}
.td1-large{ width:80px;}

.td2-small{ width:80px;}
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
		if($_GET['funcionario_id']>0){
			$filtro = " AND id='".$_GET['funcionario_id']."'";
		}
		 
		$funcionarios = mysql_query("SELECT * FROM rh_funcionario WHERE empresa_id = '$cliente_fornecedor->id' AND vkt_id='$vkt_id' AND status='admitidos' $filtro ORDER BY nome");
		
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
            	<td class="text-right text-mini offset1-right" style="height:35px; line-height:35px">NOME DO COLABORADOR:</td>
                <td class="text-center titulo2" colspan="2"><?=$funcionario->nome?></td>
            </tr>
            
            <tr>
            	<td class="text-right text-mini offset1-right" style="height:35px; line-height:35px">FUNÇÃO:</td>
                <td class="td3 text-center"> <?=$funcionario->cargo?> </td>
                <td class="text-left offset2 text-mini"> INTERVALO: <?=substr($funcionario->duracao_intervalo,0,5);?> </td>
            </tr>
            
             <tr>
            	<td class="text-right text-mini offset1-right" style="height:35px; line-height:35px">
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
                <td class="text-left offset2 text-mini"> JORNADA: 
				<?=substr($funcionario->hora_inicio_expediente,0,5);?> 
                às 
				<?=substr($funcionario->hora_fim_expediente,0,5)?></td>
            </tr>
            
        </table>
        
        <table width="100%" class="table-none-border-top">
        	<tr>
            	<th width="0" rowspan="2" class="text-small sub-titulo"  >DATA</th>
                <th width="0" rowspan="2" class="text-small sub-titulo td2-small">HORA  <br>
                ENTRADA</th>
                <th class="text-small sub-titulo" colspan="2">INTERVALO</th>
                <th width="0" rowspan="2" class="text-small sub-titulo td1">HORA<br>
                SAÍDA</th>
                <th colspan="2" class="text-small sub-titulo ">EXTRA EXTRA </th>
                <th width="0" rowspan="2" class="text-small sub-titulo td1">TOTAL</th>
                <th width="0" rowspan="2" class="text-small sub-titulo">ASSINATURA</th>
            </tr>
  <tr>
                <td width="0" class="text-small text-center td1-large"><strong>ENTRADA</strong></td>
                <td width="0" class="text-small text-center td1-large"><strong>SAIDA</strong></td>
                <td width="0" class="text-small text-center"><strong>ENTRADA</strong></td>
                <td width="0" class="text-small text-center"><strong><span class="text-small sub-titulo ">SA&Iacute;DA</span></strong></td>
              </tr>            <?php 
			
			$data = "$configuracao->dia_abertura/$mes/$ano";
			$dia_abertura = $configuracao->dia_abertura;
			$mes2=$mes;
			$ano2=$ano;
			for($i=1;$i<$qtd_dias_folha->qtd_dias+1;$i++){
				

			$refday = $i-1;
			$data_exibicao = mysql_result(mysql_query($t="
				SELECT ADDDATE('$ano-$mes-$dia_abertura', INTERVAL $refday DAY)"),0,0);

				 $diadasemana = mysql_fetch_object(mysql_query($t="SELECT DAYOFWEEK('$data_dia') as dia_semana"));
				 $diadasemanaextenso = $semana_extenso[$diadasemana->dia_semana-1];
				 $diadasemana = $semana_abreviado[$diadasemana->dia_semana-1];
				
				
				 
				  //verifica se o funcion;ario está de férias naquela dada
				 $ferias = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_ferias WHERE funcionario_id = '$funcionario->id' AND '$data_exibicao' BETWEEN data_inicio AND data_fim"));
			
			     $hora_extra = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_hora_extra WHERE funcionario_id = '$funcionario->id' AND data='$data_exibicao'"));
				 
				 		  
				 
				 if(($hora_extra->fatal_integral!=1)&&($hora_extra->falta_justificada!=1)&&!empty($hora_extra->hora_entrada)&&($hora_extra->hora_entrada!="00:00:00")){
				 	 $hora_saida         = substr($funcionario->hora_fim_expediente,0,5);
					 
					 
					 $hora_extra_entrada = substr($funcionario->hora_fim_expediente,0,5);
					 $hora_extra_saida   = substr($hora_extra->hora_saida,0,5);
					
					
					
				 	 //$hora_saida= substr($hora_saida,0,5);
				 	if($hora_extra_entrada=="00:00"){
				 		$hora_saida=$hora_extra_saida;
				 	}
				 
				 	if($hora_saida=="00:00"){
				 		$hora_saida=$hora_extra_saida;
				 	}
					
					if(strtotime($hora_extra_saida)<=strtotime("20:00:00")){ 
						$hora_saida=$hora_extra_saida;
						$hora_extra_entrada=$hora_extra_saida="00:00";
					}
					
				 }else{
				 	$hora_saida=$hora_extra_entrada=$hora_extra_saida='';
					$hora_extra->hora_retorno_almoco=$hora_extra->hora_saida_almoco=$hora_extra->hora_entrada='';
				 }
				 
				 $total_em_horas = $hora_extra->total*60*60;
				 $total_em_horas = mysql_fetch_object(mysql_query("SELECT SEC_TO_TIME($total_em_horas) as total_horas"));
				 $licenca = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_licencas_funcionarios WHERE funcionario_id = '$funcionario->id' AND '$data_exibicao' BETWEEN data_inicio AND data_fim"));
				$msg='';
				
				if($ferias->id>0){$msg = "FÉRIAS";}else if($hora_extra->falta_integral=='1'){ $msg = "FALTA";}else if($hora_extra->falta_justificada=='1'){$msg="FALTA JUSTIFICADA";}else if($licenca->id>0){ $msg="LICENÇA";}
			?>
            
              <tr>
                <td width="0" class="text-mini text-center td1-small" style="height:30px;" ><?
				$sd=explode('/',dataUsaToBr($data_exibicao));
				echo $sd[0];
				
				?><span class="text-mini td1-small text-center">
                  <?=$diadasemana?>
                </span></td>
                
                <td width="0" class="text-small text-center"><?=substr($hora_extra->hora_entrada,0,5)?></td>
                
                <td width="0" class="text-small text-center td1-large"><?=substr($hora_extra->hora_saida_almoco,0,5)?></td>
                <td width="0" class="text-small text-center td1-large"><?=substr($hora_extra->hora_retorno_almoco,0,5)?></td>
                
                <td width="0" class="text-small text-center"><?=$hora_saida?></td>
                 <td width="0" class="text-small text-center td1-large"><?=$hora_extra_entrada?></td>
                <td width="0" class="text-small text-center td1-large"><?=$hora_extra_saida?></td>
                <td width="0" class="text-small text-center"><?php if($total_em_horas->total_horas!="00:00:00"){ echo substr($total_em_horas->total_horas,0,5);}?></td>
                <td width="0" class="text-small text-center"><?php echo $msg?></td>
            </tr>
            <?php
				$hora_saida=$hora_extra_saida='';
			}	
			?>
               <tr>
                <td colspan="9" class="text-mini text-center td1-small" style="height:30px;" ><p>De conformidade com a Portaria MTE 3.626, Cap. IV, Art.13 de 13/11/1991, esta folha substitui, para todos os efeitos legais, o <br>
                 quadro de hor&aacute;rio de trabalho, inclusive o de menores. </p></td>
              </tr>
       </table><br>
       <table width="100%" border="0" cellpadding="0" cellspacing="0" id='tbs'>
  <tr>
    <td width="300" style="border-bottom:1px solid #000">&nbsp;</td>
    <td >&nbsp;</td>
    <td width="300" style="border-bottom:1px solid #000">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">VISTO FUNCIONARIO</td>
    <td>&nbsp;</td>
    <td align="center">VISTO RESPONS&Aacute;VEL</td>
  </tr>
</table>
       	<br><br>
	   <?php 
	   		
	    ?>
</div>
<?php
	if(!$qtd_horas_extras>0){
?>
<div style="page-break-after:always"></div>

<?php
	}
		/*if($configuracao->recibo_hora_extra=='sim'){
			
			include('impressao_hora_extra.php');
			echo "<div style=\"page-break-after:always\"></div>";
			include('impressao_adicional_noturno.php');
			include('impressao_hora_domingo.php');
			include('impressao_recibo.php');
			echo "<div style=\"page-break-after:always\"></div>";
		}*/
	}
	
	}
?>
