<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	global $vkt_id;
	//id do funcionario
	
	$mes        = $_GET['mes'];
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
	
	$qtd_dias_folha = mysql_fetch_object(mysql_query($t="
		SELECT DATEDIFF((SELECT ADDDATE('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)),'$ano-$mes-$dia_abertura') as qtd_dias"));
	//echo mysql_error()." ".$t." ".$qtd_dias_folha->qtd_dias;exit();
	
	if($dia_abertura<10){$dia_abertura='0'.$dia_abertura;}
	if($dia_abertura==1){
		  //$adicao_data=" AND DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)";
		  //$ultima_data_fechamento=mysql_result(mysql_query("SELECT DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)"),0);
		  $ultima_data_fechamento=$ano."-".$mes."-".date("t");
		  $ultimo_dia_mes = date("t");
	  }elseif($dia_abertura>1){
		  $adicao_data=" AND DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)";
		  $ultima_data_fechamento=mysql_result(mysql_query("SELECT DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)"),0);
	  }
	 
//echo $t;

?>

<style>
body{ }
.container{ auto; width:860px; background:#FFF;}
.container h1,h2,h3,h4,h5,h6{ margin:0;}
table{ border-collapse:collapse; border:1px solid #666; }
.table-none-border-bottom{ border-bottom:none;}
.table-none-border-top{ border-top:none;} 
.table-none-border-top tr:first-child td { border-top:none;} 
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
.td-padding-small{ padding:8px;}
.td1-mini{ width:25px;}
.td1-small{ width:55px;}
.td1{ width:76px;}
.td1-large{ width:95px;}
.td2-small{ width:128px;}
.td2{ width:160px;}
.td3-small{ width:240px;}
.td3{ width:276px;}
.td4{ width:340px;}
.offset1{ padding-left:15px;}
.offset2{ padding-left:30px; }
.offset3{ padding-left:45px;}
.offset1-right{ padding-right:12px;}
.titulo1{ font-weight:bold; font-size:16px; font-family:Arial, Helvetica, sans-serif;}
.titulo2{ font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif;}
</style>

<input type="hidden" name="count_array_dia_semana" id="count_array_dia_semana" value="<?=count($dias_semana)?>" >

<div class="container">
<?php
	$data_abertura   = $ano."-".$mes."-".$dia_abertura;
	$data_fechamento = $ultima_data_fechamento;
	if($_GET['funcionario_id']>0){
		$filtro = " AND id='".$_GET['funcionario_id']."'";
	}
	$funcionarios = mysql_query("SELECT * FROM rh_funcionario WHERE empresa_id = '$cliente_fornecedor->id' AND vkt_id='$vkt_id' AND status='admitidos' $filtro ORDER BY nome");
	while($funcionario = mysql_fetch_object($funcionarios)){
		$valor_hora          = $funcionario->salario/220;
		$valor_hora_extra_50 = $valor_hora + ($valor_hora*0.5); 
		$valor_hora_extra_100 = $valor_hora*2;
		
?>
		<table width="100%" class="table-none-border-bottom" style="margin-top:30px;">
        	<tr>
            	<td class="td3-small text-center" rowspan="2"><img src="../../vekttor/clientes/img/<?=$vkt_id?>.png"></td>
                <td class="td4 text-center titulo1" colspan="2"> <?=$cliente_fornecedor->razao_social?>  </td>
            </tr>
            
            <tr>
            	<td class="text-center" colspan="2"> <p class="text-mini"> <?=$cliente_fornecedor->endereco?> - <?=$cliente_fornecedor->bairro?> <br/> CEP: <?=$cliente_fornecedor->cep?> - <?=$cliente_fornecedor->cidade?> - <?=$cliente_fornecedor->estado?> <br/>   </p> </td>
            </tr>
         </table>
         <table width="100%" class="table-none-border-top" >
            <tr>
            	<td class="text-center text-mini offset1-right td3"> NOME DO COLABORADOR: <br> <b><?=$funcionario->nome?></b> </td>
                <td class="text-center text-mini td3"> FUNÇÃO: <br/> <b> <?=$funcionario->cargo?> </b> </td>
                <td class="text-center text-mini td3"> DATA DE ADMISSÃO <br/> <b> <?=DataUsaToBr($funcionario->data_admissao)?> </b> </td>
            </tr>
            
            <tr>
            	<td class="text-center text-mini offset1-right"> PERÍODO:<br/> <b> <?="$dia_abertura/".$mes."/".$_GET['ano']." à ".dataUsaToBr($ultima_data_fechamento);?> </b> </td>
                <td class="td3 text-center text-mini" colspan="2"> HORÁRIO DE TRABALHO <br/> <b> <?=$funcionario->hora_inicio_expediente?> às <?=$funcionario->hora_fim_expediente?> </b> </td>
            </tr>
        </table>
        
        <h2 class="text-center titulo1"> HORA EXTRA </h2>
        <table width="100%" class="table-hora-extra" >
        	
            <tr id="esse_primeiro">
            	<th class="text-small sub-titulo" colspan="3">Dia</th>
                <th class="text-small sub-titulo">Início</th>
                <th class="text-small sub-titulo">Fim</th>
                <th class="text-small sub-titulo">Subtotal</th>
                <th class="text-small sub-titulo">50%</th>
                <th class="text-small sub-titulo">100%</th>
            </tr>
            <?php
			 
            //foreach($dias_semana as $dia){
			$soma_horas_total = "00:00";
			$soma_hora_extra_50="00:00";
			$soma_hora_extra_100="00:00";
			//if(sizeof($hora_extra_funcionario)>0){
			//foreach($hora_extra_funcionario as $hora_extra){
			$hora_extra_funcionario = mysql_query($t="
			SELECT *, DAYOFWEEK(data) as dia_semana
			FROM rh_hora_extra WHERE vkt_id='$vkt_id' AND funcionario_id='$funcionario->id' AND data BETWEEN '$data_abertura' AND '$data_fechamento'
			AND  (hora_extra50 OR hora_extra_100) 
			");
			//echo $t;
			//echo mysql_num_rows($hora_extra_funcionario);
			while($hora_extra=mysql_fetch_assoc($hora_extra_funcionario)){
				//print_r($hora_extra);
				$total   = explode(".",$hora_extra['total']);
				$minutos = substr($total[1]*60,0,2);
				if($total[0]<10){ $total[0]="0".$total[0];}
				if($minutos<10){ $minutos="0".$minutos;}
				$total   = $total[0].":".$minutos; 
			?>
            <tr id="esse_segundo" align="center">
            	<td class="text-mini sub-titulo td1-mini text-center td-hora-primeiro"  >&nbsp;</td>
                <td class="text-mini sub-titulo td1 text-center"><?=substr($hora_extra['data'],8,2)."/".$mes_abreviado[$mes-1] ?>&nbsp;</td>
                <td class="text-mini sub-titulo td1 text-center"><?=$dias_semana[$hora_extra['dia_semana']-1]?>&nbsp;</td>
                     
                <td class="text-mini sub-titulo td1-large text-center"><?=substr($hora_extra['hora_entrada'],0,5)?>&nbsp;</td>
                <td class="text-mini sub-titulo td1-large"><?=substr($hora_extra['hora_saida'],0,5)?>&nbsp;</td>
                <td class="text-mini sub-titulo td1-large">
				<?php
				
					$soma_horas_total = soma_horas($soma_horas_total,$total);
					echo $total;
				?>&nbsp;</td>
                <td class="text-mini sub-titulo td1-large">
				<?php 
					/*if($hora_extra['porcentagem']=="0"){
						echo substr($hora_extra['total'],0,5);
						$soma_hora_extra_50= soma_horas($soma_hora_extra_50,substr($hora_extra['total'],0,5));
						
					}*/
					echo substr($hora_extra['hora_extra50'],0,5);
					$soma_hora_extra_50= soma_horas($soma_hora_extra_50,substr($hora_extra['hora_extra50'],0,5));
				?>&nbsp;</td>
                <td class="text-mini sub-titulo td1-large">
					<?php 
						//if($hora_extra['porcentagem']=="1"){
							//echo substr($hora_extra['total'],0,5);
							//$soma_hora_extra_100= soma_horas($soma_hora_extra_100,substr($hora_extra['total'],0,5));
						//}
						echo substr($hora_extra['hora_extra_100'],0,5);
						$soma_hora_extra_100= soma_horas($soma_hora_extra_100,substr($hora_extra['hora_extra_100'],0,5));
					?>
                        &nbsp;
                </td>
            </tr>
            <?php 
			}
			//}
			?>
             <!--<tr id="esse_segundo">
            	<td class="text-small sub-titulo td1-mini text-center td-hora-primeiro"  >&nbsp;</td>
                <td class="text-small sub-titulo td1 text-center">&nbsp;</td>
                <td class="text-mini sub-titulo td1 text-center">&nbsp;</td>
                
                
                <td class="text-small sub-titulo td1-large text-center">&nbsp;</td>
                <td class="text-small sub-titulo td1-large">&nbsp;</td>
                <td class="text-small sub-titulo td1-large">&nbsp;</td>
                <td class="text-small sub-titulo td1-large">&nbsp;</td>
                <td class="text-small sub-titulo td1-large">&nbsp;</td>
            </tr>-->
            
            <tr>
            	<td colspan="5" rowspan="2" class="td-padding-small"> <p class="text-center titulo2 ">Total de Horas Trabalhadas no Mês</p> </td>
                <td class="text-center text-mini"></td>
                <td class="text-center text-mini">50%</td>
                <td class="text-center text-mini">100%</td>
            </tr>
            <tr>
            	
                <td class="text-center text-mini"><?=$soma_horas_total?></td>
                <td class="text-center text-mini"></td>
                <td class="text-center text-mini"></td>
            </tr>
            
           
        </table>
        
        <table width="100%" class="table-none-border-top">
        	<tr>
            	<td class="text-mini text-center td3"> Salário Base </td>
                <td class="text-mini text-right td1-large offset1-right"> <?=MoedaUsaToBr($funcionario->salario)?> </td>
                <td class="text-mini text-right offset1-right" style="width:207px;"> Soma de horas </td>
                <td class="text-mini text-right offset1-right" style="background:#F7F7F7;"><?=$soma_hora_extra_50?>&nbsp;  </td>
                <td style="background:#F7F7F7;" class="text-mini text-right offset1-right"><?=$soma_hora_extra_100?></td>
            </tr>
            
            <tr>
            	<td class="text-mini text-center td3"> Horas Mês </td>
                <td class="text-mini text-right td1-large offset1-right"> 220 </td>
                <td class="text-mini text-right offset1-right" style="width:207px;"> Hora acrescida </td>
                <td style="background:#F7F7F7;" class="text-mini text-right offset1-right">
				<?php
                	$hora_acrescida = MoedaUsaToBr($valor_hora*0.5);
					echo $hora_acrescida;
				?></td>
                <td style="width:110px;background:#F7F7F7;" class="text-right offset1-right"> <span class="text-mini"> 
                <?php
                	$hora_acrescida_100 = MoedaUsaToBr($valor_hora);
					echo $hora_acrescida_100;
				?>
                </span> </td>
            </tr>
            
             <tr>
            	<td class="text-center td3"> <p class="text-mini">Valor da Hora Comercial</p></td>
                <td class="text-mini text-right td1-large offset1-right"> <?=MoedaUsaToBr($valor_hora)?></td>
                <td class="text-mini text-right offset1-right" style="width:207px;"> Valor da hora extra </td>
                <td style="background:#F7F7F7;" class="text-mini text-right offset1-right"><?=MoedaUsaToBr($valor_hora_extra_50)?></td>
                <td style="background:#F7F7F7;" class="text-right offset1-right"> <span class="text-mini">
                <?php
					echo MoedaUsaToBr($valor_hora_extra_100);
				?>
                </span> </td>
             </tr>
             
             <tr>
            	<td class="text-right td3 offset1-right" colspan="3"> <p class="text-mini">Quantidade de horas</p></td>
                <td style="background:#F7F7F7;" class="text-mini text-right offset1-right">
				<?php 
					$hora_extra_50_decimal=(substr($soma_hora_extra_50,-2)/60)+substr($soma_hora_extra_50,0,2);
					echo limitador_decimal_br($hora_extra_50_decimal,2);
				?></td>
                <td style="background:#F7F7F7;" class="text-right offset1-right"> 
                <span class="text-mini">
                <?php
                	$hora_extra_100_decimal=(substr($soma_hora_extra_100,-2)/60)+substr($soma_hora_extra_100,0,2);
					echo limitador_decimal_br($hora_extra_100_decimal,2);
				?>
                </span> 
               </td>
             </tr>
             
              <tr>
            	<td class="text-right td3 offset1-right" colspan="3"> <p class="text-mini">Subtotal</p></td>
                <td style="background:#F7F7F7;" class="text-mini text-right offset1-right">
				<?php
                	$subtotal_50 = $valor_hora_extra_50*$hora_extra_50_decimal;
					echo MoedaUsaToBr($subtotal_50);
				?></td>
                <td style="background:#F7F7F7;" class="text-right offset1-right"> 
                <span class="text-mini">
                	<?php
                    	$subtotal_100 = $valor_hora_extra_100*$hora_extra_100_decimal;
						echo MoedaUsaToBr($subtotal_100);
					?>
                </span> </td>
             </tr>
             
              <tr>
            	<td class="text-right td3 offset1-right" colspan="3"> <p class="text-mini titulo2">Total Devido</p></td>
                <td style="background:#F7F7F7;" colspan="2" class="text-mini text-right offset1-right"><?=MoedaUsaToBr($subtotal_100+$subtotal_50)?></td>
               
             </tr>
            
           
        </table>
        <?php
			}
		?>
       
</div>
<br>
<br>