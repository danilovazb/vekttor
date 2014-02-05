<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo Vekttor</title>
<?
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
// funçoes do modulo interesses
include("_functions.php");
// funçoes do modulo interesses
include("_ctrl.php"); 

?>
<style type="text/css">
.conteudo{
	font-size:20px;
}
.texto{
	font-size:9px;
}
.campos {
	font-size:13px;
	font:bold;
	background:#999;
	text-align:center;
}
table.bordasimples {border-collapse: collapse;}
table.bordasimples tr td {border:2px solid #000;}
</style>
</head>

<body>
<?php
	//while($contrato=mysql_fetch_object($contratos)){
  		//$cont++;
?>
<div style="margin:0 auto 0 auto;width:900px;"> 
	<div id="logomarca" style="float:left;background-color:white;height:35px;width:200px;">
    Logomarca
    </div>
    <div style="height:33px;background-color:#999;border:solid 1px #000;color:#FFFFFF;">
    	<center>
    	FICHA DE ATENDIMENTO AO CLIENTE/ ANEXO DA PROPOSTA
    	</center>
    </div>
    <div style="margin-top:20px;" class="campos">
    	<div style="height:20px;float:left;border:solid 1px;width:550px;">Nome Completo</div>
        <div style="height:20px;border:solid 1px ;float:left;width:200px;">Data</div>
        <div style="height:20px;border:solid 1px ;">Hora</div>
    </div>
    <div>
        <div style="height:30px;float:left;border:solid 1px;width:550px;"><?=" ".$r->nome?></div>
        <div style="height:30px;border:solid 1px ;float:left;width:200px;"><center><?=DataUsaToBr($r->data)?></center></div>
        <div style="height:30px;border:solid 1px ;"><?=$r->hora?></div>
    </div>
    
     <div style="height:20px;float:left;border:solid 1px;width:752px;" class="campos">Endereco</div>
     <div style="height:20px;border:solid 1px;" class="campos">Nº</div>
     <div style="height:30px;float:left;border:solid 1px;width:752px;"><center><?=$r->endereco?></center></div>
     <div style="height:30px;border:solid 1px ;"><center><?=$r->numero?></center></div>
     
     <div style="height:20px;float:left;border:solid 1px;width:250px;" class="campos">Complemento</div>
     <div style="height:20px;border:solid 1px;width:250px;float:left;" class="campos">Bairro</div>
     <div style="height:20px;float:left;border:solid 1px;width:248px;"  class="campos">Cidade</div>
     <div style="height:20px;border:solid 1px ;width:50px;float:left"  class="campos">Estado</div>
     <div style="height:20px;border:solid 1px ;width:91px;float:left"  class="campos">CEP</div>
     <div style="height:30px;float:left;border:solid 1px;width:250px;"><center><?=$r->complemento?></center></div>
     <div style="height:30px;border:solid 1px;width:250px;float:left;"><?=$r->bairro?></div>
     <div style="height:30px;float:left;border:solid 1px;width:248px;"><?=$r->cidade?></div>
     <div style="height:30px;border:solid 1px ;width:50px;float:left"><?=$r->estado?></div>
     <div style="height:30px;border:solid 1px ;width:91px;float:left"><?=$r->cep?></div>
     
     <div style="height:20px;float:left;border:solid 1px;width:250px;" class="campos">e-mail</div>
     <div style="height:20px;border:solid 1px;width:250px;float:left;" class="campos">Telefone Residencial</div>
  <div style="height:20px;float:left;border:solid 1px;width:225px;"  class="campos">Celular/</div>
  <div style="height:20px;border:solid 1px ;width:166px;float:left"  class="campos">Telefone Comercial</div>
  <div style="height:30px;float:left;border:solid 1px;width:250px;"><center><?=$r->email?></center></div>
  <div style="height:30px;border:solid 1px;width:250px;float:left;"><center><?=$r->telefone_residencial?></center></div>
  <div style="height:30px;float:left;border:solid 1px;width:225px;"><center><?=$r->telefone_comercial?></center></div>
  <div style="height:30px;border:solid 1px ;width:166px;float:left"><center><?=$r->telefone_comercial?></center></div>    

<div style="clear:both">
   	<table width="100%" class="bordasimples">
  <tr class="campos">
    <td colspan="10" align="center">Onde voc&ecirc; viu a propaganda do nosso empreendimento?  </td>
    </tr>
  <tr class="campos">
    <td colspan="4">Idade</td>
    <td colspan="2">Estado Civil</td>
    <td colspan="2">Sexo</td>
    <td colspan="2">Grau de Instru&ccedil;&atilde;o</td>
    </tr>
  <tr align="right">
    <td width="7%">Bandeira</td>
    <td width="3%" align="center"> <? if($r->propaganda=='bandeira'){echo 'X';}?></td>
    <td width="15%">E-mail Marketing</td>
    <td width="3%" align="center"><? if($r->propaganda=='email'){echo 'X';}?></td>
    <td width="17%">Mala Direta</td>
    <td width="4%" align="center"><? if($r->propaganda=='cavalete'){echo 'X';}?></td>
    <td width="12%">Shopping</td>
    <td width="5%"><? if($r->propaganda=='shopping'){echo 'X';}?></td>
    <td width="19%">Carro de Som / Busdoor</td>
    <td width="11%"align="center"><? if($r->propaganda=='carro'){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td width="7%">Carreata</td>
    <td width="3%" align="center"><? if($r->propaganda=='carreata'){echo 'X';}?></td>
    <td width="15%">Cavalete</td>
    <td width="3%" align="center"><? if($r->propaganda=='cavalete'){echo 'X';}?></td>
    <td width="17%">Consultor</td>
    <td width="4%" align="center"><? if($r->propaganda=='consultor'){echo 'X';}?></td>
    <td width="12%">Indica&ccedil;&atilde;o</td>
    <td width="5%" align="center"><? if($r->propaganda=='indicacao'){echo 'X';}?></td>
    <td width="19%">Internet</td>
    <td width="11%"align="center"><? if($r->propaganda=='internet'){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td>Panfleto</td>
    <td align="center"><? if($r->propaganda=='panfleto'){echo 'X';}?></td>
    <td>Jornal</td>
    <td align="center"><? if($r->propaganda=='jornal'){echo 'X';}?></td>
    <td>Stand</td>
    <td align="center"><? if($r->propaganda=='stand'){echo 'X';}?></td>
    <td><? if($r->propaganda=='outdoor'){echo 'X';}?></td>
    <td>&nbsp;</td>
    <td>TV</td>
    <td align="center"><? if($r->propaganda=='tv'){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td>Escrit&oacute;rio</td>
    <td align="center"><? if($r->propaganda=='escritorio'){echo 'X';}?></td>
    <td>Outros</td>
    <td colspan="8" align="left"><? if($r->propaganda=='outro'){echo $r->outra_propaganda;}?></td>
    </tr>
</table>
 
 </div>

<div style="clear:both">
   	<table width="100%" class="bordasimples">
  <tr class="campos">
    <td colspan="10" align="center">Mais Dados</td>
    </tr>
  <tr class="campos">
    <td colspan="4">Idade</td>
    <td colspan="2">Estado Civil</td>
    <td colspan="2">Sexo</td>
    <td colspan="2">Grau de Instru&ccedil;&atilde;o</td>
    </tr>
  <tr align="right">
    <td width="10%">Menos de 20</td>
    <td width="5%" align="center"> <? if($r->faixa_idade=='20 a 25'){echo 'X';}?></td>
    <td width="13%">20 a 25</td>
    <td width="5%" align="center"><? if($r->faixa_idade=='20 a 25'){echo 'X';}?></td>
    <td width="18%">Solteiro (a)</td>
    <td width="5%" align="center"><? if($r->estado_civil=='solteiro'){echo 'X';}?></td>
    <td width="13%">Feminino</td>
    <td width="6%"><? if($r->sexo=='feminino'){echo 'X';}?></td>
    <td width="20%">N&atilde;o Alfabetizado</td>
    <td width="5%"align="center"><? if($r->grau_instrucao=='Nao Alfabetizado'){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td width="10%">26 a 30</td>
    <td width="5%" align="center"><? if($r->faixa_idade=='26 a 30'){echo 'X';}?></td>
    <td width="13%">31 a 35</td>
    <td width="5%" align="center"><? if($r->faixa_idade=='31 a 35'){echo 'X';}?></td>
    <td width="18%">Noivo (a)</td>
    <td width="5%" align="center"><? if($r->estado_civil=='noivo'){echo 'X';}?></td>
    <td width="13%">Masculino</td>
    <td width="6%" align="center"><? if($r->sexo=='masculino'){echo 'X';}?></td>
    <td width="20%">Ensino Fundamental</td>
    <td width="5%"align="center"><? if($r->grau_instrucao=='Ensino Fundamental'){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td>36 a 40</td>
    <td align="center"><? if($r->faixa_idade=='36 a 40'){echo 'X';}?></td>
    <td>41 a 45</td>
    <td align="center"><? if($r->faixa_idade=='41 a 45'){echo 'X';}?></td>
    <td>Casado(a)</td>
    <td align="center"><? if($r->estado_civil=='casado'){echo 'X';}?></td>
    <td colspan="2" rowspan="3">&nbsp;</td>
    <td>Ensino M&eacute;dio</td>
    <td align="center"><? if($r->grau_instrucao=='Ensino Médio'){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td>45 a 50</td>
    <td align="center"><? if($r->faixa_idade=='45 a 50'){echo 'X';}?></td>
    <td>51 a 60</td>
    <td align="center"><? if($r->faixa_idade=='51 a 60'){echo 'X';}?></td>
    <td>Uni&atilde;o Est&aacute;vel(a)</td>
    <td align="center"><? if($r->estado_civil=='uniao estavel'){echo 'X';}?></td>
    <td align="right">Superior</td>
    <td><? if($r->grau_instrucao=='Superior'){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td>56 a 60</td>
    <td align="center"><? if($r->faixa_idade=='56 a 60'){echo 'X';}?></td>
    <td>Acima de 60</td>
    <td align="center"><? if($r->faixa_idade=='Acima de 60'){echo 'X';}?></td>
    <td>Vi&uacute;vo</td>
    <td align="center"><? if($r->estado_civil=='viuvo'){echo 'X';}?></td>
    <td>Especializa&ccedil;&otilde;es</td>
    <td align="center"><? if($r->grau_instrucao=='Especializações'){echo 'X';}?></td>
  </tr>
</table>
 
 </div>
  <div style="clear:both">
   	<table width="100%" class="bordasimples">
  <tr class="campos">
    <td colspan="4">Profiss&atilde;o</td>
    <td colspan="4">Renda Familiar</td>
    <td colspan="2">Possui Filhos</td>
    </tr>
  <tr align="right">
    <td colspan="4" rowspan="6">&nbsp;</td>
    <td width="23%">At&eacute; R$1.500,00</td>
    <td width="5%"><? if($r->renda_familiar=='1500'){echo 'X';}?></td>
    <td width="17%">R$ 5.001 a R$ 6.000</td>
    <td width="5%"><? if($r->renda_familiar=='5001-6000'){echo 'X';}?></td>
    <td width="11%">Sim</td>
    <td width="11%" align="center"><? if($r->filhos>0){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td>R$ 1.500,00 a R$2.000,00</td>
    <td><? if($r->renda_familiar=='1500-2000'){echo 'X';}?></td>
    <td>R$ 6.001 a R$ 7.000</td>
    <td><? if($r->renda_familiar=='6001-7000'){echo 'X';}?></td>
    <td>N&atilde;o</td>
    <td align="center"><? if($r->filhos==0){echo 'X';}?></td>
  </tr>
  <tr align="right">
    <td>R$ 2001,00 a R$3.000,00</td>
    <td><? if($r->renda_familiar=='2001-3000'){echo 'X';}?></td>
    <td>R$ 7.001 a R$ 8.000</td>
    <td><? if($r->renda_familiar=='7001-8000'){echo 'X';}?></td>
    <td colspan="2" align="center">Quantos?</td>
    </tr>
  <tr align="right">
    <td>R$ 3.001,00 a R$4.000,00</td>
    <td><? if($r->renda_familiar=='3001-4000'){echo 'X';}?></td>
    <td>R$ 8.001 a R$ 9.000</td>
    <td><? if($r->renda_familiar=='8001-9000'){echo 'X';}?></td>
    <td colspan="2" align="center"><?=$r->filhos?></td>
    </tr>
  <tr align="right">
  	<td>R$ 4.001,00 a R$5.000,00</td>
    <td><? if($r->renda_familiar=='4001-5000'){echo 'X';}?></td>
    <td>R$ 9.001 a R$ 10.000</td>
    <td><? if($r->renda_familiar=='9001-10000'){echo 'X';}?></td>
    <td colspan="2" rowspan="2">&nbsp;</td>
    <tr align="right">
    <td colspan="2"></td>
    <td>Acima de R$ 10.000</td>
    <td><? if($r->renda_familiar=='10000'){echo 'X';}?></td>
    </tr>
</table>
 
 </div>
  
   <div style="height:20px;float:left;border:solid 1px;width:250px;" class="campos">Possui Computador em casa?</div>
    <div style="height:20px;border:solid 1px;width:250px;float:left;" class="campos">Possui acesso a Internet?</div>
    <div style="height:20px;float:left;border:solid 1px;width:250px;"  class="campos">Já acessou o site da NV?</div>
    <div style="height:20px;border:solid 1px ;width:142px;float:left"  class="campos">Sua residência é:</div>

    <div style="height:20px;float:left;border:solid 1px;width:198px;">Sim</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><center><? if($r->computador=='sim'){echo 'X';}?></center></div>
     <div style="height:20px;float:left;border:solid 1px;width:198px;">Sim</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><center><? if($r->computador=='sim'){echo 'X';}?></center></div>
     <div style="height:20px;float:left;border:solid 1px;width:198px;">Sim</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><center><? if($r->computador=='sim'){echo 'X';}?></center></div>
	<div style="height:20px;float:left;border:solid 1px;width:90px;">Alugada</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><center><? if($r->residencia=='Alugada'){echo 'X';}?></center></div>
    <div style="height:20px;float:left;border:solid 1px;width:198px;">Nao</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><center><? if($r->computador=='nao'){echo 'X';}?></center></div>
     <div style="height:20px;float:left;border:solid 1px;width:198px;">Nao</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><center><? if($r->computador=='nao'){echo 'X';}?></center></div>
     <div style="height:20px;float:left;border:solid 1px;width:198px;">Nao</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><center><? if($r->computador=='nao'){echo 'X';}?></center></div>
  <div style="height:20px;float:left;border:solid 1px;width:90px;">Pais/Parentes</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><? if($r->residencia=='Pais/Parentes'){echo 'X';}?></center></div>
     <div style="height:20px;float:left;border:solid 1px;width:90px;margin-left:756px;">Própria/Quitada</div>
    <div style="height:20px;border:solid 1px ;width:50px;float:left"><? if($r->residencia=='Própria/Quitada'){echo 'X';}?></div>
      <div style="height:20px;float:left;border:solid 1px;width:90px;margin-left:756px;">Outros</div>
  <div style="height:20px;border:solid 1px ;width:50px;float:left;"><? if($r->residencia=='Outros'){echo 'X';}?></div>
    <div style="float:left;">
    	<table width="900" class="bordasimples">
  <tr class="campos">
    <td colspan="3">N&ordm; de quartos que deseja</td>
    <td colspan="2">Finalidade da Compra</td>
    <td colspan="4">Faixa de Pre&ccedil;os de Interesse</td>
    </tr>
  <tr>
    <td width="107" rowspan="3">&nbsp;</td>
    <td width="78"><div align="right">1 Quarto</div></td>
    <td width="34" align="center"><? if($r->qtd_quartos=='1'){echo 'X';}?></td>
    <td width="163"><div align="right">Uso Pr&oacute;prio</div></td>
    <td width="34"><? if($r->finalidade_compra=='uso proprio'){echo 'X';}?></td>
    <td width="183"><div align="right">At&eacute; R$ 100.000</div></td>
    <td width="34"><? if($r->faixa_interesse=='100000'){echo 'X';}?></td>
    <td width="170"><div align="right">R$ 200.001 a R$ 250.000</div></td>
    <td width="45"><? if($r->faixa_interesse=='200001 a 250000'){echo 'X';}?></td>
  </tr>
  <tr>
    <td align="right">2 Quartos</td>
    <td align="center"><? if($r->qtd_quartos=='2'){echo 'X';}?></td>
    <td><div align="right">Investimento</div></td>
    <td><? if($r->finalidade_compra=='investimento'){echo 'X';}?></td>
    <td><div align="right">R$ 100.001 a R$150.000</div></td>
    <td><? if($r->faixa_interesse=='100001 a 150000'){echo 'X';}?></td>
    <td><div align="right">R$ 250.001 a R$ 300.000</div></td>
    <td><? if($r->faixa_interesse=='250001 a 300000'){echo 'X';}?></td>
  </tr>
  <tr>
    <td><div align="right">3 Quartos</div></td>
    <td><? if($r->qtd_quartos=='3'){echo 'X';}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right">R$ 150.001a R$200.000</div></td>
    <td><? if($r->faixa_interesse=='150001 a 200000'){echo 'X';}?></td>
    <td><div align="right">Acima de 300.001</div></td>
    <td><? if($r->faixa_interesse=='Acima de 300000'){echo 'X';}?></td>
  </tr>
</table>

    </div>
    <div style="height:20px;float:left;border:solid 1px;width:897px;" class="campos">Possui interesse em outra Regiões / Cidades</div>
    <div style="float:left;">
      	<table width="900" class="bordasimples">
  <tr>
    <td width="78" height="23" align="right">N&atilde;o
      <div align="right"></div></td>
    <td width="34" align="center"><? if($r->interesse_regioes=='outro'){echo 'X';}?></td>
    <td width="78" align="right">Sim</td>
    <td width="67" align="center"><? if($r->interesse_regioes=='sim'){echo 'X';}?></td>
    <td width="609" align="left">Quais?<? if($r->interesse_regioes=='outro'){echo ' '.$r->outra_regiao;}?></td>
    </tr>
</table>

    </div>
        <div style="height:20px;float:left;border:solid 1px;width:897px;" class="campos">Qual é a característica mais importante para a aquisição de um imóvel? Marque somente uma opção</div>
    <div style="float:left;">
	<table width="900" class="bordasimples">
  <tr  align="right">
    <td width="169" height="23">Banheiro de Empregada
      </td>
    <td width="34"><? if($r->caracteristica_imovel=='Banheiro de Empregada'){echo 'X';}?></td>
    <td width="104">Lazer Completo</td>
    <td width="34"><? if($r->caracteristica_imovel=='Lazer Completo'){echo 'X';}?></td>
    <td width="195">Quantidade de Acabamento</td>
    <td width="34"><? if($r->caracteristica_imovel=='Quantidade de Acabamento'){echo 'X';}?></td>
    <td width="200">Solidez da Contrutora</td>
    <td width="34"><? if($r->caracteristica_imovel=='Solidez da Contrutora'){echo 'X';}?></td>
    </tr>
      <tr  align="right">
    <td width="169" height="23">Despensa</td>
    <td width="34"><? if($r->caracteristica_imovel=='Despensa'){echo 'X';}?></td>
    <td width="104">Localização</td>
    <td width="34"><? if($r->caracteristica_imovel=='Localização'){echo 'X';}?></td>
    <td width="195">Quarto de Empregada</td>
    <td width="34"><? if($r->caracteristica_imovel=='Quarto de Empregada'){echo 'X';}?></td>
    <td width="200">Vaga de Garagem</td>
    <td width="34"><? if($r->caracteristica_imovel=='Vaga de Garagem'){echo 'X';}?></td>
    </tr>
      <tr  align="right">
    <td width="169" height="23">Forma de Pagamento</td>
    <td width="34"><? if($r->caracteristica_imovel=='Forma de Pagamento'){echo 'X';}?></td>
    <td width="104">Prazo de Entrega</td>
    <td width="34"><? if($r->caracteristica_imovel=='Prazo de Entrega'){echo 'X';}?></td>
    <td width="195">Su&iacute;tes</td>
    <td width="34"><? if($r->caracteristica_imovel=='Suítes'){echo 'X';}?></td>
    <td width="200">Área Contruível</td>
    <td width="34"><? if($r->caracteristica_imovel=='Área Contruível'){echo 'X';}?></td>
    </tr>
    <tr>
    <td colspan="8">Outros: <? if($r->caracteristica_imovel=='outro'){echo $r->outra_caracteristica;}?></td>
    </tr>
   </table>
   </div>
       <div style="height:20px;float:left;border:solid 1px;width:897px;" class="campos">Faltou algo para fechar o negócio?</div>
    <div style="float:left;">
<table width="900" class="bordasimples">
  <tr  align="right">
    <td width="178" height="23">Fechou Neg&oacute;cio, comprou</td>
    <td width="34" align="center"><? if($r->fecha_negocio=='Fechou Negócio, comprou'){echo 'X';}?></td>
    <td width="224">Não encontrou o que procurava</td>
    <td width="34" align="center"><? if($r->fecha_negocio=='Não encontrou'){echo 'X';}?></td>
    <td width="177">Condições de pagamento</td>
    <td width="34" align="center"><? if($r->fecha_negocio=='Condicoes Pagamento'){echo 'X';}?></td>
    <td width="131">Continua Procurando</td>
    <td width="34" align="center"><? if($r->fecha_negocio=='Continua Procurando'){echo 'X';}?></td>
    </tr>
    <tr>
    <td colspan="8">Outra Opção:<? if($r->fecha_negocio=='outro'){echo $r->outro_negocio;}?></td>
    </tr>
   </table>
   </div>
       <div style="float:left;">
	<table width="900" class="bordasimples">
  <tr class="campos">
  <td colspan="8">Como foi o atendimento?</td>
  </tr>
  <tr  align="right">
    <td width="178" height="23">&Oacute;timo</td>
    <td width="34" align="center"><? if($r->avaliacao_atendimento=='otimo'){echo 'X';}?></td>
    <td width="224">Bom</td>
    <td width="34" align="center"><? if($r->avaliacao_atendimento=='bom'){echo 'X';}?></td>
    <td width="177">Regular</td>
    <td width="34" align="center"><? if($r->avaliacao_atendimento=='regular'){echo 'X';}?></td>
    <td width="131">Ruim</td>
    <td width="36" align="center"><? if($r->avaliacao_atendimento=='ruim'){echo 'X';}?></td>
    </tr>
    <tr  align="right">
    <td width="178" height="23">Consultor</td>
    <td colspan="3" align="left"><?="&nbsp;&nbsp;".$r->consultor?></td>
    <td width="177">Coordenador</td>
    <td colspan="3" align="left"><?="&nbsp;&nbsp;".$r->coordenador?></td>
    </tr>
    <tr height="20px;">
    <td colspan="8"><strong>Observa&ccedil;&otilde;es</strong><?="&nbsp;&nbsp;".$r->observacoes?></td>
    </tr>
  </table>
   </div>      
</div>
</body>
</html>
