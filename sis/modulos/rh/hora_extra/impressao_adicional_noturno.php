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
	$dias_semana = array("domingo", "segunda", "ter�a", "quarta", "quinta", "sexta", "sabado");
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
<script src="../../../../fontes/js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	//$(".table-hora-extra tr:first-child").next().find(".td-hora-primeiro").attr("rowspan", $("#count_array_dia_semana").val() );
	//console.log( $(".table-hora-extra tr:first-child").next().find(".td-hora-primeiro").text());
});	

</script>
<style>
body{ }
.container{ margin:0 auto; width:860px; background:#FFF;}
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
		$salario_atual = $funcionario->salario;
		$valor_hora    = $salario_atual/220;
		
?>
		<table width="100%" class="table-none-border-bottom" style="margin-top:30px;">
        	<tr>
            	<td class="td3-small text-center" rowspan="2">PALATARE</td>
                <td class="td4 text-center titulo1" colspan="2"> <?=$cliente_fornecedor->razao_social?>  </td>
            </tr>
            
            <tr>
            	<td class="text-center" colspan="2"> <p class="text-mini"> <?=$cliente_fornecedor->endereco?> - <?=$cliente_fornecedor->bairro?> <br/> CEP: <?=$cliente_fornecedor->cep?> - <?=$cliente_fornecedor->cidade?> - <?=$cliente_fornecedor->estado?> <br/>   </p> </td>
            </tr>
         </table>
         <table width="100%" class="table-none-border-top" >
            <tr>
            	<td class="text-center text-mini offset1-right td3"> NOME DO COLABORADOR: <br> <b><?=$funcionario->nome?></b> </td>
                <td class="text-center text-mini td3"> FUN��O: <br/> <b> <?=$funcionario->cargo?> </b> </td>
                <td class="text-center text-mini td3"> DATA DE ADMISS�O <br/> <b> <?=DataUsaToBr($funcionario->data_admissao)?> </b> </td>
            </tr>
            
            <tr>
            	<td class="text-center text-mini offset1-right"> PER�ODO:<br/> <b> <?="$dia_abertura/".$mes."/".$_GET['ano']." � ".dataUsaToBr($ultima_data_fechamento);?> </b> </td>
                <td class="td3 text-center text-mini" colspan="2"> HOR�RIO DE TRABALHO <br/> <b> <?=$funcionario->hora_inicio_expediente?> �s <?=$funcionario->hora_fim_expediente?> </b> </td>
            </tr>
        </table>
        
        <h2 class="text-center titulo1"> ADICIONAL NOTURNO</h2>
        <table width="100%" class="table-hora-extra" >
        	
            <tr id="esse_primeiro">
            	<th class="text-small sub-titulo" colspan="3">Dia</th>
                <th class="text-small sub-titulo">In�cio</th>
                <th class="text-small sub-titulo">Fim</th>
                <th class="text-small sub-titulo">Subtotal</th>
                <th class="text-small sub-titulo">Total a 20%</th>
                <!--<th class="text-small sub-titulo">100%</th>-->
            </tr>
            <?php
			$soma_total_horas              = "00:00";
			$total_horas_adicional_noturno = "00:00";
			$adicional_noturno_funcionario = mysql_query($t="
			SELECT *, DAYOFWEEK(data) as dia_semana
			FROM rh_hora_extra WHERE vkt_id='$vkt_id' AND funcionario_id='$funcionario->id' AND data BETWEEN '$data_abertura' AND '$data_fechamento' AND adicional_noturno >'0'
			");
			$valor_hora_adicional_noturno = $valor_hora*0.2;
            //echo $t;
			//if(sizeof($adicional_noturno_funcionario)>0){
			//foreach($adicional_noturno_funcionario as $adicional_noturno){
			while($adicional_noturno = mysql_fetch_array($adicional_noturno_funcionario)){	
				
				
				$total   = explode(".",$adicional_noturno['total']);
				$minutos = substr($total[1]*60,0,2);
				if($total[0]<10){ $total[0]="0".$total[0];}
				if($minutos<10){ $minutos="0".$minutos;}
				$total   = $total[0].":".$minutos;
				//-----------------------------------------------------------
				$horas_adicional_noturno    = $adicional_noturno['adicional_noturno']/60/60;
				$horas_adicional_noturno    = explode(".",$horas_adicional_noturno);
				$minutos_adicional_noturno  = substr(($horas_adicional_noturno[1]*60),0,2);
				if($horas_adicional_noturno[0]<10){ $horas_adicional_noturno[0]="0".$horas_adicional_noturno[0];}
				if($minutos_adicional_noturno<10){ $minutos_adicional_noturno="0".$minutos_adicional_noturno;}
				$adicional_noturno['qtd']   = $horas_adicional_noturno[0].":".$minutos_adicional_noturno;
				
				/*$hora_50_segundos = explode(":",$adicional_noturno['hora_extra50']);
				$hora_50_segundos = ($hora_50_segundos[0]*60*60)+($hora_50_segundos[1]*60)+($hora_50_segundos[2]);
				$hora_100_segundos = explode(":",$adicional_noturno['hora_extra_100']);
				$hora_100_segundos = ($hora_100_segundos[0]*60*60)+($hora_100_segundos[1]*60)+($hora_100_segundos[2]);
				
				if($hora_50_segundos>0){
					$valor_hora_adicional_noturno = ($adicional_noturno['adicional_noturno']/60/60) + ($valor_hora+($valor_hora*0.5))*0.2; 
				}else if($hora_100_segundos>0){
					$valor_hora_adicional_noturno = ($adicional_noturno['adicional_noturno']/60/60) + ($valor_hora+($valor_hora*2))*0.2;
				}*/
				
			?>
            <tr id="esse_segundo" align="center">
            	<td class="text-mini sub-titulo td1-mini text-center td-hora-primeiro"  ></td>
                <td class="text-mini sub-titulo td1 text-center"><?=substr($adicional_noturno['data'],8,2)."/".$mes_abreviado[$mes-1]?></td>
                <td class="text-mini sub-titulo td1 text-center"><?=$dias_semana[$adicional_noturno['dia_semana']-1]?></td>
                <td class="text-mini sub-titulo td1-large text-center"><?=$adicional_noturno['hora_entrada']?></td>
                <td class="text-mini sub-titulo td1-large"><?=$adicional_noturno['hora_saida']?></td>
                <td class="text-mini sub-titulo td1-large">
				<?php
                	$soma_total_horas = soma_horas($soma_total_horas,$total);
					echo $total;
				?>
                </td>
                <td class="text-mini sub-titulo td1-large">
                <?php
					echo $adicional_noturno['qtd'];
                	$total_horas_adicional_noturno = soma_horas($total_horas_adicional_noturno ,$adicional_noturno['qtd']);
				?>
                </td>
                <!--<td class="text-small sub-titulo td1-large"><?php if($adicional_noturno['porcentagem']=="1"){echo "0:00";}?></td>-->
            </tr>
            
            
            <?php 
			}
			//}
			?>
            <tr>
            	<td colspan="5" rowspan="2" class="td-padding-small"> <p class="text-center titulo2 ">Total de Horas Trabalhadas no M�s</p> </td>
                <td class="text-center text-mini"></td>
                <td class="text-center text-mini">20%</td>
            </tr>
            <tr>
                <td class="text-center text-mini"><?=$soma_total_horas?></td>
                <td class="text-center text-mini"><?=$total_horas_adicional_noturno?></td>
            </tr>
            <tr>
            	<td class="text-mini text-center" colspan="3">Sal�rio Base</td>
                <td class="text-mini text-right offset1-right"><?=MoedaUsaToBr($salario_atual)?></td>
                <td class="text-mini text-right offset1-right" colspan="2">Hora noturna</td>
                <td class="text-mini text-right offset1-right"><?=MoedaUsaToBr($valor_hora*0.2)?></td>
            </tr>
            
             <tr>
            	<td class="text-mini text-center" colspan="3">Horas M�s</td>
                <td class="text-mini text-right offset1-right">220</td>
                <td class="text-mini text-right offset1-right" colspan="2">Hora acrescida</td>
                <td class="text-mini text-right offset1-right">
				<?php
                	$hora_acrescida = $valor_hora+$valor_hora_adicional_noturno;
					//echo "$valor_hora+$valor_hora_adicional_noturno<br>";
					echo MoedaUsaToBr($hora_acrescida);
				?>
                </td>
             </tr>
             
              <tr>
            	<td class="text-center" colspan="3"> <p class="text-mini">Valor da Hora Comercial</p> </td>
                <td class="text-mini text-right offset1-right"> <?=MoedaUsaToBr($valor_hora)?> </td>
                <td class="text-mini text-right offset1-right" colspan="2">Valor do adicional noturno</td>
                <td class="text-mini text-right offset1-right">
                <?=MoedaUsaToBr($valor_hora_adicional_noturno+$hora_acrescida)?>
                </td>
             </tr>
             
              <tr>
            	<td class="text-right offset1-right" colspan="6"> <p class="text-mini">Quantidade de Horas</p> </td>
                <td class="text-mini text-right offset1-right">
                <?php
					$hora_noturno_decimal=(substr($total_horas_adicional_noturno,-2)/60)+substr($total_horas_adicional_noturno,0,2);
					echo MoedaUsaToBr($hora_noturno_decimal);
				?>
                </td>
              </tr>
              
               <tr>
            	<td class="text-right offset1-right" colspan="6"> <p class="text-mini">Subtotal</p> </td>
                <td class="text-mini text-right offset1-right">
                	<?php
                    $total_devido = $hora_noturno_decimal*($valor_hora_adicional_noturno+$hora_acrescida);
					echo MoedaUsaToBr($total_devido);
					?>
                </td>
              </tr>
              
               <tr>
            	<td class="text-right" colspan="6"> <p class="text-mini titulo2">Total Devido</p> </td>
                <td class="text-mini text-right offset1-right"><?=MoedaUsaToBr($total_devido)?></td>
              </tr>
           
        </table>
<?php
	}
?>     
</div>