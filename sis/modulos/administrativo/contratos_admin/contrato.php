<?
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 

?>
<div style="width:850px; margin:0 auto 0 auto"> 
<h2>Contrato Particular de Promessa de  Compra e Venda de Im&oacute;vel</h2>
<p align="JUSTIFY"><strong><?=$empresa[nome]?></strong>,  nacionalidade, estado civil, profiss&atilde;o, CNPJ n&ordm; <?=$empresa[cnpj]?>
  ,  residentes e domiciliados &agrave; rua <?=$empresa[endereco]?>, bairro  <?=$empresa[bairro]?>, na cidade de <?=$empresa[cidade]?> - <?=$empresa[estado]?>, CEP <?=$empresa[cep]?>, a seguir denominados  simplesmente <strong>VENDEDORES</strong>, e de outro lado <strong><?=$cliente->razao_social ?></strong>, nacionalidade, estado civil, profiss&atilde;o, CPF n&ordm;  <?=$cliente->cnpj_cpf ?> c&eacute;dula de identidade n&ordm; <?=$cliente->rg?> expedida por ????, e sua mulher  ????????, estado civil, profiss&atilde;o, portadora do CPF n&ordm; ?????, c&eacute;dula de  identidade de n&ordm; ??? expedida por ???, residentes e domiciliados &agrave; rua  ????, bairro ?????, na cidade de ?????, CEP ?????, a seguir denominados  simplesmente <strong>COMPRADORES</strong>, mediante cl&aacute;usulas reciprocamente estipuladas, aceitas e a seguir articuladas:</p>
<strong>
<p align="JUSTIFY">I. 	OBJETO DA COMPRA E VENDA</p>
</strong>
<p align="JUSTIFY">&Eacute;  objeto da presente Promessa de Compra e Venda o im&oacute;vel constitu&iacute;do pelo  (casa/lotes/apartamento) de n&uacute;mero ???, sito &agrave; rua ???, no bairro ????,  matr&iacute;cula de n&ordm; <?=$disponibilidade_tipo->nome?>  (<?=$disponibilidade->identificacao ?>), constante do Cart&oacute;rio do ????? Of&iacute;cio de Registro  de Im&oacute;veis de Manaus, livre e desembara&ccedil;ado de quaisquer &ocirc;nus ou  gravame. </p>
<strong>
<p align="JUSTIFY">II. 	PRE&Ccedil;O</p>
</strong>
<p align="JUSTIFY">Pela compra e venda prometida os <strong>COMPRADORES</strong> pagar&atilde;o aos <strong>VENDEDORES</strong> a import&acirc;ncia total de R$ <?=moedaUsaToBr($contrato->valor)?> 
 da seguinte forma e condi&ccedil;&otilde;es:</p>
<ol>
  <ol>
  </ol>
</ol>
<dir> <dir>
<ol>

    <? 
	$q = mysql_query("SELECT * FROM faturas WHERE contrato_id='$_GET[id]' ORDER BY data_vencimento ");
	while($r=mysql_fetch_object($q)){
	?><li>R$  <?=$r->valor?> em moeda corrente (<?=$r->descricao?>) a ser pago na data <?=dataUsaToBr($r->data_vencimento) ?></li>
    <?
	}
	
	?>
</ol>
</dir></dir> <strong>
<p align="JUSTIFY">III. 	ARREPENDIMENTO</p>
</strong>
<p align="JUSTIFY">A  presente promessa de compra e venda &eacute; pactuada com expressa ren&uacute;ncia de  arrependimento, obrigando as partes seus herdeiros e sucessores, e  responder&atilde;o os <strong>VENDEDORES</strong> pela evic&ccedil;&atilde;o de direitos.</p>
<strong>
<p align="JUSTIFY">IV. 	POSSE E ESCRITURA</p>
</strong>
<p align="JUSTIFY">Os <strong>COMPRADORES</strong> ficam autorizados a ocupar o im&oacute;vel a partir desta data, mas somente  ser&atilde;o imitidos na posse definitiva do im&oacute;vel a partir da data do  pagamento integral da Compra e Venda e seus consect&aacute;rios, oportunidade  em que os <strong>VENDEDORES</strong> outorgar&atilde;o a competente escritura e dar&atilde;o quita&ccedil;&atilde;o total pela compra e venda ora pactuada.</p>
<strong>
<p align="JUSTIFY">V.	DESPESAS</p>
</strong>
<p align="JUSTIFY">Ser&atilde;o suportadas pelos <strong>COMPRADORES</strong>,  a partir desta data, as despesas de condom&iacute;nio, luz, impostos, seguros  etc. relativamente ao im&oacute;vel objeto desta Promessa de Compra e Venda,  bem como as despesas futuras com a escritura e registro.
  <strong>
  </strong></p>
<strong>
<p align="JUSTIFY">VI.	MULTA DE MORA </p>
</strong>
<p align="JUSTIFY">O  atraso nos pagamentos da parcelas restantes implicar&aacute; na multa  morat&oacute;ria de ??% (????), mais juros morat&oacute;rios de 1% (um por cento)  incidente sobre o d&eacute;bito devidamente corrigido.</p>
<strong>
<p align="JUSTIFY">VII.	RESCIS&Atilde;O </p>
</strong>
<p align="JUSTIFY">Na  hip&oacute;tese do im&oacute;vel n&atilde;o ser integralmente quitado dentro do prazo  previsto, e depois de considerada uma toler&acirc;ncia de 30 (trinta) dias,  poder&atilde;o os <strong>VENDEDORES</strong> dar por rescindido o presente contrato,  proceder a venda do im&oacute;vel a terceiros e, depois de deduzir o valor da  multa e consect&aacute;rios da rescis&atilde;o, restituir o saldo que houver para os <strong>COMPRADORES</strong>.</p>
<strong>
<p align="JUSTIFY">VIII.	MULTA DE RESCIS&Atilde;O</p>
</strong>
<p align="JUSTIFY">O  n&atilde;o cumprimento de quaisquer das cl&aacute;usulas pactuadas que ensejar o  desfazimento do presente neg&oacute;cio implica na multa igual a ??% (????)  sobre o valor total da transa&ccedil;&atilde;o, a ser pago pela parte infratora &agrave;  parte inocente, devidamente corrigidos a partir da assinatura deste  instrumento, sem preju&iacute;zo das perdas e danos a apurar-se em procedimento  pr&oacute;prio.</p>
<strong>
<p align="JUSTIFY">IX.	BENFEITORIAS</p>
</strong>
<p align="JUSTIFY">As benfeitorias eventualmente realizadas pelos <strong>COMPRADORES</strong> at&eacute; a efetiva quita&ccedil;&atilde;o do im&oacute;vel ser&atilde;o incorporadas ao im&oacute;vel, n&atilde;o  gerando qualquer direito de indeniza&ccedil;&atilde;o ou reten&ccedil;&atilde;o na hip&oacute;tese de  rescis&atilde;o do presente contrato.</p>
<strong>
<p align="JUSTIFY">X.	FORO </p>
</strong>
<p align="JUSTIFY">Para  dirimir eventuais d&uacute;vidas sobre a interpreta&ccedil;&atilde;o das cl&aacute;usulas  pactuadas, nomeiam os contratantes o foro da comarca de ?????.</p>
<p align="JUSTIFY">E  por estarem justos e contratados mandaram lavrar o presente contrato em  duas vias de igual teor e forma, que assinam na presen&ccedil;a de duas  testemunhas, para que produza seus jur&iacute;dicos e legais efeitos.</p>
<p align="JUSTIFY"> Cidade, data </p>
<strong></strong>
<p align="JUSTIFY"><strong>VENDEDORES</strong>:</p>
<p align="JUSTIFY"> _____________________________________</p>
<p align="JUSTIFY"> </p>
<strong></strong>
<p align="JUSTIFY"><strong>COMPRADORES</strong>:</p>
<p align="JUSTIFY"> _____________________________________ </p>
<p align="JUSTIFY">&nbsp;</p>
<p align="JUSTIFY">Testemunhas:</p>
<p align="JUSTIFY">_____________________________________</p>
<p align="JUSTIFY">_____________________________________</p>
</div>