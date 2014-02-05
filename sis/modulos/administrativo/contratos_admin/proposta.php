<?
include("../../../_config.php");
// funÁoes base do sistema
include("../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 

$contrato = mysql_fetch_object(mysql_query($t="select 
c.nome_contato as cliente, c.naturalidade, c.nacionalidade, c.ramo_atividade, c.endereco_comercial, c.telefone_comercial, 
c.telefone1 as telefone1, c.telefone2 as telefone2, 
c.nascimento as data_nascimento, c.cnpj_cpf as cpf, c.rg as rg, c.local_emissao, c.data_emissao,
c.endereco as endereco, c.bairro as bairro, c.cidade as cidade, c.estado as estado, c.cep as cep, c.email as email, c.estado_civil as estado_civil,
c.conjugue_nome, c.conjugue_ramo_atividade, c.conjugue_cpf, c.conjugue_rg, c.conjugue_local_emissao, c.conjugue_telefone, c.conjugue_data_nascimento,c.conjugue_data_emissao,
c.conjugue_email, c.conjugue_naturalidade, c.conjugue_nacionalidade, c.conjugue_endereco_comercial, c.conjugue_telefone_comercial,     
f.valor as valor, f.valor_comissao, f.valor_contrato, f.ato_valor, f.ato_parcelas, f.anuais_valor, f.anuais_parcelas, f.semestrais_valor, f.semestrais_parcelas, f.mensais_parcelas, f.mensais_valor,
f.data_criado as data_criado,
f.chave_parcelas, f.chave_valor, f.data_primeiro_pagamento,  
d.identificacao as disponibilidade,
e.nome as empreendimento, e.fim as fim_empreendimento, e.tipo as tipo,
n.nome as negociacao,
cor.nome as corretor,
i.nome as imobiliaria
from 
cliente_fornecedor as c, contrato as f, disponibilidade as d, empreendimento as e, negociacao as n, corretor as cor, usuario as i where 
f.id='".$id."' AND f.cliente_fornecedor_id=c.id and f.disponibilidade_id = d.id AND f.negociacao_id=n.id AND f.corretor_id=cor.id
AND d.empreendimento_id=e.id AND f.usuario_id=i.id"));
//echo $t;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo Vekttor</title>
<style type="text/css">
body{ margin:0; padding:0;}
.conteudo{
	font-size:20px;
}
.texto{
	font-size:9px;
}
#principal div{ border-top:0; }
#principal{border-right:solid 1px;}
</style>
</head>

<body>
<?php
	//while($contrato=mysql_fetch_object($contratos)){
  		//$cont++;
?>
<div style="margin:0 auto 0 auto;width:900px;" id="principal"> 
	<div id="logomarca" style="float:left;background-color:white;height:35px;width:200px;">
    Logomarca
    </div>
    <div style="height:33px; background-color:#F00;border:solid 1px #000;color:#FFFFFF;">
    	<center>RECIBO DE RESERVA E PROPOSTA DE AQUISICAO</center>
    </div>
    <div style="margin-top:20px;">
    	<div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:550px;"><sup>Empreendimento</sup><?=" ".$contrato->empreendimento?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:200px;"><sup>Unidade</sup></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;"><sup>Data</sup><?=" ".DataUsaToBr($contrato->data_criado)?></div>
        
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:588px;"><sup>Proponente</sup><?=" ".$contrato->cliente?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px; width:304px; float:left; clear:right;"><sup>Telefone</sup><?=" ".$contrato->telefone1."/".$contrato->telefone2?></div>
        
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:170px;  "><sup>CPF</sup><?= " ".$contrato->cpf?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:150px;float:left;"><sup>RG</sup><?= " ".$contrato->rg?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>"rg"o Emissor</sup><?= " ".$contrato->local_emissao?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:170px;float:left;"><sup>Data de Emissao</sup><?= " ".DataUsaToBr($contrato->data_emissao)?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:196px;float:left;"><sup>Data de Nascimento</sup><?= DataUsaToBr($contrato->data_nascimento)?></div>
        
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:699px; clear:right;"><sup>Endereco Residencial</sup><?=" ".$contrato->endereco?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:193px;"><sup>CEP</sup><?= " ".$contrato->cep ?></div>
        
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:180px;float:left;"><sup>Bairro</sup><?= " ".$contrato->bairro?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:250px;float:left;"><sup>Cidade</sup><?= " ".$contrato->cidade?></div>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:130px;"><sup>UF</sup><?= " ".$contrato->estado?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:327px;"><sup>E-mail</sup><?= " ".$contrato->email?></div>
        
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:166px;float:left;"><sup>Estado Civil</sup><?= " ".$contrato->estado_civil?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:250px;float:left;"><sup>Naturalidade</sup><?= " ".$contrato->naturalidade?></div>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:230px;"><sup>Nacionalidade</sup><?= " ".$contrato->nacionalidade?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:246px;"><sup>Profissao</sup><?= " ".$contrato->ramo_atividade?></div>
        
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:588px;float:left;"><sup>Endereco Comercial</sup><?= " ".$contrato->endereco_comercial?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:308px;float:left;"><sup>Telefone</sup><?= " ".$contrato->telefone_comercial?></div>
        
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:588px;float:left;"><sup>Conjuge</sup><?= " ".$contrato->conjugue_nome?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:308px;float:left;"><sup>Telefone</sup><?= " ".$contrato->conjugue_telefone?></div>
        
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:170px;"><sup>CPF</sup><?= " ".$contrato->conjugue_cpf?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:150px;float:left;"><sup>RG</sup><?= " ".$contrato->conjugue_rg?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>Órgão Emissor</sup> <?= " ".$contrato->conjugue_local_emissao?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:170px;float:left;"><sup>Data de Emissao</sup> <? if($contrato->estado_civil!='Solteiro'){" ".DataUsaToBr($contrato->conjugue_data_emissao);}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>Data de Nascimento</sup><? if($contrato->estado_civil!='Solteiro'){" ".DataUsaToBr($contrato->conjugue_data_nascimento);}?></div>
        
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:699px;"><sup>Endereco Residencial</sup><? if($contrato->estado_civil!='Solteiro'){" ".$contrato->endereco;}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:197px;"><sup>CEP</sup><? if($contrato->estado_civil!='Solteiro'){" ".$contrato->cep;}?></div>
        
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:180px;float:left;"><sup>Bairro</sup><? if($contrato->estado_civil!='Solteiro'){echo " ".$contrato->bairro;}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:250px;float:left;"><sup>Cidade</sup><? if($contrato->estado_civil!='Solteiro'){" ".$contrato->cidade;}?></div>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:130px;"><sup>UF</sup><? if($contrato->estado_civil!='Solteiro'){" ".$contrato->estado;}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:332px;"><sup>E-mail</sup> <? if($contrato->estado_civil!='Solteiro'){" ".$contrato->conjugue_email;}?></div>
        
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:166px;float:left;"><sup>Estado Civil</sup> <? if($contrato->estado_civil!='Solteiro'){" ".$contrato->estado_civil;}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:250px;float:left;"><sup>Naturalidade</sup><?= " ".$contrato->conjugue_naturalidade?></div>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:230px;"><sup>Nacionalidade</sup><?= " ".$contrato->conjugue_nacionalidade?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:246px;"><sup>Profissao</sup><?= " ".$contrato->conjugue_ramo_atividade?></div>
        
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:588px;float:left;"><sup>Endereco Comercial</sup><?= " ".$contrato->conjugue_endereco_comercial?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:308px;float:left;"><sup>Telefone</sup><?= " ".$contrato->conjugue_telefone_comercial?></div>
        
    </div>
    <!---------------------------------------------------------------------------------------------------------------------------->
    <div style="width:100%;"><center>CONDICOES DE FINANCIAMENTO</center></div>
    <div class='financiamento'>
    	<div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:340px;"><sup>Valor Total em R$</sup><br /><?= number_format($contrato->valor,2,",",".")?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:340px;"><sup>Valor de comissão em R$</sup><br /><?= number_format($contrato->valor_comissao,2,",",".")?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;"><sup>Valor de contrato em R$</sup><br /><?= number_format($contrato->valor_contrato,2,",",".")?></div>     
    </div>
    <!---------------------------------------------------------------------------------------------------------------------------->
    <div style="width:898px;height:35px;background-color:#F00;border:solid 1px #000;color:#FFFFFF;"><center>CONDICOES DE PAGAMENTO</center></div>
    <div class='pagamento'>
    	<div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:340px;"><sup>Descricao do Imovel</sup></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:340px;"><sup>Mes Base</sup></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;"><sup>Opcao de Financiamento</sup></div>
        <? if($contrato->ato_parcelas>0){ ?>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:80px;"><sup>Parcelas</sup><?= " ".$contrato->ato_parcelas?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:150px;float:left;"><sup>Valor</sup><? if($contrato->ato_parcelas!=0){echo number_format(($contrato->ato_valor/$contrato->ato_parcelas),2,",",".");}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>Periodicidade</sup>Ato</div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:220px;float:left;"><sup>Data de Vencimento parcela 1</sup><center><?=" ".dataUsatoBr($contrato->data_primeiro_pagamento)?></center></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:240px;float:left;"><sup>Valor em R$</sup><?=" ".number_format(($contrato->ato_valor),2,",",".")?></div>
        <? } ?>
        <? if($contrato->anuais_parcelas>0){ ?>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:80px;"><sup>Parcelas</sup><?= " ".$contrato->anuais_parcelas?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:150px;float:left;"><sup>Valor</sup><? if($contrato->anuais_parcelas!=0){echo number_format(($contrato->anuais_valor/$contrato->anuais_parcelas),2,",",".");}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>Periodicidade</sup>Anuais</div>
        <?
        	$data_anual=mysql_fetch_object(mysql_query($t="SELECT DATE_ADD( '".$contrato->data_primeiro_pagamento."', INTERVAL 1 YEAR ) as data FROM contrato"));
		?>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:220px;float:left;"><sup>Data de Vencimento parcela 1</sup><center><?=" ".DataUsatoBr($data_anual->data)?></center></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:240px;float:left;"><sup>Valor em R$</sup><?=" ".number_format(($contrato->anuais_valor),2,",",".")?></div>
		<? } ?>
        <? if($contrato->semestrais_parcelas>0){ ?>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:80px;"><sup>Parcelas</sup><?= " ".$contrato->semestrais_parcelas?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:150px;float:left;"><sup>Valor</sup><? if($contrato->semestrais_parcelas!=0){ echo number_format(($contrato->semestrais_valor/$contrato->semestrais_parcelas),2,",",".");}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>Periodicidade</sup>Semestrais</div>
        <?
        	$data_semestral=mysql_fetch_object(mysql_query("SELECT DATE_ADD( '".$contrato->data_primeiro_pagamento."', INTERVAL 6 MONTH ) as data FROM contrato"));
        ?>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:220px;float:left;"><sup>Data de Vencimento parcela 1</sup><center><?=DataUsatoBr($data_semestral->data)?></center></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:240px;float:left;"><sup>Valor em R$</sup><?=" ".number_format(($contrato->semestrais_valor),2,",",".")?></div>
        <? } ?>
        <? if($contrato->mensais_parcelas>0){ ?>
        <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:80px;"><sup>Parcelas</sup><?= " ".$contrato->mensais_parcelas?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:150px;float:left;"><sup>Valor</sup><? if($contrato->mensais_parcelas!=0){ echo " ".number_format(($contrato->mensais_valor/$contrato->mensais_parcelas),2,",",".");}?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>Periodicidade</sup>Mensais</div>
        <?
        	$data_mensal=mysql_fetch_object(mysql_query("SELECT DATE_ADD( '".$contrato->data_primeiro_pagamento."', INTERVAL 1 MONTH ) as data FROM contrato"));
        ?>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:220px;float:left;"><sup>Data de Vencimento parcela 1</sup><center><?=DataUsatoBr($data_mensal->data)?></center></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:240px;float:left;"><sup>Valor em R$</sup><?=" ".number_format(($contrato->mensais_valor),2,",",".")?></div>
        <? } ?>
        <? if($contrato->chave_parcelas>0){ ?>
         <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:80px;"><sup>Parcelas</sup><?= " ".$contrato->chave_parcelas?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:150px;float:left;"><sup>Valor</sup><? if($contrato->chave_parcelas!=0)" ".number_format(($contrato->chave_valor/$contrato->chave_parcelas),2,",",".")?></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:200px;float:left;"><sup>Periodicidade</sup>Chave</div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:220px;float:left;"><sup>Data de Vencimento parcela 1</sup> <center><?=dataUsaToBr($contrato->fim_empreendimento)?></center></div>
        <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;width:240px;float:left;"><sup>Valor em R$</sup><?=" ".number_format(($contrato->chave_valor),2,",",".")?></div>     	<? } ?>
    
    </div>
    <div class='texto' style="border-left:solid 1px; border-bottom:solid 1px;">
    … facultado ao preponente a recusa deste intrumento no prazo de 07 dias, mediante comunicacao, por escrito no endereco indicado nesta proposta. Neste caso o valor pago de sonal ser· ao proponente.
    Caso o preponente n"o manifeste no praxo determinado presumir· aceita a presente proposta, devendo o mesmo comprarecer na sede.
    </div>
    <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:300px;"></div>
    <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:596px;"><sup>Proponente</sup><?=" ".$contrato->cliente?></div>
    
    <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:898px;height:100px;"><sup>Informacoes Complementares</sup></div>
    
    <div style="height:40px;float:left;border-left:solid 1px; border-bottom:solid 1px;width:340px;"><sup>Consultor(a)</sup><?=" ".$contrato->corretor?></div>
    <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:340px;"><sup>Gerente</sup></div>
    <div style="height:40px;border-left:solid 1px; border-bottom:solid 1px;float:left;width:214px;"><sup>Imobiliaria</sup><?= " ".$contrato->imobiliaria;?></div>
</div>
<?php
	//}
 ?>
</body>
</html>
