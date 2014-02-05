<?
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

//include("_functions.php");
include("_ctrl.php"); 
/*
$contrato = mysql_fetch_object(mysql_query($t="select 
c.nome_contato as cliente, c.naturalidade, c.nacionalidade, c.ramo_atividade, c.endereco_comercial, c.telefone_comercial, 
c.telefone1 as telefone1, c.telefone2 as telefone2, 
c.nascimento as data_nascimento, c.cnpj_cpf as cpf, c.rg as rg, c.local_emissao, c.data_emissao,
c.endereco as endereco, c.bairro as bairro, c.cidade as cidade, c.estado as estado, c.cep as cep, c.email as email, c.estado_civil as estado_civil,
c.conjugue_nome, c.conjugue_ramo_atividade, c.conjugue_cpf, c.conjugue_rg, c.conjugue_local_emissao, c.conjugue_telefone, c.conjugue_data_nascimento,c.conjugue_data_emissao,
c.conjugue_email, c.conjugue_naturalidade, c.conjugue_nacionalidade, c.conjugue_endereco_comercial, c.conjugue_telefone_comercial,     
f.valor as valor, f.valor_comissao, f.valor_contrato, f.ato_valor, f.ato_parcelas, f.anuais_valor, f.anuais_parcelas, f.semestrais_valor, f.semestrais_parcelas, f.mensais_parcelas, f.mensais_valor,
f.chave_parcelas, f.chave_valor, f.data_primeiro_pagamento, 
d.identificacao as disponibilidade,
e.nome as empreendimento, e.fim, e.tipo as tipo,
n.nome as negociacao,
cor.nome as corretor
from 
cliente_fornecedor as c, contrato as f, disponibilidade as d, empreendimento as e, negociacao as n, corretor as cor where 
f.id='".$id."' AND f.cliente_fornecedor_id=c.id and f.disponibilidade_id = d.id AND f.negociacao_id=n.id AND f.corretor_id=cor.id
AND d.empreendimento_id=e.id"));
//echo $t;
*/
$contrato=mysql_fetch_object(mysql_query("SELECT * FROM contrato WHERE id='$id'"));
$empreendimento=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='{$contrato->empreendimento_id}'"));
$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='{$contrato->disponibilidade_id}'"));
$disponibilidade_tipo=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade_tipo WHERE id='{$disponibilidade->disponibilidade_tipo_id}'"));
$negociacao=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='{$contrato->negociacao_id}'"));
$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='{$contrato->cliente_fornecedor_id}'"));
$corretor=mysql_fetch_object(mysql_query($o="SELECT * FROM corretor WHERE id='{$contrato->corretor_id}'"));
?>
<div style="width:850px; margin:0 auto 0 auto">
<p align="justify"><strong>CONTRATO  PARTICULAR DE PROMESSA DE COMPRA E VENDA DE UNIDADE AUT&Ocirc;NOMA</strong></p>
<p align="justify">Por  este <strong>CONTRATO PARTICULAR DE PROMESSA  DE COMPRA E VENDA DE UNIDADE AUT&Ocirc;NOMA</strong>, as partes abaixo mencionadas  t&ecirc;m entre si, ajustadas e contratadas, em car&aacute;ter irrevog&aacute;vel a presente  promessa de compra e venda, conforme segue:</p>
<p align="justify"><strong>1 &ndash; Promiss&aacute;rio  Vendedor: </strong></p>
<p align="justify"><strong><?= $contrato->empreendimento?></strong>, inscrita no CNPJ n&ordm; <?=$contrato->cnpj?>, com sede na  cidade de <?= $contrato->cidade?>, situada no(a) <?= $contrato->logradouro?>, <?= $contrato->bairro." ".$contrato->complemento?>, neste ato representada por seu s&oacute;cio administrador <?= $contrato->administrador.", ".$contrato->profissao.", ".$contrato->est_civil_adm ?>, portador da Carteira de Identidade n&ordm;. <?= $contrato->rg_adm."/".$contrato->orgao_adm?>, e CPF/MF n&ordm;.  <?= $contrato->cpf_adm?>, residente e domiciliado nesta cidade no(a) <?= $contrato->endereco_adm.", ".$contrato->bairro_adm?> </p>
<p align="justify"><strong>2 &ndash; Promiss&aacute;rio(s)  Comprador(es):</strong></p>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td width="578" colspan="7" valign="top"><p>Nome: <?= $cliente->nome_contato?></p></td>
    </tr>
    <tr>
      <td width="247" colspan="3" valign="top"><p>Estado    Civil: <?= $cliente->estado_civil?></p></td>
      <td width="331" colspan="4" valign="top"><p>Data de    Nascimento: <?= DataUsaToBr($cliente->nascimento)?></p></td>
    </tr>
    <tr>
      <td width="247" colspan="3" valign="top"><p>Nacionalidade:   <?= $cliente->nacionalidade?></p></td>
      <td width="331" colspan="4" valign="top"><p>Profiss&atilde;o:    <?= $cliente->ramo_atividade?></p></td>
    </tr>
    <tr>
      <td width="205" colspan="2" valign="top"><p>Identidade:    <?= $cliente->rg ?></p></td>
      <td width="198" colspan="3" valign="top"><p>&Oacute;rg&atilde;o    Emissor: <?=$cliente->local_emissao?></p></td>
      <td width="175" colspan="2" valign="top"><p>C.P.F: <?= $cliente->cpf ?></p></td>
    </tr>
    <tr>
      <td width="578" colspan="7" valign="top"><p>Endere&ccedil;o    <?=$cliente->endereco_comercial?></p></td>
    </tr>
    <tr>
      <td width="247" colspan="3" valign="top"><p>Bairro: <?= $cliente->bairro?></p></td>
      <td width="198" colspan="3" valign="top"><p>Cidade: <?= $cliente->cidade?></p></td>
      <td width="133" valign="top"><p>UF.: <?=$cliente->estado?></p></td>
    </tr>
    <tr>
      <td width="181" valign="top"><p>CEP:    <?=$contrato->cep?></p></td>
      <td width="204" colspan="3" valign="top"><p>Telefone    1: <?=$cliente->telefone1?></p></td>
      <td width="193" colspan="3" valign="top"><p>Telefone    2: <?=$cliente->telefone2?></p></td>
    </tr>
    <tr>
      <td colspan="6" valign="top"><p>Endere&ccedil;o    Comercial: <?=$cliente->endereco_comercial?></p></td>
      <td valign="top"><p>Telefone Comercial: <?=$cliente->telefone_comercial?></p></td>
    </tr>
  </table>
<p align="justify"><strong>C&ocirc;njuge</strong></p>
<p align="justify"><strong>3 &ndash; Da Incorpora&ccedil;&atilde;o</strong></p>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="578" colspan="7" valign="top"><p>Nome: <?= $cliente->conjugue_nome?></p></td>
  </tr>
  <tr>
    <td width="247" colspan="3" valign="top"><p>Estado    Civil: <?= $cliente->conjugue_estado_civil?></p></td>
    <td width="331" colspan="4" valign="top"><p>Data de    Nascimento: <?= $cliente->connjugue_data_nascimento?></p></td>
  </tr>
  <tr>
    <td width="247" colspan="3" valign="top"><p>Nacionalidade:    <?= $cliente->conjugue_nacionalidade?></p></td>
    <td width="331" colspan="4" valign="top"><p>Profiss&atilde;o: <?= $cliente->conjugue_ramo_atividade?></p></td>
  </tr>
  <tr>
    <td width="205" colspan="2" valign="top"><p>Identidade:    <?= $cliente->conjugue_rg?></p></td>
    <td width="198" colspan="3" valign="top"><p>&Oacute;rg&atilde;o    Emissor: <?= $cliente->conjugue_local_emissao?></p></td>
    <td width="175" colspan="2" valign="top"><p>C.P.F.: <?= $cliente->conjugue_cpf?></p></td>
  </tr>
  <tr>
    <td width="578" colspan="7" valign="top"><p>Endere&ccedil;o    Residencial: <?= $cliente->endereco?></p></td>
  </tr>
  <tr>
    <td width="247" colspan="3" valign="top"><p>Bairro: <?= $cliente->conjugue_bairro?></p></td>
    <td width="198" colspan="3" valign="top"><p>Cidade: <?= $cliente->conjugue_cidade?></p></td>
    <td width="133" valign="top"><p>UF.: <?= $cliente->estado?></p></td>
  </tr>
  <tr>
    <td width="181" valign="top"><p>CEP: <?= $cliente->conjugue_cep?></p></td>
    <td width="204" colspan="3" valign="top"><p>Telefone: <?= $cliente->conjugue_telefone?></p></td>
    <td width="193" colspan="3" valign="top"><p>Telefone 2:</p></td>
  </tr>
  <tr>
    <td width="70%" colspan="5" valign="top"><p>Endere&ccedil;o    Comercial:  <?= $cliente->conjugue_endereco_comercial?></p></td>
    <td width="30%" colspan="2" valign="top"><p>Telefone  Comercial:  <?= $cliente->conjugue_telefone_comercial?></p></td>
  </tr>
</table>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Matricula do Memorial de  incorpora&ccedil;&atilde;o:</strong> Matr&iacute;cula 20, folha 06, do 1&deg; Of&iacute;cio do Registro de Im&oacute;veis do Munic&iacute;pio de  Iranduba Manaus/AM.<strong></strong><br />
  <strong>Nome do Empreendimento:</strong>
  <?= $empreendimento->nome?>
  <strong></strong><br>
  <strong>Endere&ccedil;o do Im&oacute;vel:</strong>
  <?= $empreendimento->logradouro.", ".$empreendimento->bairro.", ".$empreendimento->cidade." ".$empreendimento->complemento?>
  <strong> </strong><br>
  <strong>Previs&atilde;o de Conclus&atilde;o da  Obra</strong>:
  <?= DataUsatoBr($empreendimento->fim) ?>
</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>4 &ndash; Objeto do Contrato</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify">Contrato  Particular de Promessa de Compra e Venda de Unidade Aut&ocirc;noma que se faz entre  as partes acima mencionadas.</p>
<p align="justify"><strong>4.1. Descri&ccedil;&atilde;o do Bem  Contratado</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Tipo da Unidade  adquirida:</strong> <?=$disponibilidade_tipo->nome?><br />
  <strong>N&uacute;mero da unidade:</strong> <?=$disponibilidade->identificacao?>.<br />
  <strong>N&uacute;mero das vagas de  garagem ou estacionamento:</strong> Ser&aacute; definida em assembl&eacute;ia.<br />
  <strong>&Aacute;rea privativa:</strong> <?=$disponibilidade_tipo->area_privativa?><br />
  <strong>Fra&ccedil;&atilde;o ideal:</strong> <?=$disponibilidade_tipo->fracao_ideal?></p>
<p align="justify"><strong>Descri&ccedil;&atilde;o:</strong> <?=$disponibilidade_tipo->descricao?> </p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>5 &ndash; Pre&ccedil;o de Venda e  Condi&ccedil;&otilde;es de Pagamento</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>PRE&Ccedil;O: </strong>O pre&ccedil;o da unidade  objeto deste contrato &eacute; de <?= number_format($contrato->valor_contrato,2,",",".")?>, e ser&aacute; pago pelo(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> nas  condi&ccedil;&otilde;es especificadas neste contrato resumo, sujeitas as presta&ccedil;&otilde;es aos  encargos (corre&ccedil;&atilde;o monet&aacute;ria e juros) indicados nas cl&aacute;usulas segunda e  terceira da parte 2 deste contrato. </p>
<div align="justify">
  <table border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="143" valign="top"><br />
        <strong>N&deg; de parcelas</strong></td>
      <td width="143" valign="top"><p align="center"><strong>Tipo</strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>1&deg;    Vencimento</strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Valor da Parcela</strong></p></td>
      </tr>
    <tr>
      <td width="143" valign="top"><p align="center"><strong><?= " ".$contrato->ato_parcelas?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Ato</strong></p></td>
      <td width="143" valign="top"><p align="center"><strong><center><?=dataUsatoBr($contrato->data_primeiro_pagamento)?></center></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong><? if($contrato->ato_parcelas!=0){echo number_format($contrato->ato_valor_parcela,2,",",".");}?></strong></p></td>
      </tr>
       <tr>
      <td width="143" valign="top"><p align="center"><strong><?= " ".$contrato->ato_parcelas?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Comissão</strong></p></td>
      <td width="143" valign="top"><p align="center"><strong><center><?=dataUsatoBr($contrato->data_primeiro_pagamento)?></center></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong><? if($contrato->ato_parcelas!=0){echo number_format($contrato->comissao_valor_parcela,2,",",".");}?></strong></p></td>
      </tr>
      <? if($contrato->anuais_parcelas!=0){ ?>
    <tr>
      <td width="143" valign="top"><p align="center"><strong><?=$contrato->anuais_parcelas?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Anuais</strong></p></td>
      <?
       	$data_anual=mysql_fetch_object(mysql_query($t="SELECT DATE_ADD( '".$contrato->data_primeiro_pagamento."', INTERVAL 1 YEAR ) as data FROM contrato"));
	  ?>
      <td width="143" valign="top"><p align="center"><strong><?=dataUsatoBr($data_anual->data)?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong><? echo number_format($contrato->anuais_valor_parcela,2,",",".");?></strong></p></td>
      </tr>
       <? } ?>
       <? if($contrato->semestrais_parcelas!=0){ ?>
    <tr>
      <td width="143" valign="top"><p align="center"><strong><?=$contrato->semestrais_parcelas?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Semestrais</strong></p></td>
       <?
       	$data_semestral=mysql_fetch_object(mysql_query($t="SELECT DATE_ADD( '".$contrato->data_primeiro_pagamento."', INTERVAL 6 MONTH ) as data FROM contrato"));
	  ?>
      <td width="143" valign="top"><p align="center"><strong><?=dataUsatoBr($data_semestral->data)?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong><? echo number_format($contrato->semestrais_valor_parcelas,2,",",".");?></strong></td>
      </tr>
      <? } ?>
      
      <? if($contrato->mensais_parcelas!=0){  ?>
    <tr>
      <td width="143" valign="top"><p align="center"><strong><?=$contrato->mensais_parcelas?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Mensais</strong></p></td>
      <?
       	$data_mensal=mysql_fetch_object(mysql_query($t="SELECT DATE_ADD( '".$contrato->data_primeiro_pagamento."', INTERVAL 1 MONTH ) as data FROM contrato"));
	  ?>
      <td width="143" valign="top"><p align="center"><strong><?=dataUsatoBr($data_mensal->data)?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong><? echo number_format($contrato->mensais_valor_parcelas,2,",",".");?></strong></p></td>
      </tr>
      <? } ?>
      <? if($contrato->chave_parcelas!=0){ ?>
      <tr>
      <td width="143" valign="top"><p align="center"><strong><?=$contrato->chave_parcelas?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Chave</strong></p></td>
      <td width="143" valign="top"><p align="center"></p></td>
      <td width="143" valign="top"><p align="center"><strong><?  echo number_format($contrato->chave_valor_parcelas,2,",",".");?></strong></p></td>
      </tr>
      <? } ?>
      <? if($contrato->banco_parcelas!=0){ ?>
      <tr>
      <td width="143" valign="top"><p align="center"><strong><?=$contrato->banco_parcelas?></strong></p></td>
      <td width="143" valign="top"><p align="center"><strong>Banco</strong></p></td>
      <td width="143" valign="top"><p align="center"></p></td>
      <td width="143" valign="top"><p align="center"><strong><?  echo number_format($contrato->banco_valor_parcela,2,",",".");?></strong></p></td>
      </tr>
      <? } ?>
  </table>
</div>
<p align="justify"><strong>Par&aacute;grafo Primeiro</strong>: A parcela denominada &acute;&acute;parcela  final`` do pre&ccedil;o, dever&aacute; ser pagas com recursos pr&oacute;prios do(s) PROMISS&Aacute;RIO(S)  COMPRADOR(ES) reajustada na forma prevista neste contrato; Ou por meio de  repasse pela CAIXA ECON&Ocirc;MICA FEDERAL diretamente &agrave; VENDEDORA, em at&eacute; 30 dias  ap&oacute;s a notifica&ccedil;&atilde;o enviada pela VENDEDORA nos termos da cl&aacute;usula 1.5 deste  contrato, na forma e prazos estipulados no Instrumento de Cr&eacute;dito Banc&aacute;rio &ndash;  Financiamento Banc&aacute;rio com Aliena&ccedil;&atilde;o Fiduci&aacute;ria do Im&oacute;vel e outras aven&ccedil;as a  ser firmado pela CAIXA ECON&Ocirc;MICA FEDERAL com o COMPRADOR.</p>
<p align="justify">&nbsp;<strong>Par&aacute;grafo  Segundo: </strong>O vencimento das parcelas n&atilde;o se vincula, em nenhuma hip&oacute;tese, ao  andamento das obras em termos de cronograma f&iacute;sico-financeiro. Fica ressalvado,  por&eacute;m, caso o prazo de conclus&atilde;o da obra (item 3) venha a ser antecipado ou  caso seja providenciada a notifica&ccedil;&atilde;o tratada nesta cl&aacute;usula (para contrata&ccedil;&atilde;o  do financiamento ou pagamento do pre&ccedil;o no prazo m&aacute;ximo de 30 dias), hip&oacute;tese na  qual todas as parcelas vincendas ter&atilde;o seu vencimento antecipado, em  atendimento a determina&ccedil;&atilde;o das normas do sistema financeiro do SFH que veda a  exist&ecirc;ncia de duplicidade de parcelas mensais referente &agrave; aquisi&ccedil;&atilde;o do im&oacute;vel.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Condi&ccedil;&otilde;es Gerais</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Cl&aacute;usula Primeira &ndash; Da  Incorpora&ccedil;&atilde;o e do Objeto</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>1.1. A VENDEDORA </strong>&eacute; propriet&aacute;ria do terreno sob o qual  ser&aacute; efetuada a incorpora&ccedil;&atilde;o imobili&aacute;ria, com &aacute;rea, limites e confronta&ccedil;&otilde;es  constantes da respectiva matr&iacute;cula.<strong></strong></p>
<p align="justify"><strong>1.2.&nbsp; </strong>A  incorpora&ccedil;&atilde;o e constru&ccedil;&atilde;o ser&atilde;o efetuadas pela <strong>VENDEDORA</strong> de acordo com a lei 4.591/64 e legisla&ccedil;&atilde;o posterior,  denominando-se o empreendimento doravante como <strong>CONDOM&Iacute;NIO</strong>.</p>
<p align="justify"><strong>1.3. </strong>A<strong> VENDEDORA </strong>obriga-se a vender e o(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES) </strong>a adquirir a unidade aut&ocirc;noma descrita e caracterizada no  item 4 deste contrato, que ser&aacute; entregue pronta e acabada, conforme memorial  descritivo em anexo.<strong></strong><br>
  <strong>1.4.</strong> A incorpora&ccedil;&atilde;o tem o prazo de  car&ecirc;ncia de 180 (cento e oitenta) dias, contados da data de seu registro, prorrog&aacute;veis  por igual prazo com a revalida&ccedil;&atilde;o do registro, facultando-se a <strong>VENDERORA</strong> desistir do empreendimento  caso n&atilde;o aliene at&eacute; o t&eacute;rmino do prazo de car&ecirc;ncia de 40% (quarenta por cento)  das unidades aut&ocirc;nomas.<strong></strong></p>
<p align="justify"><strong>1.4.1. </strong>Cancelada a incorpora&ccedil;&atilde;o, obriga-se a <strong>VENDEDORA</strong>, no prazo de 30<strong> </strong>(trinta) dias, a devolver ao(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>as  quantias recebidas, desde a data de cada pagamento.</p>
<p align="justify"><strong>1.5.</strong> O(S) <strong>PROMISSARIO(S) COMPRADOR(ES)</strong> declara(m)-se ciente(s) de que a  incorpora&ccedil;&atilde;o na qual se localizar&aacute; a unidade aut&ocirc;noma do presente instrumento  ser&aacute; financiada pela <strong>CAIXA ECON&Ocirc;MICA  FEDERAL</strong>, raz&atilde;o pela qual dever&aacute; (&atilde;o) firmar, 30 (trinta) dias ap&oacute;s a  notifica&ccedil;&atilde;o enviada pelo <strong>PROMISS&Aacute;RIO  VENDEDOR,</strong> <em>Contrato de Financiamento  Imobili&aacute;rio com Aliena&ccedil;&atilde;o Fiduci&aacute;ria e Outras Aven&ccedil;as</em> junto a Caixa e a <strong>VENDEDORA</strong>, concomitantemente a  assinatura do instrumento de nova&ccedil;&atilde;o e ratifica&ccedil;&atilde;o da presente aven&ccedil;a, desde  que mantida a aprova&ccedil;&atilde;o de seu cr&eacute;dito junto a institui&ccedil;&atilde;o financeira. </p>
<p align="justify"><strong>Par&aacute;grafo &Uacute;nico:</strong> A n&atilde;o aprova&ccedil;&atilde;o do cr&eacute;dito junto &agrave;  institui&ccedil;&atilde;o financeira implica na rescis&atilde;o do contrato, nos termos da cl&aacute;usula  quarta deste contrato de promessa de compra e venda.</p>
<p align="justify"><strong>1.6.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> tem ci&ecirc;ncia e concorda(m)  expressamente com eventuais altera&ccedil;&otilde;es a serem realizadas no projeto  arquitet&ocirc;nico do Empreendimento no que tange a posi&ccedil;&atilde;o de alguns equipamentos  de lazer quando sugeridos pela CAIXA, desde que os mesmos n&atilde;o sejam suprimidos.</p>
<p align="justify"><strong>&nbsp;</strong></p>
<p align="justify"><strong>Cl&aacute;usula Segunda &ndash; Do  Pre&ccedil;o e do Parcelamento</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>2.1. </strong>A venda &eacute; feita por pre&ccedil;o e prazo  certos, com reajuste, pelo valor global indicado no item 5 deste contrato.</p>
<p align="justify"><strong>2.2. </strong>As presta&ccedil;&otilde;es dever&atilde;o ser pagas  atrav&eacute;s de boleto banc&aacute;rio. No caso de n&atilde;o recebimento de boleto banc&aacute;rio no  prazo de 5 (cinco) dias anteriores ao vencimento, o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> dever&aacute;(&atilde;o) entrar em contato com a <strong>VENDEDORA</strong> para pagamento da parcela  devida, em seu escrit&oacute;rio, independente de aviso ou fatura, ou em local e a  quem indicar, mediante recibo. <strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong></p>
<p align="justify"><strong>2.3. </strong>A parcela final do pre&ccedil;o a ser pago  pelo(s) PROMISS&Aacute;RIO(S) COMPRADOR(ES)<strong> </strong>poder&aacute;  ser liquidada com recursos pr&oacute;prios ou, caso pretendam liquidar a parcela final  do pre&ccedil;o deste contrato mediante financiamento concedido pela <strong>CAIXA</strong> para concess&atilde;o de empr&eacute;stimo e  custeio dos custos, despesas e dilig&ecirc;ncias relacionadas com a documenta&ccedil;&atilde;o  exigida, devendo o referido financiamento ser obtido at&eacute; a data de vencimento  da referida parcela.</p>
<p align="justify"><strong>2.4.&nbsp; </strong>Ap&oacute;s<strong> </strong>a conclus&atilde;o f&iacute;sica da obra, pelo IGP-M  (&Iacute;ndice Geral de Pre&ccedil;os &ndash; Mercado), coluna 7 da revista Conjuntura Econ&ocirc;mica,  divulgado mensalmente pela Funda&ccedil;&atilde;o Get&uacute;lio Vargas &ndash; FGV, acrescidos de juros  de 1% ao m&ecirc;s, calculados sobre os valores corrigidos monetariamente.</p>
<p align="justify"><strong>2.5. </strong>Caso os <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>pretendam liquidar a parcela final do  pre&ccedil;o constante no item 5 deste contrato mediante financiamento concedido por  agente do sistema brasileiro de poupan&ccedil;a e empr&eacute;stimos ou com recursos do FGTS,  fica expressamente ajustado que ser&aacute; de exclusiva responsabilidade do(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> o preenchimento  de documenta&ccedil;&otilde;es exigidas &agrave; &eacute;poca pelo financiador para a concess&atilde;o de  empr&eacute;stimo imobili&aacute;rio e custeio dos custos, despesas e dilig&ecirc;ncias  relacionadas com a documenta&ccedil;&atilde;o exigida, devendo o referido financiamento a ser  obtido at&eacute; a data de vencimento da referida parcela.<strong></strong></p>
<p align="justify"><strong>Par&aacute;grafo 1&deg; - </strong>Os &ocirc;nus acima referidos incluem todos  os custos necess&aacute;rios &agrave; obten&ccedil;&atilde;o de documenta&ccedil;&atilde;o que venha a ser requerida pela <strong>VENDEDORA</strong>, tais como despesas com  c&oacute;pias, autentica&ccedil;&otilde;es, correio, taxas cartor&aacute;rias ou tributos, bem como  quaisquer outras, mesmo que n&atilde;o expressamente previstas neste instrumento. A  apresenta&ccedil;&atilde;o dessa documenta&ccedil;&atilde;o n&atilde;o implicar&aacute; responsabilidade da <strong>VENDEDORA</strong> na obten&ccedil;&atilde;o do financiamento,  nem compromisso de receber o saldo devedor &uacute;nica e exclusivamente atrav&eacute;s de  financiamento imobili&aacute;rio, n&atilde;o implicando ren&uacute;ncia ou nova&ccedil;&atilde;o de cr&eacute;dito.</p>
<p align="justify"><strong>Par&aacute;grafo 2&deg; - </strong>Ainda na hip&oacute;tese descrita no caput  deste item, enquanto n&atilde;o houver o cr&eacute;dito integral &agrave; <strong>VENDEDORA</strong> do valor financiado, o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>n&atilde;o receber&aacute; (&atilde;o) a unidade objeto  deste contrato.</p>
<p align="justify"><strong>Par&aacute;grafo 3&deg; - </strong>Durante o processo de an&aacute;lise da  proposta de financiamento do(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES) </strong>pela institui&ccedil;&atilde;o financeira, os juros e corre&ccedil;&atilde;o incidir&atilde;o da  forma prevista neste instrumento sobre os valores em aberto e dever&atilde;o ser pagos  pelo <strong>PROMISSARIO(S) COMPRADOR(ES)</strong> na  mesma ocasi&atilde;o em que for efetuado o pagamento da referida parcela final, sob  pena de reten&ccedil;&atilde;o da unidade at&eacute; a integral satisfa&ccedil;&atilde;o do pre&ccedil;o.</p>
<p align="justify"><strong>Par&aacute;grafo 4&deg; - </strong>O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>declara(m)-se ciente(s) das regras que  regem a concess&atilde;o de financiamento imobili&aacute;rio por agentes do sistema  brasileiro de poupan&ccedil;a e empr&eacute;stimo a compradores finais.</p>
<p align="justify"><strong>Par&aacute;grafo 5&deg; - </strong>No caso de o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>pleitear (em) financiamento  imobili&aacute;rio junto ao agente financeiro caber&aacute; &agrave; <strong>VENDEDORA</strong>, t&atilde;o somente, apresentar documenta&ccedil;&atilde;o relativa &agrave; sua  pessoa e ao im&oacute;vel, inclu&iacute;da a averba&ccedil;&atilde;o da certid&atilde;o de baixa de constru&ccedil;&atilde;o  expedida pelo Munic&iacute;pio de Iranduba/AM, e da certid&atilde;o negativa de d&eacute;bitos  relativa &agrave;s obras, expedida pelo INSS (instituto Nacional de Seguridade  Social). A apresenta&ccedil;&atilde;o dessa documenta&ccedil;&atilde;o n&atilde;o implicar&aacute; responsabilidade da <strong>VENDEDORA</strong> na obten&ccedil;&atilde;o do financiamento,  n&atilde;o implicando ren&uacute;ncia ou nova&ccedil;&atilde;o de cr&eacute;dito.</p>
<p align="justify"><strong>&nbsp;</strong></p>
<p align="justify"><strong>Cl&aacute;usula Terceira &ndash; Do  Equil&iacute;brio Econ&ocirc;mico e Financeiro do Contrato</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>3.1. </strong>Para assegurar a manuten&ccedil;&atilde;o do  equil&iacute;brio econ&ocirc;mico e financeiro deste contrato, as presta&ccedil;&otilde;es indicadas no  item 5 deste contrato, ser&atilde;o atualizadas monetariamente da seguinte forma:</p>
<p align="justify"><strong>a) a partir da data de  assinatura deste contrato e at&eacute; a conclus&atilde;o f&iacute;sica do abra, pelo &Iacute;ndice  Nacional de Custo da Constru&ccedil;&atilde;o (INCC), coluna 35, da Revista Conjuntura  Econ&ocirc;mica, divulgado mensalmente pela Funda&ccedil;&atilde;o Get&uacute;lio Vargas (FGV);</strong></p>
<p align="justify"><strong>b) ap&oacute;s a conclus&atilde;o  f&iacute;sica da obra, pelo &Iacute;ndice Geral de Pre&ccedil;os &ndash; Mercado (IGP-M), coluna 7, da  Revista Conjuntura Econ&ocirc;mica, divulgada mensalmente pela Funda&ccedil;&atilde;o Get&uacute;lio  Vargas (FGV), acrescido de juros de 1% ao m&ecirc;s, calculados sobre os valores  corrigidos monetariamente;</strong></p>
<p align="justify"><strong>3.2. O &iacute;ndice a ser  utilizado para efeito de aplica&ccedil;&atilde;o desta cl&aacute;usula ser&aacute; aquele divulgado para o  terceiro m&ecirc;s anterior ao da data de vencimento da obriga&ccedil;&atilde;o, tendo em vista o  tempo demandado pela FGV para publicar os &iacute;ndices supra referidos.</strong></p>
<p align="justify"><strong>3.3. Cliente que optar  por financiamento banc&aacute;rio junto a CAIXA n&atilde;o arcar&aacute; com despesas referente ao  &Iacute;ndice Geral de Pre&ccedil;os &ndash; Mercado (IGPM) e &Iacute;ndice Nacional de Custo da  Constru&ccedil;&atilde;o (INCC), entretanto, ap&oacute;s a assinatura do contrato de financiamento  banc&aacute;rio dever&aacute; arcar com as despesas da Planilha de Custo Efetivo, referente  ao andamento da obra;</strong><br>
  &nbsp;<br>
  <strong>3.4. </strong>Na hip&oacute;tese de extin&ccedil;&atilde;o, congelamento  ou proibi&ccedil;&atilde;o de utiliza&ccedil;&atilde;o dos &iacute;ndices de atualiza&ccedil;&atilde;o pactuados neste  instrumento, as partes desde j&aacute; elegem o &Iacute;ndice de Pre&ccedil;os ao Consumidor da  Funda&ccedil;&atilde;o Instituto de Pesquisas Econ&ocirc;micas (IPC &ndash; FIPE) ou, sucessivamente, o  IGP-DI/FGV, em substitui&ccedil;&atilde;o.</p>
<p align="justify"><strong>3.5. </strong>O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>poder&aacute; (&atilde;o) antecipar o pagamento das  parcelas do pre&ccedil;o, de acordo com as seguintes condi&ccedil;&otilde;es:</p>
<p align="justify">a)  se estiver (em) em dia com seus compromissos contratuais;</p>
<p align="justify">b)  a antecipa&ccedil;&atilde;o, se parcial, dever&aacute; compreender a presta&ccedil;&atilde;o inteira;</p>
<p align="justify">c)  o c&aacute;lculo da corre&ccedil;&atilde;o monet&aacute;ria ser&aacute; feito &#733;pro rata&#733; dia, atualizando-se o  valor da parcela cujo pagamento for antecipado desde a data desta promessa at&eacute;  a data do seu efetivo pagamento;</p>
<p align="justify">d)  a antecipa&ccedil;&atilde;o n&atilde;o implicar&aacute; nova&ccedil;&atilde;o ou modifica&ccedil;&atilde;o na forma de atualiza&ccedil;&atilde;o ou  quanto ao modo de pagamento;</p>
<p align="justify">e)  no caso de antecipa&ccedil;&atilde;o das presta&ccedil;&otilde;es com vencimento ap&oacute;s a data de conclus&atilde;o  f&iacute;sica da obra ou da entrega da unidade ao (s) <strong>PROMISS&Aacute;RIO (S) COMPRADOR(ES)</strong>, os juros previstos na cl&aacute;usula 2.4  deste contrato ser&atilde;o exigidos pro rata dia at&eacute; a data da antecipa&ccedil;&atilde;o.</p>
<p align="justify"><strong>3.6. </strong>Os pagamentos efetuados por cheques  quitados ap&oacute;s a afetiva compensa&ccedil;&atilde;o banc&aacute;ria.</p>
<p align="justify"><strong>3.7.</strong> O financiamento das presta&ccedil;&otilde;es  constantes do item <strong>5</strong> <strong>(Pre&ccedil;o de Venda e Condi&ccedil;&otilde;es de Pagamento)</strong> deste contrato, nas condi&ccedil;&otilde;es ali previstas, rege-se pelas normas do &#733;Sistema  Financeiro Imobili&aacute;rio - SFI&#733;, institu&iacute;do pela lei 9.514, de 20.11.1997, e  legisla&ccedil;&atilde;o posterior, e &eacute; concedido sob as seguintes condi&ccedil;&otilde;es b&aacute;sicas:</p>
<p align="justify">a)  possibilidade de cess&atilde;o do cr&eacute;dito, parcial ou total, inclusive mediante  securitiza&ccedil;&atilde;o de cr&eacute;ditos imobili&aacute;rios, com o que o (s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> concorda (m) expressamente como  condi&ccedil;&atilde;o essencial deste contrato;</p>
<p align="justify">b)  os cr&eacute;ditos imobili&aacute;rios decorrentes deste contrato poder&atilde;o lastrear, mediante  sua cess&atilde;o, a emiss&atilde;o por companhia securitizadora de t&iacute;tulos de cr&eacute;dito que  ser&atilde;o livremente negociados por meio de sistema centralizado de cust&oacute;dia e  liquida&ccedil;&atilde;o financeiras de t&iacute;tulos privados, ou permitir a emiss&atilde;o, por qualquer  entidade financeira integrante do sistema financeiro imobili&aacute;rio, de deb&ecirc;ntures  ou de qualquer outro titulo de cr&eacute;dito ou valor monet&aacute;rio previsto em lei.</p>
<p align="justify"><strong>3.8. </strong>Tendo como objetivo a reposi&ccedil;&atilde;o  integral do valor financiado, que constitui uma das condi&ccedil;&otilde;es essenciais do  presente contrato, o valor total do financiamento e de cada uma das parcelas  vincendas ser&atilde;o atualizados monetariamente, mensalmente, a partir desta data,  inclusive na ocorr&ecirc;ncia do vencimento antecipado ou nas hip&oacute;teses de  antecipa&ccedil;&atilde;o.</p>
<p align="justify"><strong>3.8.1. </strong>Fica facultado &agrave; <strong>VENDEDORA </strong>ceder e transferir, a qualquer tempo, em favor de  companhia securitizadora ou de qualquer empresa integrante do mercado  financeiro, como faculta a lei 9.514, de 20.11.1997, a totalidade de receb&iacute;veis  correspondentes ao seu cr&eacute;dito contra o(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong>, decorrentes do financiamento imobili&aacute;rio aqui pactuado.</p>
<p align="justify"><strong>3.8.2. </strong>A cess&atilde;o ou transfer&ecirc;ncia mencionada  na cl&aacute;usula 3.7.1 poder&aacute; ocorrer durante a constru&ccedil;&atilde;o do im&oacute;vel objeto do  presente instrumento.<strong> </strong></p>
<p align="justify"><strong>3.9. </strong>As partes ajustam que na hip&oacute;tese de a <strong>VENDEDORA</strong> ficar impossibilitada de  aplicar os juros, reajustes ou corre&ccedil;&atilde;o monet&aacute;ria pactuados neste instrumento  na periodicidade contratada, em raz&atilde;o de medida judicial ou norma legal, as  presta&ccedil;&otilde;es e o saldo devedor continuar&atilde;o sendo reajustados e corrigidos como  antes previsto, e os valores de reajustes e corre&ccedil;&otilde;es que porventura deixarem  de ser aplicadas as presta&ccedil;&otilde;es ser&atilde;o reajustadas/corrigidas e incorporadas de  uma &uacute;nica vez, na primeira presta&ccedil;&atilde;o que se vencer ap&oacute;s a revoga&ccedil;&atilde;o da medida  que impossibilitou sua aplica&ccedil;&atilde;o tempestiva.</p>
<p align="justify"><strong>&nbsp;</strong></p>
<p align="justify"><strong>Cl&aacute;usula Quarta &ndash; Da  Mora, da Rescis&atilde;o e Seus Efeitos</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>4.1. </strong>Caso de inadimplemento total ou  parcial pelo(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong>, antes do recebimento da escritura de compra e venda referida  na cl&aacute;usula quinta deste contrato, ou antes, de assinar o contrato de  financiamento imobili&aacute;rio com o agente financeiro, a <strong>VENDEDORA </strong>poder&aacute;, alternativamente:</p>
<p align="justify">a)  Executar o cr&eacute;dito, acrescido de corre&ccedil;&atilde;o monet&aacute;ria pelo IGP-M/FGV, al&eacute;m de  juros morat&oacute;rios de 1% ao m&ecirc;s calculado <em>pro  rata dia, </em>multa de 2% (dois por cento) incidente sobre cada parcela em  atraso devidamente corrigida, e honor&aacute;rios de advogado de 20% (vinte por cento)  sobre o d&eacute;bito, hip&oacute;tese em que todas as presta&ccedil;&otilde;es vincendas ser&atilde;o consideradas  antecipadamente vencidas.</p>
<p align="justify">b)  Ap&oacute;s 30 (trinta) dias de atraso no pagamento, pelo(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong>, resolver-se-&aacute; o presente contrato,  independentemente de interpela&ccedil;&atilde;o judicial no prazo de 30 (trinta) dias para  pagamento, hip&oacute;tese em que o(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong> receber&aacute;(&atilde;o), t&iacute;tulo de reembolso 70% (setenta por cento) do  valor por ele pago at&eacute; a data do inadimplemento, atualizado pelo mesmo &iacute;ndice  cobrado em cada presta&ccedil;&atilde;o, exclu&iacute;dos os juros e as san&ccedil;&otilde;es pecuni&aacute;rias  eventualmente pagas, repassado da mesma forma em que foi passado a construtora,  devendo ainda ser ressarcido somente ap&oacute;s a conclus&atilde;o f&iacute;sica da obra e com  car&ecirc;ncia de 60 (sessenta) dias, ap&oacute;s a entrega do empreendimento.</p>
<p align="justify">c)  Havendo falta de pagamento de 03 (tr&ecirc;s) presta&ccedil;&otilde;es do pre&ccedil;o, consecutivas ou  n&atilde;o, depois de pr&eacute;via notifica&ccedil;&atilde;o extrajudicial, com o prazo de 10 (dez),  poder&aacute; a construtora, promover a resolu&ccedil;&atilde;o do presente contrato, optando pelo  procedimento de leil&atilde;o extrajudicial previsto no artigo 63, da Lei 4.591/64,  respondendo pelo d&eacute;bito os direitos &agrave; respectiva fra&ccedil;&atilde;o ideal de terreno e &agrave;  parte constru&iacute;da, ficando a <strong>VENDEDORA</strong> constitu&iacute;da mandat&aacute;ria, na forma do inciso VII do artigo 1&deg; da Lei 4.864/64 e  do &sect;5&deg; do artigo 63 da Lei 4.591/64 para, em havendo o leil&atilde;o, efetivar a  cess&atilde;o dos direitos aquisitivos do (s) <strong>PROMISS&Aacute;RIO  (S) COMPRADOR(ES)</strong>; fixar pre&ccedil;os e ajustar condi&ccedil;&otilde;es; sub-rogar o  arrematante nos direitos e obriga&ccedil;&otilde;es decorrentes desta escritura; outorgar as  competentes escrituras e contratos; receber e dar quita&ccedil;&atilde;o; transmitir posse,  dom&iacute;nio, direito e a&ccedil;&atilde;o e rescindir este contrato, caso exer&ccedil;a o direito de  prefer&ecirc;ncia para adjudica&ccedil;&atilde;o.</p>
<p align="justify">d)  Na hip&oacute;tese de descumprimento do prazo previsto na cl&aacute;usula 1.5 deste contrato,  que determina a assinatura do contrato de financiamento em at&eacute; 30 (trinta) dias  ap&oacute;s o recebimento da respectiva intima&ccedil;&atilde;o extrajudicial, o presente contrato  ser&aacute; considerado rescindido, independentemente de aviso ou nova notifica&ccedil;&atilde;o,  ficando expressamente liberada a <strong>VENDEDORA</strong> para negociar o im&oacute;vel com terceiros, aplicando-se as penalidades e demais  condi&ccedil;&otilde;es de rescis&atilde;o narradas nesta cl&aacute;usula.</p>
<p align="justify">e)  Caso o cr&eacute;dito do (s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES) </strong>n&atilde;o seja (m) aprovado (s) pela CAIXA, o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>ter&aacute; 30  (trinta) dias para a procura de outro agente financiador, ficando sob sua  responsabilidade todo procedimento burocr&aacute;tico para sua aprova&ccedil;&atilde;o e libera&ccedil;&atilde;o  do cr&eacute;dito, o presente documento ser&aacute; rescindido ap&oacute;s 35 (trinta e cinco) dias,  independentemente de aviso ou notifica&ccedil;&atilde;o pr&eacute;via, devendo ser restitu&iacute;dos ao <strong>COMPRADOR(A) </strong>todo o valores por ele  pagos, exceto aqueles pagos a t&iacute;tulo de intermedia&ccedil;&atilde;o na compra e venda do  im&oacute;vel (despesas administrativas), o qual ser&aacute; pago &agrave; Corretora de Im&oacute;veis na  forma ajustada no presente contrato, no ato da assinatura do presente  instrumento em face da efetiva presta&ccedil;&atilde;o dos servi&ccedil;os pelo corretor contratado.</p>
<p align="justify"><strong>Par&aacute;grafo 1&deg; - </strong>O valor base para o c&aacute;lculo dos 70%  (setenta por cento) referidos na al&iacute;nea &#733;b&#733; desta cl&aacute;usula penal equivaler&aacute; ao  valor total pago pelo(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES),</strong> objetivando o ressarcimento de despesas contratuais,  jur&iacute;dicas, publicitarias e t&eacute;cnicas, decorrentes da proje&ccedil;&atilde;o de adimplemento  das obriga&ccedil;&otilde;es aqui estipuladas.</p>
<p align="justify"><strong>Par&aacute;grafo 2&deg; - </strong>Na eventualidade do inadimplemento  ocorrer ap&oacute;s a entrega das chaves, al&eacute;m da clausula penal acima estipulada, a <strong>VENDEDORA</strong>, reservar-se-&aacute; o direito de  cobran&ccedil;a de: </p>
<p align="justify">a)  Taxa mensal de ocupa&ccedil;&atilde;o fixada em 1% (um por cento) sobre o pre&ccedil;o da venda,  corrigidos pelos &iacute;ndices aqui pactuados, e devida desde a data de entrega das  chaves at&eacute; a efetiva devolu&ccedil;&atilde;o do im&oacute;vel, livre e desocupado de pessoas e  coisas e reposto ao id&ecirc;ntico estado de quando lhe foi entregue;</p>
<p align="justify">b)  Custos decorrentes de reparos necess&aacute;rios &agrave; reposi&ccedil;&atilde;o do im&oacute;vel em id&ecirc;ntico  estado de quando lhe foi entregue, a menos que o im&oacute;vel seja devolvido em tais  condi&ccedil;&otilde;es;</p>
<p align="justify">c)  Despesas de condom&iacute;nio de utiliza&ccedil;&atilde;o (valores devidos &agrave; data de desocupa&ccedil;&atilde;o);</p>
<p align="justify">d)  Luz, g&aacute;s e &aacute;gua (valores devidos &agrave; data de desocupa&ccedil;&atilde;o);</p>
<p align="justify">e)  IPTU e demais taxas incidentes sobre o im&oacute;vel (valores devidos &agrave; data de  desocupa&ccedil;&atilde;o);</p>
<p align="justify"><strong>Par&aacute;grafo 3&deg; - </strong>Em caso de rescis&atilde;o contratual poder&aacute;  a <strong>VENDEDORA </strong>alienar a terceiros a  unidade objeto deste contrato, sem que o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> possa(m) alegar posse ou reten&ccedil;&atilde;o de  qualquer natureza.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Cl&aacute;usula Quinta &ndash; Da  Entrega da Unidade e Outorga da Escritura</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>5.1. </strong>A entrega da unidade, pronta, somente  ser&aacute; efetuada desde que preenchidas as seguintes condi&ccedil;&otilde;es alternativas:</p>
<p align="justify">a)  liquida&ccedil;&atilde;o de todo o pre&ccedil;o atrav&eacute;s de recursos pr&oacute;prios e outorga de escritura  p&uacute;blica em favor do (s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES);</strong></p>
<p align="justify">b)  liquida&ccedil;&atilde;o de todo o pre&ccedil;o atrav&eacute;s de cr&eacute;dito por agente financeiro em favor da <strong>VENDEDORA </strong>do valor do financiamento;<br>
  <strong>5.2. </strong>Todas as despesas de escritura e  registro imobili&aacute;rio, bem como os tributos, taxas e emolumentos, inclusive as  decorrentes de financiamento e concess&atilde;o de garantias, IPTU e taxas de  condom&iacute;nio, bem como as taxas de imobili&aacute;rio e taxas de liga&ccedil;&atilde;o de servi&ccedil;os de  concession&aacute;rias caber&atilde;o (ao) ao(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong>, e mesmo que n&atilde;o sejam lan&ccedil;adas em seu nome, com o que este  se declara de acordo.</p>
<p align="justify">c)  clientes do Programa Minha Casa Minha Vida (PMCMV) ter&atilde;o as despesas referente  a emolumentos, registro e taxa do Imposto de Transmiss&atilde;o de Bens Im&oacute;veis  (ITBI), pagos pela <strong>VENDEDOR(A)</strong></p>
<p align="justify"><strong>5.3. </strong>A <strong>VENDEDORA </strong>exercer&aacute; o direito de reten&ccedil;&atilde;o da unidade aut&ocirc;noma enquanto o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>n&atilde;o tiver  outorgado a escritura p&uacute;blica e liquidado as obriga&ccedil;&otilde;es de pagamentos previstas  neste contrato, atrav&eacute;s de recursos pr&oacute;prios ou financiamento banc&aacute;rio,  conforme previsto na cl&aacute;usula 5.1 deste contrato.</p>
<p align="justify">a)&nbsp; a partir da expedi&ccedil;&atilde;o do &#733;habite-se&#733; a <strong>VENDEDORA </strong>poder&aacute; a qualquer momento e  sem pr&eacute;vio aviso transferir o saldo do <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES) </strong>a um agente financiador.</p>
<p align="justify"><strong>5.4. </strong>N&atilde;o ser&aacute; permitida a execu&ccedil;&atilde;o de  servi&ccedil;os ou obras por terceiros antes da entrega das chaves.</p>
<p align="justify"><strong>5.5. </strong>A <strong>VENDEDORA </strong>n&atilde;o transmitir&aacute; &#733;posse provis&oacute;ria&#733;, nem permitir&aacute;, sob nenhuma hip&oacute;tese, a  instala&ccedil;&atilde;o de quaisquer benfeitorias, equipamentos ou arm&aacute;rios, bem como a  coloca&ccedil;&atilde;o de quaisquer bens moveis ou qualquer tipo de personaliza&ccedil;&atilde;o na  unidade objeto deste contrato, antes da entrega das chaves.</p>
<p align="justify"><strong>5.6. </strong>O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>compromete(m)-se a providenciar, em  at&eacute; 60 (sessenta) dias ap&oacute;s o registro da escritura definitiva a que se refere  &agrave; cl&aacute;usula 5.1 supra a mudan&ccedil;a da titularidade junto as autoridades competentes  referente a tributo, tarifas, contribui&ccedil;&otilde;es ou qualquer outras despesas ou  encargos que incidam sobre o im&oacute;vel, comprovando as providencias ora pactuadas  por interm&eacute;dio de correspond&ecirc;ncia protocolizada junto a <strong>VENDEDORA, </strong>sob pena de configura&ccedil;&atilde;o de inadimplemento contratual  que dar&aacute; ensejo &agrave; indeniza&ccedil;&atilde;o &agrave; <strong>VENDEDORA </strong>por perdas e danos decorrentes de sua in&eacute;rcia.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Cl&aacute;usula Sexta &ndash; Da  Constru&ccedil;&atilde;o</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>6.1. </strong>O prazo de t&eacute;rmino da constru&ccedil;&atilde;o da  unidade aut&ocirc;noma est&aacute; previsto no item 4 deste contrato, admitida uma  toler&acirc;ncia de 180 (cento e oitenta) dias &uacute;teis, independente de qualquer  condi&ccedil;&atilde;o.<br>
  &nbsp;<br>
  <strong>6.2. </strong>O prazo final para conclus&atilde;o da  unidade poder&aacute; ser prorrogado pelo tempo necess&aacute;rio a retomada das obras, por  motivo de for&ccedil;a maior e caso fortuito, tais como:</p>
<p align="justify">a)  Greves parciais ou gerais dos trabalhadores da ind&uacute;stria de constru&ccedil;&atilde;o civil ou  de fornecedores de mat&eacute;rias;</p>
<p align="justify">b)  Suspens&atilde;o ou falta, total ou parcial, de transporte, materiais, combust&iacute;veis,  energia el&eacute;trica ou &aacute;gua;</p>
<p align="justify">c)  Chuvas prolongadas que impe&ccedil;am ou dificultem a execu&ccedil;&atilde;o da obra de constru&ccedil;&atilde;o  do <strong>EDIF&Iacute;CIO</strong>.</p>
<p align="justify">d)  Atraso na execu&ccedil;&atilde;o dos servi&ccedil;os de liga&ccedil;&atilde;o de servi&ccedil;os p&uacute;blicos, a cargo das  respectivas concession&aacute;rias;</p>
<p align="justify">e)  Embargo da obra determinada por autoridade administrativa ou judici&aacute;ria;</p>
<p align="justify">f)  Demora na concess&atilde;o, pela autoridade p&uacute;blica, do &#733;habite-se&#733;, certid&atilde;o de  quita&ccedil;&atilde;o previdenci&aacute;ria da obra ou aprova&ccedil;&atilde;o final do Corpo de Bombeiros, bem  como o atraso de concession&aacute;rios de servi&ccedil;os p&uacute;blicos nas execu&ccedil;&otilde;es desses  servi&ccedil;os;</p>
<p align="justify">g)  Condi&ccedil;&otilde;es at&iacute;picas de constitui&ccedil;&atilde;o do solo ou que n&atilde;o tenham sido reveladas na  sondagem pr&eacute;via e que retardem a execu&ccedil;&atilde;o das funda&ccedil;&otilde;es ou que demandem o  escoramento de pr&eacute;dios vizinhos.</p>
<p align="justify"><strong>6.3. </strong>O edif&iacute;cio ser&aacute; tido como pronto e  acabado desde que, conclu&iacute;do fisicamente, a <strong>VENDEDORA</strong> tenha dado entrada nos pedidos de liga&ccedil;&atilde;o definitiva de  &aacute;gua, esgoto e energia el&eacute;trica junto as concession&aacute;rias, requerido a obten&ccedil;&atilde;o  de CND e &#733;habite-se&#733; e pedido de aprova&ccedil;&atilde;o pelo Corpo de Bombeiros e, ainda,  caso existam pequenos servi&ccedil;os de acabamentos a serem realizados em algumas  unidade ou nas paredes comuns do pr&eacute;dio, circunst&acirc;ncias que n&atilde;o poder&atilde;o servir  de fundamento &agrave; recusa do recebimento das chaves ou de implemento &agrave; instala&ccedil;&atilde;o  do condom&iacute;nio.</p>
<p align="justify"><strong>6.4. </strong>No momento da entrega das chaves, o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>dever&aacute;  (&atilde;o) proceder a rigorosa vistoria da unidade aut&ocirc;noma, expedindo-se termo de  recebimento, no qual constar&aacute; o estado em que se encontrar o im&oacute;vel, apontando,  se for o caso, eventuais defeitos vis&iacute;veis, para permitir seu preparo pela  construtora, o que n&atilde;o constituir&aacute; motivo de recusa ao recebimento da unidade.</p>
<p align="justify"><strong>6.4.1. </strong>A <strong>VENDEDORA </strong>entregar&aacute; ao(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong> um manual contendo indica&ccedil;&otilde;es e recomenda&ccedil;&otilde;es alusivas &agrave;  conserva&ccedil;&atilde;o dos apartamentos e das partes comuns do edif&iacute;cio.</p>
<p align="justify"><strong>6.4.2. </strong>O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> obriga(m)-se a conservar a unidade aut&ocirc;noma,  ap&oacute;s a imiss&atilde;o da posse, promovendo a manuten&ccedil;&atilde;o recomendada, sob pena de parda  da garantia, obrigando-se, ainda, a manter (em) em seu poder o comprovante da  realiza&ccedil;&atilde;o das manuten&ccedil;&otilde;es recomendadas no aludido manual.</p>
<p align="justify"><strong>6.4.3. </strong>Quanto a poss&iacute;veis defeitos existentes  na data da entrega da unidade aut&ocirc;noma, ou que venham aparecer nos 90 (noventa)  dias subseq&uuml;entes, estabelece-se que o(s) <strong>PROMISS&Aacute;RIOS  COMPRADOR(ES)</strong> pedir&atilde;o (&atilde;o) a interven&ccedil;&atilde;o da <strong>VENDEDORA</strong>, no ato da entrega das chaves ou por carta protocolada,  especificando, com detalhes, a natureza do defeito, e, se for o caso, problemas  que tenham ocorridos de uso inadequado ou de atos de terceiros, para permitir  que a <strong>VENDEDORA</strong> efetue os reparos,  diretamente ou por pessoas por ela indicadas, ou ainda, pela assist&ecirc;ncia  t&eacute;cnica dos fabricantes de equipamentos e instala&ccedil;&otilde;es.</p>
<p align="justify"><strong>6.5. </strong>A construtora respons&aacute;vel pela  edifica&ccedil;&atilde;o assumir&aacute; integral responsabilidade por defeitos aparentes ou  ocultos, e pela solidez e seguran&ccedil;a da edifica&ccedil;&atilde;o, nos termos do C&oacute;digo Civil Brasileiro,  desde que o(s) <strong>PROMISS&Aacute;RIOS  COMPRADOR(ES)</strong>, relativamente &agrave; unidade objeto desta promessa, ou o  condom&iacute;nio, quanto &agrave;s partes comuns do pr&eacute;dio, n&atilde;o tenha(m) concorrido para o  seu aparecimento, ou para o seu agravamento, por a&ccedil;&atilde;o ou omiss&atilde;o, mau uso,  falta de manuten&ccedil;&atilde;o ou de conserva&ccedil;&atilde;o.</p>
<p align="justify"><strong>6.6. </strong>O prazo de car&ecirc;ncia para reclamar  contra poss&iacute;veis defeitos aparentes, de f&aacute;cil constata&ccedil;&atilde;o, &eacute; de 90 (noventa)  dias, contados da data da entrega da unidade ou das partes comuns do pr&eacute;dio,  conforme o caso.</p>
<p align="justify"><strong>6.7. </strong>A garantia oferecida a equipamentos  instalados na unidade ser&aacute; igual a fixada pelo fabricante, tornando-se como  termo inicial a data da certid&atilde;o do &#733;habite-se&#733; ou da entrega da unidade ao(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong>,  considerando dos dois eventos o que primeiro ocorrer.</p>
<p align="justify"><strong>6.8. </strong>O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> declara(m) declaram ter pleno  conhecimento do memorial de incorpora&ccedil;&atilde;o, dos projetos arquitet&ocirc;nicos e das  especifica&ccedil;&otilde;es e descri&ccedil;&otilde;es do <strong>EDIF&Iacute;CIO</strong> e de sua unidade aut&ocirc;noma.</p>
<p align="justify"><strong>Par&aacute;grafo 1&deg; - </strong>At&eacute; a entrega, com respectivo  &#733;habite-se&#733;, do &uacute;ltimo pr&eacute;dio do condom&iacute;nio, poder&aacute; a <strong>VENDEDORA</strong> realizar todas e quaisquer modifica&ccedil;&otilde;es de projetos,  sejam de que natureza for, eventualmente necess&aacute;rias a seu exclusivo crit&eacute;rio,  ou ainda, por exig&ecirc;ncia das autoridades respons&aacute;veis, mesmo que importarem em  modifica&ccedil;&atilde;o por substitui&ccedil;&atilde;o, total ou parcial, de qualquer dos blocos, respeitados  os direitos do(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong>.</p>
<p align="justify"><strong>Par&aacute;grafo 2&deg; - </strong>Da mesma forma, o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> reservam a <strong>VENDEDORA </strong>o direito de modificar as  partes comuns, as benfeitorias e a infra-estrutura urbana constantes do projeto  e, ainda: a) modificar integralmente os projetos de qualquer dos blocos cujas  unidades n&atilde;o tenham sido permitidas a venda, seja quanto a divis&atilde;o internas das  unidades, seja quanto &agrave; sua unidade ou destina&ccedil;&atilde;o, independentemente de  consulta ao(s) <strong>PRIMISS&Aacute;RIO(S) COMPRADOR(ES), </strong>respeitado sempre os direitos adquiridos pelo (s) mesmo(s), no que se  refere &agrave;s suas respectivas fra&ccedil;&otilde;es ideais, que em nenhuma hip&oacute;tese sofrer&atilde;o  altera&ccedil;&atilde;o; b) realiza as modifica&ccedil;&otilde;es parciais de detalhes de qualquer bloco ou  unidades para atender &agrave;s exig&ecirc;ncias naturais, da melhores condi&ccedil;&otilde;es funcionais  ou atender &agrave;s necessidades de seguran&ccedil;a geral.&nbsp; <strong></strong></p>
<p align="justify"><strong>6.9.</strong> O(s) <strong>PORMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>Declara(m)-se ciente(s) de que n&atilde;o  poder&aacute; (ao) realizar qualquer modifica&ccedil;&atilde;o estrutural da edifica&ccedil;&atilde;o, inclusive  no interior das unidades, mesmo ap&oacute;s a concess&atilde;o do &ldquo;habite-se&rdquo;, tendo em vista  tratar-se de processo construtivo em alvenaria estrutural, que n&atilde;o permite o  deslocamento de paredes. Tamb&eacute;m &eacute; vedado, pelas mesmas raz&otilde;es e em qualquer  &eacute;poca, proceder(em) cortes nas paredes para passagem de tubula&ccedil;&atilde;o de qualquer  natureza.</p>
<p align="justify"><strong>6.10.</strong> O(s)<strong> PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> Reconhece(m) que nenhum dos arm&aacute;rios,  m&oacute;veis, divis&oacute;rias, objetos de decora&ccedil;&atilde;o e acess&oacute;rios que comp&otilde;em os materiais  de divulga&ccedil;&atilde;o e propaganda do <strong>EDIF&Iacute;CIO</strong> s&atilde;o partes integrantes da unidade aut&ocirc;noma adquirida ou do <strong>EDIF&Iacute;CIO</strong>. As &aacute;reas comuns ser&atilde;o entregues equipadas e decoradas de  acordo com projeto de decora&ccedil;&atilde;o, sendo que as imagens n&atilde;o representam a  decora&ccedil;&atilde;o futura da &aacute;rea.</p>
<p align="justify"><strong>6.11.</strong> Como a venda da unidade &eacute; ad corpus,  as varia&ccedil;&otilde;es inferiores a 5% (cinco por cento) da &aacute;rea da unidade, definidas no  projeto aprovado, n&atilde;o afetar&atilde;o o pre&ccedil;o contratado, sendo aceito pelo (s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES).</strong></p>
<p align="justify"><strong>6.12.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>Declaram-se ciente de que execu&ccedil;&atilde;o dos  edif&iacute;cios que compor&atilde;o o Condom&iacute;nio ser&aacute; realizada em etapas, autorizando,  expressamente, a <strong>VENDEDORA</strong>, desde  que cumpridos os prazos de constru&ccedil;&atilde;o previsto neste instrumento, se assim  decidir, finalizar um bloco antes de outro, bem como excluir &aacute;reas do terreno e  &aacute;reas comuns ainda a serem utilizadas, para uso na constru&ccedil;&atilde;o dos blocos ainda  remanescentes, servindo de canteiros de obras, bloqueadas por tapumes ou muro,  respeitados sempre os limites de seguran&ccedil;a.</p>
<p align="justify"><strong>6.13.</strong> At&eacute; a conclus&atilde;o das obras do ultimo  bloco do condom&iacute;nio e de sua respectiva infra-estrutura, o transito de  moradores pelas &aacute;reas comuns sofrera as restri&ccedil;&otilde;es necess&aacute;rias para garantir a  seguran&ccedil;a dos moradores, pelo que o(s) <strong>PROMISS&Aacute;RIO(S)</strong> <strong>COMPRADOR(ES)</strong> estar&aacute; obrigado ao  cumprimento, com o m&aacute;ximo rigor, das observa&ccedil;&otilde;es de proibi&ccedil;&atilde;o de acesso &aacute;s  &aacute;reas interditadas.</p>
<p align="justify"><strong>6.14.</strong> As depend&ecirc;ncias e utilidades de uso  comum dos condom&iacute;nios dos edif&iacute;cios que comp&otilde;em o Condom&iacute;nio, fisicamente  instaladas em apenas algum ou alguns dos pr&eacute;dios ou edifica&ccedil;&otilde;es, somente ser&atilde;o  entregues e poder&atilde;o ser utilizado pelo <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES) </strong>quando do termino do edif&iacute;cio em quer for prevista a referida  depend&ecirc;ncia ou instala&ccedil;&atilde;o, o que abrange tamb&eacute;m as &aacute;reas externas de utiliza&ccedil;&atilde;o  comum.</p>
<p align="justify"><strong>6.15.</strong> A fim de n&atilde;o comprometer o bom  andamento da constru&ccedil;&atilde;o, as visitas &aacute;s obras pelo(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>s&oacute; ser&atilde;o permitidas mediante  agendamento pr&eacute;vio com o departamento de p&oacute;s-venda da construtora ou dos  telefones (92) 3648-4860 e 3648-4593, com anteced&ecirc;ncia m&iacute;nima de 48 horas.</p>
<p align="justify"><strong>6.16.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> n&atilde;o poder&aacute;(&atilde;o) interferir diretamente  na obra, em entendimento com o mestre-de-obras, encarregados, oper&aacute;rios a  servi&ccedil;o da <strong>VENDEDORA</strong> ou  subempreiteiros contratados.</p>
<p align="justify"><strong>6.17.</strong> A data de entrega da constru&ccedil;&atilde;o da  unidade n&atilde;o se vincula em hip&oacute;tese alguma coma data de entrega das &aacute;reas  comerciais do Empreendimento, podendo ocorrer anteriormente ou posteriormente &aacute;  data de conclus&atilde;o prevista para entrega das unidades aut&ocirc;nomas ao <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong>.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Clausula S&eacute;tima - Da  Conven&ccedil;&atilde;o e Instala&ccedil;&atilde;o do Condom&iacute;nio</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>7.1.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>declara conhecer e aderem &agrave; conven&ccedil;&atilde;o  de condom&iacute;nio institu&iacute;da pela <strong>VENDEDORA,</strong> integrante do memorial de incorpora&ccedil;&atilde;o, subscrevendo uma copia neste ato para  todos os efeitos legais, obrigando-se a incluir em qualquer instrumento de  aliena&ccedil;&atilde;o, loca&ccedil;&atilde;o ou cess&atilde;o de uso da unidade clausula que obrigue o  adquirente, locat&aacute;rio ou usu&aacute;rio a cumprir e fazer a referida conven&ccedil;&atilde;o.</p>
<p align="justify"><strong>7.2</strong>. Embora a ades&atilde;o e a subscri&ccedil;&atilde;o da  conven&ccedil;&atilde;o pelo <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong> ocorram neste ato, a <strong>VENDEDORA</strong> fica constitu&iacute;da mandat&aacute;ria, com poderes para assinar em nome do <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES), </strong>se  necess&aacute;rios, a conven&ccedil;&atilde;o de condom&iacute;nio junto ao registro imobili&aacute;rio.</p>
<p align="justify"><strong>7.3</strong>. &Eacute; facultado a <strong>VENDEDORA</strong>, em car&aacute;ter definitivo, colocar e manter no <strong>EDIF&Iacute;CIO</strong>, em local escolhido a seu  crit&eacute;rio, placas promocionais alusivas ao empreendimento, em metal, madeira ou  acr&iacute;lico luminoso, bem como manter local destinado a perman&ecirc;ncia de corretores  de plant&atilde;o, neste ultimo caso enquanto houver unidades a venda, mesmo ap&oacute;s a  instala&ccedil;&atilde;o do condom&iacute;nio.</p>
<p align="justify"><strong>7.4</strong>. Entre a data de conclus&atilde;o da  constru&ccedil;&atilde;o da constru&ccedil;&atilde;o do <strong>EDIF&Iacute;CIO</strong> e a data prevista para a entrega da obra, devera ser realizada assembl&eacute;ia geral  de instala&ccedil;&atilde;o do condom&iacute;nio.</p>
<p align="justify"><strong>7.5</strong>. Sem preju&iacute;zo de seu direito de  comparecer pessoalmente a assembl&eacute;ia geral de instala&ccedil;&atilde;o do condom&iacute;nio, o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> constituem  a <strong>VENDEDORA</strong> como bastante  procuradora pra represent&aacute;-los com poderes para votar em todas as mat&eacute;rias que  forem levadas a aprecia&ccedil;&atilde;o daquela assembl&eacute;ia, exceto transigir e firmar  compromisso, sendo desde j&aacute; expressamente admitido o substabelecimento.<br>
  &nbsp;<br>
  <strong>7.6.</strong> Ap&oacute;s a expedi&ccedil;&atilde;o do &ldquo;habite-se&#733; ou  entrega da unidade, considerando dos dois eventos o que primeiro ocorrer,  caber&aacute; ao <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> pagar:<br>
  &nbsp; <br>
  a)  quaisquer taxas e emolumentos relativos ao registro e averba&ccedil;&atilde;o, junto ao  Cart&oacute;rio de Registro de Im&oacute;veis, da institui&ccedil;&atilde;o e conven&ccedil;&atilde;o de condom&iacute;nio;</p>
<p align="justify">b)<strong> </strong>despesas com a outorga das escrituras  das unidades aut&ocirc;nomas junto ao servi&ccedil;o notarial competente e outras despesas  necess&aacute;rias, tais como ITBI (Imposto de Transmiss&atilde;o de Bens Im&oacute;veis), taxa de  servi&ccedil;os notariais, custas e emolumentos relacionados &agrave; lavratura da escritura,  emolumentos do registro imobili&aacute;rio, certid&otilde;es negativas e outras;</p>
<p align="justify">c)<strong> </strong>pagamento proporcional do imposto  predial e territorial urbano (IPTU) da proje&ccedil;&atilde;o, incidente sobre quota de terreno  e da unidade imobili&aacute;ria, o qual ser&aacute; devido no exerc&iacute;cio que corresponder ao  do t&eacute;rmino f&iacute;sico da unidade; </p>
<p align="justify">d)  despesas e taxas cobradas pelas concession&aacute;rias de servi&ccedil;os p&uacute;blicos para a  liga&ccedil;&atilde;o dos servi&ccedil;os de &aacute;gua, luz, g&aacute;s e telefone no condom&iacute;nio;</p>
<p align="justify">e)  despesas com taxas de liga&ccedil;&atilde;o definitiva das concession&aacute;rias de servi&ccedil;os, tais  como &aacute;gua, luz, esgoto, telefone.</p>
<p align="justify"><strong>Par&aacute;grafo 1&ordm;</strong> - O inadimplemento de quaisquer das  parcelas acima previstas ensejara o pagamento de multa de 10%sobre o valor do  d&eacute;bito em aberto.</p>
<p align="justify"><strong>Par&aacute;grafo 2&ordm; </strong>- Conforme consta da conven&ccedil;&atilde;o de  condom&iacute;nio registrada, considerando as caracter&iacute;sticas especiais do  empreendimento e visando assegurar o pleno &ecirc;xito do projeto, a escolha da  administradora especializada que administrar&aacute; o condom&iacute;nio a partir dos dois  (dois) anos ap&oacute;s a conclus&atilde;o f&iacute;sica da ultima edifica&ccedil;&atilde;o, caber&aacute; exclusivamente  a <strong>VENDEDORA</strong>, representando todo o  condom&iacute;nio.</p>
<p align="justify"><strong>Par&aacute;grafo 3&ordm;</strong> - O contrato a ser firmado pela <strong>VENDEDORA</strong>, em nome do condom&iacute;nio,  conter&aacute; a descri&ccedil;&atilde;o das atividades operacionais do condom&iacute;nio, com as cl&aacute;usulas  e condi&ccedil;&otilde;es usuais desse tipo de neg&oacute;cio.</p>
<p align="justify"><strong>7.7.</strong> A <strong>VENDEDORA</strong> poder&aacute;, ap&oacute;s a conclus&atilde;o f&iacute;sica da obra e da conven&ccedil;&atilde;o do  condom&iacute;nio, contratar provisoriamente entidade especializada em forma&ccedil;&atilde;o e  administra&ccedil;&atilde;o de condom&iacute;nio, as expensas deste.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Clausula oitava- Do  financiamento do edif&iacute;cio </strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>8.1.</strong> O(s)<strong> PROMISS&Aacute;RIO(S) COMPRADOR(ES) </strong>tem ci&ecirc;ncia de que a unidade objeto  deste instrumento particular, juntamente com o terreno incorporado e todas as  suas acess&otilde;es, ser&aacute; hipotecada em favor de institui&ccedil;&atilde;o financeira para garantia  de empres&aacute;rio destinado a produ&ccedil;&atilde;o do edif&iacute;cio, comprometendo-se a <strong>VENDEDORA</strong> a resgatar a referida  hipoteca ou outro &ocirc;nus real incidente sobre o im&oacute;vel para viabilizar a entrega  ao(s) <strong>PROMISS&Aacute;RIO(S)</strong> <strong>COMPRADOR(ES)</strong> da correspondente  escritura definitiva de compra e venda, uma vez quitado todo o pre&ccedil;o. O  pagamento do financiamento a produ&ccedil;&atilde;o do edif&iacute;cio e de exclusiva  responsabilidade da <strong>VENDEDORA</strong> e n&atilde;o  contempla a previs&atilde;o de repasse ao(s) <strong>PROMISS&Aacute;RIO(S)  COMPRADOR(ES).</strong></p>
<p align="justify"><strong>Par&aacute;grafo 1&ordm; </strong>- na hip&oacute;tese ter sido quitado o pre&ccedil;o  anteriormente ao &ldquo;habite-se&rdquo;, a baixa da hipoteca nunca ocorrera antes de  decorridos cento e oitenta (180) dias do referido &ldquo;habite-se&rdquo; no Cart&oacute;rio  Imobili&aacute;rio.</p>
<p align="justify"><strong>Par&aacute;grafo 2&ordm;</strong> - Na hip&oacute;tese do pre&ccedil;o ser quitado  ap&oacute;s o &ldquo;habite-se&rdquo;, a baixa da eventual hipoteca ocorrera no prazo Maximo de  180 (cento e oitenta) dias ap&oacute;s a integral quita&ccedil;&atilde;o do pre&ccedil;o e ap&oacute;s a lavratura  da escritura definitiva de compra e venda, uma vez que, em ambas as hipoteca, o  cancelamento da hipoteca dependera de providencias do agente fiador.</p>
<p align="justify"><strong>8.2.</strong> Se necess&aacute;rio, o(s) <strong>PORMISS&Aacute;RIO(S) COMPRADOR(ES</strong>)  obriga(m)-se, a qualquer tempo, a retificar a anu&ecirc;ncia com a hipoteca ou  aliena&ccedil;&atilde;o do terreno e suas acess&otilde;es em favor de agente financeiro para  garantir financiamento para a produ&ccedil;&atilde;o do edif&iacute;cio.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Clausula nona - Da  cess&atilde;o de direitos e obriga&ccedil;&otilde;es</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify">9.1.  O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> poder&aacute;(&atilde;o) ceder ou transferir os direitos relativos ao presente contrato  somente mediante a prevista e expressa autoriza&ccedil;&atilde;o da <strong>VENDEDORA</strong>, podendo esta exercer prefer&ecirc;ncia, nas mesmas condi&ccedil;&otilde;es  ofertadas pelo terceiro interessado.</p>
<p align="justify">9.2.  Caso a <strong>VENDEDORA </strong>n&atilde;o exer&ccedil;a a  prefer&ecirc;ncia, apesar de intimada para tanto com prazo de 10 (dez) dias, devera  autorizar a cess&atilde;o observadas &agrave;s seguintes condi&ccedil;&otilde;es, cumulativamente:</p>
<p align="justify">a)  mediante o pagamento de uma taxa de transfer&ecirc;ncia de 1% (um por cento) sobre o  valor total do contrato por unidade imobili&aacute;ria;</p>
<p align="justify">b)  comprova&ccedil;&atilde;o de adimplemento do(s) <strong>PORMISS&Aacute;RIO(S)  COMPRADOR(ES)</strong> com todas as parcelas em atraso, acrescidas dos respectivos  acess&oacute;rios;</p>
<p align="justify">c)  aprova&ccedil;&atilde;o do cadastro do terceiro cession&aacute;rio, principalmente quanto a  capacidade financeira para cumprir as obriga&ccedil;&otilde;es contratuais.</p>
<p align="justify"><strong>&nbsp;</strong></p>
<p align="justify"><strong>Clausula d&eacute;cima &ndash; Da Associa&ccedil;&atilde;o  dos Amigos do Condom&iacute;nio Residencial Bela Vista</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>10.1.</strong> O empreendimento &ldquo;Condom&iacute;nio  Residencial Bela Vista&rdquo; se originara do parcelamento do solo oriundo do  loteamento do lote de terras, com &aacute;rea de 277.606,27 m&sup2;, situado na Estrada  Manuel Urbano, Rodovia AM - 070, n&deg; 08, Km 09, Lote 36, Bairro Centro, descrito  e caracterizado na matricula n&ordm; 20, Folha 06 do Cart&oacute;rio do 1&ordm; Oficio de  Registro de Im&oacute;veis de Iranduba &ndash; AM, a obra relativa ao Condom&iacute;nio ser&aacute;  implantada com observ&acirc;ncia da Licen&ccedil;a n&deg; 00672010 expedida pela Prefeitura do  Munic&iacute;pio de Iranduba &ndash; AM, em 30/06/2011;</p>
<p align="justify"><strong>10.2. </strong>A concep&ccedil;&atilde;o do &#733;Condom&iacute;nio Residencial  Bela Vista&#733; baseia-se no conceito de comunidade planejada, assim entendido como  local de moradia com op&ccedil;&atilde;o de com&eacute;rcio, trabalho, divers&atilde;o, entretenimento,  centro educacional, entre outros.</p>
<p align="justify"><strong>10.3.</strong> O loteamento que deu origem ao  &ldquo;Condom&iacute;nio Residencial Bela Vista&rdquo; possuir&aacute; as seguintes &aacute;reas: (i) &aacute;rea  Residencial, composta de 07 (sete) lotes resid&ecirc;ncias em que ser erguer&atilde;o  incorpora&ccedil;&otilde;es imobili&aacute;rias, dentre elas a presente, objeto deste contrato; (ii)  &Aacute;rea Comercial, com lotes comerciais; (iii) &Aacute;rea de Equipamento Comunit&aacute;rio  (&aacute;rea publica), composta de lotes para instala&ccedil;&atilde;o de equipamentos comunit&aacute;rios;  (iv) &Aacute;rea Verde (&aacute;rea publica) composta de 1 (um) lote de &aacute;rea verde com  120.744,32m&sup2;; (v) &Aacute;rea de preserva&ccedil;&atilde;o Ambiental A.P.P. (&aacute;rea n&atilde;o edificavel);  (vi) Sistema Vi&aacute;rio, composto Avenida de Acesso, al&ccedil;a vi&aacute;rias e ruas.</p>
<p align="justify"><strong>10.4.</strong> O conceito, natureza e diversidade,  bem como o alcance social na regi&atilde;o do &ldquo;Condom&iacute;nio Residencial Bela Vista&ldquo; ser&aacute;  administrado pela <strong>&ldquo;ASSOCIA&Ccedil;&Atilde;O DOS AMIGOS  DO CONDOM&Iacute;NIO RESIDENCIAL BELA VISTA&rdquo;, </strong>criada especialmente para gest&atilde;o,  aperfei&ccedil;oamento e melhoria da condi&ccedil;&atilde;o de vida de seus moradores e  propriet&aacute;rios dos im&oacute;veis que se erguer&atilde;o sobre os lotes descritos no item  anterior. O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> toma(m) ci&ecirc;ncia da minuta daquele estatuto, cuja copia integra este contrato.  Obrigando-se por si e seus sucessores, a cumpri-lo fielmente, em todos os seus  termos.</p>
<p align="justify"><strong>10.4.1.</strong> Os associados titulares de unidades  inseridas no &ldquo;Condom&iacute;nio Residencial Bela Vista&rdquo;, ao alienarem ou prometerem  alienar a terceiros im&oacute;veis ali situados, obrigam-se a fazer constar dos  respectivos instrumentos que os adquirentes dever&atilde;o se filiar necessariamente a  associa&ccedil;&atilde;o, devendo, de qualquer modo, independentemente da efetiva filia&ccedil;&atilde;o,  obriga-se pelo custeio proporcional das respectivas despesas, conforme previsto  neste estatuto, tendo em vista os servi&ccedil;os prestados e colocados &agrave; disposi&ccedil;&atilde;o  de todos os moradores do referido bairro.</p>
<p align="justify"><strong>10.4.2.</strong> S&atilde;o associados efetivos todo o <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> de  unidades residenciais prometidas &agrave; venda pelo incorporador de empreendimentos,  bem como todos os titulares do dom&iacute;nio das referidas unidades do Condom&iacute;nio  Residencial Bela Vista, observando-se que a cada unidade ser&aacute; indissoluvelmente  vinculada a propriedade de uma cota da associa&ccedil;&atilde;o.</p>
<p align="justify"><strong>10.4.3.</strong> A filia&ccedil;&atilde;o como associado efetivo  faz-se pela aquisi&ccedil;&atilde;o, a qualquer t&iacute;tulo, de unidade aut&ocirc;noma residencial  situada no Condom&iacute;nio Residencial Bela Vista ou pela assinatura de promessa de  compra e venda como o incorporador.</p>
<p align="justify"><strong>10.4.4.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> assina(m), neste ato, o termo de  filia&ccedil;&atilde;o &agrave; associa&ccedil;&atilde;o.</p>
<p align="justify"><strong>10.4.5.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> desligar-se-&aacute;(&atilde;o) da associa&ccedil;&atilde;o pela  transmiss&atilde;o ou perda da propriedade, a qualquer t&iacute;tulo, do apartamento  integrante de um dos condom&iacute;nios do Condom&iacute;nio Residencial Bela Vista, bem como  pela rescis&atilde;o da respectiva promessa de compra e venda com o incorporador.</p>
<p align="justify"><strong>10.4.6.</strong> Alterada, por qualquer raz&atilde;o, a  titularidade do im&oacute;vel, o alienante e o adquirente dever&atilde;o comunicar a  transfer&ecirc;ncia da propriedade &agrave; associa&ccedil;&atilde;o, ficando o transmitente  solidariamente respons&aacute;vel pelo cumprimento das obriga&ccedil;&otilde;es previstas naquele  estatuto at&eacute; que a referida comunica&ccedil;&atilde;o seja efetuada.</p>
<p align="justify"><strong>10.4.7.</strong> Caber&aacute; a cada associado efetivo a  fra&ccedil;&atilde;o ideal do patrim&ocirc;nio da associa&ccedil;&atilde;o correspondente &agrave; fra&ccedil;&atilde;o ideal que  detiver em cada apartamento.</p>
<p align="justify"><strong>10.5.</strong> A incorporadora n&atilde;o se  responsabilizar&aacute; pelo desenvolvimento das atividades nos equipamentos  comunit&aacute;rios, tais como escola, posto de sa&uacute;de, creche, etc., limitando-se  apenas em constru&iacute;-las e entreg&aacute;-las ao Munic&iacute;pio de Manaus ou &agrave; Associa&ccedil;&atilde;o do  Condom&iacute;nio Residencial Bela Vista, a quem competir&aacute; garantir o seu pleno  funcionamento, individualmente, ou por meio de conv&ecirc;nios ou parcerias a serem  posteriormente firmadas.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Cl&aacute;usula D&eacute;cima Primeira  &ndash; Das Despesas de Corretagem</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>11.1.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> arcar&atilde;o com as despesas de remunera&ccedil;&atilde;o  do corretor e/ou empresa de corretagem que intermediar a venda do presente  im&oacute;vel. </p>
<p align="justify"><strong>11.2.</strong> A emiss&atilde;o de nota fiscal, referente  ao valor pago a este t&iacute;tulo, &eacute; de &uacute;nica e exclusiva responsabilidade da  intermediadora na negocia&ccedil;&atilde;o, neste caso o corretor.</p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>Cl&aacute;usula D&eacute;cima Segunda  &ndash; Das Disposi&ccedil;&otilde;es Gerais</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify"><strong>12.1.</strong> A partir da data de assinatura deste  contrato e at&eacute; a data da averba&ccedil;&atilde;o do &ldquo;habite-se&rdquo; no registro imobili&aacute;rio, a <strong>VENDEDORA</strong> representar&aacute; o(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> podendo,  em seu nome, assinar documentos perante concession&aacute;rias de servi&ccedil;os p&uacute;blicos,  reparti&ccedil;&otilde;es p&uacute;blicas, autarquias, cart&oacute;rios em geral, especialmente o de  registro de im&oacute;veis, podendo assinar em nome do mandante o memorial de  incorpora&ccedil;&atilde;o e suas modifica&ccedil;&otilde;es, o registro da institui&ccedil;&atilde;o e conven&ccedil;&atilde;o de  condom&iacute;nio, a averba&ccedil;&atilde;o da constru&ccedil;&atilde;o do <strong>EDIF&Iacute;CIO</strong> e do &ldquo;habite-se&rdquo; e, praticar todo e qualquer ato indispens&aacute;vel &agrave; regulariza&ccedil;&atilde;o  da constru&ccedil;&atilde;o.</p>
<p align="justify"><strong>12.1.1.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> nomeia(m) e constitue(m), ainda, em  car&aacute;ter irrevog&aacute;vel, conforme disp&otilde;e o Artigo 684 do C&oacute;digo Civil, a <strong>VENDEDORA</strong> como sua procuradora, com o  fim especial de represent&aacute;-lo(s) perante a Prefeitura Municipal de Iranduba,  empresas concession&aacute;rias de servi&ccedil;os p&uacute;blicos, entidades p&uacute;blicas federais,  estaduais, municipais e suas autarquias, em tudo que se fizer necess&aacute;rio para a  regulariza&ccedil;&atilde;o de eventuais altera&ccedil;&otilde;es ou modifica&ccedil;&otilde;es no projeto de constru&ccedil;&atilde;o,  bem como perante o Cart&oacute;rio de Registro de Im&oacute;veis competente, para efetivar no  momento pr&oacute;prio a averba&ccedil;&atilde;o da constru&ccedil;&atilde;o e os registros decorrentes da futura  especifica&ccedil;&atilde;o e conven&ccedil;&atilde;o de condom&iacute;nio, podendo, para tanto, a <strong>VENDEDORA</strong> assinar todos os documentos  necess&aacute;rios.</p>
<p align="justify"><strong>12.1.2.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong>, inclusive o(s) c&ocirc;njuge(s)  adquirente(s), neste ato nomeia(m) e constitui (em)-se mutuamente procurador  (es), um (uns) do(s) outro(s), com poderes irrevog&aacute;veis e irretrat&aacute;veis, nos  termos do Artigo 684, do C&oacute;digo Civil, com o fim especial de representar o(s)  outro(s) para receber cita&ccedil;&otilde;es, inclusive inicial, notifica&ccedil;&otilde;es judiciais e  extrajudiciais, aditar, re-ratificar, rescindir, confessar d&iacute;vida, fazer  acordo, emitir, endossar e avalizar notas promiss&oacute;rias, tendo como refer&ecirc;ncia a  presente transa&ccedil;&atilde;o, atos esses que ser&atilde;o considerados sempre bons, firmes e  valiosos.</p>
<p align="justify"><strong>Par&aacute;grafo &Uacute;nico</strong> &ndash; Os mandatos acima s&atilde;o outorgados  como cl&aacute;usulas contratuais e, assim, tem car&aacute;ter irrevog&aacute;vel, conforme os  Artigos 683, 684 e 686, par&aacute;grafo &uacute;nico, do C&oacute;digo Civil, podendo a <strong>VENDEDORA</strong>, ainda, assinar instrumentos  p&uacute;blicos ou particulares de re-ratifica&ccedil;&atilde;o porventura necess&aacute;rios, inclusive  para atendimento de exig&ecirc;ncias formuladas pelo registro imobili&aacute;rio competente,  sem altera&ccedil;&atilde;o do objeto e caracter&iacute;sticas da presente escritura e dos direitos  do(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong>.</p>
<p align="justify"><strong>12.2.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> fica(m) ciente(s) e concorda(m) com o  fato de que a <strong>VENDEDORA</strong> poder&aacute;,  diante das normas regulamentares ou exig&ecirc;ncias das empresas concession&aacute;rias de  servi&ccedil;os p&uacute;blicos, se assim for exigido, transferir ou ceder as redes internas  e &aacute;reas da edifica&ccedil;&atilde;o para localiza&ccedil;&atilde;o e instala&ccedil;&atilde;o de m&aacute;quinas e equipamentos,  que passar&atilde;o a ser de uso exclusivo da respectiva concession&aacute;ria.</p>
<p align="justify"><strong>12.3.</strong> Dever&atilde;o ser pagas pelo(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong>: </p>
<p align="justify">a)  As despesas decorrentes deste instrumento e dos que dele sejam dele  conseq&uuml;entes, inclusive de an&aacute;lise, viabilidade e cess&atilde;o de cr&eacute;dito, em  decorr&ecirc;ncia de financiamento e, ainda, outras decorrentes ou complementares,  dentre os quais o imposto sobre a transmiss&atilde;o de bens im&oacute;veis inter-vivos  (ITBI), ou quaisquer outras despesas e tributos que venham a ser cobrados ou  criados pelos poderes p&uacute;blicos competentes, emolumentos de Tabeli&atilde;o de Notas e  de Cart&oacute;rio de Registro de Im&oacute;veis, inclusive o registro deste contrato no  Cart&oacute;rio de Registro de Im&oacute;veis competente, ainda que por iniciativa da <strong>VENDEDORA</strong> ou de empresa cession&aacute;rias  dos cr&eacute;ditos decorrentes deste contrato;</p>
<p align="justify">b)  O imposto territorial incidente a partir do primeiro dia do m&ecirc;s subseq&uuml;ente ao  da conclus&atilde;o f&iacute;sica da obra da unidade objeto deste contrato, o pagamento dos  impostos e taxas que incidem ou venham a incidir sobre a unidade objeto deste  contrato, ainda que lan&ccedil;ados como territorial ou predial, e, englobadamente e  em nome da <strong>VENDEDORA</strong>, sendo que,  nesse caso, ser&atilde;o rateados entre todas as unidades aut&ocirc;nomas do empreendimento;</p>
<p align="justify">c)  Despesas de instala&ccedil;&atilde;o e manuten&ccedil;&atilde;o do condom&iacute;nio a partir do primeiro dia do  m&ecirc;s subseq&uuml;ente ao da instala&ccedil;&atilde;o do condom&iacute;nio;</p>
<p align="justify">d)  Despesas de liga&ccedil;&otilde;es individuais de &aacute;gua, luz, g&aacute;s, telefone e outros servi&ccedil;os  relativos &agrave; unidade aut&ocirc;noma ora compromissada;</p>
<p align="justify">e)  Despesas com as taxas de liga&ccedil;&atilde;o definitiva das concession&aacute;rias de servi&ccedil;os  p&uacute;blicos, tais como &aacute;gua, luz, esgoto, telefone e g&aacute;s;</p>
<p align="justify">f)  Impostos, taxas ou contribui&ccedil;&otilde;es que venham a incidir adicionalmente sobre a  presente transa&ccedil;&atilde;o, mesmo que debitados em nome da <strong>VENDEDORA</strong>;</p>
<p align="justify">g)  O pagamento, diretamente aos corretores e &agrave; empresa que intermediar este  neg&oacute;cio, da remunera&ccedil;&atilde;o relativa a comiss&atilde;o.</p>
<p align="justify"><strong>Par&aacute;grafo &Uacute;nico</strong> &ndash; O inadimplemento de quaisquer das  parcelas acima previstas ensejar&aacute; o pagamento de multa de 2% (dois por cento)  sobre o valor do d&eacute;bito em aberto, acrescido de atualiza&ccedil;&atilde;o monet&aacute;ria e juros  de mora de 1% (hum por cento) ao m&ecirc;s, e honor&aacute;rios advocat&iacute;cios da ordem de 20%  (vinte por cento).</p>
<p align="justify"><strong>12.4.</strong> A <strong>VENDEDORA</strong> fica autorizada a instalar e manter na cobertura dos  edif&iacute;cios e em &aacute;reas externas ou internas do empreendimento, por um per&iacute;odo  m&iacute;nimo de 10 (dez) anos contados da data da instala&ccedil;&atilde;o do condom&iacute;nio, logotipos  ou outros sinais indicativos dos nomes e atividades empresariais da <strong>VENDEDORA</strong>, ou de empresas pertencentes  ao seu grupo societ&aacute;rio.</p>
<p align="justify"><strong>12.5.</strong> A <strong>VENDEDORA</strong> fica desde j&aacute; autorizada a manter corretores nas partes  comuns do condom&iacute;nio, at&eacute; a venda da &uacute;ltima de suas unidades.</p>
<p align="justify"><strong>12.6.</strong> A eventual declara&ccedil;&atilde;o de nulidade de  alguma disposi&ccedil;&atilde;o contratual n&atilde;o acarretar&aacute; a rescis&atilde;o do contrato,  permanecendo vigentes as demais cl&aacute;usulas, podendo as partes, ainda, ajustar  cl&aacute;usula substitutiva da norma anulada, preservando o contrato e a inten&ccedil;&atilde;o dos  contratantes.</p>
<p align="justify"><strong>12.7.</strong> Eventual toler&acirc;ncia pelo n&atilde;o  cumprimento de qualquer obriga&ccedil;&atilde;o relacionada ao presente contrato por qualquer  das partes ser&aacute; considerada mera liberalidade, n&atilde;o constituindo nova&ccedil;&atilde;o,  ren&uacute;ncia a direito, altera&ccedil;&atilde;o t&aacute;cita deste instrumento ou direito adquirida da  outra parte.</p>
<p align="justify"><strong>12.8.</strong> As comunica&ccedil;&otilde;es entre as partes  dever&atilde;o ser feitas por escrito e endere&ccedil;adas aos endere&ccedil;os e pessoas indicadas  no quadro resumo deste contrato, ressalvada altera&ccedil;&atilde;o de endere&ccedil;o devidamente  comunicada por escrito.</p>
<p align="justify"><strong>12.9.</strong> O presente instrumento &eacute; celebrado em  car&aacute;ter irrevog&aacute;vel e irretrat&aacute;vel, obrigado os contratantes por si, seus  herdeiros e sucessores. </p>
<p align="justify"><strong>12.10.</strong> O(s) <strong>PROMISS&Aacute;RIO(S) COMPRADOR(ES)</strong> declara(m) que a minuta deste contrato  fora-lhe apresentada previamente, inclusive em tempo h&aacute;bil para obter  aconselhamento jur&iacute;dico, tendo o texto sido integralmente compreendido.</p>
<p align="justify"><strong>12.11.</strong> As partes elegem, para dirimir  qualquer controv&eacute;rsia oriunda deste contrato, o foro da Cidade de Iranduba &ndash;  AM, local onde est&aacute; situado o im&oacute;vel objeto do presente instrumento.</p>

<p align="justify">E,  por estarem assim justos e contratados, assinam o presente instrumento em 02 (duas)  vias de igual forma e teor, para um s&oacute; efeito, perante as testemunhas abaixo  assinadas.</p>
<p align="justify">&nbsp;</p>
<p align="justify">Cidade  de Manaus-AM, <?= date('d/m/Y')?>.</p>
<p align="justify">&nbsp;</p>
<p align="justify">______________________________________________________<br>
  <strong><?=$corretor->nome?> </strong><br>
  <strong>VENDEDORA</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify">______________________________________________________<br>
  <strong><?= $cliente->razao_social?></strong><br>
  <strong>PROMISS&Aacute;RIO COMPRADOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>
<p align="justify">&nbsp;</p>
<p align="justify">______________________________________________________<br>
  <strong><?= $cliente->conjugue_nome?></strong><br>
  <strong>PROMISS&Aacute;RIA COMPRADORA</strong></p>
<p align="justify">&nbsp;</p>
<p align="justify">TESTEMUNHAS:</p>
<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="326" valign="top"><p>&nbsp;</p>
      <p>NOME:</p>
      <p>CPF:</p>
      <p>RG:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p></td>
    <td width="326" valign="top"><p>&nbsp;</p>
      <p>NOME:</p>
      <p>CPF:</p>
      <p>RG:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p></td>
  </tr>
</table>
<p align="justify">&nbsp;</p>
</div>