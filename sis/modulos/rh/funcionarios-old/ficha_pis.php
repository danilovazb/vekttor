<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
$id = $_GET['id'];

function mes($mes){
	
	switch($mes){
		case '01': $mes="Janeiro";break;
		case '02': $mes="Fevereiro";break;
		case '03': $mes="Março";break;
		case '04': $mes="Abril";break;
		case '05': $mes="Maio";break;
		case '06': $mes="Junho";break;
		case '07': $mes="Julho";break;
		case '08': $mes="Agosto";break;
		case '09': $mes="Setembro";break;
		case '10': $mes="Outubro";break;
		case '11': $mes="Novembro";break;
		case '12': $mes="Dezembro";break;
		
		
	}
	
	echo $mes;
}
	
$empregado = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=$id"));
	
$empresa_empregado     = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$empregado->empresa_id"));

$dependentes_empregado = mysql_query($t="SELECT * FROM rh_funcionario_dependentes WHERE funcionario_id='$empregado->id'");

if($empregado->grau_instrucao==1){
	$escolaridade = "Analfabeto";
}else if($empregado->grau_instrucao==2){
	$escolaridade = "Até a 4ª série incompleta do ensino fundamental";
}else if($empregado->grau_instrucao==3){
	$escolaridade = "Com a 4ª série completa do ensino fundamental";
}else if($empregado->grau_instrucao==4){
	$escolaridade = "De 5 a 8ª série incompleta do ensino fundamental";
}else if($empregado->grau_instrucao==5){
	$escolaridade = "Ensino fundamental completo";
}else if($empregado->grau_instrucao==6){
	$escolaridade = "Ensino médio incompleto";
}else if($empregado->grau_instrucao==7){
	$escolaridade = "Ensino médio completo";
}else if($empregado->grau_instrucao==8){
	$escolaridade = "Superior incompleto";
}else if($empregado->grau_instrucao==9){
	$escolaridade = "Superior completo";
}else if($empregado->grau_instrucao==10){
	$escolaridade = "Mestrado";
}else if($empregado->grau_instrucao==11){
	$escolaridade = "Doutorado";
}else if($empregado->grau_instrucao==12){
	$escolaridade = "Pós-Doutorado";
}
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
				
	}
	#tbl_registro_empregado tr td, #dados_dependentes tr td{		
		border-bottom:solid #000 1px;
		border-right:solid #000 1px;
		border-left:solid #000 1px;
		height:40px;
	}
	.campo{
		margin:0px;
		margin-bottom:10px;
		margin-left:4px;
		font-size:12px;
		line-height:10px;
		font-weight:bold;
	}
	.campo2{
		margin:0px;
		margin-bottom:10px;
		margin-left:4px;
		font-size:12px;
		line-height:10px;
		font-weight:normal;
	}
	.linha_assinatura{
		width:100%;
		height:2px;
		border-bottom:solid 1px #000000;
		
	}
	.quebra{
		white-space:normal;		
	}
</style>
<title>FIcha de Empregados</title>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" id="tbl_registro_empregado">
  <tr >
  	<td align="center" style="border-style:none"><img src="../../../modulos/rh/imagens/logo_caixa.jpg" height="38"/></td>
    <td colspan="5" style="border-style:none;"><div style="margin-left:50px;font-size:17px;margin-top:10px;">DCN – Documento de Cadastramento do NIS</div></td>
  </tr>
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
   <tr>
    <td colspan="5" style="border-style:none"></td>
    <td ><div class="campo">Grau de Sigilo</div>#00</td>
   
   
  </tr>
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td ><div class="campo">01. [x]CNPJ  [ ]CEI</div><?=$empresa_empregado->cnpj_cpf?></td>
    <td colspan="4"><div class="campo">02. Nome do Empregador:</div><?=$empresa_empregado->razao_social?></td>
    <td ><div class="campo">03. Data de Vínculo:</div><?=DataUsaToBr($empregado->data_admissao)?></td>
   
  </tr>
  <tr>
  	<td colspan="6" style="height:10px;border:none;text-align:center;font-size:9px;"> Os campos 01, 02 e 03 são de preenchimento exclusivo para cadastramento de trabalhador.</td>
  </tr>
  
  <tr>
    <td colspan="3"><div class="campo">04. Nome:</div><?=$empregado->nome?></td>
    <td colspan="2"><div class="campo">05. Data de Nascimento:</div><?=DataUsaToBr($empregado->data_nascimento)?></td>
    <td><div class="campo">06. Sexo:</div> [<? if($empregado->sexo=="masculino"){ echo "X";}?>   ] M [<? if($empregado->sexo=="feminino"){ echo "X";}?> ] F</td>  
  </tr>
  
   <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td colspan="6"><div class="campo">07. Nome do Pai:</div><?=$empregado->filiacao_pai?></td>
   
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td colspan="6"><div class="campo">08. Nome da Mãe:</div><?=$empregado->filiacao_mae?></td>
   
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td colspan="2"><div class="campo">
    09. Nacionalidade:</div>[<? if($empregado->quando_estrangeiro=="nao"){ echo "X";}?> ]Brasileira &nbsp;&nbsp;&nbsp;[ ]Brasileiro nascido no exterior<br>
    [<? if($empregado->quando_estrangeiro=="sim"&&$empregado->naturalizado=="nao"){ echo "X";}?> ]Estrangeira [<? if($empregado->naturalizado=="sim"){ echo "X";}?> ]Brasileiro Naturalizado</td>
    <td colspan="1"><div class="campo">10. País de Origem:</div><?=$empregado->pais_origem?></td>
    <td colspan="3"><div class="campo">11. UF e Município de Nascimento:</div><?=$empregado->municipio_nascimento." ".$empregado->uf_nascimento?></td>
      
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td><div class="campo">12. Cor:</div><?=$empregado->cor?></td>
    <td><div class="campo">13. Estado Civil:</div><?=$empregado->estado_civil?></td>
    <td colspan="2"><div class="campo">14. Nível de Instrução:</div><?=$escolaridade?></td>
    <td colspan="2"><div class="campo">15. Data de chegada ao Brasil:</div><?=DataUsaToBr($empregado->data_chegada_brasil)?></td>  
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td ><div class="campo">16. CPF:</div><?=$empregado->cpf?></td>
    <td ><div class="campo" style="margin-bottom:3px;">17. Identidade</div><div class="campo2">17.1 Número</div><?=$empregado->rg?></td>
    <td ><div class="campo2">17.2 Complemento:</div><?=$empregado->complemento?></td>
   	 <td ><div class="campo2">17.3 UF:</div><?=$empregado->estado?></td>
    <td ><div class="campo2">17.4 Emissor:</div><?=$empregado->rg_orgao_emissor?></td>
    <td ><div class="campo2">17.5 Data de Emissão:</div><?=DataUsaToBr($empregado->rg_data_emissao)?></td>
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td ><div class="campo" style="margin-bottom:0px;">18. CTPS</div><div class="campo2">18.1 Número</div><?=$empregado->carteira_profissional_numero?></td>
    <td ><div class="campo2">18.2 Série</div><?=$empregado->carteira_profissional_serie?></td>
    <td ><div class="campo2">18.3 UF:</div><?=$empregado->carteira_profissional_estado_emissor?></td>
   	 
    <td colspan="3"><div class="campo2">18.4 Data de Emissão:</div><?=DataUsaToBr($empregado->carteira_profissional_data_expedicao)?></td>
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td colspan="2"><div class="campo" style="margin-bottom:0px;">19. Certidão Civil</div><div class="campo2">19.1 Tipo</div><?=$empregado->certidao_civil_tipo?></td>
    <td ><div class="campo2">19.2 Data de Emissão</div><?=DataUsaToBr($empregado->certidao_civil_data_emissao)?></td>
    <td colspan="3"><div class="campo2">19.3 Termo/Matrícula:</div><?=$empregado->certidao_civil_matricula?></td>
   
   
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td ><div class="campo" style="margin-bottom:0px;">Certidão civil - continuação</div><div class="campo2">19.4 Livro</div><?=$empregado->certidao_civil_livro?></td>
    <td ><div class="campo2">19.5 Folha</div><?=$empregado->certidao_civil_folha?></td>
    <td colspan="2"><div class="campo2">19.6 Cartório:</div><?=$empregado->certidao_civil_cartorio?></td>   	 
    <td><div class="campo2">19.7 UF:</div><?=$empregado->certidao_civil_uf?></td>
    <td><div class="campo2">19.8 Município:</div><?=$empregado->certidao_civil_municipio?></td>
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td ><div class="campo" style="margin-bottom:0px;">20. Passaporte</div><div class="campo2">20.1 Número</div><?=$empregado->passaporte_numero?></td>
    <td ><div class="campo2">20.2 Emissor:</div><?=$empregado->passaporte_emissor?></td>
    <td ><div class="campo2">20.3 UF:</div><?=$empregado->passaporte_estado_emissor?></td>
   	 <td ><div class="campo2">20.4 Data de Emissão:</div><?=DataUsaToBr($empregado->data_emissao_passaporte)?></td>
    <td ><div class="campo2">20.5 Data de Validade:</div><?=DataUsaToBr($empregado->data_validade_passaporte)?></td>
    <td ><div class="campo2">20.6 País de Emissão:</div><?=$empregado->pais_emissao_passaporte?></td>
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td ><div class="campo" style="margin-bottom:0px;">21. Título de eleitor:</div><div class="campo2">21.1 Número</div><?=$empregado->titulo_eleitor_numero?></td>
    <td ><div class="campo2">21.2 Zona:</div><?=$empregado->titulo_eleitor_zona?></td>
    <td ><div class="campo2">21.3 Seção:</div><?=$empregado->titulo_eleitor_secao?></td>
   	 <td colspan="2"><div class="campo" style="margin-bottom:0px;">22. Portaria de Naturalização:</div><div class="campo2">22.1 Número:</div><?=$empregado->portaria_naturalizacao_numero?></td>
    <td ><div class="campo2">22.2 Data de Naturaliza&ccedil;&atilde;o:</div><?=$empregado->portaria_naturalizacao_data?></td>    
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td ><div class="campo" style="margin-bottom:0px;">23. RIC:</div><div class="campo2">23.1 Número:</div><?=$empregado->ric_numero?></td>
    <td ><div class="campo2">23.2 UF:</div><?=$empregado->ric_uf?></td>
    <td ><div class="campo2">23.3 Emissor:</div><?=$empregado->ric_emissor?></td>
   	 <td colspan="2"><div class="campo2">23.4 Município:</div><?=$empregado->ric_municipio?></td>
    <td ><div class="campo2">23.5 Data de Expedicao:</div><?=DataUsaToBr($empregado->ric_data_expedicao)?></td>    
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td  colspan="2"><div class="campo" style="margin-bottom:0px;">24. Endereço:</div><div class="campo2">24.1 Tipo:</div>[ ]Comercial [X]Residencial</td>
     
   	  	
     <td ><div class="campo2">39. Cep:</div><?=$empregado->cep?></td>
  	 <td ><div class="campo2">38. UF:</div><?=$empregado->estado?></td>
      <td colspan="2"><div class="campo2">37. Município:</div><?=$empregado->cidade?></td>
  </tr>
  
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
  
  <tr>
    <td  colspan="2"><div class="campo2">24.5 Bairro:</div><?=$empregado->bairro?></td>
     
   	  	
     <td ><div class="campo2">24.6 Logradouro:</div><?=$empregado->endereco?></td>
  	 <td ><div class="campo2">24.7 N&ordm;:</div><?=$empregado->casa_numero?></td>
      <td colspan="2"><div class="campo2">24.8 Complemento:</div><?=$empregado->complemento?></td>
  </tr>
   
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
   
   <tr>
    <td ><div class="campo" style="margin-bottom:0px;">25. Caixa Postal:</div><div class="campo2">25.1 Número:</div><?=$empregado->telefone1?></td>     
   	<td ><div class="campo2">25.2 Cep:</div><?=$empregado->cep?></td>
    <td ><div class="campo" style="margin-bottom:0px;">26. Telefone:</div><div class="campo2">26.1 DDD:</div><?=substr($empregado->telefone1,1,2)?></td>
    <td ><div class="campo2">26.2 Fixo:</div><?=substr($empregado->telefone1,4)?></td>     
   	<td ><div class="campo2">26.3 DDD:</div><?=substr($empregado->telefone2,1,2)?></td>
    <td ><div class="campo2">Celular</div><?=substr($empregado->telefone2,4)?></td>
   	
  </tr>
  <tr>
  	<td colspan="6" style="height:10px;border:none;"> </td>
  </tr>
   
   <tr>
    <td colspan="6"><div class="campo">27. E-mail</div><?=$empregado->email?></td>     
   	   	
  </tr>
  
 
</table>

<div id="data" style="width:800px;margin-top:65px;">
    <div style="float:left;width:350px;">
        <div><?=$empresa_empregado->cidade?></div>
        
        <div class="quebra"></div>
        
        Local/Data
   	</div>
    
     <div style="float:right;width:300px;margin-right:100px;">
            <?=date('d')?> de <?=mes(date('m'))?> de <?=date('Y')?> 
            
            
    </div>
    
</div>

<div style="clear:both"></div>

<div id="data" style="width:800px;margin-top:30px;">
    <div style="float:left;width:350px;">
        <div class="linha_assinatura"></div>
        
        <div class="quebra"></div>
        
        Assinatura do solicitante
   	</div>
    
     <div style="float:left;width:350px;margin-left:10px;">
        <div class="linha_assinatura"></div>
        
        <div class="quebra"></div>
        
        Assinatura do empregado CAIXA – Sob carimbo
   	</div>
    
</div>
</body>
</html>