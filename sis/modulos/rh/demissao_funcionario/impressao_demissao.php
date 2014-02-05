<?php
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
include("_functions.php");
include("../../../_config.php");
include("../../../_functions_base.php");
$dataHoje = date("Y-m-d");
$diasProjecao = 0;
$TipoDemissao = array('demissao_com_justa_causa'=>'Demissão com justa causa', 'pedido_demissao' => 'Pedido de Demissão','fim_contrato' => 'Fim de Contrato','demissao_sem_justa_causa' => 'Demissão sem justa causa');

$relatorio = mysql_fetch_object(mysql_query($sql="SELECT *, 
	cliente.endereco AS enderecoEmpresa, cliente.bairro AS bairroEmpresa, cliente.cidade AS cidadeEmpresa, cliente.email AS emailEmpresa,
	funcionario.nome AS nomeFUNC,
	funcionario.data_admissao AS dtAdmissao,
	cargo.cargo AS funcCargo  
	FROM rh_funcionario_demitidos AS funcDemitido	
		JOIN rh_empresas AS empresa ON empresa.cliente_fornecedor_id = funcDemitido.empresa_id 
		JOIN cliente_fornecedor AS cliente ON cliente.id = empresa.cliente_fornecedor_id
		JOIN rh_funcionario AS funcionario ON funcionario.id = funcDemitido.funcionario_id
		LEFT JOIN cargo_salario AS cargo ON funcionario.cargo_id = cargo.id
		WHERE funcionario.vkt_id = '$vkt_id' AND funcDemitido.funcionario_id = '".trim($_GET['funcionario_id'])."' "));
				
if( !empty($relatorio->funcionario_id) ){	
  $dataAvisoPrevio = $relatorio->data_aviso_previo;
  $dataDemissao = $relatorio->data_demissao;
  list($anoDemissao, $mesDemissao, $diaDemissao) = explode('-', $relatorio->data_demissao);
  
  $DayProjecao = mysql_result(mysql_query("SELECT TIMESTAMPDIFF(DAY, '$relatorio->dtAdmissao','$relatorio->data_demissao')"),0,0);
  $YearProjecao = mysql_result(mysql_query("SELECT TIMESTAMPDIFF(YEAR, '$relatorio->dtAdmissao','$relatorio->data_demissao')"),0,0);
  $diasProjecao = empty($YearProjecao) ?  PrejecaoDias($DayProjecao) : ProjecaoAno($YearProjecao);
  $DataDemiProjecao = mktime(0,0,0,$mesDemissao,$diaDemissao+$diasProjecao,$anoDemissao);
  $feriado = mysql_fetch_object(mysql_query("SELECT * FROM rh_feriado WHERE vkt_id = '$vkt_id' AND mes = '$mesDemissao' "));
  $faltas = mysql_fetch_object(mysql_query(" SELECT *, COUNT(id) AS qtdFalta FROM `rh_hora_extra` WHERE month(data) = $mesDemissao AND falta_integral = '0'  "));
} 

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Aviso Prévio</title>
<style>
 body{ margin:0;  padding:0;  background-color:#FAFAFA;  font:12pt "Tahoma"}
.page{ width:21cm;  padding:1cm;  margin:1cm auto;  height:277mm;  border:1px #D3D3D3 solid;  border-radius:5px;  background:white;  box-shadow:0 0 5px rgba(0,0,0,0.1)}
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
@media print{ .page{margin:0; border:initial; border-radius:initial; width:initial; min-height:initial; box-shadow:initial; background:initial; page-break-after:always}
}
</style>
</head>

<body>

<div class="page">
<? if( !empty($relatorio->funcionario_id) ) {?>
<!--header-->
<div class="header">
	<p>
      <span><?=$relatorio->razao_social;?></span><br/>
      <?=$relatorio->enderecoEmpresa?><br/>
      <?=$relatorio->bairroEmpresa." ".$relatorio->cidadeEmpresa?> <br>
      <?=$relatorio->cep."  ".$relatorio->cidadeEmpresa."  ".$relatorio->uf?><br/>
      <? 
	  if(!empty($relatorio->fax))
	  	echo "Fax: ".$relatorio->fax?><br><? 
	  if(!empty($relatorio->emailEmpresa))
	  	echo " E-mail".$relatorio->emailEmpresa?>
    </p>
</div>

<!--content-->
<div class="content">
	<p class="paragraph"><? echo strftime(" Manaus, %d de %B de %Y.", strtotime( $dataHoje ));?> </p>
    <p> A <br>
    <span class="uppercase"><?=$relatorio->razao_social;?></span><br/>
    Att.: Sra. Rose/Nancy (Depto de Pessoal).
    </p>
    <p>
      <div class="paragraph"> Ref.: Demissão de funcionário(a). </div>
      <div class="text">Com a presente vimos solicitar que seja providenciada a documentação, para efeito de demissão <b><?=$TipoDemissao[$relatorio->tipo_demissao]?>,</b> do(a) funcionário(a), <b> <?=$relatorio->nomeFUNC?> (<?=$relatorio->funcCargo?>),</b> que se encontra cumprindo aviso <b> AVISO PRÉVIO DO EMPREGADOR (TRABALHADO) </b> desde a data de <?=strftime("%d de %B de %Y,", strtotime( $dataAvisoPrevio ));?> até a data de <b> <?=strftime("%d de %B de %Y,", strtotime( $dataDemissao ));?> + <?=$diasProjecao?> dias de projeção.</b> </div>       
    </p>
    <p>
    	<table>
        	<tr><td> Data de Demissão C/ a projeção: <?=date("d/m/Y", $DataDemiProjecao);?> </td></tr>
            <?php if( !empty($relatorio->horas_extras_50) || !empty($relatorio->horas_extras_50) ){
					$horaExtra = "Sim";		
			} else { $horaExtra = "Não"; }?>
            <tr><td> Hora Extra: <b><?=$horaExtra?></b> </td></tr>
            
            <?php if( !empty($relatorio->adicional_noturno) ){
					$addNoturno = "Sim";		
			} else { $addNoturno = "Não"; }?>
            <tr><td> Adic. Norturno: <b><?=$addNoturno?></b> </td></tr>
            
            <?php if( !empty($feriado->id) ){
					$Feriados = "Sim";		
			} else { $Feriados = "Não"; }?>
            <tr><td> Feriados(s): <b><?=$Feriados?></b> </td></tr>
            
             <?php if( !empty($relatorio->adicional_noturno) ){
					$Feriados = "Sim";		
			} else { $Feriados = "Não"; } ?>
            
            <?php if( !empty($faltas->qtdFalta ) ){
				$Faltas = "Sim";
		    } else { $Faltas = "Não"; } ?>
            <tr><td> Faltas(s): <b><?=$Faltas?></b> </td></tr>
            
            <?php if( !empty($relatorio->vale_transporte) ) {
					$valeTransporte = "Sim";
			} else{ $valeTransporte = "Não"; } ?>
            <tr><td> Vales: <b><?=$valeTransporte?></b> </td></tr>
            
            <?php ?>
            <!--<tr><td> Vale Refeição: <b>Não</b> </td></tr> DERNANDO FALOU, VER COM O MARIO  -->
            <?php ?>
            <tr><td> Vale Transporte: <b><?=$valeTransporte?></b> </td></tr>
            <tr><td> Bonificação: <b>Não</b> </td></tr>
            <tr><td> Gratif. Função (Quebra de Caixa): R$ 140,00 </td></tr>
        </table>
        <p> 
        	<b> OBS: Homologação junto ao SINTRAPAM: 25/11/2013 </b> <br/><br/>
            <small>Atenciosamente,</small>
        </p>
    </p>
</div>

<!--footer-->
<div class="footer">
	<p>
    	G M RODRIGUES ALIMENTOS<br/>
        Francineide Rocha<br/>
        Departamento Administrativo<br/>
        <small>Setor Pessoal</small>
    </p>
</div>
<?php } else { echo "<p> Não existe relatório para este funcionário </p>"; }?>
</div>
</body>
</html>