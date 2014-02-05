<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	global $vkt_id;
	//id do funcionario
	
	//tipo de recibo
	$tipo_recibo = $_GET['tipo'];
	
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
/*textos*/
.text-left{ text-align:left;}
.text-center{ text-align:center;}
.text-mini{ font-size:8pt; }
.text-normal{ font-size:12pt;}
.text-height-small{ line-height:28px;}
.td1-mini{ width:25px;}
.td1-small{ width:55px;}
.td1{ width:76px;}
.td2-small{ width:128px;}
.td2{ width:160px;}
.td3-small{ width:240px;}
.td3{ width:276px;}
.td4{ width:340px;}
.offset-mini{ padding-left:5px;}
.offset-small{ padding-left:13px;}
.offset-large{ padding-left:40px;}
.td-padding-small{ padding:8px;}
/*títulos*/
.titulo2{ font-weight:bold; font-size:13px; font-family:Arial, Helvetica, sans-serif;}
/*bordas*/
.border-dotted{border:1px dotted #000;}
.border-dotted-bottom{border-bottom:1px dotted #000;}
.border-dotted-top{border-top:1px dotted #000;}
.border-dotted-left{border-left:1px dotted #000;}
.border-dotted-right{border-right:1px dotted #000;}
</style>
<?php
$data_abertura   = $ano."-".$mes."-".$dia_abertura;
	$data_fechamento = $ultima_data_fechamento;	
if($_GET['funcionario_id']>0){
	$filtro = " AND id='".$_GET['funcionario_id']."'";
}
$funcionarios = mysql_query("SELECT * FROM rh_funcionario WHERE empresa_id = '$cliente_fornecedor->id' AND vkt_id='$vkt_id' AND status='admitidos' $filtro ORDER BY nome");
while($funcionario = mysql_fetch_object($funcionarios)){

	$valor_hora = $funcionario->salario/220;

	if($tipo_recibo=="adiantamento"){
	
		$parcelas_venda = mysql_result(mysql_query($t="
			SELECT 
				SUM(valor_parcela) as total
			FROM
				rh_venda_funcionario rh_v,
				rh_venda_funcionario_parcela rh_fp
			WHERE
				rh_fp.venda_id = rh_v.id AND
				rh_v.funcionario_id='$funcionario->id' AND
				MONTH(rh_fp.data_vencimento) = '".($_GET['mes']+1)."' AND
				YEAR(rh_fp.data_vencimento) = '".$_GET['ano']."'
			"),0,0);
		$mes_e=$mes_extenso[$mes];
		$descricao="Adiantamento";
		$valor=$parcelas_venda;
		//echo $parcelas_venda;exit();
	}
	
	if($tipo_recibo=="noturno"){
		
		//SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( hora_extra_100 ) ) ) AS total_horas FROM rh_hora_extra
		$horas = mysql_query($t="
		SELECT * FROM rh_hora_extra WHERE vkt_id='$vkt_id' AND funcionario_id='$funcionario->id' AND MONTH(data)='$mes'AND (data BETWEEN '$data_abertura' AND '$data_fechamento')  AND adicional_noturno>0");
		//echo $t." ".$horas->total_horas;
		//$horas   = $horas/60/60;
		$valor=$valor_hora;
		
		while($hora = mysql_fetch_object($horas)){
			/*$hora_50_segundos = explode(":",$hora->hora_extra50);
			$hora_50_segundos = ($hora_50_segundos[0]*60*60)+($hora_50_segundos[1]*60)+($hora_50_segundos[2]);
			$hora_100_segundos = explode(":",$hora->hora_extra_100);
			$hora_100_segundos = ($hora_100_segundos[0]*60*60)+($hora_100_segundos[1]*60)+($hora_100_segundos[2]);
			 				
			if($hora_50_segundos>0){
				$hora_acrescida = $valor_hora+$valor_hora_adicional_noturno;
				$valor+=(($hora->adicional_noturno/60/60) + ($valor_hora+($valor_hora*0.5)))*0.2; 
			}else if($hora_100_segundos>0){
			
				$valor+=(($hora->adicional_noturno/60/60) + ($valor_hora+($valor_hora*2)))*0.2;
			}*/
			$valor+=$valor_hora*0.2;		
		}
		
		/*$horas   = explode(".",$horas);
		$minutos = $horas[1];
		$minutos = substr(($minutos*60),0,2);
		//$minutos = $minutos; 
		$horas   = $horas[0];
		$horas   = $horas.":".$minutos;*/
		$descricao="Adicional Noturno";		
		$mes_e=$mes_extenso[$mes-1]; 
	}
	
	if($tipo_recibo=="domingo"){
		//SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( hora_extra_100 ) ) ) AS total_horas FROM rh_hora_extra
		$horas = mysql_result(mysql_query($t="SELECT SUM( TIME_TO_SEC(hora_extra_100)) AS total_horas FROM rh_hora_extra WHERE vkt_id='$vkt_id' AND funcionario_id='$funcionario->id' AND MONTH(data)='$mes'AND YEAR(data)='$ano' AND DAYOFWEEK(data)=1"),0,0);
		
		$horas   = $horas/60/60;
		
		$valor   = ($valor_hora*$horas)*2;		
		
		$horas   = explode(".",$horas);
		$minutos = $horas[1];
		$minutos = substr(($minutos*60),0,2);
		//$minutos = $minutos; 
		$horas   = $horas[0];
		$horas   = $horas.":".$minutos;
		$descricao="Horas Trabalhadas no Domingo";
		$mes_e=$mes_extenso[$mes-1];
		 
	}
	
	if($tipo_recibo=="extra"){
		//SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( hora_extra_100 ) ) ) AS total_horas FROM rh_hora_extra
		$horas = mysql_fetch_object(mysql_query($t="
		SELECT SUM( TIME_TO_SEC(hora_extra50)) AS total_horas50, SUM( TIME_TO_SEC(hora_extra_100)) AS total_horas100
		FROM rh_hora_extra WHERE vkt_id='$vkt_id' AND funcionario_id='$funcionario->id' AND MONTH(data)='$mes'AND YEAR(data)='$ano'"));
		
		$horas_50     = $horas->total_horas50/60/60;
		$valor_hora_50 = ($valor_hora*$horas_50)*1.5; 
		$horas_100  = $horas->total_horas100/60/60;
		$valor_hora_100= ($valor_hora*$horas_100)*2;
		
		$valor   = $valor_hora_50+$valor_hora_100;		
		
		/*$horas   = explode(".",$horas);
		$minutos = $horas[1];
		$minutos = substr(($minutos*60),0,2);
		//$minutos = $minutos; 
		$horas   = $horas[0];
		$horas   = $horas.":".$minutos;*/
		$descricao="Horas Extras";
		
		$mes_e=$mes_extenso[$mes-1];
	}
	
	//echo $horas;exit();

	//foreach($recibos as $recibo){
?>

<div class="container">
		<table width="100%" class="table-none-border-bottom" style="margin-top:10px;margin-bottom:10px;">
        	<tr>
            	<td class="td3-small text-center" rowspan="2"><img src="../../vekttor/clientes/img/<?=$vkt_id?>.png"></td>
                <td class="td4 text-center titulo2" colspan="2"> <?=$cliente_fornecedor->razao_social?>  </td>
                <td class="text-center text-mini"> RECIBO </td>
            </tr>
            
            <tr>
            	<td class="text-center" colspan="2"> <p class="text-mini"> <?=$cliente_fornecedor->endereco?> - <?=$cliente_fornecedor->bairro?> <br/> CEP: <?=$cliente_fornecedor->cep?> - <?=$cliente_fornecedor->cidade?> - <?=$cliente_fornecedor->estado?> <br/> Fone/Fax: <?=$cliente_fornecedor->telefone1?>   </p> </td>
                <td class="td1 text-mini offset-mini"> R$ <?=MoedaUsaToBr($valor)?></td>
            </tr>
            <tr>
            	<td class="text-left offset-small"> <p class="text-mini"> CNPJ: <?=$cliente_fornecedor->cnpj_cpf?></p> </td>
                <td class="text-left text-mini offset-small" colspan="3"> <p class="text-mini"> INSC. ESTADUAL: <?=$cliente_fornecedor->inscricao_estadual?> </p> </td>
            </tr>
            <tr>
            	<td colspan="4" class="td-padding-small text-normal"> 
                	<p class="text-height-small"> 
                    	Recebi da: <span class="offset-large"> <?=$cliente_fornecedor->razao_social?>  </span> <br/>
                        a quantia de: <!--<span class="offset-large"> R$ <?=MoedaUsaToBr($recibo['valor'])?> </span>--> <span> <?=numero(number_format($valor,2,',',''),'moeda')?> </span>
                    </p> 
                </td>
            </tr>
            <tr>
                <td colspan="4" class="td-padding-small text-normal">
                    <p class="text-height-small "> referente ao <span class="offset-large"> <?=$descricao?>:  </span> <span> <b><?=$mes_e?>/<?=$ano?></b> </span> </p>
                </td>
            </tr>
            <tr>
            	<td colspan="4" class="text-center td-padding-small"> 
                <p> Manaus - Am <?=date('d')?> de <?=$mes_extenso[date($mes-1)]?> de <?=date('Y')?> </p><br/> <p class="border-dotted-bottom td4 text-center" style="margin:0 auto;">  </p> <b class="text-normal"><?=$funcionario->nome?></b> <br/><br/> </td>
               
            </tr>
         </table>
      
</div>
<?php
	//}
}
?>