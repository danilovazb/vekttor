<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
$id = $_GET['id'];
	
$empregado = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=$id"));
	
if($empregado->quando_estrangeiro=='sim'){
	
	$nacionalidade = $empregado->pais_origem;

}else{
	
	$nacionalidade = "Brasileira";
	
}
$escolaridade = array('Analfabeto','Até a 4ª série incompleta do ensino fundamental','Com a 4ª série completa do ensino fundamental','De 5 a 8ª série incompleta do ensino fundamental','Ensino fundamental completo','Ensino médio incompleto','Ensino médio completo','Superior incompleto','Superior completo','Mestrado','Doutorado','Pós-Doutorado');

$data_admissao = explode("-",$empregado->data_admissao);

$data_admissao = $data_admissao[2]." de ".$mes_extenso[$data_admissao[1]-1]." de ".$data_admissao[0];	



	
$cliente_fornecedor     = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$empregado->empresa_id"));

$dependentes_empregado = mysql_query($t="SELECT * FROM rh_funcionario_dependentes WHERE funcionario_id='$empregado->id' order by nome");

if($empregado->status=='demitidos'){
	$demissao  = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario_demitidos WHERE funcionario_id='$empregado->id'"));
}

$corarray = array(
"9"=>"Não Informado",
"1"=>"Indígena",
"2"=>"Branca",
"4"=>"Negra",
"6"=>"Amarela",
"8"=>"Parda");

$tipo_emprego_array = array(
"10"=>"Primeiro Emprego",
"20"=>"Reemprego",
"25"=>"Contrato por prazo determinado",
"35"=>"Reintegração",
"70"=>"Transferência de entrada");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style>
	*{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	#tbl_registro_empregado,#dados_estrangeiro, #dados_dependentes, #rodape{
		width:800px;
	}
	#tbl_registro_empregado, #dados_dependentes{
		border-left:solid #999 1px;
		border-top:solid #999 1px;
		
	}
	#tbl_registro_empregado tr td, #dados_dependentes tr td{		
		border-bottom:solid #999 1px;
		border-right:solid #999 1px;
		height:35px;
	}
	.campo{
		margin:0px;
		font-size:10px;
		line-height:10px;
		font-weight:bold;
	}
	.linha_assinatura{
		width:100%;
		height:2px;
		border-bottom:solid 1px #000000;
		
	}
</style>
<title>FIcha de Empregados</title>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" id="tbl_registro_empregado">

  <tr>
    <td colspan="4" style="width:650px;text-align:center;"><strong>FICHA REGISTRO DE EMPREGADO</strong><div style="float:right;font-size:18px;width:10px;margin-right:65px;">Nº.<?=$empregado->numero_sequencial_empresa?></div></td>
    <td rowspan="4" align="center" style="width:150px;">
    	<img src="../../../../upload/rh/funcionarios/fotos/<?=$empregado->id.".".$empregado->extensao?>" height="150"/>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="width:410px;"><div class="campo">Firma:</div><?=$cliente_fornecedor->razao_social?></td>
    <td width="133" style="width:100px;"><div class="campo">CNPJ:</div><?=$cliente_fornecedor->cnpj_cpf?></td>
    <td><div class="campo">Atividade Comercial:</div>
    <?=$cliente_fornecedor->ramo_atividade?></td>
  </tr>
  <tr>
    <td colspan="2" style="width:100px;"><div class="campo">Rua:</div><?=$cliente_fornecedor->endereco?></td>
    
    <td width="161" style="width:100px;"><div class="campo">Cidade</div><?=$cliente_fornecedor->cidade?></td>
    <td style="width:100px;"><div class="campo">UF</div><?=$cliente_fornecedor->estado?></td>
  </tr>
  <tr>
    <td style="width:100px;border-right:1px solid #000;"><div class="campo">Nome do Empregado: </div><?=$empregado->nome?></td>
    <td style="width:100px;"><div class="campo">Telefone:</div><?=$empregado->telefone1?></td>
    <td colspan="2"><div class="campo">Data de Nascimento</div><?=DataUsaToBr($empregado->data_nascimento)?></td>
  </tr>
  <tr>
    <td colspan="2">
    	<div class="campo">Salário:</div>
		<?
        echo MoedaUsaToBr($empregado->salario);
		$salario_total = $empregado->salario;
		if($empregado->adicional_insalubridade>0){
			echo " + $empregado->adicional_insalubridade % (Insalubridade)";
			$adicional_insalubridade = ($empregado->adicional_insalubridade*$empregado->salario)/100;
			$salario_total +=$adicional_insalubridade;
		}
		if($empregado->adicional_periculosidade>0){
			echo " + $empregado->adicional_periculosidade % (Periculosidade)";
			$adicional_periculosidade = ($empregado->adicional_periculosidade*$empregado->salario)/100;
			$salario_total +=$adicional_periculosidade;
		}
		if($empregado->adicional_noturno>0){
			echo " + $empregado->adicional_noturno % (Noturno)";
			$adicional_noturno = ($empregado->adicional_noturno*$empregado->salario)/100;
			$salario_total +=$adicional_noturno;
		}
		
		if($salario_total > $empregado->salario){
			echo " = ".MoedaUsaToBr($salario_total);
		}
		?>
    </td>
    <td colspan="3"><div class="campo">Forma de Pagamento:</div>Mensal</td>
  </tr>
  <tr>
    <td><div class="campo">Carteira Profissional:</div><?=$empregado->carteira_profissional_numero?></td>
    <td><div class="campo">Série:</div><?=$empregado->carteira_profissional_serie?>/<?=$empregado->carteira_profissional_estado_emissor?></td>
    <td colspan="2"><div class="campo">Carteira Reservista:</div><?=$empregado->carteira_reservista?></td>
    <td><div class="campo">Categoria:</div><?=$empregado->categoria?></td>
  </tr>
  <tr>
    <td><div class="campo">PIS n&deg;:</div><?=$empregado->pis?></td>
    <td><div class="campo">CPF n&deg;:</div><?=$empregado->cpf?></td>
    <td colspan="2"><div class="campo">RG n&deg;:</div><?=$empregado->rg?></td>
    <td><?=$empregado->rg_orgao_emissor?></td>
  </tr>
  <tr>
    <td><div class="campo">Data Admissao:</div><?=DataUsaToBr($empregado->data_admissao)?></td>
    <td><div class="campo">Ocupaçao:</div><?=$empregado->cargo?></td>
    <td colspan="2"><div class="campo">CBO:</div><?=$empregado->cbo?></td>
    <td><div class="campo">Tipo Admissao:</div><?=$tipo_emprego_array[$empregado->tipo_admissao]?></td>
  </tr>
  <tr>
    <td colspan="5">Horário normal de trabalho:das <?=substr($empregado->hora_inicio_expediente,0,5);?> as <?=substr($empregado->hora_fim_expediente,0,5);?> com intervalo de <?=substr($empregado->duracao_intervalo,0,5);?> para repouso e alimentação</td>
  </tr>
  <tr>
    <td><div class="campo">Estado Civil:</div><?=$empregado->estado_civil?></td>
    <td><div class="campo">Conjugue(se casado):</div><?=$empregado->nome_conjugue?></td>
    <td colspan="1"><div class="campo">Sexo:</div><?=$empregado->sexo?></td>
    <td colspan="2"><div class="campo">Cor:</div><?=$corarray[$empregado->cor]?></td>
  
  </tr>
<tr>
    <td colspan="2"><div class="campo">Filho de:</div><?=$empregado->filiacao_pai?></td>
    <td colspan="3"><div class="campo">E de:</div><?=$empregado->filiacao_mae?></td>
  </tr>
   <tr>
    <td><div class="campo">Nacionalidade:</div><?=$nacionalidade?></td>
    <td colspan="2"><div class="campo">Naturalidade:</div><?=$empregado->municipio_nascimento?>-<?=$empregado->uf_nascimento?></td>
    <td colspan="2"><div class="campo">Sabe Ler e escrever:</div><?=$empregado->sabe_ler_escrever?></td>
  
  </tr>
  <tr>
    <td><div class="campo">Grau de Instruçao:</div><?=$escolaridade[$empregado->grau_instrucao-1]?></td>
    <td colspan="2"><div class="campo">Tem algum Certificado:</div><? if(!empty($empregado->certificado)){ echo "sim";}else{ echo "não";}?></td>
    <td colspan="2"><div class="campo">De que:</div><?=$empregado->certificado?></td>
  
  </tr>
  <tr>
    <td colspan="2"><div class="campo">Residencia Atual:</div><?=$empregado->endereco?> Nº.<?=$empregado-> casa_numero ?> </td>
    <td><div class="campo">Bairro:</div><?=$empregado->bairro?></td>
    <td><div class="campo">Cidade:</div><?=$empregado->cidade?></td>
    <td ><div class="campo">CEP:</div><?=$empregado->cep?></td>
  
  </tr>
  <tr>
    <td colspan="5"><div class="campo">Sindicato que esta filiado:</div><?=$empregado->sindicato?></td>
      
  </tr>
    <tr>
    <td colspan="5"><div class="campo">Quando Estrangeiro:</div><?=$empregado->quando_estrangeiro?></td>
      
  </tr>
</table>


<table border="0" cellpadding="0" cellspacing="0" id="dados_estrangeiro">
	<tr>
		<td colspan="2">a) É casado com: <?=$empregado->nome_conjugue?></td>
        <td colspan="2">Nacionalidade:</td>
    </tr>
    <tr>
		<td colspan="2">b) Data que chegou ao Brasil: <?=DataUsaToBr($empregado->data_chegada_brasil)?></td>
        <td>Naturalizado: <?=$empregado->naturalizado?></td>
        <td>Estado:<?=$empregado->estado_naturalizado?> </td>
    </tr>
    <tr>
		<td width="35%">c) Carteira Estrangeira Modelo: <?=$empregado->carteira_estrangeira_modelo?></td>
		<td width="15%">N&ordm;: <?=$empregado->carteira_estrangeira_numero?></td>
        <td width="30%">Expedida em: <?=DataUsaToBr($empregado->carteira_estrangeira_data_expedicao)?></td>
        <td>Estado:<?=$empregado->estado_naturalizado?></td>
    </tr>
</table>

<?
	if(mysql_num_rows($dependentes_empregado)>0){
?>
<table id="dados_dependentes">
	<tr>
		<td>NOME DOS BENEFICIÁRIOS</td>
        <td>DATA NASCIMENTO</td>
        <td>GRAU DE PARENTESCO</td>
    </tr>
   	<?php
		while($dependete = mysql_fetch_object($dependentes_empregado)){
	?>
    <tr>
		<td><?=$dependete->nome?></td>
        <td><?=DataUsaToBr($dependete->data_nascimento)?></td>
        <td><?=$dependete->grau_parentesco?>(a)</td>
    </tr>
   
    <?
		}
	?>
</table>
<?
	}
?>
<div id="rodape">
	Declaro serem verdadeiras as informações acima prestadas, podendo ser usados como expressão da verdade quando
	exigidos por Lei.

	<div style="clear:both"></div>

	Localidade E Data:<?=$cliente_fornecedor->cidade.", ".$data_admissao?>

  <div style="clear:both">
   <div style="float:right;margin-right:180px;;margin-top:80px;">
        	            
            <div class="linha_assinatura" style="margin-left:auto;margin-right:auto;width:250px;">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Assinatura do Empregado
            </div>
    	</div>
  
  </div>
  <!--<div style="margin-top:30px;float:right;margin-right:200px;">Assinatura Empregado:</div>-->
    
    <div style="clear:both"></div>

	Data em que o empregado deixou o serviço desta firma:<?
    
	if($demissao->data_demissao!='0000-00-00'){
		DataUsaToBr($demissao->data_demissao);
	}
	
	?>
    
    <div style="clear:both"></div>

	Tempo de Serviço:
    
    <div style="clear:both"></div>

	<div style="float:left">Motivo:</div>
	<div style="float:right;margin-right:25px;">Polegar Direito:</div>
    
	<div style="clear:both"></div>
	   
    <div id="polegar" style="border:#CCC 2px solid;border-bottom:none;width:150px;height:150px;float:right;"></div>
</div>
</body>
</html>