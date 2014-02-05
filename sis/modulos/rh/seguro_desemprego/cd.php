<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>emissao</title>
<style type="text/css">
<!--
body {
	background-image: url(documentos.jpg);
	background-repeat:no-repeat;
	font-family:"Courier New", Courier, monospace;
	font-size:15px;
	letter-spacing: 10px; word-spacing: 0px;
}
div{position:absolute;}
#nome{top:80px; left:23px;}
#nomeMae{top:130px; left:23px;}
#endereco{top:175px; left:23px;}

#complemento{top:225px; left:20px;}
#cep{top:225px; left:309px;}
#uf{top:225px; left:498px;}
#telefone{top:225px; left:558px;}

#PIS{top:271px; left:20px;}
#carteira{top:271px; left:272px;}
#carteira_n{
	top:271px;
	left:459px;
}
#carteira_s{
	top:271px;
	left:402px;
}
#CPF{top:271px; left:538px;}

#tipo{top:319px; left:92px;}
#cnpj{top:319px; left:147px;}
#ativEconomica{top:319px; left:443px;}

#CBO{top:367px; left:20px;}
#cboDescricao{top:367px; left:150px;}

#emissao{top:463px; left:25px;}
#dispensa{top:463px; left:164px;}
#sexo{top:463px; left:378px;}
#instrucao{top:463px; left:493px;}
#nascimento{top:462px; left:545px;}
#horas_trabalhadas{top:462px; left:688px;}

#mes{top:512px; left:22px;}
#antepenutimoSalario{top:511px; left:65px;}
#mes2{top:511px; left:263px;}
#penultimoSalario{top:512px; left:304px;}
#mes3{top:511px; left:506px;}
#utimoSalario{top:509px; left:553px;}
#somaSalarios{top:558px; left:20px;}
#bancario{top:558px; left:259px;}
#mesesTrabalhados{top:556px; left:702px;}
#recebeuSalario{top:603px; left:207px;}
#avisoPrevio{top:605px; left:387px;}
#pisPazepNit2{top:840px; left:20px;}
#nome2{top:890px; left:20px;}
-->
</style></head>

<body>
	<div id='nome'><?=$funcionario->nome?></div>
	<div id='nomeMae'><?=$funcionario->filiacao_mae?></div>
	<div id='endereco'><?=$funcionario->endereco?></div>
	<div id='complemento'><?=$complemento?></div>
	<div id='cep'><?=$funcionario->cep?></div>
	<div id='uf'><?=$funcionario->uf?></div>
	<div id='telefone'><?=$telefone1?></div>
	<div id='PIS'><?=$funcionario->pis?></div>
	<div id='carteira'><?=$funcionario->carteira_profissional_numero?></div>
	<div id='carteira_n'><?=$funcionario->carteira_profissional_estado_emissor?></div>
	<div id='carteira_s'><?=$funcionario->carteira_profissional_serie?></div>
<div id='CPF'><?=$cpf?></div>
	<div id='tipo'>1</div>
	<div id='cnpj'><?=$cnpj?></div>
	<div id='ativEconomica'><?=$atividade?></div>
	<div id='CBO'><?=$funcionario->cbo?></div>
	<div id='cboDescricao'><?=$funcionario->cargo?></div>
	<div id='emissao'><?=$data_admissao[2].$data_admissao[1].substr($data_admissao[0],2)?></div>
	<div id='dispensa'><?=$data_demissao[2].$data_demissao[1].substr($data_demissao[0],2)?></div>
	<div id='sexo'><?=$sexo?></div>
	<div id='instrucao'><?=$funcionario->grau_instrucao?></div>
	<div id='nascimento'><?=$data_nascimento[2].$data_nascimento[1].substr($data_nascimento[0],2)?></div>
	<div id='horas_trabalhadas'><?=$horas?></div>
	<div id='mes'><?=$mes_extenso[$antepenultimo_salario->mes]?></div>
	<div id='antepenutimoSalario'><?=DataUsaToBr($antepenultimo_salario->saldo_a_receber_salario)?></div>
	<div id='mes2'><?=$mes_extenso[$penultimo_salario->mes]?></div>
	<div id='penultimoSalario'><?=DataUsaToBr($penultimo_salario->saldo_a_receber_salario)?></div>
	<div id='mes3'><?=$mes_extenso[$ultimo_salario->mes]?></div>
	<div id='utimoSalario'><?=DataUsaToBr($ultimo_salario->saldo_a_receber_salario)?></div>
	<div id='somaSalarios'><?=$soma_salarios?></div>
	<div id='bancario'><?=$banco.$agencia?></div>
	<div id='mesesTrabalhados'><?=$meses_trabalhados?></div>
	<div id='recebeuSalario'><?=$recebeu?></div>
	<div id='avisoPrevio'><?=$aviso?></div>
    <? if($pagina==1){ ?>
	<div id='pisPazepNit2'><?=$pis?></div>
	<div id='nome2'><?=$empregado?></div>
	<?
    }
	?>
																																																																																																																							                                                                                                             </div></body>
</html>
