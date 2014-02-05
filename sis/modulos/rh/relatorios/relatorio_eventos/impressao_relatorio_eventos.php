<?
include "../../../../_config.php";
include "../../../../_functions_base.php";
if(($_GET['eventos']!='')){
	$eventos=explode(',',$_GET['eventos']);
}
function exibe_funcionarios($evento,$empresa){
	global $vkt_id;
	if($empresa>0){
		$add_sql = " AND empresa_id='$empresa' ";
	}
	$evento=mf(mq("SELECT * FROM rh_eventos WHERE vkt_id='$vkt_id' AND id = '$evento' "));
	
	$cargo = $evento->cargo_id;
	$funcionario= $evento->funcionario_id;
	$emresa= $evento->empresa_id;
	
	// Todos
	if($cargo==0 && $funcionario==0 && $emresa==0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' $add_sql");
	}
	// Todos na Empresa
	if($cargo==0 && $funcionario==0 && $emresa>0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' AND empresa_id='$empresa' $add_sql");
	}
	
	// Cargo
	if($cargo>0 && $funcionario==0 && $emresa==0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' AND cargo_id='$cargo'  $add_sql");
	}
	// Cargos na Empresa
	if($cargo>0 && $funcionario==0 && $emresa>0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' AND empresa_id='$emresa' AND  cargo_id='$cargo' $add_sql");
	}
	// Funcionario
	if($funcionario>0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND id='$funcionario'  $add_sql");
	}
	
	return array($evento,$f);
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão do relatório de eventos</title>
<style>
table tr td{ border-right:solid 1px black; border-bottom:solid 1px black;}
</style>
<style>
 body{ margin:0;  padding:0;  background-color:#FAFAFA;  font:9pt "Tahoma"}
 table{ padding:0; margin:0;}
 

 /* impressao na horizontal */
.page{ /*width:277mm;*/ width:277mm;  padding:1cm;  margin:1cm auto;  height:21cm;  border:1px #D3D3D3 solid;  border-radius:5px;  background:white;  box-shadow:0 0 5px rgba(0,0,0,0.1)}


small{ font-size:11pt}
.header{padding:0 0 15px}
.header p{text-align:center}
.uppercase{text-transform:uppercase}
.header p span{font-weight:bold; text-transform:uppercase}
.content .paragraph{padding:0 0 18px; display:block}
.content .text{text-align:justify}
.footer{padding:100px 0 0}
.footer p{text-align:center; float:left}
@page{ size:A4;  margin:0}

/* configuracao atribuida na hora da impressao */
@media print{ .page{margin:0; border:initial; border-radius:initial; width:initial; min-height:initial; box-shadow:initial; background:initial; page-break-after:always}
}
</style>
</head>

<body>

<div  class="page" style="text-align:center;">
<h2 style="text-align:center;">Planilha de eventos REF. AO MÊS DE <?=$mes_extenso[$_GET['mes']-1]?> de <?=$_GET['ano']?> </h2>

<table  cellspacing="0" cellpadding="1" style="border-left:solid 1px black; border-top:solid 1px black; width:277mm;">
    <thead>
		<tr>
        	<td rowspan="2">Funcionários</td>
            <td>Prêmio</td>
            <td>Valor</td>
            <td>Faltas</td>
            <td>Saldo do</td>
            <td>Saldo a</td>
            <td rowspan="2" colspan="2">OBS:</td>
            <td rowspan="2">RECEBIDO/CLIENTE</td>
        </tr>
        <tr>
        	<td>R$</td>
            <td>Reprov.</td>
            <td>no Mês</td>
            <td>Mês Ant.</td>
            <td>Receber</td>
        </tr>
      
    </thead>
    <tbody>
    	
        <?
		if($_GET['mes']<10){
			$mes = "0{$_GET['mes']}";
		}else{
			$mes = $_GET['mes'];
		}
		
		$x=0;
		$folha=mysql_fetch_object(mysql_query("SELECT * FROM rh_folha WHERE mes='".$_GET[mes]."' AND ano='".$_GET[ano]."' AND empresa_id='".$_GET['empresa_id']."' AND vkt_id='$vkt_id'"));
		
		for($i=0;$i<count($eventos);$i++){//for dos eventos
			
			
			$rf= exibe_funcionarios($eventos[$i],$_GET[empresa_id]); //Funcionarios retorno da funcao
			$evento= $rf[0];
			$f= $rf[1];
			if(mysql_num_rows($f)>0){
				?>
                <tr>
                	<td style="background-color:gray; color:white;" colspan="9"><?=$evento->nome?></td>
                </tr>
                <?
			}
        	while($funcionario= mf($f)){//funcionario
			/*$faltas= mysql_result(mysql_query($t="
		SELECT
			COUNT(rx.id) as faltas
		FROM
			rh_hora_extra as rx
		WHERE
			rx.vkt_id='$vkt_id'
		AND
			rx.funcionario_id='$funcionario->id'
		AND
			rx.falta_integral='1'
		AND
			MONTH(rx.data)='($mes+1)' 
			"),0);
			*/
			$folha_funcionario_evento = mysql_fetch_object(mysql_query($t="
			SELECT * FROM rh_folha_funcionarios_eventos WHERE
			folha_id='$folha->id' AND funcionario_id='$funcionario->id'
			AND evento_id='$evento->id'
			"));
			$faltas = mysql_result(mysql_query($t="
			SELECT referencia FROM rh_folha_funcionarios_eventos WHERE
			folha_id='$folha->id' AND funcionario_id='$funcionario->id'
			AND nome='FALTAS'
			"),0,0);
			
			
			$valor_reprovado=$folha_funcionario_evento->desconto+$folha_funcionario_evento->desconto_faltas+$folha_funcionario_evento->desconto_grupo;
			
				$x++;
				if($x%2==0){$al='al';}else{$al='';}
				//if($evento->forma_valor==0){
					$valor = $folha_funcionario_evento->premio;
				//}
				//if($evento->forma_valor==1){
					//$valor = $evento->valor/100*$funcionario->salario;
				//}
			
		?>
    	<tr class=" <?=$al?>">
            <td align="left" width="170"><?=$funcionario->nome?></td>
            <td align="center" width="70"><?=moedaUsaToBr($valor)?></td>
            <td align="center" width="70"><?=moedaUsaToBr($valor_reprovado)?></td>
            <td width="50" align="center"><?=$faltas?></td>
            <td width="70" align="center"><?=moedaUsaToBr($folha_funcionario_evento->desconto_mes_anterior)?></td>
            <td width="70" align="center"><?=moedaUsaToBr($folha_funcionario_evento->valor_real)?></td>
          	<td width="100"align="left" ></td>
            <td width="100"align="left" ></td>
          	<td width="150"align="center"></td>
			
        </tr>
        
        <?
        }
		}
		
		?>
    </tbody>
</table>
<span style="margin-top:10px; display:block;"><!--Total  C/ Cursos: R$ 2.149,00--> Entregue por:_______________________ DATA:__/__/____</span>
</div>



</body>
</html>